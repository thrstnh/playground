class polynom:
    '''
    Diese Klasse repraesentiert ein Polynom
    '''
    def __init__(self, function={}):
        '''
        Initialisierung mit einer map bzw. einen dict
        dict:
           key:    exp
           value:  coeff
        '''
        self.function = function
        
    def add(self, map={}):
        '''
            Add a dict to the given function
        '''
        if map:
            for k,v in map.items():
                self.function[k] = v
        
    def highestExponent(self):
        '''
            return the highest exp of the given function
        '''
        if self.function:
            return int(max(self.function.keys()))
        return 0
        
    def eval(self, x):
        '''
            evaluates the value x for the given function
        '''
        highestExp = self.highestExponent()
        val = self.function.get(highestExp)
        for i in xrange(highestExp-1, -1, -1):
            val = (val * x)
            if(i in self.function.keys()):
                val = val + self.function.get(i)
        return val
    
    def deflection(self):
        '''
            calculates the deflection
        '''
        deflection = polynom()
        for k in self.function.keys():
            if(k != 0):
                deflection.add({k-1: self.function.get(k) * k})
        return deflection
    
    def gerschgorin(self):
        '''
            Gerschgorin-Kreis
        '''
        sumCoeff = 0.0
        highestExp = self.highestExponent()
        highestCoeff = 0.0
        lstCoeff = []
        
        for i in xrange(highestExp-1, -1, -1):
            if(i in self.function.keys()):
                sumCoeff = sumCoeff + abs(self.function.get(i))
                lstCoeff.append(1+abs(self.function.get(i)))
         
        highestCoeff = max(lstCoeff)
        #if(sumCoeff > highestCoeff):
        return highestCoeff
        #else:
        #    return sumCoeff
    
    def eval_zero_point(self, closeness=1.0E-5):
        '''
            evaluates the first zero_point
        '''
        zero_point = self.gerschgorin()
        diff = zero_point
        found = False
        deflection = self.deflection()
        while(not found):
            zero_point = diff - (self.eval(zero_point) / deflection.eval(zero_point))
            if(abs((zero_point-diff)/diff) > closeness):
                diff = zero_point
            else:
                found = True
        return zero_point
    
    def zero_points(self, closeness=1.0E-5):
        '''
            returns a list with all zero_points
        '''
        lst_zero_points = []
        zero_point = 0.0
        separation = self
        i = 1
        while(separation.highestExponent() > 0):
            zero_point = separation.eval_zero_point(closeness)
            lst_zero_points.append(zero_point)
            separation = separation.separation(zero_point, closeness)
            print "sep: " + str(separation)
            i = i+1
        return lst_zero_points
                                 
                                 
    def separation(self, zero_point, closeness=1.0E-5):
        '''
            seperation after the horner-scheme
        '''
        p = 0.0
        separation = polynom({})
        for i in xrange(self.highestExponent(), 0, -1):
            p = p * zero_point
            if self.function.has_key(i):
                p = p + self.function.get(i)
                if(abs(p) > closeness):
                    separation.add({ i-1 : p})
        return separation
            
    def __str__(self):
        '''
            string-representation of the given polynom
        '''
        from UserString import MutableString
        highestExp = self.highestExponent()
        rts = MutableString("")
        rts = str(self.function.get(highestExp))
        if(highestExp > 0):
            rts += "x"
        if(highestExp > 1):
            rts += "^"
            rts += str(highestExp)
        for i in xrange(highestExp-1, -1, -1):
            if(i in self.function.keys()):
               if(self.function.get(i) < 0):
                   rts += " - "
               else:
                   rts += " + "
               rts+= str(abs(self.function.get(i)))
               if(i > 0):
                   rts += "x"
                   if(i > 1):
                       rts += "^"
                       rts += str(i)
        
        return rts
