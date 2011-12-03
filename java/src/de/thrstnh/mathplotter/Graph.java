package de.thrstnh.mathplotter;



import java.awt.Color;
import java.awt.Graphics;
import java.util.ArrayList;
import java.util.List;

import javax.swing.JPanel;


import javax.swing.JSlider;
import java.awt.BorderLayout;

public class Graph extends JPanel {
	private static final long serialVersionUID = 1L;

	private List<Bezier> lstBezier = new ArrayList<Bezier>(); // @jve:decl-index=0:

	private List<Punkt> lstPunkte = new ArrayList<Punkt>(); // @jve:decl-index=0:
	@SuppressWarnings("unused")
	private List<Punkt> lstZeroPunkte = new ArrayList<Punkt>(); // @jve:decl-index=0:

	private List<Color> lstColors = new ArrayList<Color>(); // @jve:decl-index=0:

	private List<Spline> lstSplines = new ArrayList<Spline>();
	
	private List<Polynom> lstPolynome = new ArrayList<Polynom>();

	private boolean connectPunkte = true;
	
	private boolean bezier = false;
	
	private boolean offen = false;

	private Color colGrey = new Color(222, 222, 222);

	// Mittepunkt
	private int xZeroPoint = 0;

	private int yZeroPoint = 0;

	private double unitX = 0;

	private double unitY = 0;

	private double fromX = 7;

	private double fromY = 7;

	private int punktIndex = 0;

	private int nBezierCount = 0;

	private int maxBezierCount = 4;

	private int nSplineCount = 0;

	private int SplineCount = 4;

	private JSlider sliderX = null;

	private JSlider sliderY = null;

	/**
	 * This is the default constructor
	 */
	public Graph() {
		super();
		initialize();
	}

	/**
	 * This method initializes this
	 * 
	 * @return void
	 */
	private void initialize() {
		
//		this.lstPolynome.add(new Polynom("2x^2"));
//		this.lstPolynome.add(new Polynom("5x^6 + 2x^5 - 2x^4 + 6x^3 - 10x^2 + 2x^1 -2"));
		
//		this.lstPolynome.add(new Polynom("x^1"));
		this.lstPolynome.add(new Polynom("x^2"));
		Polynom p1 = new Polynom("x^3");
		this.lstPolynome.add(p1);
		this.lstPolynome.add(p1.deflection());
		this.lstPolynome.add(p1.deflection().deflection());
		this.lstPolynome.add(new Polynom("x^8"));
		
//		this.lstPolynome.add(new Polynom("8x^3 - 5x^2 + 4x^1 +2"));
//		this.lstPolynome.add(new Polynom("1x^9 + 4x^2 - 3"));
		
		
		this.setLayout(new BorderLayout());
		this.setSize(300, 200);
		this.add(getSliderY(), BorderLayout.WEST);
		this.add(getSliderX(), BorderLayout.NORTH);
		this.initColors();
		this.addMouseListener(new java.awt.event.MouseAdapter() {
			public void mousePressed(java.awt.event.MouseEvent e) {
				if(e.getClickCount() > 2)
					System.out.println("doppelklick");
				doMousePressed(e.getButton(), e.getX(), e.getY(), false);
			}
		});
	}
	
