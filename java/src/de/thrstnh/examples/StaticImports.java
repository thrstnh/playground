/*
 * StaticImports.java
 * 
 * Created on 22.05.2007, 17:14:29
 */

package de.thrstnh.examples;

import static java.lang.Math.max;
import static java.lang.Math.pow;
import static java.lang.Math.abs;
import static java.lang.System.*;


/**
 *
 */
public class StaticImports {

    /**
     * some examples...
     */
    public StaticImports() {
        double a, b, c;
        a = 13.;
        b = 23.;
        c = 42.;
        
        // using the out-PrintStream without System-namespace =)
        out.format("\na := %10.3f \nb := %4.2f \nc :=  %5.0f \n\n", a, b, c);
        out.println("max(a,b) = " + max(a, b));
        out.println("pow(b,c) = " + pow(b, c));
        out.println("abs(-(a+b) = " + abs(-(a+b)));
        
    }
    
    /**
     *  example run...
     * @param args 
     */
    public static void main(String[] args) {
        new StaticImports();
    }


}
