#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
import arlog

__author__="thrstnh"
__date__ ="$08.12.2010 23:00:36$"

#arLogC = arlog.ArTCPLogClient('localhost', 4712, lazy=False)
## say hello =)
#arLogC.helo()

def decolog(target):
    def wrapper(*args, **kwargs):
        global arLogC
        if not arLogC:
            arLogC = arlog.ArTCPLogClient('localhost', 4712)
        arLogC.append('Calling function "%s" with arguments %s and keyword arguments %s' % (target.__name__, args, kwargs))
        return target(*args, **kwargs)
    return wrapper


def info(fname, expected, actual, flag):
    """ Convenience function returns nicely formatted error/warning msg. """
    format = lambda types: ', '.join([str(t).split("'")[1] for t in types])
    expected, actual = format(expected), format(actual)
    msg = "'%s' method " % fname \
          + ("accepts", "returns")[flag] + " (%s), but " % expected\
          + ("was given", "result is")[flag] + " (%s)" % actual
    return msg


def accepts(*types, **kw):
    """ Function decorator. Checks that inputs given to decorated function
    are of the expected type.

    Parameters:
    types -- The expected types of the inputs to the decorated function.
             Must specify type for each parameter.
    kw    -- Optional specification of 'debug' level (this is the only valid
             keyword argument, no other should be given).
             debug = ( 0 | 1 | 2 )

    """
    if not kw:
        # default level: MEDIUM
        debug = 1
    else:
        debug = kw['debug']
    try:
        def decorator(f):
            def newf(*args):
                if debug == 0:
                    return f(*args)
                assert len(args) == len(types)
                argtypes = tuple(map(type, args))
                if argtypes != types:
                    msg = info(f.__name__, types, argtypes, 0)
                    if debug == 1:
                        print >> sys.stderr, 'TypeWarning: ', msg
                    elif debug == 2:
                        raise TypeError, msg
                return f(*args)
            newf.__name__ = f.__name__
            return newf
        return decorator
    except KeyError, key:
        raise KeyError, key + "is not a valid keyword argument"
    except TypeError, msg:
        raise TypeError, msg


def returns(ret_type, **kw):
    """ Function decorator. Checks that return value of decorated function
    is of the expected type.

    Parameters:
    ret_type -- The expected type of the decorated function's return value.
                Must specify type for each parameter.
    kw       -- Optional specification of 'debug' level (this is the only valid
                keyword argument, no other should be given).
                debug=(0 | 1 | 2)

    """
    try:
        if not kw:
            # default level: MEDIUM
            debug = 1
        else:
            debug = kw['debug']
        def decorator(f):
            def newf(*args):
                result = f(*args)
                if debug == 0:
                    return result
                res_type = type(result)
                if res_type != ret_type:
                    msg = info(f.__name__, (ret_type,), (res_type,), 1)
                    if debug == 1:
                        print >> sys.stderr, 'TypeWarning: ', msg
                    elif debug == 2:
                        raise TypeError, msg
                return result
            newf.__name__ = f.__name__
            return newf
        return decorator
    except KeyError, key:
        raise KeyError, key + "is not a valid keyword argument"
    except TypeError, msg:
        raise TypeError, msg
