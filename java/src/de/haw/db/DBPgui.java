package de.haw.db;

// Imports der Klassen
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Statement;

// TODO: uncomment for oracle
//import oracle.jdbc.driver.OracleDriver;

import org.eclipse.swt.widgets.Shell;
import org.eclipse.swt.widgets.Display;
import org.eclipse.swt.widgets.Button;
import org.eclipse.swt.widgets.TableColumn;
import org.eclipse.swt.widgets.TableItem;
import org.eclipse.swt.SWT;
import org.eclipse.swt.widgets.Text;
import org.eclipse.swt.widgets.Label;

import org.eclipse.swt.widgets.Combo;
import org.eclipse.swt.widgets.Table;

public class DBPgui {

	private Shell sShell = null;  //  @jve:decl-index=0:visual-constraint="7,1"
	private Button btn_connect = null;
	private Text txt_Password = null;
	private Text txt_UserName = null;
	private Label lbl_UserName = null;
	private Label lbl_Password = null;
	private Combo cmb_Tables = null;
	private Connection con=null;
	String userName="";
	private Table tbl_Content = null;
	
	/**
	 * This method initializes cmb_Tables	
	 *
	 */
	private void createCmb_Tables() {
		cmb_Tables = new Combo(sShell, SWT.READ_ONLY);
		cmb_Tables.setEnabled(false);
		cmb_Tables.setLocation(new org.eclipse.swt.graphics.Point(280,5));
		cmb_Tables.setSize(new org.eclipse.swt.graphics.Point(160,22));
		
		cmb_Tables.addModifyListener(new org.eclipse.swt.events.ModifyListener() {
			public void modifyText(org.eclipse.swt.events.ModifyEvent e) {
				if(cmb_Tables.getSelectionIndex()>= 0){
					fillTable(cmb_Tables.getItem(cmb_Tables.getSelectionIndex()));
				}
			}
		});
	}

	/**
	 * This method initializes tbl_Content	
	 *
	 */
	private void createTbl_Content() {
		tbl_Content = new Table(sShell, SWT.NONE);
		tbl_Content.setHeaderVisible(true);
		tbl_Content.setLinesVisible(true);
		tbl_Content.setLocation(new org.eclipse.swt.graphics.Point(6,112));
		tbl_Content.setSize(new org.eclipse.swt.graphics.Point(859,182));
		tbl_Content.setData(btn_connect);
	}

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		/* Before this is run, be sure to set up the launch configuration (Arguments->VM Arguments)
		 * for the correct SWT library path in order to run with the SWT dlls. 
		 * The dlls are located in the SWT plugin jar.  
		 * For example, on Windows the Eclipse SWT 3.1 plugin jar is:
		 *       installation_directory\plugins\org.eclipse.swt.win32_3.1.0.jar
		 */
		Display display = Display.getDefault();
		DBPgui thisClass = new DBPgui();
		thisClass.createSShell();
		thisClass.sShell.open();

