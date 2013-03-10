/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * frameTema.java
 *
 * Created on 2/Dez/2010, 15:47:24s
 */

package javaapplication1;

import javax.swing.DefaultListModel;
import java.sql.ResultSet;
import java.util.Calendar;
import java.util.GregorianCalendar;
import javax.swing.JOptionPane;
/**
 *
 * @author Milton
 */

/**********Precisa de ser editado porque surgiu a lista de especificaçoes***********/
public class frameTema extends javax.swing.JFrame {
   
    String tema = "";
    Nucleo nucleo;
    /** Creates new form frameTema */


    public frameTema(Nucleo nuc){
        nucleo=nuc;
        initComponents();
        btnApagarTema.setVisible(false);
        jButton5.setText("Adicionar");
        lblTema.setVisible(false);
        
    }
    public frameTema(String tema, Nucleo nuc) throws Exception {
        initComponents();
        nucleo=nuc;
        this.tema = tema;
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

        txtname = new javax.swing.JTextField();
        jLabel5 = new javax.swing.JLabel();
        txtcod = new javax.swing.JTextField();
        jLabel3 = new javax.swing.JLabel();
        jLabel4 = new javax.swing.JLabel();
        jLabel1 = new javax.swing.JLabel();
        lblTema = new javax.swing.JLabel();
        jScrollPane1 = new javax.swing.JScrollPane();
        jList1 = new javax.swing.JList();
        jButton8 = new javax.swing.JButton();
        btnApagarTema = new javax.swing.JButton();
        jButton5 = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.DISPOSE_ON_CLOSE);
        setResizable(false);
        addWindowListener(new java.awt.event.WindowAdapter() {
            public void windowClosing(java.awt.event.WindowEvent evt) {
                formWindowClosing(evt);
            }
        });

