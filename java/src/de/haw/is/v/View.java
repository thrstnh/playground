/*
 * GUI.java
 *
 * Created on 16. Mai 2008, 12:39
 */
package de.haw.is.v;

import de.haw.is.c.Controller;
import de.haw.is.heap.Pair;
import de.haw.is.m.Model;
import de.haw.is.m.Node;
import java.awt.Color;
import java.awt.Graphics;
import java.util.ArrayList;
import java.util.List;
import javax.swing.JFrame;

/**
 *
 */
public class View extends javax.swing.JPanel {

    public static final int BARRIER = 100;
    public static final int FINISH = 200;
    //public static final int FINISH = 200;
    public static final int START = 300;
    public static final int PATH = 400;
    public static final int _ = 100;
    private final JFrame frame;
    private Model model;
    private Color cRed = new Color(255, 0, 0);
    private Color cGrey = new Color(166, 166, 166);
    private Color cBlack = new Color(0, 0, 0);
    private Color cGreen = new Color(0, 255, 0);
    private Color cBlue = new Color(0, 0, 255);
    private Color cOrange = new Color(255, 185, 15);
    List<Pair<Integer, Integer>> visited = new ArrayList<Pair<Integer, Integer>>();
    List<Pair<Integer, Integer>> path = new ArrayList<Pair<Integer, Integer>>();

    public static void main(String[] args) {
        View v = new View();
        Node rootNode;
        Pair<Integer, Integer> goal = new Pair<Integer, Integer>(4, 35);
        rootNode = Node.getRootNode(v, 36, 3, v.getCost(36, 3), goal);
//        rootNode = Node.getRootNode(v, 8, 30, v.getCost(8, 30), goal);
//        Pair<Integer, Integer> goal = new Pair<Integer, Integer>(1, 13);
//        rootNode = Node.getRootNode(v, 6, 6, v.getCost(6, 6), goal);
        Controller<Integer> controller = new Controller<Integer>();

        //controller.generalSearch(v, rootNode, Controller.depthSearch);
        //controller.generalSearch(v, rootNode, Controller.breadthSearch);
        //controller.generalSearch(v, rootNode, Controller.bestFirst);
        controller.generalSearch(v, rootNode, Controller.aStar);
        //controller.generalSearch(v, rootNode, Controller.hillClimbing);
    }

    /** Creates new form GUI */
    public View() {
        initComponents();
        model = new Model(18, 18, 10, 40, 40, false);
        //model = new Model(18, 18, 10, 15, 15, false);
        
        frame = new JFrame("Seek'n'Destroy");
        frame.add(this);
        frame.setSize(780, 780);
        frame.setVisible(true);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
    }

    /**
     * Zeichnet das Gitternetz
     * @param g
     */
    public void init(Graphics g) {
        // Zeilen
        for (int i = 0; i < model.y; i++) {
            int ypos = i * model.height;

            // Spalten
            for (int j = 0; j < model.x; j++) {
                int xpos = j * model.width;

                // Gitter
                g.drawRect(model.offset + xpos, model.offset + ypos, model.width, model.height);
            }
        }
    }

    public List<Pair<Integer, Integer>> getNeighbours(int x, int y) {

        List<Pair<Integer, Integer>> lst = new ArrayList<Pair<Integer, Integer>>();

        for (int yy = y - 1; yy <= y + 1; yy++) {
            for (int xx = x - 1; xx <= x + 1; xx++) {
                if (yy >= model.y || xx >= model.x || yy < 0 || xx < 0) {
                //System.out.println("Uebers Feld!!!!");
                } else if (xx == x && yy == y) {
                    //System.out.println("Auf Startfeld: " + xx + " , " + yy);
                } else {
                    if (model.getCost(xx, yy) == BARRIER) {
                        //System.out.println("Barriere nicht betreten");
                    } else {
                        lst.add(new Pair<Integer, Integer>(xx, yy));
                    }
                }
            }
        }

        //System.out.println(lst);

        return lst;
    }

    public int getCost(int x, int y) {
        int r = 0;
        try {
            r = this.model.getCost(x, y);
        } catch (ArrayIndexOutOfBoundsException e) {

        }
        return r;

    }

    public void setMask(Graphics g) {
        for (int yy = 0; yy < model.y; yy++) {
            for (int xx = 0; xx < model.x; xx++) {
                int field = model.getCost(xx, yy);//this.mask[j][i];//model.getCost(j, i);
                if (field == START) {
                    this.fillBox(g, cBlue, xx, yy);
                } else if (field == FINISH) {
                    this.fillBox(g, cOrange, xx, yy);
                } else if (field == BARRIER) {
                    this.fillBox(g, cBlack, xx, yy);
                } else if (field == PATH) {
                    this.fillBox(g, cRed, xx, yy);
                    this.label(g, String.valueOf(model.getCost(xx, yy)), xx, yy);
                } else {
                    this.label(g, String.valueOf(field), xx, yy);
                }
            }
        }
    }

    public void label(Graphics g, String label, int x, int y) {
        int xpos = model.getXPos(x);
        int ypos = model.getYPos(y);

        Color oldColor = g.getColor();
        g.setColor(cBlack);
        g.drawString(label, xpos + model.width / 3, ypos + model.height - 7);
        g.setColor(oldColor);
    }

    public void fillBox(Graphics g, int x, int y) {
        int xpos = model.getXPos(x);
        int ypos = model.getYPos(y);

        Color oldColor = g.getColor();
        g.setColor(cGrey);
        g.fillRect(xpos, ypos, model.width, model.height);
        g.setColor(oldColor);
    }

    public void fillBox(Graphics g, Color c, int x, int y) {
        int xpos = model.getXPos(x);
        int ypos = model.getYPos(y);

        Color oldColor = g.getColor();
        g.setColor(c);
        g.fillRect(xpos, ypos, model.width, model.height);
        g.setColor(oldColor);
    }

    public void setVisited(List<Pair<Integer, Integer>> visited) {
        this.visited = visited;
        this.repaint();
    }

    public void setPath(List<Pair<Integer, Integer>> path) {
        this.path = path;
    }

    private void drawVisited(Graphics g) {
        for (int i = 0; i < this.visited.size(); i++) {
            Pair<Integer, Integer> p = this.visited.get(i);
            if (i == this.visited.size() - 1) {
                this.fillBox(g, cGreen, p.getFirst(), p.getSecond());
            } else {
                this.fillBox(g, cRed, p.getFirst(), p.getSecond());
            }
        }
    }

    private void drawPath(Graphics g) {
        for (int i = 0; i < this.path.size(); i++) {
            Pair<Integer, Integer> p = this.path.get(i);
            if (i == this.path.size() - 1) {
                this.fillBox(g, cGreen, p.getFirst(), p.getSecond());
            } else {
                this.fillBox(g, cGreen, p.getFirst(), p.getSecond());
            }
        }
    }

    @Override
    public void paint(Graphics g) {
        super.paint(g);
        this.drawVisited(g);
        this.drawPath(g);
        this.init(g);
        this.setMask(g);

    }

    /** This method is called from within the constructor to
     * initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is
     * always regenerated by the Form Editor.
     */
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(this);
        this.setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 400, Short.MAX_VALUE)
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 300, Short.MAX_VALUE)
        );
    }// </editor-fold>//GEN-END:initComponents
    // Variables declaration - do not modify//GEN-BEGIN:variables
    // End of variables declaration//GEN-END:variables
}
