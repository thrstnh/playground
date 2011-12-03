/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.nimmspiel;

import java.util.ArrayList;
import java.util.List;

/**
 *
 */
public class Node {

    private Node parent;
    //private List<Node> children = new ArrayList<Node>();
    private Node left;
    private Node middle;
    private Node right;
    private int value;

    public Node(Node parent, int value) {
        this.parent = parent;
        this.value = value;
    }

    public Node getParent() {
        return this.parent;
    }
    
    public boolean isRoot() {
        return this.parent == null;
    }

    public int getValue() {
        return this.value;
    }

    public boolean isLeaf() {
        return this.left == null && this.right == null && this.middle == null;
    }

    public String toString() {
        StringBuffer s = new StringBuffer("       ");
        if(this.getLeft() != null)
            s.append(this.getLeft()).append("\n").append("  ");
        if(this.getMiddle() != null)
            s.append(this.getMiddle().getValue()).append("  ");
        if(this.getRight() != null)
            s.append(this.getRight().getValue()).append("  ");
        return s.toString();
    }

    public Node getLeft() {
        return left;
    }

    public Node getMiddle() {
        return middle;
    }

    public Node getRight() {
        return right;
    }

    public void setLeft(Node left) {
        this.left = left;
    }

    public void setMiddle(Node middle) {
        this.middle = middle;
    }

    public void setRight(Node right) {
        this.right = right;
    }
    
    public List<Node> getChildren() {
        List<Node> lst = new ArrayList<Node>();
        if(left != null){
            lst.add(this.left);
        }
        if(middle != null){
            lst.add(this.middle);
        }
        if(right != null){
            lst.add(this.right);
        }
        
        return lst;
    }
}
