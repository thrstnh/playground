package de.thrstnh.mathplotter;


import javax.swing.SwingUtilities;
import java.awt.BorderLayout;
import javax.swing.JPanel;
import javax.swing.JFrame;
import java.awt.GridBagLayout;
import java.awt.Dimension;
import javax.swing.JButton;
import java.awt.GridBagConstraints;

import javax.swing.ButtonGroup;
import javax.swing.JSplitPane;
import javax.swing.JCheckBox;
import javax.swing.JOptionPane;
import javax.swing.BorderFactory;
import javax.swing.border.TitledBorder;
import javax.swing.JRadioButton;
import java.awt.Font;
import java.awt.Color;
import javax.swing.JLabel;
import javax.swing.JTextField;


public class MathPlotter extends JFrame {

	private MathPlotter mathPlotter = this;
	private static final long serialVersionUID = 1L;

	private JPanel jContentPane = null;

	private Graph graph = null;

	private JPanel jPanel = null;

	private JButton btnExample = null;

	private JSplitPane jSplitPane = null;

	private JCheckBox jCheckBox = null;

	private JButton btnRedraw = null;

	private JButton btnClear = null;

	private JPanel pnlOptions = null;

	private JPanel pnlAddPunkt = null;

	private JLabel lblX = null;

	private JLabel lblY = null;

	private JTextField txtX = null;

	private JTextField txtY = null;

	private JButton btnAddPunkt = null;

	private JPanel pnlActions = null;

	private JRadioButton optBezier = null;

	private JRadioButton optSpline = null;

	private JLabel lblSplinePunkte = null;

	private JTextField txtSplinePunkte = null;
	private JCheckBox chkOpen = null;

	/**
	 * This method initializes graph	
	 * 	
	 * @return hilleb_t.math.Graph	
	 */
	private Graph getGraph() {
		if (graph == null) {
			graph = new Graph();
		}
		return graph;
	}

	/**
	 * This method initializes jPanel	
	 * 	
	 * @return javax.swing.JPanel	
	 */
	private JPanel getJPanel() {
		if (jPanel == null) {
			GridBagConstraints gridBagConstraints8 = new GridBagConstraints();
			gridBagConstraints8.fill = GridBagConstraints.HORIZONTAL;
			gridBagConstraints8.anchor = GridBagConstraints.NORTH;
			GridBagConstraints gridBagConstraints31 = new GridBagConstraints();
			gridBagConstraints31.gridx = 0;
			gridBagConstraints31.fill = GridBagConstraints.HORIZONTAL;
			gridBagConstraints31.anchor = GridBagConstraints.NORTH;
			gridBagConstraints31.gridy = 5;
			GridBagConstraints gridBagConstraints21 = new GridBagConstraints();
			gridBagConstraints21.gridx = 0;
			gridBagConstraints21.fill = GridBagConstraints.HORIZONTAL;
			gridBagConstraints21.anchor = GridBagConstraints.NORTH;
			gridBagConstraints21.gridy = 4;
			GridBagConstraints gridBagConstraints3 = new GridBagConstraints();
			gridBagConstraints3.gridx = -1;
			gridBagConstraints3.gridy = 1;
			jPanel = new JPanel();
			jPanel.setLayout(new GridBagLayout());
			jPanel.add(getPnlOptions(), gridBagConstraints21);
			jPanel.add(getPnlAddPunkt(), gridBagConstraints31);
			jPanel.add(getPnlActions(), gridBagConstraints8);
		}
		return jPanel;
	}

