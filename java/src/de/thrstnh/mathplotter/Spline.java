package de.thrstnh.mathplotter;

import java.util.ArrayList;
import java.util.List;

public class Spline {

	// Matrix der Gleichungen
	private double[][] a;

	private Punkt first;

	private Punkt last;

	private boolean open = false;

	// Punkte, aus denen das Spline entstehen soll
	private List<Punkt> lstPunkte = new ArrayList<Punkt>();

	/**
	 * verboten
	 * 
	 */
	@SuppressWarnings("unused")
	private Spline() {
		// Der Standardkonstruktur ohne Parameter soll nicht erlaubt werden!
	}

	/**
	 * n Punkte sollen uebergeben werden
	 * 
	 * @param punkts
	 */
	public Spline(Punkt... punkts) {
		for (Punkt e : punkts)
			this.lstPunkte.add(e);
		this.a = new double[this.lstPunkte.size() * 2][this.lstPunkte.size() * 2];
		fillMatrix();
	}

	public Spline(List<Punkt> lstP, Punkt first, Punkt last, boolean open) {
		for (Punkt e : lstP)
			this.lstPunkte.add(e);
		this.first = first;
		this.last = last;
		this.open = open;
		this.a = new double[this.lstPunkte.size() * 2 - 2][this.lstPunkte
				.size() * 2 - 2];
		fillMatrix();
	}

	/**
	 * n Punkte als List uebergeben
	 * 
	 * @param lstP
	 */
	public Spline(List<Punkt> lstP) {
		for (Punkt e : lstP)
			this.lstPunkte.add(e);
		this.a = new double[this.lstPunkte.size() * 2][this.lstPunkte.size() * 2];
		fillMatrix();
	}

