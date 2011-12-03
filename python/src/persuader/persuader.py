#!/usr/bin/env python
__author__="thrstnh"
__date__ ="$25.03.2009 02:49:20$"

import wx
import pygame
import os
import os.path
import sys
import wx.lib.mixins.listctrl  as  listmix
from mutagen.id3 import ID3
from config import db
import sqlite3 as lite
import random
import time
from MP3 import MatMP3 as MP3

class PlaylistCtrl(wx.ListCtrl, listmix.ListCtrlAutoWidthMixin, listmix.ColumnSorterMixin):
    def __init__(self, parent):
        wx.ListCtrl.__init__( self, parent, -1, style=wx.LC_REPORT|wx.LC_VIRTUAL|wx.LC_HRULES|wx.LC_VRULES)
        
        # some vars
        self._pause = True
        self._random = db['random']
        self._repeat = db['repeat']
        self._count_items = 0
        self._current = ''
        self._current_id = 0
        self._selected = ''
        self._pattern = '%'

        self.InsertColumn(0, "Titel")
        self.InsertColumn(1, "Artist")
        self.InsertColumn(2, "Album")
        self.InsertColumn(3, "Nr")
        self.InsertColumn(4, "Path")
        
        self.SetColumnWidth(0, 200)
        self.SetColumnWidth(1, 160)
        self.SetColumnWidth(2, 200)
        self.SetColumnWidth(3, 50)
        self.SetColumnWidth(4, 200)

        self.fill(self.selectData(self._pattern))
        
        #mixins
        listmix.ListCtrlAutoWidthMixin.__init__(self)
        listmix.ColumnSorterMixin.__init__(self, 5)

        #sort by column 2, A->Z ascending order (1)
        self.SortListItems(2, 1)

        #events
        self.Bind(wx.EVT_LIST_ITEM_SELECTED, self.OnItemSelected)
        self.Bind(wx.EVT_LIST_ITEM_ACTIVATED, self.OnItemActivated)
        self.Bind(wx.EVT_LIST_ITEM_DESELECTED, self.OnItemDeselected)
        self.Bind(wx.EVT_LIST_COL_CLICK, self.OnColClick)
        # focus first track
        self.Focus(0)
        
    def clear(self):
        self.fill({})
        
    def length(self):
        return self._count_items
    
    def fill(self, data):
        #if not data:
        #    data = self.selectData(pattern)
        self.itemDataMap = data
        self.itemIndexMap = data.keys()
        self._count_items = len(data)
        self.SetItemCount(self._count_items)
        print '%s items' % self.length()
        
    
    def current(self):
        self._current_id = self.GetFocusedItem()
        self._current = self.getColumnText(self._current_id, 4)
        return self._current

    def next(self):
        idx = self._current_id
        if db['random']:
            next = random.randint(0, self.length()-1)
        else:
            next = idx + 1
        path = self.getColumnText(next, 4)
        self.Select(idx,0)
        self.Select(next,1)
        self.Focus(next)
        self._current = next
        return path
    
    def prev(self):
        idx = self._current_id
        prev = idx - 1
        path = self.getColumnText(prev, 4)
        self.Select(idx,0)
        self.Select(prev,1)
        self.Focus(prev)
        return path            
        
    def selectData(self, pattern='%'):
        print "pattern ", pattern
        con = lite.connect(db['playlist'], isolation_level=None)
        cur = con.cursor()
        query = 'create table if not exists playlist(artist text, titel text, album text, tracknr text, path text);'
        cur.execute(query)
        query = "select * from playlist where artist LIKE '%%%s%%' OR titel LIKE '%%%s%%' OR album LIKE '%%%s%%'" % (pattern, pattern, pattern)
        print query
        cur.execute(query)
        
        rows = cur.fetchall()
        data = {}
        i = 1
        for row in rows:
            data[row[4]] = (row[1], row[0], row[2], row[3], row[4])
            i = i + 1
        cur.close()
        con.close()
        return data
    
    def OnColClick(self,event):
        event.Skip()

    def OnItemSelected(self, event):
        item = event.m_itemIndex
        self._selected = self.getColumnText(item, 4)
        #print self.currentItem

    def OnItemActivated(self, event):
        print "activated"

    def getColumnText(self, index, col):
        item = self.GetItem(index, col)
        return item.GetText()

    def OnItemDeselected(self, evt):
        print "deselect"

    def OnGetItemText(self, item, col):
        index=self.itemIndexMap[item]
        s = self.itemDataMap[index][col]
        return s

    def OnGetItemImage(self, item):
        index=self.itemIndexMap[item]
        genre=self.itemDataMap[index][2]
        return -1

    def OnGetItemAttr(self, item):
        index=self.itemIndexMap[item]
        genre=self.itemDataMap[index][2]
        return None

    #---------------------------------------------------
    # Matt C, 2006/02/22
    # Here's a better SortItems() method --
    # the ColumnSorterMixin.__ColumnSorter() method already handles the ascending/descending,
    # and it knows to sort on another column if the chosen columns have the same value.

    def SortItems(self,sorter=cmp):
        items = list(self.itemDataMap.keys())
        items.sort(sorter)
        self.itemIndexMap = items
        
        # redraw the list
        self.Refresh()

    # Used by the ColumnSorterMixin, see wx/lib/mixins/listctrl.py
    def GetListCtrl(self):
        return self




