/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.m;

import java.util.Random;
import static de.haw.is.v.View.*;

/**
 *
 */
public class Model {

    // Breite von einem Feld
    public int height;
    // Hoehe von einem Feld
    public int width;
    // Rand
    public int offset;
    // Anzahl horizontal
    public int x;
    // Anzahl vertikal
    public int y;
    
//    private int[][] mask = {       
//        {1, 8, 1, 1, 2, 8, 0, 7, 6, 0, 4, 7, 6, 1, 0},
//        {0, 3, 8, 5, 7, 0, 2, 1, 1, 3, 4, 7, 7, START, 0},
//        {3, 6, 1, 0, 6, 6, 2, 7, 5, 6, 5, 8, 1, 0, 0},
//        {1, 5, BARRIER, 5, 1, 5, 7, 2, BARRIER, 2, 2, 0, 8, 3, 6},        
//        {1, 0, BARRIER, 1, 2, 8, 1, 3, BARRIER, 0, 6, 6, 0, 8, 2},
//        {3, 3, BARRIER, 6, 7, 4, 5, 2, BARRIER, 2, 7, 6, 8, 1, 8},
//        {0, 6, BARRIER, 0, 1, 2, 4, 4, BARRIER, 2, 7, 8, 5, 6, 6},
//        {3, 3, BARRIER, 3, 7, 3, 5, 3, BARRIER, 8, 4, 8, 1, 6, 8},
//        {6, 0, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, 7, 5, 0, 8, 7, 7},
//        {4, 7, 6, 2, 0, 1, 0, 2, 3, 2, 3, 8, 2, 5, 6},
//        {2, 7, 8, 2, 2, 7, 3, 4, 6, 1, 8, 5, 1, 5, 2},
//        {6, 7, 6, 5, 8, 6, 2, 2, 5, 0, 5, 5, 3, 7, 4},
//        {8, 5, 1, 8, 4, 4, 5, 2, 0, 4, 4, 1, 1, 6, 1},
//        {6, FINISH, 5, 5, 1, 5, 8, 0, 0, 2, 8, 6, 8, 5, 6},
//        {5, 4, 1, 0, 4, 8, 8, 6, 6, 1, 5, 1, 2, 2, 1}};

//           {1, 8, 1, 1, 2, 8, 0, 7, 6, 0, 4, 7, 6, 1, 0},
//        {0, 3, 8, 5, 7, 0, 2, 1, 1, 3, 4, 7, 7, START, 0},
//        {3, 6, 1, 0, 6, 6, 2, 7, 5, 6, 5, 8, 1, 0, 0},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 99, 0, 8, 3, 6},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 6, 6, 0, 8, 2},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 7, 6, 8, 1, 8},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 7, 8, 5, 6, 6},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 4, 8, 1, 6, 8},
//        {6, 0, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, 7, 5, 0, 8, 7, 7},
//        {4, 7, 6, 2, 0, 1, 0, 2, 3, 2, 3, 8, 2, 5, 6},
//        {2, 7, 8, 2, 2, 7, 3, 4, 6, 1, 8, 5, 1, 5, 2},
//        {6, 7, 6, 5, 8, 6, 2, 2, 5, 0, 5, 5, 3, 7, 4},
//        {8, 5, 1, 8, 4, 4, 5, 2, 0, 4, 4, 1, 1, 6, 1},
//        {6, FINISH, 5, 5, 1, 5, 8, 0, 0, 2, 8, 6, 8, 5, 6},
//        {5, 4, 1, 0, 4, 8, 8, 6, 6, 1, 5, 1, 2, 2, 1}};
        
        
//        {99, 99, 99, 99, 2, 8, 0, 7, 6, 0, 4, 7, 6, 1, 0},
//        {99, 99, 99, 99, 7, 0, 2, 1, 1, 3, 4, 7, 7, START, 0},
//        {99, 99, 99, 99, 6, 6, 2, 7, 5, 6, 5, 8, 1, 0, 0},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 99, 0, 8, 3, 6},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 6, 6, 0, 8, 2},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 7, 6, 8, 1, 8},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 7, 8, 5, 6, 6},
//        {99, 99, BARRIER, 99, 99, 99, 99, 99, BARRIER, 99, 4, 8, 1, 6, 8},
//         {6, 0, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, BARRIER, 7, 5, 0, 8, 7, 7},
//        {4, 7, 6, 2, 0, 99, 99, 99, 3, 2, 3, 8, 2, 5, 6},
//        {2, 7, 8, 2, 2, 99, 99, 99, 6, 1, 8, 5, 1, 5, 2},
//        {6, 7, 6, 5, 8, 99, 99, 99, 5, 0, 5, 5, 3, 7, 4},
//        {8, 5, 1, 8, 4, 99, 99, 99, 0, 4, 4, 1, 1, 6, 1},
//        {6, FINISH, 5, 1, 1, 1, 8, 0, 0, 2, 8, 6, 8, 5, 6},
//        {5, 4, 1, 0, 4, 8, 8, 6, 6, 1, 5, 1, 2, 2, 1}};        

//    private int[][] mask = {
//        {8, 3, 0, 8, 0, 7, 5, 2, 7, 2, 2, 8, 6, 0, 8, 5, 6, 6, 1, 8, 5, 4, 8, 6, 5, 0, 7, 4, 1, 3, 4, 3, 2, 5, 2, 5, 3, 7, 7, 3},
//        {5, 4, 8, 7, 5, 6, 4, 2, 1, 7, 4, 5, 8, 4, 8, 7, 1, 4, 3, 0, 1, 5, 2, 4, 8, 5, 5, 4, 3, 0, 1, 5, 4, 7, 7, 5, 5, 7, 2, 6},
//        {3, 1, 5, 2, 1, 6, 3, 3, 5, 7, 0, 3, 3, 0, 5, 6, 3, 6, 8, 4, 3, 1, 6, 1, 8, 4, 0, 8, 4, 2, 8, 1, 3, 7, 3, 3, 7, 7, 8, 6},
//        {3, 6, 2, 4, 8, 3, 4, 0, 7, 1, 4, 8, 4, 4, 0, 5, 6, 2, 8, 4, 2, 5, 4, 8, 8, 5, 0, 8, 4, 2, 4, 2, 2, 3, 1, 4, START, 8, 2, 3},
//        {4, 3, 2, 5, 1, 6, 5, 6, 2, 4, 5, 8, 0, 6, 4, 3, 0, 3, 7, 4, 2, 4, 2, 7, 0, 8, 0, 6, 3, 6, 8, 0, 2, 1, 0, 2, 5, 5, 7, 3},
//        {3, 8, 3, 8, 2, 7, 3, 7, 4, 8, 3, 7, 5, 4, 1, 7, 2, 8, 2, 4, 8, 8, 7, 5, 3, 8, 4, 1, 1, 4, 3, 4, 4, 6, 0, 0, 7, 6, 8, 3},
//        {6, 0, 5, 1, 3, 3, 7, 5, 3, 4, 0, 6, 2, 3, 3, 3, 2, 6, 6, 4, 5, 0, 3, 7, 1, 4, 8, 2, 0, 0, 5, 3, 3, 1, 5, 3, 3, 4, 3, 7},
//        {4, 2, 6, 0, 4, 6, 4, 2, 6, 8, 6, 0, 4, 5, 2, 8, 3, 1, 5, 7, 2, 4, 3, 3, 0, 0, 1, 7, 1, 2, 2, 2, 4, 8, 2, 5, 7, 7, 6, 5},
//        {6, 4, 3, 4, 2, 0, 5, 5, 6, 3, 5, 5, 2, 7, 8, 5, 7, 1, 7, 2, 3, 3, 6, 0, 1, 8, 4, 6, 3, 2, 6, 7, 6, 3, 3, 1, 7, 2, 1, 4},
//        {8, 8, 3, 1, 4, 0, 8, 3, 2, 5, 0, 0, 7, 6, 2, 4, 4, 5, 8, 1, 3, 8, 0, 1, 3, 5, 2, 1, 8, 3, 5, 1, 2, 5, 1, 2, 0, 8, 6, 4},
//        {1, 7, 1, 2, 7, 8, 7, 2, 0, 7, 4, 6, 4, 0, 4, 0, 6, 5, 1, 2, 4, 0, 2, 3, 5, 7, 2, 0, 0, 0, 2, 7, 4, 7, 7, 3, 2, 5, 8, 2},
//        {3, 5, 0, 2, 6, 0, 8, 1, 6, 0, 0, 0, 7, 8, 2, 4, 4, 4, 7, 1, 0, 0, 6, 0, 3, 6, 6, 8, 3, 0, 2, 4, 7, 0, 2, 0, 0, 0, 0, 1},
//        {5, 2, 6, 8, 0, 3, 5, 6, 0, 4, 3, 5, 1, 1, 4, 1, 4, 6, 1, 0, 8, 1, 7, 5, 8, 6, 6, 3, 5, 4, 2, 1, 4, 1, 7, 8, 7, 4, 0, 4},
//        {0, 4, 2, 0, 3, 5, 5, 0, 3, 0, 3, 0, 1, 4, 4, 2, 0, 0, 7, 3, 4, 1, 7, 2, 5, 6, 6, 4, 5, 0, 2, 5, 3, 1, 8, 2, 2, 4, 7, 7},
//        {0, 6, 4, 1, 1, 5, 3, 6, 0, 8, 6, 0, 2, 5, 8, 4, 2, 6, 5, 7, 6, 8, 6, 8, 5, 2, 6, 1, 4, 4, 4, 4, 8, 2, 6, 5, 2, 3, 2, 6},
//        {7, 4, 6, 8, 7, 5, 6, 0, 5, 6, 5, 8, 5, 2, 4, 6, 3, 7, 4, 2, 7, 4, 3, 1, 4, 8, 8, 6, 8, 8, 3, 7, 3, 4, 6, 8, 1, 4, 5, 0},
//        {5, 2, 8, 1, 8, 4, 2, 0, 6, 7, 7, 3, 5, 8, 5, 5, 3, 4, 7, 1, 7, 4, 7, 8, 2, 5, 3, 7, 7, 7, 7, 5, 5, 5, 1, 4, 7, 2, 6, 1},
//        {1, 7, 3, 4, 1, 1, 1, 4, 4, 1, 3, 6, 7, 6, 2, 4, 0, 2, 8, 3, 5, 8, 7, 3, 1, 1, 4, 3, 0, 4, 3, 8, 5, 0, 0, 6, 0, 1, 8, 5},
//        {2, 4, 0, 1, 4, 6, 3, 4, 5, 6, 1, 2, 1, 6, 5, 4, 6, 7, 8, 2, 5, 1, 3, 1, 4, 8, 1, 7, 7, 6, 8, 8, 1, 7, 4, 8, 3, 5, 7, 3},
//        {4, 8, 4, 0, 3, 4, 2, 7, 2, 5, 2, 4, 1, 4, 0, 7, 6, 3, 1, 6, 3, 7, 0, 5, 6, 5, 5, 3, 5, 2, 8, 3, 3, 7, 4, 2, 8, 7, 0, 6},
//        {3, 1, 6, 7, 1, 7, 8, 5, 3, 2, 6, 0, 0, 8, 0, 3, 1, 0, 1, 5, 2, 2, 5, 2, 8, 1, 4, 8, 1, 7, 4, 1, 7, 4, 4, 1, 1, 5, 7, 2},
//        {6, 4, 5, 5, 6, 7, 5, 5, 1, 2, 5, 8, 1, 5, 7, 4, 6, 3, 7, 6, 1, 4, 4, 3, 0, 1, 1, 6, 4, 8, 0, 1, 3, 4, 8, 6, 5, 5, 0, 5},
//        {3, 6, 0, 6, 2, 1, 4, 1, 8, 8, 3, 1, 5, 7, 5, 4, 0, 4, 7, 0, 1, 4, 1, 0, 0, 2, 3, 1, 5, 5, 0, 2, 8, 1, 6, 4, 0, 6, 5, 3},
//        {5, 4, 8, 5, 7, 6, 1, 0, 0, 7, 5, 7, 2, 7, 6, 5, 6, 5, 5, 6, 7, 1, 2, 1, 1, 5, 3, 0, 0, 3, 4, 5, 7, 0, 8, 0, 3, 1, 5, 5},
//        {5, 4, 8, 2, 7, 6, 8, 5, 3, 6, 5, 1, 0, 2, 2, 4, 4, 0, 5, 3, 2, 4, 0, 6, 7, 3, 5, 4, 8, 7, 8, 3, 5, 3, 2, 3, 3, 5, 0, 4},
//        {8, 7, 5, 4, 0, 8, 3, 1, 2, 4, 0, 8, 1, 8, 0, 8, 3, 0, 8, 3, 5, 6, 6, 3, 1, 7, 6, 2, 7, 8, 0, 6, 4, 3, 6, 7, 0, 2, 3, 0},
//        {0, 6, 8, 4, 8, 6, 8, 1, 6, 6, 2, 6, 7, 2, 5, 0, 5, 4, 0, 5, 4, 1, 1, 4, 5, 6, 8, 8, 2, 2, 4, 7, 0, 2, 2, 5, 2, 4, 5, 8},
//        {3, 1, 5, 3, 7, 8, 0, 6, 4, 8, 8, 0, 4, 2, 6, 3, 8, 2, 3, 4, 1, 8, 0, 1, 2, 2, 7, 8, 1, 7, 3, 4, 2, 8, 1, 3, 3, 3, 0, 7},
//        {8, 0, 2, 0, 0, 5, 6, 4, 2, 6, 5, 1, 4, 5, 8, 3, 1, 8, 0, 2, 1, 4, 0, 8, 8, 4, 7, 4, 6, 7, 6, 7, 8, 1, 6, 1, 4, 8, 8, 8},
//        {0, 8, 0, 2, 6, 4, 2, 5, 3, 7, 3, 5, 2, 7, 7, 4, 6, 2, 0, 0, 1, 7, 3, 2, 3, 6, 2, 1, 2, 5, 3, 4, 6, 3, 8, 4, 6, 3, 2, 7},
//        {3, 3, 6, 1, 1, 4, 0, 6, 6, 4, 8, 4, 3, 1, 5, 3, 2, 5, 8, 2, 1, 1, 6, 7, 3, 8, 3, 0, 1, 3, 1, 6, 2, 0, 5, 7, 8, 8, 1, 4},
//        {2, 7, 8, 1, 2, 8, 7, 8, 2, 8, 2, 7, 3, 5, 0, 4, 4, 1, 5, 4, 3, 2, 3, 0, 4, 2, 3, 3, 5, 2, 3, 7, 3, 3, 0, 6, 8, 0, 8, 0},
//        {1, 4, 2, 1, 6, 2, 6, 3, 0, 5, 2, 3, 8, 5, 2, 6, 1, 6, 3, 1, 3, 7, 3, 1, 2, 3, 7, 7, 6, 3, 6, 5, 4, 0, 8, 2, 8, 4, 0, 7},
//        {5, 2, 6, 2, 2, 8, 5, 1, 3, 1, 4, 8, 7, 3, 4, 4, 5, 1, 4, 7, 2, 2, 4, 6, 4, 5, 6, 7, 4, 1, 6, 5, 8, 4, 3, 4, 3, 5, 6, 4},
//        {6, 7, 3, 3, 3, 3, 4, 8, 3, 3, 8, 6, 0, 4, 3, 8, 5, 6, 8, 0, 7, 0, 1, 7, 3, 0, 6, 3, 0, 0, 8, 2, 5, 7, 1, 7, 5, 6, 7, 7},
//        {7, 3, 5, 7, 8, 8, 8, 5, 2, 2, 6, 5, 4, 4, 1, 5, 6, 6, 7, 8, 2, 7, 4, 4, 6, 6, 1, 8, 7, 3, 7, 3, 5, 8, 3, 3, 2, 7, 5, 3},
//        {4, 1, 8, FINISH, 7, 7, 3, 7, 5, 8, 0, 3, 0, 1, 8, 7, 7, 1, 7, 8, 1, 3, 6, 4, 6, 2, 1, 0, 1, 6, 0, 5, 4, 5, 4, 0, 2, 0, 0, 6},
//        {2, 4, 0, 2, 4, 6, 6, 7, 6, 0, 1, 1, 2, 5, 5, 0, 1, 8, 5, 1, 6, 6, 1, 0, 5, 8, 2, 6, 4, 3, 4, 1, 8, 4, 0, 0, 5, 7, 2, 0},
//        {2, 0, 7, 6, 7, 8, 0, 6, 2, 0, 2, 8, 1, 1, 6, 2, 4, 6, 3, 6, 7, 1, 1, 3, 6, 8, 1, 0, 5, 6, 2, 7, 8, 7, 4, 7, 7, 4, 7, 7},
//        {5, 6, 3, 5, 5, 8, 3, 7, 3, 0, 8, 8, 7, 7, 1, 6, 8, 4, 5, 4, 7, 1, 0, 1, 5, 1, 8, 2, 7, 1, 7, 0, 4, 6, 0, 3, 3, 0, 8, 1},
//        };

