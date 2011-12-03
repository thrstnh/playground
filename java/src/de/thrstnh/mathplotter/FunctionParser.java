package de.thrstnh.mathplotter;


import javax.swing.JPanel;
import javax.swing.JTextField;
import java.awt.Dimension;
import javax.swing.JButton;

public class FunctionParser extends JPanel {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private JTextField txtFunction = null;
	private JButton btnParse = null;

	/**
	 * This method initializes 
	 * 
	 */
	public FunctionParser() {
		super();
		initialize();
	}

	/**
	 * This method initializes this
	 * 
	 */
	private void initialize() {
        this.setSize(new Dimension(220, 65));			
        this.add(getTxtFunction(), null);
        this.add(getBtnParse(), null);
	}

	/**
	 * This method initializes txtFunction	
	 * 	
	 * @return javax.swing.JTextField	
	 */
	private JTextField getTxtFunction() {
		if (txtFunction == null) {
			txtFunction = new JTextField();
			txtFunction.setPreferredSize(new Dimension(160, 20));
			txtFunction.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					parse();
				}
			});
		}
		return txtFunction;
	}

	/**
	 * This method initializes btnParse	
	 * 	
	 * @return javax.swing.JButton	
	 */
	private JButton getBtnParse() {
		if (btnParse == null) {
			btnParse = new JButton();
			btnParse.setText("Parse...");
			btnParse.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					parse();
				}
			});
		}
		return btnParse;
	}

	private Polynom parse() {
		// TODO
		String function =  txtFunction.getText().trim();
		System.out.println(function);
		Polynom polynom = new Polynom(function);
		
		System.out.println(polynom);
		return polynom;
	}
}  //  @jve:decl-index=0:visual-constraint="10,10"