class PersuaderTrayIcon(wx.TaskBarIcon):
    def __init__(self, frame):
        wx.TaskBarIcon.__init__(self)

        self.frame = frame
        self.SetIcon(wx.Icon('media/atom.ico', wx.BITMAP_TYPE_ICO), 'Persuader')
        
        self.Bind(wx.EVT_MENU, self.OnTaskBarActivate, id=1)
        self.Bind(wx.EVT_MENU, self.OnTaskBarDeactivate, id=2)
        self.Bind(wx.EVT_MENU, self.OnTaskBarClose, id=3)
        #self.Bind(wx.EVT_TASKBAR_LEFT_DCLICK, self.onClick, id=4)
    
    def onClick(self, e):
        print "onClick"
        if self.frame.IsShown():
            self.frame.Hide()
        else:
            self.frame.Show()

    def CreatePopupMenu(self):
        menu = wx.Menu()
        menu.Append(1, 'Show')
        menu.Append(2, 'Hide')
        menu.Append(3, 'Close')
        menu.Append(4, 'Play')
        menu.Append(5, 'Stop')
        menu.Append(6, 'Next')
        menu.Append(7, 'Prev')
        return menu

    def OnTaskBarClose(self, event):
        self.frame.Close()

    def OnTaskBarActivate(self, event):
        if not self.frame.IsShown():
            self.frame.Show()

    def OnTaskBarDeactivate(self, event):
        if self.frame.IsShown():
            self.frame.Hide()