	private void doMousePressed(int button, double clickedX, double clickedY, boolean graphPoint) {
		double x = clickedX;
		double y = clickedY;

		if(!graphPoint) {
			// Linke Maustaste: genauer Punkt
			if (button == 1) {
				x = ((clickedX - xZeroPoint) / unitX);
				y = ((yZeroPoint - clickedY) / unitY);
			}
			// Rechte Maustaste: glatter Punkt
			if (button == 3) {
				x = Math.round(((clickedX - xZeroPoint) / unitX));
				y = Math.round(((yZeroPoint - clickedY) / unitY));
			}
		}
		// Wenn "b" gedrueckt ist...
		if (bezier) {
			lstPunkte.add(new Punkt(x, y, punktIndex));
			punktIndex++;
			repaint();
			nBezierCount++;
			if (nBezierCount == maxBezierCount) {
				nBezierCount = 0;
				punktIndex = 0;
				Bezier b = new Bezier(lstPunkte.get(0), lstPunkte
						.get(1), lstPunkte.get(2), lstPunkte.get(3));
				lstBezier.add(b);
				lstPunkte.clear();
				repaint();
			}
		}
		// Spline zeichnen
		else {
			lstPunkte.add(new Punkt(x, y, punktIndex));
			punktIndex += 3;
			repaint();
			System.out.println(x + ":" + y);
			nSplineCount++;

			// Wenn 4 Punkte gesetzt sind, wird das Bezier erstellt
			// und
			// die Liste mit den Punkten geleert.
			int spCount = getSplineCount();
			if(this.isOffen())
				spCount +=2;
			if (nSplineCount == spCount) {
				punktIndex = 0;
				int pIndex = 0;
				Spline spline = null;
				spline = new Spline(lstPunkte);
				if(this.isOffen()) {
					Punkt first = this.lstPunkte.get(1);
					Punkt last = this.lstPunkte.get(this.lstPunkte.size()-2);
					
					this.lstPunkte.remove(1);
					this.lstPunkte.remove(this.lstPunkte.size()-2);
					
					spline = new Spline(this.lstPunkte, first, last, true);
				}

				lstSplines.add(spline);
				for (Bezier b : spline.mergePoints()) {
					b.p1.index = pIndex;
					b.p2.index = pIndex + 1;
					b.p3.index = pIndex + 2;
					b.p4.index = pIndex + 3;
					pIndex = pIndex + 3;
					lstBezier.add(b);
				}
				// Bezier b = new Bezier(lstPunkte.get(0),
				// lstPunkte.get(1), lstPunkte.get(2),
				// lstPunkte.get(3));
				lstPunkte.clear();
				// lstBezier.add(b);
				nSplineCount = 0;
			}
		}
	}

	public void drawExample() {
		Punkt b0 = new Punkt(0, 1, 0);
		Punkt b3 = new Punkt(2, 4, 3);
		Punkt b6 = new Punkt(4, 3, 6);
		Punkt b9 = new Punkt(6, 3, 9);
		List<Punkt> lstPunkte = new ArrayList<Punkt>();
		lstPunkte.add(b0);
		lstPunkte.add(b3);
		lstPunkte.add(b6);
		lstPunkte.add(b9);
//		Punkt b12 = new Punkt(3, 1, 12);
		Spline spline = new Spline(lstPunkte);

		this.lstSplines.add(spline);
		for (Bezier b : spline.mergePoints()) {
			this.lstBezier.add(b);
		}
		repaint();
	}
	
	public void drawExample1() {
//		Punkt b0 = new Punkt(0, 1, 0);
//		Punkt b3 = new Punkt(2, 4, 3);
//		Punkt b6 = new Punkt(4, 3, 6);
//		Punkt b9 = new Punkt(6, 3, 9);
//		List<Punkt> lstPunkte = new ArrayList<Punkt>();
//		lstPunkte.add(b0);
//		lstPunkte.add(b3);
//		lstPunkte.add(b6);
//		lstPunkte.add(b9);
////		Punkt b12 = new Punkt(3, 1, 12);
//		Spline spline = new Spline(lstPunkte, new Punkt(-1,3,1), new Punkt(5,1,8), true);
//
//		this.lstSplines.add(spline);
//		for (Bezier b : spline.mergePoints()) {
//			this.lstBezier.add(b);
//		}
		repaint();
	}

	/**
	 * Initialisiert die Werte
	 * 
	 */
	private void initDynamicValues() {
		// Mitte
		xZeroPoint = getWidth() / 2;
		yZeroPoint = getHeight() / 2;

		// Beschriftung vom Achsenkreuz, n-Einheiten
		// Einheiten X
		fromX = sliderX.getValue();
		// Einheiten Y
		fromY = sliderY.getValue();

		// Fuer die ansicht jeweils um 1 erhöhen;
		fromX++;
		fromY++;

		// Einheit in Pixel
		unitX = (xZeroPoint / fromX);
		unitY = (yZeroPoint / fromY);
	}

