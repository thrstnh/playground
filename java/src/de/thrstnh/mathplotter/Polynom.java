package de.thrstnh.mathplotter;


import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Scanner;

public class Polynom {
	public final static char PLUS = '+';

	public final static char MINUS = '-';

	public final static String TERM_DELIMITER = "\\s*[" + PLUS + MINUS
			+ "]\\s*";

	private String tVAR = "x";

	private String tEXP = "^";

//	private List<Double> a = new ArrayList<Double>();

	private void parsePolynom(String p) {
		TermScanner tScan = new TermScanner(p);
		String sTerm;
		int i = 0, exp = -1;
		double coeff = 0.;
		while ((sTerm = tScan.nextTerm()) != null) {
			i = sTerm.indexOf(tVAR);
			if (i == 1) // only var
				coeff = 1.;
			else if (i > 1) // coeff, var
				coeff = Double.parseDouble(sTerm.substring(0, i));
			else { // only coeff
				coeff = Double.parseDouble(sTerm);
				exp = 0;
			}
			if (0 < i && i + tVAR.length() < sTerm.length()) // exp
				exp = Integer.parseInt(sTerm.substring(
						i + tVAR.length() + tEXP.length()).trim());
			
			this.function.put(exp, coeff);
		}
	}

	private Map<Integer, Double> function = new HashMap<Integer, Double>();

	/**
	 * Standardkonstruktur. Werte koennen mit add(Pelem) hinzugefuegt werden
	 */
	public Polynom() {
	}

	public Polynom(String polynom) {
		if (polynom == null || polynom.length() == 0)
			throw new IllegalArgumentException("Leeres Polynom");
		parsePolynom(polynom);
	}

	/**
	 * Dem Standardkonstruktur koennen n Elemente vom Typ Pelem uebergeben
	 * werden.
	 * 
	 * @param pelems
	 */
	public Polynom(Pelem... pelems) {
		if (pelems == null || pelems.length == 0)
			throw new IllegalArgumentException(
					"Keine PolynomElemente vorhanden...");

		for (Pelem each : pelems)
			function.put(each.getExp(), each.getCoeff());
	}

	/**
	 * Liefert den hoechsten Exponenten der Funktion
	 * 
	 * @return
	 */
	public int getHighestExp() {
		int hExp = 0;
		for (Integer each : this.function.keySet()) {
			if (each > hExp)
				hExp = each;
		}
		return hExp;
	}

	/**
	 * Evaluiert die Funktion mit dem Wert x
	 * 
	 * @param x
	 * @return
	 */
	public double eval(double x) {
		int highestExp = this.getHighestExp();
		double p = function.get(highestExp);
		for (int i = (highestExp - 1); i > -1; i--) {
			p = p * x;
			if (function.containsKey(i))
				p = p + function.get(i);
		}
		return p;
	}

	/**
	 * Berechnet die Ableitung der Funktion und gibt diese als Polynom-Objekt
	 * zurueck
	 * 
	 * @return
	 */
	public Polynom deflection() {
		Polynom deflection = new Polynom();
		for (Integer each : function.keySet()) {
			if (each != 0) {
				deflection.add(new Pelem(function.get(each) * each, each - 1));
			}
		}
		return deflection;
	}

	/**
	 * Fuegt ein Pelem zum Polynom hinzu
	 * 
	 * @param pelem
	 * @throws IllegalArgumentException
	 */
	public void add(Pelem pelem) throws IllegalArgumentException {
		if (function.containsKey(pelem.getExp())) {
			throw new IllegalArgumentException(
					"Exponent schon vorhanden, wurde nicht ersetzt!");
		}
		function.put(pelem.getExp(), pelem.getCoeff());
	}

	/**
	 * Ersetzt ein Pelem im Polynom
	 * 
	 * @param pelem
	 * @throws IllegalArgumentException
	 */
	public void replace(Pelem pelem) throws IllegalArgumentException {
		if (!function.containsKey(pelem.getExp())) {
			throw new IllegalArgumentException(
					"Exponent nicht vorhanden, wurde nicht gesetzt!");
		}
		function.put(pelem.getExp(), pelem.getCoeff());

	}

	/**
	 * Berechnet das Gerschgorin-Kriterium (Gerschgorin-Kreis)
	 * 
	 * @return
	 */
	public double gerschgorin() {
		double sumCoeff = 0.;
		int highestExp = this.getHighestExp();
		double highestCoeff = 0.;
		List<Double> lstCoeff = new ArrayList<Double>();

		for (int i = highestExp - 1; i > -1; i--) {
			if (function.containsKey(i)) {
				sumCoeff = sumCoeff + Math.abs(function.get(i));
				lstCoeff.add(1 + Math.abs(function.get(i)));
			}
		}

		for (int i = 0; i < lstCoeff.size(); i++) {
			if (lstCoeff.get(i) > highestCoeff)
				highestCoeff = lstCoeff.get(i);
		}

		if (sumCoeff > highestCoeff)
			return highestCoeff;
		else
			return sumCoeff;
	}