        private int[][] mask = {
        {8, 3, 0, 8, 0, 7, 5, 2, 7, 2, 2, 8, 6, 0, 8, 5, 6, 6, 1, 8, 5, 4, 8, 6, 5, 0, 7, 4, 1, 3, 4, 3, 2, 5, 2, 5, 3, 7, 7, 3},
        {5, 4, 8, 7, 5, 6, 4, 2, _, _, _, _, _, _, 8, 7, 1, 4, 3, 0, 1, 5, 2, 4, 8, 5, 5, 4, 3, 0, 1, 5, 4, 7, 7, 5, 5, 7, 2, 6},
        {3, 1, 5, 2, 1, 6, 3, 3, _, 7, 0, 3, 3, 0, 5, 6, 3, 6, 8, 4, 3, 1, 6, 1, 8, 4, 0, 8, 4, 2, 8, 1, 3, 7, 3, 3, 7, 7, 8, 6},
        {3, 6, 2, 4, 8, 3, 4, 0, _, 1, 4, 8, 4, 4, 0, 5, 6, 2, 8, 4, 2, 5, 4, 8, 8, 5, 0, 8, 4, 2, 4, 2, 2, 3, 1, 4, START, 8, 2, 3},
        {4, 3, 2, 5, 1, 6, 5, 6, _, 4, 5, 8, 0, 6, 4, 3, 0, 3, 7, 4, 2, 4, 2, 7, 0, 8, 0, 6, 3, 6, 8, 0, 2, 1, 0, 2, 5, 5, 7, 3},
        {3, 8, 3, 8, 2, 7, 3, 7, _, 8, 3, 7, 5, 4, 1, 7, 2, 8, 2, 4, 8, 8, 7, 5, 3, 8, 4, 1, 1, 4, 3, 4, 4, 6, 0, 0, 7, 6, 8, 3},
        {6, 0, 5, 1, 3, 3, 7, 5, _, 4, 0, 6, 2, 3, 3, 3, 2, 6, 6, 4, 5, 0, 3, 7, 1, 4, 8, 2, 0, 0, 5, 3, 3, 1, 5, 3, 3, 4, 3, 7},
        {4, 2, 6, 0, 4, 6, 4, 2, _, 8, 6, 0, 4, 5, 2, 8, 3, 1, 5, 7, 2, 4, 3, 3, 0, 0, 1, 7, 1, 2, 2, 2, 4, 8, 2, 5, 7, 7, 6, 5},
        {6, 4, 3, 4, 2, 0, 5, 5, _, 3, 5, 5, 2, 7, 8, 5, 7, 1, 7, 2, 3, 3, 6, 0, 1, 8, 4, 6, 3, 2, 6, 7, 6, 3, 3, 1, 7, 2, 1, 4},
        {8, 8, 3, 1, 4, 0, 8, 3, _, _, _, _, _, _, _, _, _, _, _, _, _, 8, 0, 1, 3, 5, 2, 1, 8, 3, 5, 1, 2, 5, 1, 2, 0, 8, 6, 4},
        {1, 7, 1, 2, 7, 8, 7, 2, 0, 7, 4, 6, 4, 0, 4, 0, 6, 5, 1, 2, 4, 0, 2, 3, 5, 7, 2, 0, 0, 0, 2, 7, 4, 7, 7, 3, 2, 5, 8, 2},
        {3, 5, 0, 2, 6, 0, 8, 1, 6, 0, 0, 0, 7, 8, 2, 4, 4, 4, 7, 1, 0, 0, 6, 0, 3, 6, 6, 8, 3, 0, 2, 4, 7, 0, 2, 0, 0, 0, 0, 1},
        {5, 2, 6, 8, 0, 3, 5, 6, 0, 4, 3, _, _, _, _, _, 4, 6, 1, 0, 8, 1, 7, 5, 8, 6, 6, 3, 5, 4, 2, 1, 4, 1, 7, 8, 7, 4, 0, 4},
        {0, 4, 2, 0, 3, 5, 5, 0, 3, 0, 3, _, _, _, _, _, 0, 0, 7, 3, 4, 1, 7, 2, 5, 6, 6, 4, 5, 0, 2, 5, 3, 1, 8, 2, 2, 4, 7, 7},
        {0, 6, 4, 1, 1, 5, 3, 6, 0, 8, _, _, _, _, _, _, 2, 6, 5, 7, 6, 8, 6, 8, 5, 2, 6, 1, 4, 4, 4, 4, 8, 2, 6, 5, 2, 3, 2, 6},
        {7, 4, 6, 8, 7, 5, 6, 0, 5, 6, _, _, _, _, _, _, 3, 7, 4, 2, 7, 4, 3, 1, 4, 8, 8, 6, 8, 8, 3, 7, 3, 4, 6, 8, 1, 4, 5, 0},
        {5, 2, 8, 1, 8, 4, 2, 0, 6, 7, _, _, _, _, _, _, 3, 4, 7, 1, 7, 4, 7, 8, 2, 5, 3, 7, 7, 7, 7, 5, 5, 5, 1, 4, 7, 2, 6, 1},
        {1, 7, 3, 4, 1, 1, 1, 4, 4, 1, _, _, _, _, _, _, 0, 2, 8, 3, 5, 8, 7, 3, 1, 1, 4, 3, 0, 4, 3, 8, 5, 0, 0, 6, 0, 1, 8, 5},
        {2, 4, 0, 1, 4, 6, 3, 4, 5, 6, _, _, _, _, _, _, 6, 7, 8, 2, 5, 1, 3, 1, 4, 8, 1, 7, 7, 6, 8, 8, 1, 7, 4, 8, 3, 5, 7, 3},
        {4, 8, 4, 0, 3, 4, 2, 7, 2, 5, _, _, _, _, _, _, 6, 3, 1, 6, 3, 7, 0, 5, 6, 5, 5, 3, 5, 2, 8, 3, 3, 7, 4, 2, 8, 7, 0, 6},
        {3, 1, 6, 7, 1, 7, 8, 5, 3, 2, _, _, _, _, _, _, 1, 0, 1, 5, 2, 2, 5, 2, 8, 1, 4, 8, 1, 7, 4, 1, 7, 4, 4, 1, 1, 5, 7, 2},
        {6, 4, 5, 5, 6, 7, 5, 5, 1, 2, _, _, _, _, _, _, 6, 3, 7, 6, 1, 4, 4, 3, 0, 1, 1, 6, 4, 8, 0, 1, 3, 4, 8, 6, 5, 5, 0, 5},
        {3, 6, 0, 6, 2, 1, 4, 1, 8, 8, _, _, _, _, _, _, 0, 4, 7, 0, 1, 4, 1, 0, 0, 2, 3, 1, 5, 5, 0, 2, 8, 1, 6, 4, 0, 6, 5, 3},
        {5, 4, 8, 5, 7, 6, 1, 0, 0, 7, _, _, _, _, _, _, 6, 5, 5, 6, 7, 1, 2, 1, 1, 5, 3, 0, 0, 3, 4, 5, 7, 0, 8, 0, 3, 1, 5, 5},
        {5, 4, 8, 2, 7, 6, 8, 5, 3, 6, _, _, _, _, _, _, 4, 0, 5, 3, 2, 4, 0, 6, 7, 3, 5, 4, 8, 7, 8, 3, 5, 3, 2, 3, 3, 5, 0, 4},
        {8, 7, 5, 4, 0, 8, 3, 1, 2, 4, _, _, _, _, _, _, 3, 0, 8, 3, 5, 6, 6, 3, 1, 7, 6, 2, 7, 8, 0, 6, 4, 3, 6, 7, 0, 2, 3, 0},
        {0, 6, 8, 4, 8, 6, 8, 1, 6, 6, _, _, _, _, _, _, 5, 4, 0, 5, 4, 1, 1, 4, 5, 6, 8, 8, 2, 2, 4, 7, 0, 2, 2, 5, 2, 4, 5, 8},
        {3, 1, 5, 3, 7, 8, 0, 6, 4, 8, 8, _, _, _, _, _, 8, 2, 3, 4, 1, 8, 0, 1, 2, 2, 7, 8, 1, 7, 3, 4, 2, 8, 1, 3, 3, 3, 0, 7},
        {8, 0, 2, 0, 0, 5, 6, 4, 2, 6, 5, _, _, _, _, _, 1, 8, 0, 2, 1, 4, 0, 8, 8, 4, 7, 4, 6, 7, 6, 7, 8, 1, 6, 1, 4, 8, 8, 8},
        {0, 8, 0, 2, 6, 4, 2, 5, 3, 7, 3, 5, 2, 7, 7, 4, 6, 2, 0, 0, 1, 7, 3, 2, 3, 6, 2, 1, 2, 5, 3, 4, 6, 3, 8, 4, 6, 3, 2, 7},
        {3, 3, 6, 1, 1, 4, 0, 6, 6, 4, 8, 4, 3, 1, 5, _, _, _, _, _, _, _, _, _, _, _, _, _, _, _, _, _, _, 0, 5, 7, 8, 8, 1, 4},
        {2, 7, 8, 1, 2, 8, 7, 8, 2, 8, 2, 7, 3, 5, 0, 4, 4, 1, 5, 4, 3, 2, 3, 0, 4, 2, 3, 3, 5, 2, 3, 7, 3, 3, 0, 6, 8, 0, 8, 0},
        {1, 4, 2, 1, 6, 2, 6, 3, 0, 5, 2, 3, 8, 5, 2, 6, 1, 6, 3, 1, 3, 7, 3, 1, 2, 3, 7, 7, 6, 3, 6, 5, 4, 0, 8, 2, 8, 4, 0, 7},
        {5, 2, 6, 2, 2, 8, 5, 1, 3, 1, 4, 8, 7, 3, 4, 4, 5, 1, 4, 7, 2, 2, 4, 6, 4, 5, 6, 7, 4, 1, 6, 5, 8, 4, 3, 4, 3, 5, 6, 4},
        {6, 7, 3, 3, 3, 3, 4, 8, 3, 3, 8, 6, 0, 4, 3, 8, 5, 6, 8, 0, 7, 0, 1, 7, 3, 0, 6, 3, 0, 0, 8, 2, 5, 7, 1, 7, 5, 6, 7, 7},
        {7, 3, 5, 7, 8, 8, 8, 5, 2, 2, 6, 5, 4, 4, 1, 5, 6, 6, 7, 8, 2, 7, 4, 4, 6, 6, 1, 8, 7, 3, 7, 3, 5, 8, 3, 3, 2, 7, 5, 3},
        {4, 1, 8, FINISH, 7, 7, 3, 7, 5, 8, 0, 3, 0, 1, 8, 7, 7, 1, 7, 8, 1, 3, 6, 4, 6, 2, 1, 0, 1, 6, 0, 5, 4, 5, 4, 0, 2, 0, 0, 6},
        {2, 4, 0, 2, 4, 6, 6, 7, 6, 0, 1, 1, 2, 5, 5, 0, 1, 8, 5, 1, 6, 6, 1, 0, 5, 8, 2, 6, 4, 3, 4, 1, 8, 4, 0, 0, 5, 7, 2, 0},
        {2, 0, 7, 6, 7, 8, 0, 6, 2, 0, 2, 8, 1, 1, 6, 2, 4, 6, 3, 6, 7, 1, 1, 3, 6, 8, 1, 0, 5, 6, 2, 7, 8, 7, 4, 7, 7, 4, 7, 7},
        {5, 6, 3, 5, 5, 8, 3, 7, 3, 0, 8, 8, 7, 7, 1, 6, 8, 4, 5, 4, 7, 1, 0, 1, 5, 1, 8, 2, 7, 1, 7, 0, 4, 6, 0, 3, 3, 0, 8, 1},
        };
    
    
    
//    public String toString() {
//        StringBuffer sb = new StringBuffer();
//        for(int[] line : this.mask) {
//            for (int column : line) {
//                sb.append(column).append(" ");
//            }
//            sb.append("\n");
//        }
//        return sb.toString();
//    }
    public Model() {
        this(20, 20, 20, 12, 12, false);
    }

    public Model(int width, int height, int offset, int x, int y, boolean generate) {
        this.width = width;
        this.height = height;
        this.offset = offset;
        this.x = x;
        this.y = y;
//        if(generate) {
//            this.genMask();
//        }
    }

//    public void genMask() {
//        int[][] m = new int[40][40];
//        Random rand = new Random(42);
//
//        System.out.println("{");
//        for (int i = 0; i < this.y; i++) {
//            System.out.println("{");
//            for (int j = 0; j < this.x; j++) {
//                if(j == this.x-1)
//                    System.out.println(rand.nextInt(9));
//                else
//                    System.out.println(rand.nextInt(9)+", ");
//                //m[i][j] = rand.nextInt(9);
//            }
//            System.out.println("},");
//        }
//        System.out.println("};");
//        this.mask = m;
//    }

    public int getCost(int x, int y) {
        return this.mask[y][x];
    }

    public int getXPos(int x) {
        return this.offset + x * this.width;
    }

    public int getYPos(int y) {
        return this.offset + y * this.height;
    }

    public void setMask(int[][] m) {
        this.mask = m;
    }
}