	private void initColors() {
		lstColors.add(new Color(255, 0, 0));
		lstColors.add(new Color(0, 255, 0));
		lstColors.add(new Color(0, 0, 255));
		lstColors.add(new Color(255, 255, 0));
		lstColors.add(new Color(200, 0, 0));
		lstColors.add(new Color(0, 200, 0));
		lstColors.add(new Color(0, 0, 200));
		lstColors.add(new Color(200, 200, 0));
		lstColors.add(new Color(150, 0, 0));
		lstColors.add(new Color(0, 150, 0));
		lstColors.add(new Color(0, 0, 150));
		lstColors.add(new Color(150, 150, 0));
	}

	@Override
	public void paint(Graphics gfx) {
		super.paint(gfx);
		this.initDynamicValues();
		this.drawAxies(gfx);
		this.drawPunkte(gfx);
		
		if(this.connectPunkte)
			this.connectPunkte(gfx);
		this.drawBeziers(gfx);
		
		
		this.drawPolynom(gfx);
		this.drawZeroPoints(gfx);
	}
	
	private void drawPolynom(Graphics gfx) {
		int PolynomNr = 0;
		int colNr = 0;
		for(Polynom each : this.lstPolynome) {
			// Farbe setzen
			if (colNr >= lstColors.size())
				colNr = 0;
			gfx.setColor(lstColors.get(colNr));
			colNr++;
			
			PolynomNr++;
			double i = -fromX;
			while(i<fromX) {
				double yOld = each.eval(i);
				i = i + 0.001;
				double y = each.eval(i);
				gfx.drawLine((int) (xZeroPoint + i * unitX),
						(int) (yZeroPoint - y * unitY), 
						(int) (xZeroPoint + i * unitX), 
						(int) (yZeroPoint - yOld * unitY));
				if(i > 2.9 && i <= 3.0) {
					gfx.drawString(each.toString(), 
							(int)20, 
							(int)20+PolynomNr*14);
					System.out.println(each.toString());
				}
			}
		}
	}
	
	private void drawZeroPoints(Graphics gfx) {
		for(Polynom each : this.lstPolynome) {
			List<Double> lstZeroPoints = each.getZeroPoints(1.0E-6);
			for(double zp : lstZeroPoints) {
//				this.lstZeroPunkte.add(new Punkt(0, zp));
				gfx.drawString("ZeroPoint: " + each.toString(), 
						(int)(xZeroPoint+zp/unitX), 
						0);
				System.out.println("ZP: " + zp);
			}
		}
	}
	
	public void clearAll() {
		this.lstBezier.clear();
		this.lstPunkte.clear();
		this.lstSplines.clear();
		this.nBezierCount = 0;
		this.nSplineCount = 0;
		repaint();
	}

	private void drawBeziers(Graphics gfx) {
		int i = 0;
		for (Bezier each : lstBezier) {

			gfx.setColor(new Color(0, 0, 0));
			drawPunkt(gfx, "P1", each.p1);
			drawPunkt(gfx, "P2", each.p2);
			drawPunkt(gfx, "P3", each.p3);
			drawPunkt(gfx, "P4", each.p4);

			if(this.connectPunkte)
				connectPunkte(gfx, each.p1, each.p2, each.p3, each.p4);

			if (i >= lstColors.size())
				i = 0;
			gfx.setColor(lstColors.get(i));

			drawBezier(gfx, each);
			i++;
		}
	}

	private void drawBezier(Graphics gfx, Bezier b) {
		double i = 0.;
		while (i < 1.0) {
			Punkt p = b.errechnePunkt(i);
			// gc.setForeground(new Color(getDisplay(), 0, 0, 0));
			gfx.drawLine((int) (xZeroPoint + p.x * unitX),
					(int) (yZeroPoint - p.y * unitY), (int) (xZeroPoint + p.x
							* unitX), (int) (yZeroPoint - p.y * unitY));

			i = i + 0.001;
		}
	}

