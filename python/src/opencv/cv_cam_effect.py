import cv
import time

'''
quick doc:

Smooth(src, dst, smoothtype=CV_GAUSSIAN, param1=3, param2=0, param3=0, param4=0) None
Canny(image, edges, threshold1, threshold2, aperture_size=3) None
CreateImage(size, depth, channels) image
Threshold(src, dst, threshold, maxValue, thresholdType)
AbsDiffS(src, value, dst)


'''
# global vars
trackbar_name = 'Threshold'
trackbar_pos = 0
fps = 0
TIME_PATTERN = '%Y-%m-%d--%H:%M:%S'

# laplace vars
laplace = None
colorlaplace = None
planes = [ None, None, None ]


def now():
    return time.strftime(TIME_PATTERN)

def edge_detection(position):
    global trackbar_pos
    if trackbar_pos != position:
        trackbar_pos = position
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
    cv.ShowImage('edge_detection', img_out)


def apply_laplace():
    global laplace
    global planes
    global colorlaplace
    if not laplace:
        planes = [cv.CreateImage((img.width, img.height), 8, 1) for i in range(3)]
        laplace = cv.CreateImage((img.width, img.height), cv.IPL_DEPTH_16S, 1)
        colorlaplace = cv.CreateImage((img.width, img.height), 8, 3)

    cv.Split(img, planes[0], planes[1], planes[2], None)
    for plane in planes:
        cv.Laplace(plane, laplace, 3)
        cv.ConvertScaleAbs(laplace, plane, 1, 0)

    cv.Merge(planes[0], planes[1], planes[2], None, colorlaplace)

    cv.ShowImage('laplace', colorlaplace)


def bg_sub(image, n=[]):
    image = cv.GetMat(image)
    if len(n) < 5:
        n.append(image)
        return image
    n.append(image)
    if len(n) > 7:
        del n[0]
    
    original = n[3]
    diffImage = cv.CloneMat(image)
    cv.AbsDiff(image, original, diffImage)
    thresholdValue = 20
    cv.Threshold(diffImage, diffImage, thresholdValue, 255, cv.CV_THRESH_BINARY)

    gray = cv.CreateImage(cv.GetSize(diffImage), 8, 1)
    cv.CvtColor(diffImage, gray, cv.CV_BGR2GRAY)

    cv.Smooth(gray, gray, cv.CV_MEDIAN, 15)
    result = cv.CloneMat(image)
    cv.SetZero(result)
    
    cv.And(image, image, result, gray)
    cv.ShowImage('bg_sub', result)

def good_features():
    gray = cv.CreateImage((img.width, img.height), 8, 1)
    cv.CvtColor(img, gray, cv.CV_BGR2GRAY)
    eigImage = cv.CreateImage(cv.GetSize(gray), cv.IPL_DEPTH_32F, 1)
    tempImage = cv.CreateImage(cv.GetSize(gray), cv.IPL_DEPTH_32F, 1)

    cornerMem = []
    cornerCount = 300
    qualityLevel = 0.1
    minDistance = 5
    cornerMem = cv.GoodFeaturesToTrack(gray, eigImage, tempImage,  cornerCount, qualityLevel, minDistance, None, 3, False)

    print len(cornerMem), " corners found"
    print cornerMem
    # Find up to 300 corners using Harris
    for point in cornerMem:
        center = int(point[0]), int(point[1])
        cv.Circle(img, (center), 2, (0,255,255))
    cv.ShowImage('good_features', tempImage)
#    for (x,y) in cv.GoodFeaturesToTrack(img, eigImage, tempImage, 300, None, 1.0, use_harris = True):
#        print "good feature at", x,y

if __name__ == '__main__':
    capture = cv.CreateCameraCapture(0)

    width = 800
    height = 600

    cv.SetCaptureProperty(capture, cv.CV_CAP_PROP_FRAME_WIDTH, width)
    cv.SetCaptureProperty(capture, cv.CV_CAP_PROP_FRAME_HEIGHT, height)

    result = cv.CreateImage((width,height), cv.IPL_DEPTH_8U, 3)

    print('resolution: %dx%d' % (width, height))

    cv.NamedWindow('edge_detection', cv.CV_WINDOW_AUTOSIZE)
    cv.NamedWindow('bg_sub', cv.CV_WINDOW_AUTOSIZE)
    cv.NamedWindow('good_features', cv.CV_WINDOW_AUTOSIZE)
    cv.NamedWindow('laplace', cv.CV_WINDOW_AUTOSIZE)

    cv.CreateTrackbar(trackbar_name, 'edge_detection', 1, 100, edge_detection)

    t_start = time.time()
    t_temp = time.time()
    print('%s starting...' % t_start)

    while True:
        fps = fps + 1
        if time.time() - t_temp > 1.0:
            print "%3ds   fps: %d" % (time.time()-t_start, fps)
            t_temp = time.time()
            fps = 0

        img = cv.QueryFrame(capture)




        # create trackbar

#        tbpos = cv.GetTrackbarPos(trackbar_name, win_name)
#        print "pos: ", type(tbpos), tbpos
        edge_detection(trackbar_pos)
        good_features()
        apply_laplace()


    #    cv.Smooth(img,result,cv.CV_GAUSSIAN,9,9)
    #        cv.Dilate(img,result,None,5) #uncommet to apply affect
    #        cv.Erode(img,result,None,1) #uncommet to apply affect
    #        cv.Smooth(img,result,cv.CV_GAUSSIAN) #uncommet to apply affect
#        cv.ShowImage("camera", img_out)
        k = cv.WaitKey(10);
        if k == 'f':
            break