	/**
	 * Matrix a fuellen
	 * 
	 */
	public void fillMatrix() {
		a[0][a.length - 1] = 0.5;
		if (this.open) {
			for (int i = 0; i < a.length; i++) {
				for (int j = 0; j < a[i].length; j++) {

					// Diagonale
					if (i % 2 == 0 && j % 2 == 0) {
						if (i == j) {
							a[i][j] = 0.5;
							if (j > 1)
								a[i][j - 1] = 0.5;
						}
					}
					// Diagonale
					if (i % 2 == 1 && j % 2 == 1) {
						if (i == j) {
							a[i][j] = -1;
							if (j < 3) {
								a[i][0] = 2;
								a[i][a.length - 1] = -2;
								a[i][a.length - 2] = 1;
							} else if (j >= 3) {
								a[i][j - 1] = 2;
								a[i][j - 2] = -2;
								a[i][j - 3] = 1;
							}
						}
					}
				}
			}

			for (int i = 0; i < a.length; i++) {
				a[0][i] = 0;
			}
			for (int i = 2; i < a.length; i++) {
				for (int j = 0; j < a.length; j++) {
					a[i - 1][j] = a[i][j];
				}
			}
			for (int i = 0; i < a.length; i++) {
				a[a.length - 1][i] = 0;
			}
			a[0][0] = 1;
			a[a.length - 1][a.length - 1] = 1;
			printMatrix(a);
		} else {
			for (int i = 0; i < a.length; i++) {
				for (int j = 0; j < a[i].length; j++) {

					// Diagonale
					if (i % 2 == 0 && j % 2 == 0) {
						if (i == j) {
							a[i][j] = 0.5;
							if (j > 1)
								a[i][j - 1] = 0.5;
						}
					}
					// Diagonale
					if (i % 2 == 1 && j % 2 == 1) {
						if (i == j) {
							a[i][j] = -1;
							if (j < 3) {
								a[i][0] = 2;
								a[i][a.length - 1] = -2;
								a[i][a.length - 2] = 1;
							} else if (j >= 3) {
								a[i][j - 1] = 2;
								a[i][j - 2] = -2;
								a[i][j - 3] = 1;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Gauss auf die Matrix loslassen
	 * 
	 */
	public void gauss() {

		int n = a.length;

		// Berechnung
		for (int i = 0; i < n; i++) {
			for (int j = i; j < n; j++) {
				for (int k = 0; k <= i - 1; k++) {
					a[i][j] -= a[i][k] * a[k][j];
				}
			}
			for (int j = i + 1; j < n; j++) {
				for (int k = 0; k <= i - 1; k++) {
					a[j][i] -= a[j][k] * a[k][i];
				}
				a[j][i] /= a[i][i];
			}
		}
	}

	/**
	 * Helper zum Ausgeben der Matrix auf der Console
	 * 
	 * @param a
	 */
	private void printMatrix(double[][] a) {
		for (int i = 0; i < a.length; i++) {
			for (int j = 0; j < a[i].length; j++) {
				System.out.print(a[i][j] + "    ");
			}
			System.out.println();
		}
	}

	/**
	 * Helper zum Ausgeben des Vectors auf der Console
	 * 
	 * @param a
	 */
	private void printVector(double[] a) {
		for (int i = 0; i < a.length; i++) {
			System.out.print(a[i] + "    ");
			System.out.println();
		}
	}

	/**
	 * Nachdem Gauss durchgelaufen ist, wird der linkte Teil (betreffend der
	 * Diagonale) von A abgesplittet...
	 * 
	 * @param a
	 * @return
	 */
	public double[][] getL(double a[][]) {
		int n = a.length;
		double l[][] = new double[n][n];

		for (int i = 0; i < n; i++) {
			for (int j = 0; j <= i; j++) {
				if (i == j)
					l[i][j] = 1;
				else
					l[i][j] = a[i][j];
			}
		}
		return l;
	}

	/**
	 * Nachdem Gauss durchgelaufen ist, wird der Rechte Teil (betreffend der
	 * Diagonale) von A abgesplittet...
	 * 
	 * @param a
	 * @return
	 */
	public double[][] getR(double a[][]) {
		int n = a.length;
		double r[][] = new double[n][n];

		for (int i = 0; i < n; i++) {
			for (int j = i; j < n; j++) {
				r[i][j] = a[i][j];
			}
		}
		return r;
	}

	/**
	 * Diese Methode fuegt die X- und Y-Werte zu reellen Punkte zusammen und
	 * erstellt aus den entsprechenden Punkten je ein Bezier, was der Liste
	 * hinzugefuegt wird. Am Ende wird die Liste mit den Beziers zurueckgegeben
	 * und der Graph darf zeichnen.
	 */
	public List<Bezier> mergePoints() {

		this.gauss();

		// x- und y-Werte auslesen
		double[] x = this.xvalues();
		double[] y = this.yvalues();

		// Liste mit den Punkten erstellen
		List<Punkt> lstPkt = new ArrayList<Punkt>();
		for (int i = 0; i < a.length + this.lstPunkte.size(); i++) {
			if (i % 3 == 0) {
				lstPkt.add(this.lstPunkte.get(i / 3));
			} else {
				lstPkt.add(new Punkt(x[((i - i / 3) - 1)],
						y[((i - i / 3) - 1)], i));
			}
		}

		if (this.open) {
			lstPkt.set(1, this.first);
			lstPkt.set(lstPkt.size() - 2, this.last);
		} else {
			// Ersten Punkt nochmal hinten anfuegen, da der erste gleichzeitig
			// der letzte Punkt beim geschlossenem Spline ist
			lstPkt.add(lstPkt.get(0));
		}
		List<Bezier> lstB = new ArrayList<Bezier>();

		for (int i = 3; i < lstPkt.size(); i = i + 3) {
			lstB.add(new Bezier(lstPkt.get(i - 3), lstPkt.get(i - 2), lstPkt
					.get(i - 1), lstPkt.get(i)));
		}
		return lstB;
	}

	/**
	 * Berechnen der X-Werte
	 * 
	 * @return
	 */
	private double[] xvalues() {
		double[][] l = this.getL(a);
		double[][] r = this.getR(a);

		double[] ergVec = this.initX();

		double[] yVec = new double[a.length];
		double[] xVec = new double[a.length];
		
		double summe = 0;


		yVec[0] = this.first.y;
		xVec[xVec.length-1] = this.last.x;
		yVec[yVec.length-1] = this.last.y;
		
		// Y
		for (int i = 0; i < l.length; i++) {
			// Summe-FOR
			for (int j = 0; j < l[i].length; j++) {
				summe = summe + l[i][j] * yVec[j];
			}
			ergVec[i] = ergVec[i] - summe;
			yVec[i] = ergVec[i] / l[i][i];
			summe = 0;
		}

		

		
		// X]
		summe = 0;
		for (int i = r.length - 1; i >= 0; i--) {
			// Summe-FOR
			for (int j = i; j < r[i].length; j++) {
				summe = summe + r[i][j] * xVec[j];
			}
			;
			ergVec[i] = yVec[i] - summe;
			xVec[i] = ergVec[i] / r[i][i];
			summe = 0;
		}
		return xVec;
	}

	/**
	 * Y-Werte berechnen
	 * 
	 * @return
	 */
	private double[] yvalues() {
		double[][] l = this.getL(a);
		double[][] r = this.getR(a);

		double[] ergVec = this.initY();

		double[] yVec = new double[a.length];
		double[] xVec = new double[a.length];

		double summe = 0;

		xVec[0] = this.first.x;
		yVec[0] = this.first.y;
		xVec[xVec.length-1] = this.last.x;
		yVec[yVec.length-1] = this.last.y;
		
		
		// Y
		for (int i = 0; i < l.length; i++) {
			// Summe-FOR
			for (int j = 0; j < l[i].length; j++) {
				summe = summe + l[i][j] * yVec[j];
			}
			ergVec[i] = ergVec[i] - summe;
			yVec[i] = ergVec[i] / l[i][i];
			summe = 0;
		}

		
		
		// X]
		summe = 0;
		for (int i = r.length - 1; i >= 0; i--) {
			// Summe-FOR
			for (int j = i; j < r[i].length; j++) {
				summe = summe + r[i][j] * xVec[j];
			}
			;
			ergVec[i] = yVec[i] - summe;
			xVec[i] = ergVec[i] / r[i][i];
			summe = 0;
		}
		return xVec;
	}

	/**
	 * Initialisierung fuer die Y-Werte mit den gegebenen Punkten
	 * 
	 * @return
	 */
	private double[] initY() {
		double[] ergVec = new double[a.length];
		int j = 0;
		for (int i = 0; i < a.length - 1; i++) {
			if (i % 2 == 0) {
				ergVec[i] = this.lstPunkte.get(j).y;
				j++;
			} else
				ergVec[i] = 0;
		}
		
		 if(this.open) {
			 for(int i=1; i<a.length-1; i++) {
					ergVec[i-1] = ergVec[i];
				}
			 ergVec[0] = this.first.y;
			 ergVec[a.length-1] = this.last.y;
		 }
		 printVector(ergVec);
		 return ergVec;
		
	}

	/**
	 * Initialisierung fuer die X-Werte mit den gegebenen Punkten
	 * 
	 * @return
	 */
	private double[] initX() {
		double[] ergVec = new double[a.length];
		int j = 0;
		for (int i = 0; i < a.length - 1; i++) {
			if (i % 2 == 0) {
				ergVec[i] = this.lstPunkte.get(j).x;
				j++;
			} else
				ergVec[i] = 0;
		}
		
		 if(this.open) {
			 for(int i=1; i<a.length-1; i++) {
					ergVec[i-1] = ergVec[i];
				}
			 ergVec[0] = this.first.x;
			 ergVec[a.length-1] = this.last.x;
		 }
		 printVector(ergVec);
		return ergVec;
	}
}
