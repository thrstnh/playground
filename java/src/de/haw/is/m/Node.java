/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.m;

import de.haw.is.heap.Pair;
import de.haw.is.v.View;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;


/**
 *
 */
public class Node implements INode {
    // Parent Node
    private Node parent;
    // Cost
    private int cost;
    // Tiefe im Baum
    private int depth;
    private int x;
    private int y;
    private View view;
    public List<INode> parents;
    private Pair<Integer, Integer> goal;
    
    
    private Node(View v, int x, int y, int cost, Pair<Integer, Integer> goal) {
        this.view = v;
        this.depth = 0;
        this.cost = cost;
        this.parent = null;
        this.x = x;
        this.y = y;
        parents = new ArrayList<INode>();
        this.goal = goal;
        //System.out.format("ROOT: %d, %d", this.x, this.y);
    }

    public static Node getRootNode(View v, int x, int y, int cost, Pair<Integer, Integer> goal) {
        return new Node(v, x, y, cost, goal);
    }

    public Node(Node parent, int x, int y, int cost,  Pair<Integer, Integer> goal) {
        this.view = parent.view;
        this.parent = parent;
        this.parents = parent.parents;
        this.parents.add(parent);
        this.depth = parent.getDepth() + 1;
        this.cost = cost;
        this.x = x;
        this.y = y;
        this.goal = goal;
    }
    
//    public Node(Node parent, int x, int y, int cost, Pair<Integer, Integer> goal) {
//        this(parent, x, y, cost);
//        this.goal = goal;
//    }

    public Pair<Integer, Integer> getKoord() {
        return new Pair<Integer, Integer>(this.x, this.y);
    }

    public int heuristic() {
        int h = (Math.abs(this.x - this.goal.getFirst()) + Math.abs(this.y- this.goal.getSecond()));
        return h;
    }

    public int getDepth() {
        return this.depth;
    }

    public INode getParent() {
        return this.parent;
    }

    public void setCost(int cost) {
        this.cost = cost;
    }

    public int getCost() {
        return this.cost;
    }

    public int getX() {
        return this.x;
    }

    public int getY() {
        return this.y;
    }

    public boolean finish() {
        //System.out.println(this.x + " " + this.y);
        return this.x == goal.getFirst() && this.y == goal.getSecond();//this.getCost() == View.FINISH;
    }

    public boolean isRoot() {
        return this.parent == null;
    }

    /**
     * 
     * @return
     */
    public List<INode> getChildren() {
        List<INode> l = new ArrayList<INode>();
        for (Pair<Integer, Integer> p : view.getNeighbours(this.x, this.y)) {
            l.add(new Node(this, p.getFirst(), p.getSecond(), view.getCost(p.getFirst(), p.getSecond()), this.goal));
        }
        return l;
    }

    /**
     * 
     * @param node
     * @return
     */
    public boolean contains(INode node) {
            return this.parents.contains(node);
    }

    @Override
    public String toString() {
        StringBuffer sb = new StringBuffer();
        sb.append("(");
        sb.append(x).append(",");
        sb.append(y).append(":");
        sb.append(cost).append(")");
        return sb.toString();
    }

    @Override
    public boolean equals(Object o) {
        if (o == null) {
            throw new IllegalArgumentException("null is not a valid value!");
        }

        if (o instanceof INode) {
            Node otherNode = (Node) o;
            if ((this.x == otherNode.x) && (this.y == otherNode.y)) { /// && (this.cost == otherNode.cost)) {
                return true;
            }
        }
        return false;
    }

    @Override
    public int hashCode() {
        int hash = 7;
        hash = 29 * hash + this.cost;
        hash = 29 * hash + this.x;
        hash = 29 * hash + this.y;
        return hash;
    }

    public List<INode> getParents() {
        List<INode> p = new ArrayList<INode>();
        Node n = this;
        while(!n.isRoot()) {
            p.add(n);
            n = (Node) n.getParent();
        }
        return p;
    }

    public int getCostFromStart() {
        int sum = 0;
        Node n = this;
        while(!n.isRoot()) {
            sum = sum + n.getCost();
            n = (Node) n.getParent();
        }
        //System.out.println("sum("+this.x+","+this.y+") "+sum);
        return sum;
    }
}
