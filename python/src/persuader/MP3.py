
__author__="thrstnh"
__date__ ="$24.03.2009 04:21:16$"

from mutagen.id3 import ID3
from mutagen.mp3 import MP3
import os.path

class MatMP3():
    def __init__(self, path):
        self.path = path
        if os.path.isfile(path):
            self.audio = ID3(path)
            self.mp3 = MP3(path)

    def tracknr(self):
        tracknr = (str(self.audio.get("TRCK", "none")))
        tracknr = tracknr.split('/')[0]
        return str(tracknr)

    def track_count(self):
        tracknr = (str(self.audio.get("TRCK", "none")))
        tracknr = tracknr.split('/')[1]
        return str(tracknr)

    def year(self):
        return str(self.audio.get('TDRC', 'none'))

    def title(self):
        return str(self.audio.get("TIT2", "none"))

    def artist(self):
        return str(self.audio.get("TPE1", "none"))

    def album(self):
        return str(self.audio.get("TALB", "none"))

    def genre(self):
        return str(self.audio.get('TCON', 'none'))
    
    def www(self):
        return str(self.audio.get('WXXX:', 'none'))

    def encoded(self):
        return str(self.audio.get('TENC', 'none'))

    def cdnr(self):
        return str(self.audio.get('TPOS', 'none'))

    def comment(self):
        return str(self.audio.get("COMM::'eng'", 'none'))
    
    def length(self):
        return self.mp3.info.length
    
    def bitrate(self):
        return self.mp3.info.bitrate



if __name__ == '__main__':
    p = '/home/user/skapunk.mp3'
    m = MatMP3(p)
    print 'Path:      %s' % p
    print 'Track:     %s / %s' % (m.tracknr(), m.track_count())
    print 'Year:      %s' % m.year()
    print 'Title:     %s' % m.title()
    print 'Artist:    %s' % m.artist()
    print 'Album:     %s' % m.album()
    print 'Genre:     %s' % m.genre()
    print 'WWW:       %s' % m.www()
    print 'Encoded:   %s' % m.encoded()
    print 'CD-NR:     %s' % m.cdnr()
    print 'Comment:   %s' % m.comment()