		while (!thisClass.sShell.isDisposed()) {
			if (!display.readAndDispatch())
				display.sleep();
		}
		display.dispose();
	}

	/**
	 * This method initializes sShell
	 */
	private void createSShell() {
		sShell = new Shell();
		sShell.setText("Shell");
		sShell.setLayout(null);
		sShell.setSize(new org.eclipse.swt.graphics.Point(879,326));
		btn_connect = new Button(sShell, SWT.NONE);
		btn_connect.setText("Connect");
		btn_connect.setSize(new org.eclipse.swt.graphics.Point(120,22));
		btn_connect.setLocation(new org.eclipse.swt.graphics.Point(110,61));
		txt_Password = new Text(sShell, SWT.BORDER | SWT.PASSWORD);
		txt_Password.setLocation(new org.eclipse.swt.graphics.Point(110,33));
		txt_Password.setSize(new org.eclipse.swt.graphics.Point(120,22));
		txt_UserName = new Text(sShell, SWT.BORDER);
		txt_UserName.setLocation(new org.eclipse.swt.graphics.Point(110,5));
		txt_UserName.setForeground(null);
		txt_UserName.setSize(new org.eclipse.swt.graphics.Point(120,22));
		lbl_UserName = new Label(sShell, SWT.NONE);
		lbl_UserName.setText("UserName");
		lbl_UserName.setSize(new org.eclipse.swt.graphics.Point(80,22));
		lbl_UserName.setLocation(new org.eclipse.swt.graphics.Point(5,5));
		lbl_Password = new Label(sShell, SWT.NONE);
		lbl_Password.setText("Password");
		lbl_Password.setSize(new org.eclipse.swt.graphics.Point(80,22));
		lbl_Password.setLocation(new org.eclipse.swt.graphics.Point(5,33));
		createTbl_Content();
		createCmb_Tables();
		btn_connect.addSelectionListener(new org.eclipse.swt.events.SelectionAdapter() {
			public void widgetSelected(org.eclipse.swt.events.SelectionEvent e) {
				createDBConnection();
			}
		});
		// Focus beim Start auf das Username-Feld setzen
		txt_UserName.setFocus();
	}
	private void createDBConnection(){
		try {
			// Instanz des Oracle Treibers über den DriverManager erstellen.
			// Der DriverManager ist für das JDBC/ODBC zuständig
			// TODO: uncomment for oracle
			//DriverManager.registerDriver(new OracleDriver());
			String password="";
			String url="";
			
			// Aus dem Textfeld Username/Password holen, trim() um leerzeichen abzutrennen
			userName= txt_UserName.getText().trim();
			password= txt_Password.getText().trim();
			// Connection URL
			url= "jdbc:oracle:thin:@oracle.informatik.haw-hamburg.de:1521:SWT05";
			
			// Verbindung herstellen mit der ConnectionURL, Username, Password
			con= DriverManager.getConnection(url,userName,password);
			// Wenn die Verbindung nicht hergestellt werden kann, also Username oder Password
			// falsch ist, wird "Keine Verbindung" ausgegeben.
			// Sonst "Verbindung aufgebaut"
			if(con==null) System.out.println("Keine Verbindung");
			else System.out.println("Verbindung aufgebaut");
			
			// Da die Verbindung steht, wird nun die ConboBox mit den Tabellennamen gefüllt
			fillComboBoxTables();
		} catch (SQLException e) {
			System.out.println("Verbindung fehlgeschlgen");
			e.printStackTrace();
		}
	}
	private void fillComboBoxTables(){
		// Statement führt ein SQL-Query aus
		Statement stmt;
		// Exception abfangen falls nötig...
		try {
			// Statement erzeugen
			stmt = con.createStatement();
			// Query festlegen und das Ergebnis (Die Tabelle) in einem ResultSet sichern
			ResultSet rs=stmt.executeQuery("select * from USER_TABLES");
			// Solange das Tabellenende nicht erreich ist...
			while (rs.next()){
				// Zeile für Zeile auslesen und direkt in die ComboBox packen
				cmb_Tables.add(rs.getString("TABLE_NAME"));
			}
			// Das ResultSet wieder schliessen
			rs.close();
			// Wenn die ComboBox nun leer sein sollte (Keine Tabellen vorhanden),
			// bleibt die ComboBox disabled, sonst wird diese aktiviert, um eine
			// der Tabellen anzuklicken
			if (cmb_Tables.getItemCount() > 0){
				cmb_Tables.setEnabled(true);
			}
			
			stmt.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	};
	private void fillTable(String table){
		// Wieder ein Statement für das SQL-Query
		Statement stmt;
		// Anzahl der Spalten
		int countCol=0;
		try {
			// Statement erzeigen
			stmt = con.createStatement();
			// SQL-Query ausführen und das ergebnis im ResultSet sichern
			ResultSet rs=stmt.executeQuery("select * from "+table);
			// Metadaten der Tabelle, also Spaltennamen etc auslesen
			ResultSetMetaData rsmd=rs.getMetaData();
			// Anzahl der Spalten erfragen
			countCol= rsmd.getColumnCount();
			// Falls die Tabelle schonmal gefüllt war, diese zuerst leeren
			clearTable();
			
			// TABELLE AUFBAUEN
			// Für jede Spalte in der Datenbank...
			for(int i=1;i<=countCol;i++) {
				// ... eine TableColumn erzeigen...
				TableColumn tc=new TableColumn(tbl_Content,SWT.NONE);
				// ... als Text die Spaltenüberschrift setzen
				tc.setText(rsmd.getColumnLabel(i));
				// ... Breite konstant auf 80 setzen
				// (eine 'vernünftige' Breite liefern die MetaDaten nicht...?)
				tc.setWidth(80);
			}
			
			// TABELLE FÜLLEN
			// Solange Zeilen vorhanden sind...
			while (rs.next()){
				// ... TableItem (Zeile) erzeugen
				TableItem ti= new TableItem(tbl_Content,SWT.COLOR_BLACK);
				// StringArray (ArrayList geht evtl auch und wäre schneller...) erzeugen mit
				// der gegebenen Anzahl an Spalten
				String[] strArray = new String[countCol];
				// Zwischenspeicher für einen Eintrag
				String item = "";
				// ZEILE MIT DATEN FÜLLEN
				for(int i=1;i<=countCol;i++) {
					// String/null auslesen aus dem ResultSet
					item = rs.getString(i);
					// Wenn das item nicht 'null' ist und die Laenge groesser 0... 
					if(item != null && item.trim().length() > 0) {
						// ... das item setzen...
						strArray[i-1] = item;
					} else {
						// ... sonst 'null' in das item schreiben, da 
						// 'null' ja wichtig für die DB-Eintraege ist...
						strArray[i-1] = "null";
					}
				}
				// nun wird dem TableItel (Zeile) das StringArray (GefüllteZeile) übergeben...
				ti.setText(strArray);
				// und der Tabelle wird das TableItem übergeben
				tbl_Content.setData(ti);
			}
			// ResultSet schliessen
			rs.close();
			stmt.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}
	
	private void clearTable() {
		// Elemente aus der Tabelle loeschen
		tbl_Content.setItemCount(0);
		// TableColums "beenden"/entfernen
		TableColumn[] tcArray = tbl_Content.getColumns();
		for(int i=0; i<tcArray.length; i++)
			tcArray[i].dispose();
	}
}