	private void drawPunkte(Graphics gfx) {
		@SuppressWarnings("unused")
		int i = 1;
		for (Punkt each : this.lstPunkte) {
			drawPunkt(gfx, "P" + each.index, each);
			i++;
		}
	}

	private void drawPunkt(Graphics gfx, String name, Punkt p) {
		gfx.drawLine((int) (xZeroPoint + p.x * unitX) - 3,
				(int) (yZeroPoint - p.y * unitY) - 3, (int) (xZeroPoint + p.x
						* unitX) + 3, (int) (yZeroPoint - p.y * unitY) + 3);

		gfx.drawLine((int) (xZeroPoint + p.x * unitX) - 3,
				(int) (yZeroPoint - p.y * unitY) + 3, (int) (xZeroPoint + p.x
						* unitX) + 3, (int) (yZeroPoint - p.y * unitY) - 3);

		gfx.drawString("P" + p.index, (int) (xZeroPoint + p.x * unitX + 4),
				(int) (yZeroPoint - p.y * unitY));
	}

	private void connectPunkte(Graphics gfx) {
		if (this.lstPunkte.size() == 0)
			return;
		Punkt pOld = this.lstPunkte.get(0);
		for (Punkt p : this.lstPunkte) {
			gfx.drawLine((int) (xZeroPoint + p.x * unitX),
					(int) (yZeroPoint - p.y * unitY),
					(int) (xZeroPoint + pOld.x * unitX),
					(int) (yZeroPoint - pOld.y * unitY));
			pOld = p;
		}
	}

	private void connectPunkte(Graphics gfx, Punkt... punkts) {
		if (punkts.length == 0)
			return;
		Punkt pOld = punkts[0];
		for (Punkt p : punkts) {
			gfx.drawLine((int) (xZeroPoint + p.x * unitX),
					(int) (yZeroPoint - p.y * unitY),
					(int) (xZeroPoint + pOld.x * unitX),
					(int) (yZeroPoint - pOld.y * unitY));
			pOld = p;
		}
	}

	/**
	 * Zeichnet das Achsenkreuz
	 * 
	 * @param gfx
	 */
	private void drawAxies(Graphics gfx) {
		//
		// x-Achse
		//
		gfx.drawLine(0, yZeroPoint, getWidth(), yZeroPoint);
		// links
		for (int i = 1; i < fromX; i++) {
			// graues Raster
			Color oldColor = gfx.getColor();
			gfx.setColor(colGrey);
			gfx.drawLine((int) (i * unitX), (int) 0, (int) (i * unitX),
					(int) getSize().height);
			gfx.setColor(oldColor);
			// Achse
			gfx.drawLine((int) (i * unitX), (int) (yZeroPoint - 5),
					(int) (i * unitX), (int) (yZeroPoint + 5));
			// Beschriftung
			gfx
					.drawString(String.valueOf(-i), (int) (xZeroPoint - i
							* unitX - 5), (int) (yZeroPoint + 16));
			// Halbstriche
			gfx.drawLine((int) (i * unitX + unitX / 2), (int) (yZeroPoint - 2),
					(int) (i * unitX + unitX / 2), (int) (yZeroPoint + 2));
		}
		// rechts
		for (int i = 1; i < fromX; i++) {
			// graues Raster
			Color oldColor = gfx.getColor();
			gfx.setColor(colGrey);
			gfx.drawLine((int) (i * unitX + xZeroPoint), (int) 0, (int) (i
					* unitX + xZeroPoint), (int) getSize().height);
			gfx.setColor(oldColor);
			// Achse
			gfx.drawLine((int) (i * unitX + xZeroPoint),
					(int) (yZeroPoint - 5), (int) (i * unitX + xZeroPoint),
					(int) (yZeroPoint + 5));
			// Beschriftung
			gfx.drawString(String.valueOf(i),
					(int) (i * unitX - 5 + xZeroPoint + 2),
					(int) (yZeroPoint + 16));
			// Halbstriche
			gfx.drawLine((int) (i * unitX + xZeroPoint - unitX / 2),
					(int) (yZeroPoint - 2),
					(int) (i * unitX + xZeroPoint - unitX / 2),
					(int) (yZeroPoint + 2));
		}

		//
		// y-Achse
		//
		gfx.drawLine(xZeroPoint, 0, xZeroPoint, getHeight());
		// oben
		for (int i = 1; i < fromY; i++) {
			// graues Raster
			Color oldColor = gfx.getColor();
			gfx.setColor(colGrey);
			gfx.drawLine((int) 0, (int) (i * unitY), (int) getWidth(),
					(int) (i * unitY));
			gfx.setColor(oldColor);
			// Achse
			gfx.drawLine((int) (xZeroPoint - 5), (int) (i * unitY),
					(int) (xZeroPoint + 5), (int) (i * unitY));
			// Beschriftung
			gfx.drawString(String.valueOf(i), (int) (xZeroPoint + 8),
					(int) (yZeroPoint - i * unitY + 5));
			// Halbstriche
			gfx.drawLine((int) (xZeroPoint - 2), (int) (i * unitY + unitY / 2),
					(int) (xZeroPoint + 2), (int) (i * unitY + unitY / 2));
		}
		// unten
		for (int i = 1; i < fromY; i++) {
			// graues Raster
			Color oldColor = gfx.getColor();
			gfx.setColor(colGrey);
			gfx.drawLine((int) 0, (int) (yZeroPoint + i * unitY),
					(int) getSize().width, (int) (yZeroPoint + i * unitY));
			gfx.setColor(oldColor);
			// Achse
			gfx.drawLine((int) (xZeroPoint - 5),
					(int) (yZeroPoint + i * unitY), (int) (xZeroPoint + 5),
					(int) (yZeroPoint + i * unitY));
			// Beschriftung
			gfx.drawString(String.valueOf(-i), (int) (xZeroPoint + 8),
					(int) (yZeroPoint + i * unitY + 5));
			// Halbstriche
			gfx.drawLine((int) (xZeroPoint - 2),
					(int) (yZeroPoint + i * unitY - unitY / 2),
					(int) (xZeroPoint + 2),
					(int) (yZeroPoint + i * unitY - unitY / 2));
		}
	}

