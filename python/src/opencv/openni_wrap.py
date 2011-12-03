#!/usr/bin/env python
import opennpy
import cv
import frame_convert
import time

cv.NamedWindow('Depth')
cv.NamedWindow('Video')
print('Press ESC in window to stop')


def edge_detection(position):
    # convert to grayscale
    gray = cv.CreateImage((img.width, img.height), 8, 1)
    edge = cv.CreateImage((img.width, img.height), 8, 1)
    # create out image
    img_out = cv.CreateImage((img.width, img.height), 8, 3)
    cv.CvtColor(img, gray, cv.CV_BGR2GRAY)
    cv.Smooth(gray, edge, cv.CV_BLUR, 3, 3, 0)
    cv.Not(gray, edge)
    # run edge detector on gray scale
    cv.Canny(gray, edge, position, position*3, 3)
    # reset
    cv.SetZero(img_out)
    # copy edge points
    cv.Copy(img, img_out, edge)
    # show the img
    cv.ShowImage('Video', img_out)


def get_depth():
    return frame_convert.pretty_depth_cv(opennpy.sync_get_depth()[0])


def get_video():
    return frame_convert.video_cv(opennpy.sync_get_video()[0])


t_start = time.time()
t_temp = time.time()
print('%s starting...' % t_start)

fps = 0

while 1:
    fps = fps + 1
    if time.time() - t_temp > 1.0:
        print "%3ds   fps: %d" % (time.time()-t_start, fps)
        t_temp = time.time()
        fps = 0

    cv.ShowImage('Depth', get_depth())

    img = get_video()
    
    edge_detection(0)
#    cv.ShowImage('Video', get_video())
    if cv.WaitKey(10) == 27:
        break