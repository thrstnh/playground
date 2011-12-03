/*
 * Main.java
 *
 * Created on 9. Mai 2007, 02:11
 *
 * Just a little window with your message =)
 *
 * @author Thorsten Hillebrand
 */

package de.thrstnh.logbox;

import java.awt.BorderLayout;
import java.awt.Toolkit;
import java.awt.datatransfer.StringSelection;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JMenuItem;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JPopupMenu;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.filechooser.FileFilter;

/**
 * Give a string als param
 */
public class LogBox {
    
    private JFrame window = new JFrame();
    private JPanel contentPane = new JPanel();
    private JTextArea msgBox = new JTextArea();
    private JButton btnSave = new JButton("Save...");
    private JPopupMenu contextMenu = new JPopupMenu();
    private JMenuItem mniCopyToClipboard = new JMenuItem("copy");
    private StringBuilder msg = null;
    
    /** 
     * Creates a new instance of Main 
     * @param msg 
     */
    public LogBox(CharSequence msg) {
        this.msg = new StringBuilder(msg);
        this.initialize();
    }
    /**
     * initialize the application and set it visible
     */
    private void initialize() {
        // JFrame window
        window.setSize(800, 600);
        window.setContentPane(this.contentPane);
        window.setTitle("LogBox");
        window.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        // JButton btnSave
        btnSave.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                save();
            }
        });
        // JMenuItem mniCopyToClipboard
        mniCopyToClipboard.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                copyToClipboard();
            }
        });
        // JPopupMenu contextMenu
        contextMenu.add(mniCopyToClipboard);
        // JTextArea msgBox
        msgBox.setEditable(false);
        msgBox.append(this.msg.toString());
        msgBox.add (contextMenu);
        msgBox.addMouseListener (new MouseListener () {
            @SuppressWarnings("static-access")
			public void mouseClicked (MouseEvent e) {
                // if right click
                if(e.getButton() == e.BUTTON3) {
                    // show context menu
                    contextMenu.show (e.getComponent(), e.getX(), e.getY());
                }
            }
            public void mouseEntered (MouseEvent e) {}
            public void mouseExited (MouseEvent e) {}
            public void mousePressed (MouseEvent e) {}
            public void mouseReleased (MouseEvent e) {}
        });
        msgBox.addKeyListener(new KeyListener() {
            @SuppressWarnings("static-access")
			public void keyPressed(KeyEvent e) {
                if(e.getKeyCode() == e.VK_ESCAPE)
                    exit();
            }
            public void keyReleased(KeyEvent e) {}
            public void keyTyped(KeyEvent e) {}
        });
        // JPanel contentPane
        contentPane.setLayout(new BorderLayout());
        contentPane.add(new JScrollPane(msgBox), BorderLayout.CENTER);
        contentPane.add(btnSave, BorderLayout.SOUTH);
        // show the window
        window.setVisible(true);
    }
    /**
     * Append a CharSequence 
     * @param chars 
     * @return 
     */
    public StringBuilder append(CharSequence chars) {
        this.msg.append(chars);
        this.msgBox.setText(this.msg.toString());
        return this.msg;
    }
    /**
     * copy selected string from the textArea to the system clipboard
     */
    private void copyToClipboard() {
        String selectedText = msgBox.getSelectedText();
        if(selectedText != null) {
            StringSelection text = new StringSelection(selectedText);
            Toolkit.getDefaultToolkit().getSystemClipboard().setContents(text, null);
        }
    }
    /**
     * Save the complete text to a file with
     * the JFileChooser save-dialog
     */
    private void save() {
        JFileChooser fc = new JFileChooser();
        fc.setFileSelectionMode(JFileChooser.FILES_AND_DIRECTORIES);
        fc.setFileFilter(new FileFilter() {
            public boolean accept(File f) {
                return f.isFile() | f.isDirectory();
            }
            public String getDescription() {
                return "AllFiles";
            };
        });
        int rv = fc.showSaveDialog(window);
        if(rv == JFileChooser.APPROVE_OPTION) {
            File file = fc.getSelectedFile();
            if(file.isDirectory()) 
                JOptionPane.showMessageDialog(window, "Datei verlangt!");
            else {
                try {
                    file.createNewFile();
                    FileOutputStream out = new FileOutputStream(file);
                    for (int i=0; i < this.msg.length(); i++){
                        out.write((byte)this.msg.charAt(i));
                    }
                    out.close();
                    JOptionPane.showMessageDialog(window, "Done!");
                } catch (IOException ex) {
                    JOptionPane.showMessageDialog(window, "Konnte nicht in die Datei schreiben!");
                }
            }
        }
    }
    /**
     * exit on escape
     */
    public void exit() {
        window.dispose();
    }
}
