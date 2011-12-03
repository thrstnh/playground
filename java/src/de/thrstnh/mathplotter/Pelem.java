package de.thrstnh.mathplotter;


public class Pelem {
	private int exp = 0;

	private double coeff = 0.0;

	public Pelem(double coeff, int exp) {
		this.setCoeff(coeff);
		this.setExp(exp);
	}

	public double getCoeff() {
		return coeff;
	}

	public void setCoeff(double coeff) {
		this.coeff = coeff;
	}

	public int getExp() {
		return exp;
	}

	public void setExp(int exp) {
		if (exp < 0)
			throw new IllegalArgumentException(
					"Exponent darf nicht negativ sein!");
		this.exp = exp;
	}

	@Override
	public String toString() {
		StringBuffer stb = new StringBuffer();
		stb.append(this.getCoeff()).append("x^").append(this.getExp());
		return stb.toString();
	}
}
