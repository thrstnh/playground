/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.heap;

import de.haw.is.m.INode;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;

/**
 *
 */
public class MinHeap {

    private List<INode> heap = new ArrayList<INode>();
    private int size;
    private Comparator comp;

    public MinHeap(Comparator comp) {
        size = 0;
        this.comp = comp;
    }

    public static void main(String... args) {

    }
    
    public static final Comparator testcomp = new Comparator() {

        public int compare(Object o1, Object o2) {
            if((Integer) o1 < (Integer) o2){
                return -1;
            } 
            else if(o1 == o2){
                return 0;
            }
            else return 1;
        }


    };

    public void insertAll(List<INode> neighbours) {
        for (INode e : neighbours) {
            this.insert(e);
        }
    }

    private int leftchild(int pos) {
        return 2 * pos;
    }

    private int rightchild(int pos) {
        return 2 * pos + 1;
    }

    private int parent(int pos) {
        return pos / 2;
    }

    public int size() {
        return this.heap.size();
    }

    @SuppressWarnings("unchecked")
    public void insert(INode elem) {
        if (this.heap.size() > 0) {
            size++;
            heap.add(elem);
            int current = size;

            // Solange child < parent wird neu sortiert
//            System.out.print(heap.get(current));
//            System.out.print(" ");
//            System.out.print(heap.get(parent(current)));
//            System.out.print("   ");
//            System.out.println(comp.compare(heap.get(current), heap.get(parent(current))));
            while (comp.compare(heap.get(current), heap.get(parent(current))) > 0) {

//                while (heap.get(current) < heap.get(parent(current))) {
                Collections.swap(heap, current, parent(current));
                //current = elem;
                current = parent(current);
            }
        } else {
            this.heap.add(elem);
        }
    }

    public void insertAll(INode... elem) {
        for (INode e : elem) {
            this.insert(e);
        }
    }

    private boolean isleaf(int pos) {
        return ((pos > size / 2) && (pos <= size));
    }

    @Override
    public String toString() {
        return heap.toString();
    }

    public INode removemin() {
        Collections.swap(heap, 0, size);
        INode tmp = heap.get(0);
        heap.remove(0);
        size--;
        if (size != 0) {
            downheap(0);
        }
        return tmp;
    }

    @SuppressWarnings("unchecked")
    private void downheap(int position) {
        int smallestchild;
        while (!isleaf(position)) {
            smallestchild = leftchild(position);
            if ((smallestchild < size) && comp.compare(heap.get(smallestchild), heap.get(smallestchild + 1)) > 0) {
                smallestchild = smallestchild + 1;
            }
            if (comp.compare(heap.get(position), heap.get(smallestchild)) <= 0) {
                return;
            }
            Collections.swap(heap, position, smallestchild);
            position = smallestchild;
        }
    }
}
