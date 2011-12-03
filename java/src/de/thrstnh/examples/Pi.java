/*
 * Pi.java
 * 
 * Created on 22.05.2007, 17:47:08
 */

package de.thrstnh.examples;

import java.util.Scanner;
import static java.lang.System.out;
import static java.lang.Math.random;
import static java.lang.Math.sqrt;
import static java.lang.Math.PI;

/**
 *
 */;
public class Pi {
    
    private double count;
    private double x, y, pi;
    private double z = 0.0;
    private double sum = 0.0;
    private Scanner in = new Scanner(System.in);
    
    public Pi() {
        out.println("Berechnung von PI nach der Regentropfen-Methode");
        out.println("Bitte Anzahl der Regentropfen eingeben: ");
        this.count = in.nextDouble();
        
        for(int i=0; i<this.count; i++) {
            this.x = random();
            this.y = random();
            
            if(sqrt(x*x + y*y) < 1)
                z = z + 1.0;
            sum = sum + 1.0;
        }
        
        pi = z / sum * 4.0;
        out.format("\nPI errechnet mit %013.0f Schritten: %23.22f \n", this.count, this.pi);
        out.println("\nZum Vergleich Math.PI: " + PI);
    }
    
    public static void main(String[] args) {
        new Pi();
    }
}
