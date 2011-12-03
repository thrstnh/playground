package de.thrstnh.mathplotter;

import java.awt.Point;

public class Punkt {
	public double x;
	public double y;
	public int index = 0;
	
	public Punkt(double x, double y){
		this.x = x;
		this.y = y;
	}
	
	public Punkt(double x, double y, int index){
		this.x = x;
		this.y = y;
		this.index = index;
	}
	
	public Point toPoint(int scale){
		return new Point((int)(x * scale), (int)(y * scale));
	}
	
	public String toString(){
		return index + ": " + x + " : " + y;
	}	
}