class ConfigPanel(wx.Panel):
    def __init__(self, parent, playlist):
        wx.Panel.__init__(self, parent, style=wx.SUNKEN_BORDER)

        self.pls = playlist
        
        # widgets start
        self.st_collection_root = wx.StaticText(self, -1, "Collection-root", size=(100, 20), pos=(20, 20))
        self.tc_collection_root_path = wx.StaticText(self, -1, db['collection_path'],style=wx.SUNKEN_BORDER, size=(300, -1), pos=(200, 20))
        self.btn_collection = wx.Button(self, -1, "search", pos=(520, 20))
        self.Bind(wx.EVT_BUTTON, self.setCollectionRoot, self.btn_collection)
        self.btn_collection_rescan = wx.Button(self, -1, "rescan collection", pos=(620, 20))
        self.Bind(wx.EVT_BUTTON, self.rescan_collection, self.btn_collection_rescan)
        
        self.st_history = wx.StaticText(self, -1, "History", size=(100, 20), pos=(20,50))
        self.tc_history = wx.TextCtrl(self, -1, db['history'], size=(100, 20), pos=(200,50))
        
        self.cb_tray_icon = wx.CheckBox(self, -1, "TrayIcon", pos=(20, 80))
        
        sizer = wx.GridSizer(rows=3, cols=2, hgap=5, vgap=5)
        sizer.Add(self.st_collection_root, 1, wx.EXPAND)
        sizer.Add(self.tc_collection_root_path, 1, wx.EXPAND)
        sizer.Add(self.st_history, 1, wx.EXPAND)
        sizer.Add(self.tc_history, 1, wx.EXPAND)
        sizer.Add(self.cb_tray_icon, 1, wx.EXPAND)
        # widgets stop
    
        #self.SetSizer(sizer)
    
    def rescan_collection(self, e):
        print "begin rescan"
        self.pls.fill(self.collect())
        print "end rescan"
        
    def setCollectionRoot(self, e):
        dlg = wx.DirDialog(None, "Choose a directory:",
                        style=wx.DD_DEFAULT_STYLE | wx.DD_NEW_DIR_BUTTON)
        dlg.SetPath(db['collection_path'])
        if dlg.ShowModal() == wx.ID_OK:
            tp = dlg.GetPath()
            db['collection_path'] = tp
            self.tc_collection_root_path.SetLabel(tp)
        dlg.Destroy()
    
    def collect(self):
        '''
            scan whole collection dir and insert into sqlite3-playlist
        '''
        con = lite.connect('playlist', isolation_level=None)
        cur = con.cursor()
        query = 'drop table playlist;'
        cur.execute(query)
        query = 'create table playlist(artist text, titel text, album text, tracknr text, path text);'
        cur.execute(query)
        cur.close()
        con.close()
        def _collect(dummy, path, filesindir):
            con = lite.connect('playlist', isolation_level=None)
            cur = con.cursor()
            row = 0
            for fname in filesindir:
                if fname.endswith(".mp3"):
                    tpath = os.path.join(path,fname)
                    try:
                        mp3 = MP3(tpath)
                        #print mp3.artist()
                        query = 'insert into playlist values ("%s", "%s", "%s", "%s", "%s")' % (mp3.artist(), mp3.title(), mp3.album(), mp3.tracknr(), tpath)
                        print query
                        cur.execute(query)
                    except:
                        pass
                    #print tpath
            cur.close()
            con.close()
        os.path.walk(db['collection_path'], _collect, None)

class LyricPanel(wx.Panel):
    def __init__(self, parent):
        wx.Panel.__init__(self, parent)
        t = wx.StaticText(self, -1, "Lyric", (40, 40))

class ArtistPanel(wx.Panel):
    def __init__(self, parent):
        wx.Panel.__init__(self, parent)
        t = wx.StaticText(self, -1, "Artist", (40, 40))
        
class StatisticPanel(wx.Panel):
    def __init__(self, parent):
        wx.Panel.__init__(self, parent)
        t = wx.StaticText(self, -1, "Stats", (40, 40))



