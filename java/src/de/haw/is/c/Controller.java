/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.c;

import de.haw.is.heap.Pair;
import de.haw.is.m.INode;
import de.haw.is.m.Node;
import de.haw.is.v.View;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.PriorityQueue;
import java.util.Set;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 */
public class Controller<T> {

    public Controller() {
    }

    @SuppressWarnings("unchecked")
    public boolean generalSearch(View v, final INode node, Comparator comp) {

        List<Pair<Integer, Integer>> visited = new ArrayList<Pair<Integer, Integer>>();
        PriorityQueue<INode> openlist = new PriorityQueue<INode>(500, comp);
        //MinHeap openList = new MinHeap(comp);
        INode tmpNode = node;

        List<INode> neighbours;
        openlist.add(tmpNode);
        //openList.insert(tmpNode);

        while (openlist.size() >= 0) {
            //tmpNode = openlist.remove();
            if (tmpNode.finish()) {
                List<Pair<Integer, Integer>> path = new ArrayList<Pair<Integer, Integer>>();
                for (INode each : tmpNode.getParents()) {
                    path.add(((Node) each).getKoord());
                }
                v.setPath(path);
                System.out.println("FINISH!!!!!!!");
                return true;
            } else {
                neighbours = tmpNode.getChildren();
                for (INode each : neighbours) {
                    if (!tmpNode.contains(each)) {
                        openlist.add(each);
                        //openList.insert(each);
                    }
                }
               tmpNode = openlist.poll();
                //tmpNode = openList.removemin();
            }

//            try {
//                Thread.sleep(700);
//
//            } catch (InterruptedException ex) {
//                Logger.getLogger(Controller.class.getName()).log(Level.SEVERE, null, ex);
//            }

            visited.add(((Node) tmpNode).getKoord());
            v.setVisited(visited);
        }

        return false;
    }
    /**
     * Tiefensuche
     */
    public static final Comparator<INode> depthSearch = new Comparator<INode>() {

        public int compare(INode o1, INode o2) {
            return o2.getDepth() - o1.getDepth();
        }
    };
    /**
     * Breitensuche
     */
    public static final Comparator<INode> breadthSearch = new Comparator<INode>() {

        public int compare(INode o1, INode o2) {
            return o1.getDepth() - o2.getDepth();
        }
    };
    /**
     * BestFirst
     */
    public static final Comparator<INode> bestFirst = new Comparator<INode>() {

        public int compare(INode o1, INode o2) {
            return o1.heuristic() - o2.heuristic();
        }
    };
    /**
     * A*
     */
    public static final Comparator<INode> aStar = new Comparator<INode>() {

        public int compare(INode o1, INode o2) {
            int value = (o1.getCostFromStart() + o1.heuristic()) - (o2.getCostFromStart() + o2.heuristic());
            return value;
        }
    };
    /**
     * HillClimbing
     */
    public static final Comparator<INode> hillClimbing = new Comparator<INode>() {

        public int compare(INode o1, INode o2) {
            int value = o2.getCost() - o1.getCost();
            return value;
        }
    };

}
