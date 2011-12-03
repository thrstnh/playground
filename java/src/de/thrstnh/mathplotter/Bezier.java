package de.thrstnh.mathplotter;

public class Bezier {
	public Punkt p1;
	public Punkt p2;
	public Punkt p3;
	public Punkt p4;
	
	public Bezier(Punkt p1, Punkt p2, Punkt p3, Punkt p4){
		this.p1 = p1;
		this.p2 = p2;
		this.p3 = p3;
		this.p4 = p4;
	}
	
	public Punkt errechnePunkt(double t){
		double ergX;
		double ergY;
		
		
		ergX = p1.x * Math.pow((1 - t), 3);
		ergX = ergX + p2.x * 3 * t * Math.pow((1 - t), 2);
		ergX = ergX + p3.x * 3 * Math.pow(t, 2) * (1 - t);
		ergX = ergX + p4.x * Math.pow(t, 3);
		
		ergY = p1.y * Math.pow((1 - t), 3);
		ergY = ergY + p2.y * 3 * t * Math.pow((1 - t), 2);
		ergY = ergY + p3.y * 3 * Math.pow(t, 2) * (1 - t);
		ergY = ergY + p4.y * Math.pow(t, 3);
		
		return new Punkt(ergX, ergY);
	}
	
	public String toString() {
		return this.p1.toString() + "|" + this.p2.toString() + "|" + this.p3.toString()+ "|" + this.p4.toString();
	}
}
