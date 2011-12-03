/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package de.haw.is.m;

import java.util.List;

/**
 *
 */
public interface INode {

    public List getChildren();

    public int getDepth();
    
    public INode getParent();
    
    public List<INode> getParents();
    
    public boolean finish();
    
    public boolean isRoot();
    
    public int getCost();
    
    public boolean contains(INode node);
    
    public int heuristic();
    
    public int getCostFromStart();

}