class MP3Tree(wx.Panel):
    def __init__(self, parent, *args, **kwargs):
        wx.Panel.__init__(self, parent, *args, **kwargs)

        vbox = wx.BoxSizer(wx.VERTICAL)
        self.tree = wx.TreeCtrl(self, 1, wx.DefaultPosition, (800,600), wx.TR_HIDE_ROOT|wx.TR_HAS_BUTTONS)
        root = self.tree.AddRoot('Interpret - Album - Track')

        data = self.selectData()
        artistDic = {}
        albumDic = {}
        
        for path, row in data.iteritems():
            
            album = row[2]
            artist = row[1]
            titel = row[0]
            
            if not artistDic.has_key(artist):
                artistDic[artist] = self.tree.AppendItem(root, artist)
            if not albumDic.has_key(album):
                albumDic[album] = self.tree.AppendItem(artistDic[artist], album)
            self.tree.AppendItem(albumDic[album], titel)


        self.tree.Bind(wx.EVT_TREE_SEL_CHANGED, self.OnSelChanged, id=1)
        vbox.Add(self.tree, flag=wx.EXPAND | wx.BOTTOM | wx.TOP)
        self.SetSizer(vbox)
        self.Centre()
        
        
    def selectData(self):
        con = lite.connect(db['playlist'], isolation_level=None)
        cur = con.cursor()
        
        query = 'select * from playlist'
        cur.execute(query)
        
        rows = cur.fetchall()
        data = {}
        i = 1
        for row in rows:
            data[row[4]] = (row[1], row[0], row[2], row[3], row[4])
            i = i + 1
        cur.close()
        con.close()
        return data

    def OnSelChanged(self, event):
        item =  event.GetItem()
        print self.tree.GetItemText(item)
        print item

    def collect(self):
        data = []
        def _collect(dummy, path, filesindir):
            row = 0
            for fname in filesindir:
                if fname.endswith(".mp3"):
                    tpath = os.path.join(path,fname)
                    track = MP3(tpath)
                    data.append(track)
                    row = row+1
        os.path.walk(db['collection_path'], _collect, None)
        return data



class Collector(object):
    def __init__(self):
        pass
        
    def collect(self):
        os.path.walk(db['collection_path'], _collect, None)
        return data
        
    def _collect(self):
        data = []
        def _collect(dummy, path, filesindir):
            row = 0
            for fname in filesindir:
                if fname.endswith(".mp3"):
                    tpath = os.path.join(path,fname)
                    track = MP3(tpath)
                    data.append(track)
                    row = row+1



