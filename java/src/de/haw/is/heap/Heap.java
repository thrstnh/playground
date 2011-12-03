/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.heap;

import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;

/**
 *
 */
public class Heap<T extends Comparable> {

    private List<T> heap = new ArrayList<T>();
    private int size;
    private Comparator<T> comp;

    public Heap(Comparator<T> comp) {
        size = 0;
        this.comp = comp;
        heap.add(null);
    }

    public void insertAll(T... elem) {
        for (T e : elem) {
            this.insert(e);
        }
    }

    public void insertAll(List<T> neighbours) {
        for (T e : neighbours) {
            this.insert(e);
        }
    }

    public String toString() {
        return heap.toString();
    }

    public void insert(T elem) {
        // Add a new leaf
        heap.add(null);
        int index = heap.size() - 1;

        // Demote parents that are larger than the new element

        while (index > 1 && comp.compare(getParent(index), elem) > 0) {

            heap.set(index, getParent(index));
            index = getParentIndex(index);

        }
        // Store the new element into the vacant slot
        heap.set(index, elem);
    }

    /**
    Removes the minimum element from this heap.
    @return the minimum element
     */
    public T remove() {
        T minimum = heap.get(1);

        // Remove last element
        int lastIndex = heap.size() - 1;
        T last = heap.remove(lastIndex);

        if (lastIndex > 1) {
            heap.set(1, last);
            fixHeap();
        }

        return minimum;
    }

    /**
    Turns the tree back into a heap, provided only the root 
    node violates the heap condition.
     */
    private void fixHeap() {
        T root = heap.get(1);

        int lastIndex = heap.size() - 1;
        // Promote children of removed root while they are larger than last      

        int index = 1;
        boolean more = true;
        while (more) {
            int childIndex = getLeftChildIndex(index);
            if (childIndex <= lastIndex) {
                // Get smaller child 

                // Get left child first
                T child = getLeftChild(index);

                // Use right child instead if it is smaller
                if (getRightChildIndex(index) <= lastIndex && comp.compare(getRightChild(index), child) < 0) { //getRightChild(index).compareTo(child) < 0) {
                    childIndex = getRightChildIndex(index);
                    child = getRightChild(index);
                }

                // Check if larger child is smaller than root
                if (comp.compare(child, root) < 0) {//child.compareTo(root) < 0) {
                    // Promote child
                    heap.set(index, child);
                    index = childIndex;
                } else {
                    // Root is smaller than both children
                    more = false;
                }
            } else {
                // No children
                more = false;
            }
        }

        // Store root element in vacant slot
        heap.set(index, root);
    }

    public int size() {
        return heap.size();
    }

    private T getParent(int index) {
        return heap.get(index / 2);
    }

    private static int getParentIndex(int index) {
        return index / 2;
    }

    private T getLeftChild(int index) {
        return heap.get(2 * index);
    }

    private static int getLeftChildIndex(int index) {
        return 2 * index;
    }

    private T getRightChild(int index) {
        return heap.get(2 * index + 1);
    }

    private static int getRightChildIndex(int index) {
        return 2 * index + 1;
    }
}