	/**
	 * Berechnet eine Nullstelle bis zu einer Genauigkeit, die angegeben werden
	 * kann.
	 * 
	 * @param closeness
	 * @return
	 */
	public double evalZeroPoint(double closeness) {
		double gerschgorin = this.gerschgorin();
		double diff = gerschgorin;
		boolean found = false;
		Polynom deflection = this.deflection();
		int i = 0;
		do {
			i++;
			try {
				gerschgorin = diff
						- (this.eval(gerschgorin) / deflection
								.eval(gerschgorin));
				if (Double.isNaN(gerschgorin))
					throw new Exception("0/0");
			} catch (Exception e) {
				gerschgorin = 0.0;
			}
			if (Math.abs((gerschgorin - diff) / diff) > closeness)
				diff = gerschgorin;
			else
				found = true;
		} while (!found && i < 1000);
		System.out.println("Schritte: " + i);
		if (i >= 1000)
			System.out.println("KEINE NULLSTELLE");
		return gerschgorin;
	}

	public double evalZeroPoint(double zeroPoint, double closeness) {
		double gerschgorin = zeroPoint;
		double diff = gerschgorin;
		boolean found = false;
		Polynom deflection = this.deflection();
		int i = 0;
		do {
			i++;
			try {
				gerschgorin = diff
						- (this.eval(gerschgorin) / deflection
								.eval(gerschgorin));
				if (Double.isNaN(gerschgorin))
					throw new Exception("0/0");
			} catch (Exception e) {
				gerschgorin = 0.0;
			}
			if (Math.abs((gerschgorin - diff) / diff) > closeness)
				diff = gerschgorin;
			else
				found = true;
		} while (!found && i < 1000);
		System.out.println("Schritte: " + i);
		if (i >= 1000)
			System.out.println("KEINE NULLSTELLE");
		return gerschgorin;
	}

	/**
	 * Gibt eine List<Double> mit allen Nullstellen des Polynoms zurueck
	 * 
	 * @param closeness
	 * @return
	 */
	public List<Double> getZeroPoints(double closeness) {
		List<Double> lstZeroPoints = new ArrayList<Double>();
		double zeroPoint = 0.;
		Polynom separation = this;
		@SuppressWarnings("unused")
		int i = 0;

		while (separation.getHighestExp() > 0) {
			zeroPoint = separation.evalZeroPoint(closeness);
			System.out.println("Abweichung:  " + this.eval(zeroPoint));
			lstZeroPoints.add(zeroPoint);
			separation = separation.separation(zeroPoint, closeness);

			i++;
		}
		return lstZeroPoints;
	}

	/**
	 * Die Nullstellen nochmals genauer berechnen
	 * 
	 * @param closeness
	 * @return
	 */
	public List<Double> getZeroPointsPrecision(List<Double> lstZeroPoints,
			double closeness) {
		List<Double> returnList = new ArrayList<Double>();
		List<Double> zeroPoints = lstZeroPoints;
		Polynom separation = this;
		for (double zeroPoint : zeroPoints) {
			double zp = zeroPoint;
			zp = separation.evalZeroPoint(zeroPoint, closeness);
			returnList.add(zp);
			System.out.println("Abweichung:  " + this.eval(zp));
			separation = separation.separation(zp, closeness);
		}
		return returnList;
	}

	/**
	 * Abspaltung nach dem Horner-Schema
	 * 
	 * @param zeroPoint
	 * @param closeness
	 * @return
	 */
	public Polynom separation(double zeroPoint, double closeness) {
		double p = 0.;
		Polynom seperation = new Polynom();

		for (int i = this.getHighestExp(); i > -1; i--) {
			p = p * zeroPoint;
			if (this.function.containsKey(i)) {
				p = p + this.function.get(i);
				if (Math.abs(p) > closeness) {
					seperation.add(new Pelem(p, i - 1));
				}
			}
		}
		return seperation;
	}

	@Override
	public String toString() {
		int highestExp = this.getHighestExp();
		StringBuffer stb = new StringBuffer();
		if (function.containsKey(highestExp)) {
			if (this.function.get(highestExp) > 1)
				stb.append(this.function.get(highestExp));
			if (highestExp > 0)
				stb.append("x");
			if (highestExp > 1)
				stb.append("^").append(highestExp);
		}

		for (int i = (highestExp - 1); i > -1; i--) {
			if (function.containsKey(i)) {
				if (function.get(i) < 0) {
					stb.append(" - ");
				} else {
					stb.append(" + ");
				}
				if (this.function.get(i) > 1)
					stb.append(Math.abs(function.get(i)));
				else
					stb.append(Math.abs(function.get(i)));
				if (i > 0) {
					stb.append("x");
					if (i > 1)
						stb.append("^").append(i);
				}
			}
		}
		return stb.toString();
	}

	private static class TermScanner {
		Scanner sc;

		String p;

		char sign;

		TermScanner(String polynom) {
			p = polynom.trim();
			if ((sign = p.charAt(0)) == MINUS || sign == PLUS)
				p = p.substring(1);
			else
				sign = PLUS;
			sc = new Scanner(p).useDelimiter(TERM_DELIMITER);
		}

		String nextTerm() {
			String s = null;
			if (sc.hasNext()) {
				s = sign + sc.next();
				if (sc.match().end() < p.length() - 2)
					sign = p.charAt(sc.match().end() + 1);
			}
			return s;
		}
	}

}