	/**
	 * This method initializes btnExample	
	 * 	
	 * @return javax.swing.JButton	
	 */
	private JButton getBtnExample() {
		if (btnExample == null) {
			btnExample = new JButton();
			btnExample.setText("example");
			btnExample.setPreferredSize(new Dimension(120, 25));
			btnExample.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.drawExample1();
				}
			});
		}
		return btnExample;
	}

	/**
	 * This method initializes jSplitPane	
	 * 	
	 * @return javax.swing.JSplitPane	
	 */
	private JSplitPane getJSplitPane() {
		if (jSplitPane == null) {
			jSplitPane = new JSplitPane();
			jSplitPane.setLeftComponent(getJPanel());
			jSplitPane.setRightComponent(getGraph());
		}
		return jSplitPane;
	}

	/**
	 * This method initializes jCheckBox	
	 * 	
	 * @return javax.swing.JCheckBox	
	 */
	private JCheckBox getJCheckBox() {
		if (jCheckBox == null) {
			jCheckBox = new JCheckBox();
			jCheckBox.setText("connectPunkte");
			jCheckBox.setSelected(true);
			jCheckBox.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.setConnectPunkte(jCheckBox.isSelected());
					graph.repaint();
					System.out.println("...");
				}
			});
		}
		return jCheckBox;
	}

	/**
	 * This method initializes btnRedraw	
	 * 	
	 * @return javax.swing.JButton	
	 */
	private JButton getBtnRedraw() {
		if (btnRedraw == null) {
			btnRedraw = new JButton();
			btnRedraw.setText("redraw");
			btnRedraw.setPreferredSize(new Dimension(120, 25));
			btnRedraw.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.repaint();
				}
			});
		}
		return btnRedraw;
	}

	/**
	 * This method initializes btnClear	
	 * 	
	 * @return javax.swing.JButton	
	 */
	private JButton getBtnClear() {
		if (btnClear == null) {
			btnClear = new JButton();
			btnClear.setText("clear");
			btnClear.setPreferredSize(new Dimension(120, 25));
			btnClear.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.clearAll();
				}
			});
		}
		return btnClear;
	}

	/**
	 * This method initializes pnlOptions	
	 * 	
	 * @return javax.swing.JPanel	
	 */
	private JPanel getPnlOptions() {
		if (pnlOptions == null) {
			GridBagConstraints gridBagConstraints13 = new GridBagConstraints();
			gridBagConstraints13.gridx = 0;
			gridBagConstraints13.gridwidth = 0;
			gridBagConstraints13.gridy = 5;
			GridBagConstraints gridBagConstraints12 = new GridBagConstraints();
			gridBagConstraints12.fill = GridBagConstraints.VERTICAL;
			gridBagConstraints12.gridy = 7;
			gridBagConstraints12.weightx = 1.0;
			gridBagConstraints12.gridx = 1;
			GridBagConstraints gridBagConstraints11 = new GridBagConstraints();
			gridBagConstraints11.gridx = 0;
			gridBagConstraints11.gridy = 6;
			lblSplinePunkte = new JLabel();
			lblSplinePunkte.setText("SplinePunkte");
			GridBagConstraints gridBagConstraints10 = new GridBagConstraints();
			gridBagConstraints10.gridx = 0;
			gridBagConstraints10.fill = GridBagConstraints.HORIZONTAL;
			gridBagConstraints10.gridwidth = 1;
			gridBagConstraints10.gridy = 4;
			GridBagConstraints gridBagConstraints9 = new GridBagConstraints();
			gridBagConstraints9.gridx = 0;
			gridBagConstraints9.fill = GridBagConstraints.HORIZONTAL;
			gridBagConstraints9.gridwidth = 2;
			gridBagConstraints9.gridy = 2;
			GridBagConstraints gridBagConstraints1 = new GridBagConstraints();
			gridBagConstraints1.gridx = -1;
			gridBagConstraints1.gridwidth = 2;
			gridBagConstraints1.gridy = -1;
			pnlOptions = new JPanel();
			pnlOptions.setLayout(new GridBagLayout());
			pnlOptions.setBorder(BorderFactory.createTitledBorder(null, "Options", TitledBorder.DEFAULT_JUSTIFICATION, TitledBorder.DEFAULT_POSITION, null, null));
			pnlOptions.add(getJCheckBox(), gridBagConstraints1);
			pnlOptions.add(getOptBezier(), gridBagConstraints9);
			pnlOptions.add(getOptSpline(), gridBagConstraints10);
			pnlOptions.add(lblSplinePunkte, gridBagConstraints11);
			pnlOptions.add(getTxtSplinePunkte(), gridBagConstraints12);
			pnlOptions.add(getChkOpen(), gridBagConstraints13);
			ButtonGroup bg = new ButtonGroup();
			bg.add(getOptBezier());
			bg.add(getOptSpline());
		}
		return pnlOptions;
	}

	/**
	 * This method initializes pnlAddPunkt	
	 * 	
	 * @return javax.swing.JPanel	
	 */
	private JPanel getPnlAddPunkt() {
		if (pnlAddPunkt == null) {
			GridBagConstraints gridBagConstraints7 = new GridBagConstraints();
			gridBagConstraints7.gridx = 0;
			gridBagConstraints7.gridwidth = 3;
			gridBagConstraints7.weightx = 1.0D;
			gridBagConstraints7.fill = GridBagConstraints.HORIZONTAL;
			gridBagConstraints7.gridy = 2;
			GridBagConstraints gridBagConstraints6 = new GridBagConstraints();
			gridBagConstraints6.gridx = 0;
			gridBagConstraints6.gridy = 1;
			GridBagConstraints gridBagConstraints5 = new GridBagConstraints();
			gridBagConstraints5.fill = GridBagConstraints.VERTICAL;
			gridBagConstraints5.gridx = 2;
			gridBagConstraints5.gridy = 1;
			gridBagConstraints5.weightx = 1.0;
			GridBagConstraints gridBagConstraints4 = new GridBagConstraints();
			gridBagConstraints4.fill = GridBagConstraints.VERTICAL;
			gridBagConstraints4.gridx = 2;
			gridBagConstraints4.weightx = 1.0;
			lblY = new JLabel();
			lblY.setText("Y");
			lblY.setPreferredSize(new Dimension(20, 21));
			lblX = new JLabel();
			lblX.setText("X");
			lblX.setPreferredSize(new Dimension(20, 21));
			pnlAddPunkt = new JPanel();
			pnlAddPunkt.setLayout(new GridBagLayout());
			pnlAddPunkt.setBorder(BorderFactory.createTitledBorder(null, "addPunkt", TitledBorder.DEFAULT_JUSTIFICATION, TitledBorder.DEFAULT_POSITION, new Font("Dialog", Font.BOLD, 12), new Color(51, 51, 51)));
			pnlAddPunkt.add(lblX, new GridBagConstraints());
			pnlAddPunkt.add(lblY, gridBagConstraints6);
			pnlAddPunkt.add(getTxtX(), gridBagConstraints4);
			pnlAddPunkt.add(getTxtY(), gridBagConstraints5);
			pnlAddPunkt.add(getBtnAddPunkt(), gridBagConstraints7);
		}
		return pnlAddPunkt;
	}

	/**
	 * This method initializes txtX	
	 * 	
	 * @return javax.swing.JTextField	
	 */
	private JTextField getTxtX() {
		if (txtX == null) {
			txtX = new JTextField();
			txtX.setPreferredSize(new Dimension(30, 21));
		}
		return txtX;
	}

	/**
	 * This method initializes txtY	
	 * 	
	 * @return javax.swing.JTextField	
	 */
	private JTextField getTxtY() {
		if (txtY == null) {
			txtY = new JTextField();
			txtY.setPreferredSize(new Dimension(30, 21));
		}
		return txtY;
	}

	/**
	 * This method initializes btnAddPunkt	
	 * 	
	 * @return javax.swing.JButton	
	 */
	@SuppressWarnings("deprecation")
	private JButton getBtnAddPunkt() {
		if (btnAddPunkt == null) {
			btnAddPunkt = new JButton();
			btnAddPunkt.setText("add");
			btnAddPunkt.setNextFocusableComponent(getTxtX());
			btnAddPunkt.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					addPunkt();
				}
			});
			btnAddPunkt.addKeyListener(new java.awt.event.KeyAdapter() {
				@SuppressWarnings("static-access")
				public void keyPressed(java.awt.event.KeyEvent e) {
					if(e.getKeyCode() == e.VK_ENTER)
						addPunkt();
				}
			});
		}
		return btnAddPunkt;
	}

	/**
	 * This method initializes pnlActions	
	 * 	
	 * @return javax.swing.JPanel	
	 */
	private JPanel getPnlActions() {
		if (pnlActions == null) {
			GridBagConstraints gridBagConstraints61 = new GridBagConstraints();
			gridBagConstraints61.gridx = 0;
			gridBagConstraints61.gridy = 2;
			GridBagConstraints gridBagConstraints51 = new GridBagConstraints();
			gridBagConstraints51.gridx = 0;
			gridBagConstraints51.gridy = 1;
			GridBagConstraints gridBagConstraints = new GridBagConstraints();
			gridBagConstraints.gridx = 0;
			gridBagConstraints.gridy = 0;
			GridBagConstraints gridBagConstraints2 = new GridBagConstraints();
			gridBagConstraints2.gridx = 0;
			gridBagConstraints2.gridy = 2;
			pnlActions = new JPanel();
			pnlActions.setLayout(new GridBagLayout());
			pnlActions.setBorder(BorderFactory.createTitledBorder(null, "actions", TitledBorder.DEFAULT_JUSTIFICATION, TitledBorder.DEFAULT_POSITION, null, null));
			pnlActions.add(getBtnExample(), new GridBagConstraints());
			pnlActions.add(getBtnClear(), gridBagConstraints51);
			pnlActions.add(getBtnRedraw(), gridBagConstraints61);
		}
		return pnlActions;
	}

	/**
	 * This method initializes optBezier	
	 * 	
	 * @return javax.swing.JRadioButton	
	 */
	private JRadioButton getOptBezier() {
		if (optBezier == null) {
			optBezier = new JRadioButton();
			optBezier.setText("Bezier");
			optBezier.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.setBezier(true);
					txtSplinePunkte.setEnabled(false);
				}
			});
		}
		return optBezier;
	}

	/**
	 * This method initializes optSpline	
	 * 	
	 * @return javax.swing.JRadioButton	
	 */
	private JRadioButton getOptSpline() {
		if (optSpline == null) {
			optSpline = new JRadioButton();
			optSpline.setText("Spline");
			optSpline.setSelected(true);
			optSpline.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.setBezier(false);
					txtSplinePunkte.setEnabled(true);
				}
			});
		}
		return optSpline;
	}

	/**
	 * This method initializes txtSplinePunkte	
	 * 	
	 * @return javax.swing.JTextField	
	 */
	private JTextField getTxtSplinePunkte() {
		if (txtSplinePunkte == null) {
			txtSplinePunkte = new JTextField();
			txtSplinePunkte.setPreferredSize(new Dimension(30, 21));
			txtSplinePunkte.setText("4");
			txtSplinePunkte.addCaretListener(new javax.swing.event.CaretListener() {
				public void caretUpdate(javax.swing.event.CaretEvent e) {
					if(txtSplinePunkte.getText().trim().length() > 0) {
						try {
							graph.setSplineCount(new Integer(txtSplinePunkte.getText().trim()));
						} catch (Exception ex) {
							JOptionPane.showMessageDialog(mathPlotter, "SplinePunkte nur eine ganze Zahl größer 1");
						}
					}
				}
			});
		}
		return txtSplinePunkte;
	}

	/**
	 * This method initializes chkOpen	
	 * 	
	 * @return javax.swing.JCheckBox	
	 */
	private JCheckBox getChkOpen() {
		if (chkOpen == null) {
			chkOpen = new JCheckBox();
			chkOpen.setSelected(false);
			chkOpen.setText("offen");
			chkOpen.addActionListener(new java.awt.event.ActionListener() {
				public void actionPerformed(java.awt.event.ActionEvent e) {
					graph.setOffen(!graph.isOffen());
				}
			});
		}
		return chkOpen;
	}

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				MathPlotter thisClass = new MathPlotter();
				thisClass.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
				thisClass.setVisible(true);
			}
		});
	}

	/**
	 * This is the default constructor
	 */
	public MathPlotter() {
		super();
		initialize();
	}

	/**
	 * This method initializes this
	 * 
	 * @return void
	 */
	private void initialize() {
		this.setSize(600, 400);
		this.setContentPane(getJContentPane());
		this.setTitle("JFrame");
		this.addKeyListener(new java.awt.event.KeyListener() {
			public void keyPressed(java.awt.event.KeyEvent e) {
				if(e.getKeyCode() == 66)
					graph.setBezier(true);
			}
			public void keyTyped(java.awt.event.KeyEvent e) {
			}
			public void keyReleased(java.awt.event.KeyEvent e) {
				if(e.getKeyCode() == 66)
					graph.setBezier(false);
			}
		});
	}

	/**
	 * This method initializes jContentPane
	 * 
	 * @return javax.swing.JPanel
	 */
	private JPanel getJContentPane() {
		if (jContentPane == null) {
			jContentPane = new JPanel();
			jContentPane.setLayout(new BorderLayout());
			jContentPane.add(getJSplitPane(), BorderLayout.CENTER);
		}
		return jContentPane;
	}

	private void addPunkt(){
		double x = 0.;
		double y = 0.;
		boolean error = false;
		try {
			x = new Double(txtX.getText().trim()).doubleValue();
		} catch (Exception e) {
			error = true;
		}
		try {
			y = new Double(txtY.getText().trim()).doubleValue();
		} catch (Exception e) {
			error = true;
		}
		if(!error) {
			graph.addPunkt(new Punkt(x, y));
		} else 
			JOptionPane.showMessageDialog(this, "Fehler: Bitte positiven oder negativen double-Wert für den Punkt angeben!");
		
	}
}