class ControlPanel(wx.Panel):
    def __init__(self, parent, playlist, statusbar):
        wx.Panel.__init__(self, parent, style=wx.EXPAND)
        
        self.pls = playlist
        self.sbar = statusbar
        
        self._mute = False
        self._playing = False
        # init pygame for playback
        pygame.mixer.init()
        #print "Mixer Channels: %s" % pygame.mixer.get_num_channels()
        
        # timer
        self.timer = wx.Timer(self)
        self.Bind(wx.EVT_TIMER, self.onTimer)
        
        ## GUI START
        # current Track TextField
        self.stCurrentTrack = wx.TextCtrl(self, -1, "Artist - Titel", style=wx.SUNKEN_BORDER, size=(400,25))
        
        # volume/mute
        self.btnVolume  = wx.BitmapButton(self, -1, wx.Bitmap('media/Volume16.gif'))
        self.btnVolume.SetToolTip(wx.ToolTip("Mute"))
        # volume/slider
        self.sliVolume = wx.Slider(self, -1, 0, 0, 100, size=(120, 20))
        # default value of 75
        self.sliVolume.SetValue(db['volume'])
        
        # time, labels and slider
        self.stTimeStart = wx.StaticText(self, -1, "0:00", size=(40,-1))
        self.sliTime = wx.Slider(self, -1, 0, 0, 100, size=(120, 20))
        self.stTimeStop = wx.StaticText(self, -1, "3:33", size=(40,-1))
        
        # hbox for vol
        hbox1 = wx.BoxSizer(wx.HORIZONTAL)
        hbox1.Add(self.btnVolume)
        hbox1.Add(self.sliVolume)
        hbox1.Add(self.stTimeStart, flag=wx.LEFT, border=30)
        hbox1.Add(self.sliTime)
        hbox1.Add(self.stTimeStop)
        
        # stop
        btnStop = wx.BitmapButton(self, -1, wx.Bitmap('media/player_stop.png'))
        btnStop.SetToolTip(wx.ToolTip("Stop"))
        # play
        btnPlay  = wx.BitmapButton(self, -1, wx.Bitmap('media/player_play.png'))
        btnPlay.SetToolTip(wx.ToolTip("Play"))
        # next
        btnNext  = wx.BitmapButton(self, -1, wx.Bitmap('media/player_end.png'))
        btnNext.SetToolTip(wx.ToolTip("Next"))
        # prev
        btnPrev  = wx.BitmapButton(self, -1, wx.Bitmap('media/player_start.png'))
        btnPrev.SetToolTip(wx.ToolTip("Prev"))
        # random
        self.btnRandom  = wx.BitmapButton(self, -1, wx.Bitmap('media/misc.png'))
        if db['random']:
            self.btnRandom.SetToolTip(wx.ToolTip("Random (on)"))
        else:
            self.btnRandom.SetToolTip(wx.ToolTip("Random (off)"))
        # repeat
        self.btnRepeat  = wx.BitmapButton(self, -1, wx.Bitmap('media/redo.png'))
        if db['repeat']:
            self.btnRepeat.SetToolTip(wx.ToolTip("Repeat (on)"))
        else:
            self.btnRepeat.SetToolTip(wx.ToolTip("Repeat (off)"))
        # search
        self.tcSearch = wx.TextCtrl(self, -1, "", style=wx.SUNKEN_BORDER, size=(400,25))
        self.tcSearch.Bind(wx.EVT_KEY_UP, self.onSearch)
        # btn clear for searchCtrl
        btnClearSearch = wx.BitmapButton(self, -1, wx.Bitmap('media/fileclose.png'))
        btnClearSearch.SetToolTip(wx.ToolTip("Clear Search"))
        
        hbox2 = wx.BoxSizer(wx.HORIZONTAL)
        hbox2.Add(btnStop)
        hbox2.Add(btnPlay)
        hbox2.Add(btnPrev)
        hbox2.Add(btnNext)
        hbox2.Add(self.btnRandom, flag= wx.LEFT, border=30)
        hbox2.Add(self.btnRepeat)
        hbox2.Add(self.tcSearch, flag=wx.LEFT, border=30)
        hbox2.Add(btnClearSearch)
        
        vbox = wx.BoxSizer(wx.VERTICAL)
        vbox.Add(self.stCurrentTrack, flag=wx.ALL, border=5)
        vbox.Add(hbox1, flag=wx.ALL, border=5)
        vbox.Add(hbox2, flag=wx.ALL, border=5)
        
        self.SetSizer(vbox)
        ## GUI STOP

        
        # actions
        self.Bind(wx.EVT_BUTTON, self.onPlay, btnPlay)
        self.Bind(wx.EVT_BUTTON, self.onStop, btnStop)
        
        self.Bind(wx.EVT_BUTTON, self.onPrev, btnPrev)
        self.Bind(wx.EVT_BUTTON, self.onNext, btnNext)
        
        self.Bind(wx.EVT_BUTTON, self.onMute, self.btnVolume)
        
        self.Bind(wx.EVT_BUTTON, self.onRandom, self.btnRandom)
        self.Bind(wx.EVT_BUTTON, self.onRepeat, self.btnRepeat)
        
        self.Bind(wx.EVT_BUTTON, self.onClearSearch, btnClearSearch)
        
        
        self.Bind(wx.EVT_SLIDER, self.onTimeScroll)
    
    def onClearSearch(self, e):
        self.tcSearch.SetValue('')
        self.search()

    def updateControls(self):
        # slider: time
        cur = self.pls.current()
        mp3 = MP3(cur)
        tstop = mp3.length()

        tstart = pygame.mixer.music.get_pos()
        if tstart > 0 and self._playing:
            tstart = tstart / 1000
        else:
            tstart = 0
        self.sliTime.SetValue(tstart)

        # time start
        if tstart > 0 and self._playing:
            tpl_start = "%02d:%02d" %(tstart // 60., tstart % 60.)
            self.stTimeStart.SetLabel(tpl_start)
        else:
            self.stTimeStart.SetLabel('00:00')
        
        # current track
        tpl_track = "%s - %s (%s)" % (mp3.artist(), mp3.title(), mp3.album())
        self.stCurrentTrack.SetValue(tpl_track)
        
        if tstop > 0 and self._playing:
            tpl_stop = '%02d:%02d' % (tstop // 60., tstop % 60.)
            self.stTimeStop.SetLabel(tpl_stop)
            self.sliTime.SetValue(tstart * 100 / tstop)
            #print '%d' % (tstart * 100 / tstop)
        else:
            self.stTimeStop.SetLabel('00:00')
            self.sliTime.SetValue(0)
        
        self.sbar.SetStatusText('Tracks: %d' % self.pls.length(), 2)
        
        
        # volume
        #print self.sliVolume.GetValue(), "   "
        pygame.mixer.music.set_volume(self.sliVolume.GetValue() / 100.)
        #print self.sliVolume.GetValue()
        #self.sliVolume.SetValue(pygame.mixer.music.get_volume() * 100)
    
    def onMute(self, e):
        if self._mute:
            self.sliVolume.SetValue(db['volume'])
            pygame.mixer.music.set_volume(db['volume'] / 100.)
            self._mute = False
            print "unmute"
        else:
            self.sliVolume.SetValue(0)
            pygame.mixer.music.set_volume(0.0)
            self._mute = True
            print "mute"
        
    def onRandom(self, e):
        if db['random']:
            db['random'] = False
            print "Random: False"
            self.btnRandom.SetToolTip(wx.ToolTip("Random (off)"))
        else:
            db['random'] = True
            print "Random: True"
            self.btnRandom.SetToolTip(wx.ToolTip("Random (on)"))
    
    def onRepeat(self, e):
        if db['repeat']:
            db['repeat'] = False
            print "Repeat: False"
            self.btnRepeat.SetToolTip(wx.ToolTip("Repeat (off)"))
        else:
            db['repeat'] = True
            print "Repeat: True"
            self.btnRepeat.SetToolTip(wx.ToolTip("Repeat (on)"))
        
    def onSearch(self, e):
        if e.GetKeyCode() == wx.WXK_RETURN:
            p = self.tcSearch.GetValue()
            if p == '' or len(p) < 1:
                p = '%'
            self.search(p)
            
    def search(self, pattern='%'):
        self.pls.fill(self.pls.selectData(pattern))
    
    def onTimer(self, e):
        self.updateControls()
#        offset = self.mc.Tell()
#        curPosition = offset/1000
#        trkLength = self.mc.Length()/1000
#        
#        self.sliTimeScroll.SetValue(curPosition)
#        
#        tpl_start = "%02d:%02d" %(curPosition // 60., curPosition % 60.)
#        tpl_stop = "%02s:%02s" % (trkLength // 60, trkLength % 60)
#        tpl_track = "%s - %s" % (self.playlist.artist(), self.playlist.title())
#        
#        self.st_TimeStart.SetLabel(tpl_start)
#        self.st_TimeStop.SetLabel(tpl_stop)
#        self.st_curTrack.SetLabel(tpl_track)
    
    def onStop(self, e):
        self.stop()
        
    def stop(self):
        pygame.mixer.music.stop()
        self.timer.Stop()
        self._playing = False
        self.updateControls()

    def onPause(self, e):
        self.pause()
        
    def pause(self):
        if self.paused:
            pygame.mixer.music.unpause()
            print "unpause()"
        else:
            pygame.mixer.music.pause()
            print "pause()"

    def onPlay(self, e):
        self.play(self.pls.current())
        
    def play(self, item, start=0):
        print "playing %s" % item
        pygame.mixer.music.load(item)
        pygame.mixer.music.play(start)
        self._playing = True
        self.timer.Start(1000)
        #self.updateControls()
        #while pygame.mixer.music.get_busy():
        #    print ".",
        #    time.sleep(1)
    
    def _chk_repeat(self):
        if db['repeat']:
            self.next(self.pls.next())

    def onNext(self, e):
        path = self.pls.next()
        self.next(path)
        
    def next(self, item):
        self.play(item)

    def onPrev(self, e):
        self.play(self.pls.prev())

    def onTimeScroll(self, e):
        pass
        #print dir(e)
        
        #print "timescroll"
        #sv = self.sliTime.GetValue()
        #print "slider  %s", sv
#        t = self.mc.Tell()
#        curPosition = t/1000
#        trkLength = self.mc.Length()/1000
#        
#        offset = self.sliTimeScroll.GetValue()
#        print offset
#        print "sl#offset %s / %s" % (self.mc.Length() / 100 * offset, self.mc.Length())
#        self.mc.Seek(self.mc.Length() / 100. * offset)


class Persuader(wx.Frame):
    def __init__(self, *args, **kwargs):
        wx.Frame.__init__(self, *args, **kwargs)
        
        # taskbar icon        
        #self.tskic = PersuaderTrayIcon(self)        
        self.tbicon = wx.TaskBarIcon()
        icon = wx.Icon('media/atom.ico', wx.BITMAP_TYPE_ICO)
        self.tbicon.SetIcon(icon, 'persuader')
        
        self.statusbar = self.CreateStatusBar(3)
        self.statusbar.SetStatusText("Hallo", 0)
        self.statusbar.SetStatusText("da", 1)
        self.statusbar.SetStatusText("draussen", 2)
        
        wx.EVT_LEFT_DOWN(self.tbicon, self.onTBLC)

        self.SetMenuBar(self.init_menu())

        # Add the Widget Panel
        nb = wx.Notebook(self, -1, style=wx.NB_BOTTOM)
        pls = PlaylistCtrl(nb)
        cp = ControlPanel(self, pls, self.statusbar)
        
        #nb.AddPage(Playlist(nb), "Playlist")
        nb.AddPage(pls, "Playlist")
        nb.AddPage(MP3Tree(nb), "Collection")
        nb.AddPage(ArtistPanel(nb), "Artist")
        nb.AddPage(LyricPanel(nb), "Lyric")
        nb.AddPage(StatisticPanel(nb), "Stats")
        nb.AddPage(ConfigPanel(nb, pls), "Config")
        
        self.CreateStatusBar()
        
        sizer = wx.BoxSizer(wx.VERTICAL)
        sizer.Add(cp)
        sizer.Add(nb, flag=wx.EXPAND | wx.BOTTOM | wx.TOP | wx.ALL)

        self.SetSizer(sizer)
        self.SetSizerAndFit(sizer)
        self.Center()
        #self.Fit()

    def onTBLC(self, e):
        print "onTBLC"
    
    def init_menu(self):
        MenuBar = wx.MenuBar()
        mnuPersuade = wx.Menu()
        item = mnuPersuade.Append(wx.ID_EXIT, text="&Quit")
        self.Bind(wx.EVT_MENU, self.OnQuit, item)

        mnuPlaylist = wx.Menu()
        mnuPlaylist.Append(-1, text="neu")
        mnuPlaylist.Append(-1, text="laden")
        mnuPlaylist.Append(-1, text="speichern")
        mnuPlaylist.Append(-1, text="mischen")
        mnuPlaylist.Append(-1, text="leeren")

        mnuModus = wx.Menu()
        mnuModus.Append(-1, text="random")
        mnuModus.Append(-1, text="repeat")
        mnuModus.Append(-1, text="fav-playlist")
        mnuModus.Append(-1, text="666 random tracks")

        mnuQueue = wx.Menu()
        mnuQueue.Append(-1, text="verwalten")
        mnuQueue.Append(-1, text="...")

        MenuBar.Append(mnuPersuade, "&File")
        MenuBar.Append(mnuPlaylist, "&Playlist")
        MenuBar.Append(mnuModus, "&Modus")
        MenuBar.Append(mnuQueue, "&Queue")
        
        return MenuBar

    def OnQuit(self, event=None):
        self.Close()
        self.Destroy()

if __name__ == '__main__':
    app = wx.App()
    frame = Persuader(None, title="persuader", id=-1)
    frame.Show()
    app.MainLoop()
