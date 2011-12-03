/*
 * PortScanner.java
 *
 * Created on October 23, 2007, 4:28 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package de.haw.portscanner;

import java.net.InetSocketAddress;
import java.net.Socket;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

/**
 *
 */
public class PortScanner extends Thread {
    
    protected String host = "";
    protected int startport = 0;
    protected int endport = 0;
    protected List<Integer> openPorts = new ArrayList<Integer>();
    protected Map<Integer, Boolean> portMap= new TreeMap<Integer, Boolean>();
    protected List<Thread> lstThread = new ArrayList<Thread>();
    
    /** Creates a new instance of PortScanner */
    public PortScanner(String host, int startport, int endport) {
        this.host = host;
        this.startport = startport;
        this.endport = endport;
    }
    
    public void run() {
        
        
        for(int i=startport; i<=endport; i++) {
            final int pi = i;
            
            Thread tx = new Thread() {
                public void run() {
                    Socket s;
                    try {
                        //s = new Socket(host, pi);
                        s = new Socket();
                        s.connect(new InetSocketAddress(host, pi), 5000);
                        
                        synchronized(portMap) {
                            //System.out.println("offener Port " + pi);
                            portMap.put(pi, true);
                        }
                        s.close();
                    } catch (Exception ex) {}
                    this.interrupt();
                }
            };
            lstThread.add(tx);
            tx.start();
            
        }
        
        System.out.println();
        synchronized (portMap) {
            for(Integer each : portMap.keySet()){
                System.out.format("Port %d \t%s\n", each, portMap.get(each));
            }
        }
        System.exit(0);
    }
    public static void main(String argv[]) throws Exception {
        String host = argv[0];
        int start = Integer.parseInt(argv[1]);
        int stop = Integer.parseInt(argv[2]);
        
        PortScanner myClient = new PortScanner(host, start, stop);
        myClient.start();
        System.out.println(host + start + stop);
    }
    
}