/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * media.java
 *
 * Created on 22/Jan/2011, 2:31:12
 */

package javaapplication1;

import java.awt.Dimension;
import java.sql.ResultSet;
import javax.swing.JFrame;

import org.jfree.chart.*;
import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.PlotOrientation;
import org.jfree.data.category.CategoryDataset;
import org.jfree.data.category.DefaultCategoryDataset;
/**
 *
 * @author Milton
 */
public class media extends javax.swing.JFrame {

    Nucleo nucleo = null;
    /** Creates new form grafico1 */
    public media() {
        initComponents();
    }


    public media(Nucleo nuc) throws Exception{
        super("Classificações");
        initComponents();
        nucleo = nuc;
        ResultSet dt = nucleo.getMedia();
        CategoryDataset dataset = media.createDataset(dt);
        JFreeChart chart = media.createBarChart(dataset);
        ChartPanel panel = new ChartPanel(chart);
        panel.setPreferredSize(new Dimension(400, 300));
        setContentPane(panel);
    }
    /** This method is called from within the constructor to
     * initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is
     * always regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        setDefaultCloseOperation(javax.swing.WindowConstants.DISPOSE_ON_CLOSE);
        setResizable(false);
        addWindowListener(new java.awt.event.WindowAdapter() {
            public void windowClosing(java.awt.event.WindowEvent evt) {
                formWindowClosing(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 514, Short.MAX_VALUE)
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGap(0, 353, Short.MAX_VALUE)
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void formWindowClosing(java.awt.event.WindowEvent evt) {//GEN-FIRST:event_formWindowClosing

        nucleo.setEnab(true);
        this.dispose();        // TODO add your handling code here:
    }//GEN-LAST:event_formWindowClosing
    public media(String title) throws Exception{
        super(title);
        ResultSet dt = nucleo.getMedia();
        CategoryDataset dataset = media.createDataset(dt);
        JFreeChart chart = media.createBarChart(dataset);
        ChartPanel panel = new ChartPanel(chart);
        panel.setPreferredSize(new Dimension(400, 300));
        setContentPane(panel);
        dt.close();
}

private static CategoryDataset createDataset(ResultSet dt) throws Exception{
    DefaultCategoryDataset dataset = new DefaultCategoryDataset();
    ResultSet dx = dt;
    int x=1;
    while(dx.next() && x<5){
        dataset.addValue(Integer.parseInt(dx.getString(2)), "", dx.getString(1));
        x++;
    }
    dx.close();
    return dataset;

}


private static JFreeChart createBarChart(CategoryDataset dataset) {
    JFreeChart chart = ChartFactory.createBarChart(
    "Classificações", //Titulo
    "Nome de ficheiro", // Eixo X
    "Classificação média", //Eixo Y
    dataset, // Dados para o grafico
    PlotOrientation.VERTICAL, //Orientacao do grafico
    false, false, false); // exibir: legendas, tooltips, url
    return chart;
}

public static void main( String[] args ) throws Exception{
    media chart = new media("Classificações");
    chart.pack();
    chart.setVisible(true);
}
    /**
    * @param args the command line arguments
    */



    // Variables declaration - do not modify//GEN-BEGIN:variables
    // End of variables declaration//GEN-END:variables

}