	public boolean isBezier() {
		return bezier;
	}

	public void setBezier(boolean bezier) {
		this.bezier = bezier;
	}

	public boolean isConnectPunkte() {
		return connectPunkte;
	}

	public void setConnectPunkte(boolean connectPunkte) {
		this.connectPunkte = connectPunkte;
	}

	/**
	 * This method initializes sliderX	
	 * 	
	 * @return javax.swing.JSlider	
	 */
	private JSlider getSliderX() {
		if (sliderX == null) {
			sliderX = new JSlider();
			sliderX.setMinimum(1);
			sliderX.setMaximum(30);
			sliderX.setValue(7);
			sliderX.addChangeListener(new javax.swing.event.ChangeListener() {
				public void stateChanged(javax.swing.event.ChangeEvent e) {
					fromX = sliderX.getValue();
					repaint();
				}
			});
		}
		return sliderX;
	}

	/**
	 * This method initializes sliderY	
	 * 	
	 * @return javax.swing.JSlider	
	 */
	private JSlider getSliderY() {
		if (sliderY == null) {
			sliderY = new JSlider();
			sliderY.setMaximum(30);
			sliderY.setValue(7);
			sliderY.setOrientation(JSlider.VERTICAL);
			sliderY.setMinimum(1);
			sliderY.addChangeListener(new javax.swing.event.ChangeListener() {
				public void stateChanged(javax.swing.event.ChangeEvent e) {
					fromY = sliderY.getValue();
					repaint();
				}
			});
		}
		return sliderY;
	}
	
	public void addPunkt(Punkt...punkts) {
		if(punkts.length == 0)
			return;
		for(Punkt p : punkts) {
			this.doMousePressed(1, p.x, p.y, true);
		}
		repaint();
	}

	public int getSplineCount() {
		return SplineCount;
	}

	public void setSplineCount(int splineCount) {
		SplineCount = splineCount;
	}

	public boolean isOffen() {
		return offen;
	}

	public void setOffen(boolean offen) {
		this.offen = offen;
	}

}
