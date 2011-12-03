/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package de.haw.is.m;

import java.util.Random;

/**
 *
 */
public class Mask {
     public static void main(String[] args) {
        int[][] m = new int[40][40];
        Random rand = new Random(42);

        System.out.println("{");
        for (int i = 0; i < 40; i++) {
            System.out.print("{");
            for (int j = 0; j < 40; j++) {
                if(j == 40-1)
                    System.out.print(rand.nextInt(9));
                else
                    System.out.print(rand.nextInt(9)+", ");
                //m[i][j] = rand.nextInt(9);
            }
            System.out.println("},");
        }
        System.out.println("};");
    }


}
