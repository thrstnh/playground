/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.nimmspiel;

import java.util.List;
import javax.swing.JOptionPane;

/**
 *
 */
public class Game {

    private int anzahl;
    private Tree tree;
    private boolean computer = true;

    public Game(int anzahl) {
        this.anzahl = anzahl;
        this.tree = new Tree(this.anzahl);
        move();
        System.out.println(tree);
    }

    public boolean win() {
        if (this.anzahl == 1) {
            return true;
        }
        return false;
    }

    public void move() {
        int count = 0;
        boolean maximieren = computer;

        while (!this.win()) {

            System.out.println("\nUebrige Staebchen: " + this.anzahl);
            
            if (computer) {

                if (maximieren) {
                    if (min(this.tree.getRoot().getLeft()) == 1) {
                        count = 1;
                    } else if (min(this.tree.getRoot().getMiddle()) == 1) {
                        count = 2;
                    } else if (min(this.tree.getRoot().getRight()) == 1) {
                        count = 3;
                    } else {
                        count = 1;
                    }
                    
                    
                } else {
                    if (max(this.tree.getRoot().getLeft()) == -1) {
                        count = 1;
                    } else if (max(this.tree.getRoot().getMiddle()) == -1) {
                        count = 2;
                    } else if (max(this.tree.getRoot().getRight()) == -1) {
                        count = 3;
                    } else {
                        count = 1;
                    }
                }
                
                System.out.println("Der Computer zieht: " + count);
                this.computer = !this.computer;
                
            } else {
                count = 0;
                String msg = this.anzahl + " Stäbchen da, 1,2 oder 3 ziehen";
                while (count < 1 || count > 3) {
                    try {
                    count = Integer.parseInt(JOptionPane.showInputDialog(null, msg));
                    } catch (Exception e) {System.exit(0);}
                }
                this.computer = !this.computer;
                System.out.println("Der Spieler zieht: " + count);

            }

            
            this.anzahl = this.anzahl - count;
            this.tree = new Tree(this.anzahl);
            
        }

        if (this.computer) {
            System.out.println("Player 1 wins!");
        } else {
            System.out.println("CPU 1 wins!");
        }


    }

    public static void main(String[] args) {
        System.out.println(args[0]);
        int anzahl = Integer.parseInt(args[0]);
		Game game = new Game(anzahl);
    }

    // Alpha = min erreichter Wert, 
    // Beta = max erreichter Wert
    public int max(Node n) {

        int best;
        List<Node> childs = n.getChildren();

        if (n.isLeaf()) {
            return evalMax(n);
        }

        best = Integer.MIN_VALUE;

        for (Node each : childs) {
            int val = min(each);
            if (val > best) {
                best = val;
            }
        }

        return best;
    }

    public int min(Node n) {
        int best;
        List<Node> childs = n.getChildren();

        if (n.isLeaf()) {
            return evalMin(n);
        }

        best = Integer.MAX_VALUE;

        for (Node each : childs) {
            int val = max(each);
            if (val < best) {
                best = val;
            }
        }
        return best;
    }

    private int evalMax(Node n) {
        return -1;
    }

    private int evalMin(Node n) {
        return 1;
    }
}
