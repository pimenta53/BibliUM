/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * frameEspecifico.java
 *
 * Created on 28/Dez/2010, 23:29:42
 */

package javaapplication1;
import java.sql.ResultSet;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;
/**
 *
 * @author Milton
 */
public class frameEspecifico extends javax.swing.JFrame {

    
    String espec = "";
    Nucleo nucleo;
    /** Creates new form frameEspecifico */
    public frameEspecifico(Nucleo nuc) {
        nucleo=nuc;
        initComponents();
        jButton7.setVisible(false);
        jButton5.setText("Adicionar");
        jLabel2.setVisible(false);
        try {
            actualizarComboArea();
        } catch (Exception ex) {
            Logger.getLogger(frameEspecifico.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

     public frameEspecifico(String espec, Nucleo nuc) throws Exception{
        nucleo=nuc;
        initComponents();
        this.espec = espec;
        carregarDados();

    }



    /** This method is called from within the constructor to
     * initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is
     * always regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jLabel2 = new javax.swing.JLabel();
        txtarea = new javax.swing.JTextField();
        txtname = new javax.swing.JTextField();
        jLabel4 = new javax.swing.JLabel();
        jLabel5 = new javax.swing.JLabel();
        comboarea = new javax.swing.JComboBox();
        txtcod = new javax.swing.JTextField();
        jLabel1 = new javax.swing.JLabel();
        jLabel3 = new javax.swing.JLabel();
        jButton9 = new javax.swing.JButton();
        jButton7 = new javax.swing.JButton();
        jButton5 = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.DISPOSE_ON_CLOSE);
        setResizable(false);
        addWindowListener(new java.awt.event.WindowAdapter() {
            public void windowClosing(java.awt.event.WindowEvent evt) {
                formWindowClosing(evt);
            }
        });

        jLabel2.setText("jLabel2");

        txtarea.setEditable(false);

        jLabel4.setText("Nome");

        jLabel5.setText("Tema");

        comboarea.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "Tema" }));
        comboarea.addItemListener(new java.awt.event.ItemListener() {
            public void itemStateChanged(java.awt.event.ItemEvent evt) {
                comboareaItemStateChanged(evt);
            }
        });

        txtcod.setEditable(false);

        jLabel1.setFont(new java.awt.Font("Tahoma", 0, 18));
        jLabel1.setText("Especifico");

        jLabel3.setText("Código");

        jButton9.setText("Fechar");
        jButton9.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jButton9MouseClicked(evt);
            }
        });
        jButton9.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton9ActionPerformed(evt);
            }
        });

        jButton7.setText("Apagar");
        jButton7.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton7ActionPerformed(evt);
            }
        });

        jButton5.setText("Guardar");
        jButton5.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jButton5MouseClicked(evt);
            }
        });
        jButton5.addKeyListener(new java.awt.event.KeyAdapter() {
            public void keyPressed(java.awt.event.KeyEvent evt) {
                jButton5KeyPressed(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(27, 27, 27)
                        .addComponent(jLabel4)
                        .addGap(24, 24, 24)
                        .addComponent(txtname, javax.swing.GroupLayout.PREFERRED_SIZE, 123, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(27, 27, 27)
                        .addComponent(jLabel5)
                        .addGap(25, 25, 25)
                        .addComponent(txtarea, javax.swing.GroupLayout.PREFERRED_SIZE, 123, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addGap(10, 10, 10)
                        .addComponent(comboarea, javax.swing.GroupLayout.PREFERRED_SIZE, 72, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(96, 96, 96)
                        .addComponent(jButton7)
                        .addGap(10, 10, 10)
                        .addComponent(jButton5)
                        .addGap(10, 10, 10)
                        .addComponent(jButton9))
                    .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING, false)
                        .addGroup(layout.createSequentialGroup()
                            .addGap(36, 36, 36)
                            .addComponent(jLabel1)
                            .addGap(18, 18, 18)
                            .addComponent(jLabel2, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                        .addGroup(javax.swing.GroupLayout.Alignment.LEADING, layout.createSequentialGroup()
                            .addGap(27, 27, 27)
                            .addComponent(jLabel3)
                            .addGap(18, 18, 18)
                            .addComponent(txtcod, javax.swing.GroupLayout.PREFERRED_SIZE, 123, javax.swing.GroupLayout.PREFERRED_SIZE))))
                .addContainerGap(33, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(28, 28, 28)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jLabel1)
                    .addComponent(jLabel2))
                .addGap(25, 25, 25)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(3, 3, 3)
                        .addComponent(jLabel3))
                    .addComponent(txtcod, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(6, 6, 6)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(9, 9, 9)
                        .addComponent(jLabel4))
                    .addComponent(txtname, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(6, 6, 6)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(3, 3, 3)
                        .addComponent(jLabel5))
                    .addComponent(txtarea, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(comboarea, javax.swing.GroupLayout.PREFERRED_SIZE, 22, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(18, 18, 18)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jButton7)
                    .addComponent(jButton5)
                    .addComponent(jButton9))
                .addContainerGap(22, Short.MAX_VALUE))
        );

        java.awt.Dimension screenSize = java.awt.Toolkit.getDefaultToolkit().getScreenSize();
        setBounds((screenSize.width-368)/2, (screenSize.height-253)/2, 368, 253);
    }// </editor-fold>//GEN-END:initComponents

    private void jButton9MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jButton9MouseClicked
        nucleo.setEnab(true);
        this.dispose();
}//GEN-LAST:event_jButton9MouseClicked

    private void jButton9ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton9ActionPerformed

}//GEN-LAST:event_jButton9ActionPerformed

    private void jButton7ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton7ActionPerformed
        GregorianCalendar dateA = new GregorianCalendar();

        String data = dateA.get(Calendar.YEAR) + "." + dateA.get(Calendar.MONTH)+1 + "." + dateA.get(Calendar.DAY_OF_MONTH);
        try {
            nucleo.apagarEspec(txtcod.getText(), data);
            // TODO add your handling code here:
        } catch (Exception ex) {
            JOptionPane.showMessageDialog(null,ex);
            return;
        }
        JOptionPane.showMessageDialog(null,"Tipo Especifico apagado com sucesso!");
        this.dispose();        // TODO add your handling code here:
}//GEN-LAST:event_jButton7ActionPerformed

    private void jButton5MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jButton5MouseClicked
        if(jButton5.getText().equals("Guardar")) try {
            update();
            JOptionPane.showMessageDialog(null,"Tipo Especifico alterado com sucesso!");
            nucleo.setEnab(true);
            this.dispose();
        } catch (Exception ex) {
            Logger.getLogger(frameEspecifico.class.getName()).log(Level.SEVERE, null, ex);
        }
        else try {
            gravar();
            JOptionPane.showMessageDialog(null,"Tipo Especifico criado com sucesso!");
            nucleo.setEnab(true);
            this.dispose();
        } catch (Exception ex) {
            Logger.getLogger(frameEspecifico.class.getName()).log(Level.SEVERE, null, ex);
        }
}//GEN-LAST:event_jButton5MouseClicked

    private void jButton5KeyPressed(java.awt.event.KeyEvent evt) {//GEN-FIRST:event_jButton5KeyPressed

}//GEN-LAST:event_jButton5KeyPressed

    private void formWindowClosing(java.awt.event.WindowEvent evt) {//GEN-FIRST:event_formWindowClosing
        nucleo.setEnab(true);
        this.dispose();        // TODO add your handling code here:
    }//GEN-LAST:event_formWindowClosing

    private void comboareaItemStateChanged(java.awt.event.ItemEvent evt) {//GEN-FIRST:event_comboareaItemStateChanged
        String t = comboarea.getSelectedItem().toString();
        if(t.equals("Tema")) t = "";
        txtarea.setText(t);        // TODO add your handling code here:
    }//GEN-LAST:event_comboareaItemStateChanged

    public void carregarDados()throws Exception{
        ResultSet especs = nucleo.getSpecific(espec);
        
        while(especs.next()){
            jLabel2.setText(especs.getString(2));
            txtcod.setText(especs.getString(1));
            txtname.setText(especs.getString(2));
            ResultSet ar = nucleo.getArea(especs.getString(3));
            while(ar.next())
            txtarea.setText(ar.getString(2));
            ar.close();
        }
        especs.close();
        actualizarComboArea();


    }

    private void actualizarComboArea() throws Exception{
        ResultSet area = nucleo.listarArea();
        while(area.next()){
            if(area.getString(3)==null) comboarea.addItem(area.getString(2));
        }
        area.close();
    }
    
    public void gravar() throws Exception{
        String nome = txtname.getText();
        String tema = verTema(txtarea.getText());
        nucleo.createSpecific(nome, tema);
    
    }


    public void update() throws Exception{
        String cod = txtcod.getText();
        String nome = txtname.getText();
        String tema = verTema(txtarea.getText());
        nucleo.updateSpecific(cod, nome, tema);

    }


    public String verTema(String nome)throws Exception{
        String res = "";
        ResultSet temas = nucleo.listarArea();
        while(temas.next() && res.equals("")){
            if (temas.getString(2).equals(nome)) res = temas.getString(1);
        }
        temas.close();
        return res;
    }

    /**
    * @param args the command line arguments
    */
    public static void main(String args[]) {
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new frameEspecifico(new Nucleo()).setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JComboBox comboarea;
    private javax.swing.JButton jButton5;
    private javax.swing.JButton jButton7;
    private javax.swing.JButton jButton9;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JLabel jLabel5;
    private javax.swing.JTextField txtarea;
    private javax.swing.JTextField txtcod;
    private javax.swing.JTextField txtname;
    // End of variables declaration//GEN-END:variables

}