/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package de.haw.is.nimmspiel;

/**
 *
 */
public class Tree {
    
    private int value;
    private Node root;
    
    public Tree(int value) {
        this.value = value;
        this.root = this.createTree(null, value);
    }
    
    public Node createTree(Node parent, int anzahl) {
        
        if(anzahl < 1) return null;
        
        Node n = new Node(parent, anzahl);
        n.setLeft(this.createTree(n, anzahl - 1));
        n.setMiddle(this.createTree(n, anzahl - 2));
        n.setRight(this.createTree(n, anzahl - 3));
        return n;
    }
    
    public String toString() {
        return this.getRoot().toString();
    }

    public Node getRoot() {
        return root;
    }

}