        txtname.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                txtnameActionPerformed(evt);
            }
        });

        jLabel5.setText("Temas especificos:");

        txtcod.setEditable(false);
        txtcod.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                txtcodActionPerformed(evt);
            }
        });

        jLabel3.setText("Código");

        jLabel4.setText("Nome");

        jLabel1.setFont(new java.awt.Font("Tahoma", 0, 18));
        jLabel1.setText("Tema");

        jScrollPane1.setViewportView(jList1);

        jButton8.setText("Fechar");
        jButton8.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jButton8MouseClicked(evt);
            }
        });
        jButton8.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton8ActionPerformed(evt);
            }
        });

        btnApagarTema.setText("Apagar");
        btnApagarTema.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnApagarTemaActionPerformed(evt);
            }
        });

        jButton5.setText("Guardar");
        jButton5.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jButton5MouseClicked(evt);
            }
        });
        jButton5.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButton5ActionPerformed(evt);
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
                        .addGap(31, 31, 31)
                        .addComponent(jLabel1)
                        .addGap(18, 18, 18)
                        .addComponent(lblTema, javax.swing.GroupLayout.PREFERRED_SIZE, 136, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(29, 29, 29)
                        .addComponent(jLabel3)
                        .addGap(18, 18, 18)
                        .addComponent(txtcod, javax.swing.GroupLayout.PREFERRED_SIZE, 129, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(29, 29, 29)
                        .addComponent(jLabel4)
                        .addGap(24, 24, 24)
                        .addComponent(txtname, javax.swing.GroupLayout.PREFERRED_SIZE, 129, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(29, 29, 29)
                        .addComponent(jLabel5))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(79, 79, 79)
                        .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 273, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(188, 188, 188)
                        .addComponent(btnApagarTema)
                        .addGap(10, 10, 10)
                        .addComponent(jButton5)
                        .addGap(10, 10, 10)
                        .addComponent(jButton8)))
                .addContainerGap(36, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(25, 25, 25)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jLabel1)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(7, 7, 7)
                        .addComponent(lblTema, javax.swing.GroupLayout.PREFERRED_SIZE, 15, javax.swing.GroupLayout.PREFERRED_SIZE)))
                .addGap(18, 18, 18)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(3, 3, 3)
                        .addComponent(jLabel3))
                    .addComponent(txtcod, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(6, 6, 6)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(3, 3, 3)
                        .addComponent(jLabel4))
                    .addComponent(txtname, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(6, 6, 6)
                .addComponent(jLabel5)
                .addGap(6, 6, 6)
                .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 111, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(btnApagarTema)
                    .addComponent(jButton5)
                    .addComponent(jButton8))
                .addContainerGap(32, Short.MAX_VALUE))
        );

        java.awt.Dimension screenSize = java.awt.Toolkit.getDefaultToolkit().getScreenSize();
        setBounds((screenSize.width-463)/2, (screenSize.height-359)/2, 463, 359);
    }// </editor-fold>//GEN-END:initComponents


    public void carregarDados()throws Exception{
        ResultSet temas = null;
        
        temas = nucleo.getArea(tema);
        while(temas.next()){
            lblTema.setText(temas.getString(2));
            txtcod.setText(temas.getString(1));
            txtname.setText(temas.getString(2));

        }
        temas.close();

        DefaultListModel model = new DefaultListModel();
        ResultSet esp = nucleo.listarSpec();
        while(esp.next()){
            if(esp.getString(3)!=null){
            if(esp.getString(3).equals(tema)){
                model.addElement(esp.getString(2));
            }
            }
        }
        esp.close();
        jList1.setModel(model);
    }

    private void txtnameActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_txtnameActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_txtnameActionPerformed

    private void jButton8MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jButton8MouseClicked
        dispose();
        nucleo.setEnab(true);
}//GEN-LAST:event_jButton8MouseClicked

    private void jButton8ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton8ActionPerformed

}//GEN-LAST:event_jButton8ActionPerformed

    private void btnApagarTemaActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnApagarTemaActionPerformed
        GregorianCalendar dateA = new GregorianCalendar();

        String data = dateA.get(Calendar.YEAR) + "." + dateA.get(Calendar.MONTH)+1 + "." + dateA.get(Calendar.DAY_OF_MONTH);
        try {
            nucleo.apagarTema(txtcod.getText(), data);
            nucleo.apagaSpec(txtcod.getText(), data);
            // TODO add your handling code here:
        } catch (Exception ex) {
            JOptionPane.showMessageDialog(null,ex);
            return;
        }
        JOptionPane.showMessageDialog(null,"Tema apagado com sucesso!");
        nucleo.setEnab(true);
        this.dispose();        // TODO add your handling code here:
}//GEN-LAST:event_btnApagarTemaActionPerformed

    private void jButton5MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jButton5MouseClicked
        if(jButton5.getText().equals("Guardar")) try {
            update();
            JOptionPane.showMessageDialog(null,"Operação efectuada com sucesso!");
            nucleo.setEnab(true);
            this.dispose();
        } catch (Exception ex) {
            JOptionPane.showMessageDialog(null,ex);
        }
        else try {
            gravar();
            JOptionPane.showMessageDialog(null,"Operação efectuada com sucesso!");
            nucleo.setEnab(true);
            this.dispose();
        } catch (Exception ex) {
           JOptionPane.showMessageDialog(null,ex);
        }
}//GEN-LAST:event_jButton5MouseClicked

    private void jButton5KeyPressed(java.awt.event.KeyEvent evt) {//GEN-FIRST:event_jButton5KeyPressed

}//GEN-LAST:event_jButton5KeyPressed

    private void txtcodActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_txtcodActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_txtcodActionPerformed

    private void jButton5ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButton5ActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_jButton5ActionPerformed

    private void formWindowClosing(java.awt.event.WindowEvent evt) {//GEN-FIRST:event_formWindowClosing
        nucleo.setEnab(true);
        this.dispose();        // TODO add your handling code here:
    }//GEN-LAST:event_formWindowClosing

    public void gravar() throws Exception{
        String name = txtname.getText();
        nucleo.createArea(name);
    }


    public void update() throws Exception{
        String cod = txtcod.getText();
        String name = txtname.getText();
        nucleo.updateArea(cod, name);
    }

    /**
    * @param args the command line arguments
    */
    public static void main(String args[]) {
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new frameTema(new Nucleo()).setVisible(true);
            }
        });
    }
    

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton btnApagarTema;
    private javax.swing.JButton jButton5;
    private javax.swing.JButton jButton8;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JLabel jLabel5;
    private javax.swing.JList jList1;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JLabel lblTema;
    private javax.swing.JTextField txtcod;
    private javax.swing.JTextField txtname;
    // End of variables declaration//GEN-END:variables

}
