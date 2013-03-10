/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package javaapplication1;

import java.io.Serializable;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Observable;

/**
 *
 * @author miguel
 */
public class Nucleo extends Observable implements Serializable{

    private Connection con;

    private String alterado;
    private boolean enab;

    public Nucleo(){
        alterado="";
        con=null;
        enab=true;
    }

    public void setEnab(boolean en){
        enab = en;
        if(enab){
        this.setChanged();
        this.notifyObservers();
        }
    }
    
    public boolean getEnab(){return enab;}

    public String getAlterado(){return alterado;}
    public void setAlterado(){alterado = "";}
    
    public boolean abreConeccao(String ip, String user, String pass){
		try{
               Class.forName("oracle.jdbc.driver.OracleDriver");
               con = DriverManager.getConnection("jdbc:oracle:thin:@"+ip+":1521:xe",user,pass);
	            System.out.println ("Ligação estabelecida");
			 }catch (Exception e){System.err.println (e);}

                if(con==null) return false;
                return true;
     }


    public boolean validarLogin (String user, String pass) throws Exception{
        String sql = "SELECT username, password FROM users where username='"+user+"' and password='"+pass+"'";

        PreparedStatement stmt = con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        while(resultSet.next()){
            if(user.equals(resultSet.getString(1)) && pass.equals(resultSet.getString(2))) return true;
        }
        return false;
}

    public void inserirDoc (String cod_doc, String name, String descripton, String data, String cod_area, String cod_univ, String cod_author, String cod_type) throws Exception{
        String sql = "INSERT INTO docs VALUES ('"+cod_doc+"', '"+name+"', "+descripton+"', '"+data+"', '"+cod_area+"', '"+cod_univ+"', '"+cod_author+"', '"+cod_type+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "docs";
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirUser(String user, String f_name, String l_name, String date, String sex, String mail, String pass, String cod_country, String cod_doc) throws Exception{
        String sql = "INSERT INTO usersB VALUES ('"+user+"', '"+f_name+"', "+l_name+"', '"+date+"', '"+sex+"', '"+mail+"', '"+pass+"', '"+cod_country+"', '"+cod_doc+"')";
    
        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "users";
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirCountry(String cod_country, String name) throws Exception{
        String sql = "INSERT INTO country VALUES ('"+cod_country+"', '"+name+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "country";
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirUniv(String cod_univ, String name, String cod_country) throws Exception{
        String sql = "INSERT INTO univ VALUES ('"+cod_univ+"', '"+name+"', '"+cod_country+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "univ";
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirSpecific(String cod_specific, String name) throws Exception{
        String sql = "INSERT INTO specific VALUES ('"+cod_specific+"', '"+name+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "spc";
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirArea(String cod_area, String name, String cod_specific) throws Exception{
        String sql = "INSERT INTO area VALUES ('"+cod_area+"', '"+name+"', '"+cod_specific+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "country";
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirDocType(String cod_type, String name) throws Exception{
        String sql = "INSERT INTO country VALUES ('"+cod_type+"', '"+name+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirLogg(String cod_log, String username, String log_data, String tipo, String cod_doc) throws Exception{
        String sql = "INSERT INTO logg VALUES ('"+cod_log+"', '"+username+"', "+log_data+"', '"+tipo+"', '"+cod_doc+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        this.setChanged();
        this.notifyObservers();
    }

    public void inserirAuthor(String cod_author, String f_name, String l_name, String bdate, String cod_country) throws Exception{
        String sql = "INSERT INTO author VALUES ('"+cod_author+"', '"+f_name+"', '"+l_name+"', '"+bdate+"','"+cod_country+"')";

        PreparedStatement stmt = con.prepareStatement(sql);
        stmt.executeQuery();
        this.setChanged();
        this.notifyObservers();
    }

    public  ResultSet listarUsers() throws Exception{
        String sql = "SELECT username, cod_country FROM usersB order by username";

        PreparedStatement stmt = con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  void fechaConeccao()throws Exception{
		con.close();
		System.out.println("Liagacao fechada");
    }

    public  ResultSet listarDocs() throws Exception{
        String sql = "SELECT * FROM DOCS order by cod_doc";
        
        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }


    public  ResultSet listarUniv() throws Exception{
        String sql = "SELECT * FROM univ order by cod_univ";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet listarTypes() throws Exception{
        String sql = "SELECT * FROM doctype order by cod_type";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet listarSpec() throws Exception{
        String sql = "SELECT * FROM specific order by cod_specific";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public String contUsers() throws Exception{
        String sql = "SELECT count(*) FROM usersB";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }

    public String contDocs() throws Exception{
        String sql = "SELECT count(*) FROM docs";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }

    public String contTema() throws Exception{
        String sql = "SELECT count(*) FROM area";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }

    public String contAutor() throws Exception{
        String sql = "SELECT count(*) FROM author";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }
    
    public String contTipo() throws Exception{
        String sql = "SELECT count(*) FROM doctype";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }
    
    public String contSpec() throws Exception{
        String sql = "SELECT count(*) FROM specific";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }

    public String contPais() throws Exception{
        String sql = "SELECT count(*) FROM country";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }
    public String contUniv() throws Exception{
        String sql = "SELECT count(*) FROM univ";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="0";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }







    public  ResultSet listarAutores() throws Exception{
        String sql = "SELECT * FROM author order by cod_author";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }


    public  ResultSet getDoc(String cod_doc) throws Exception{
        String sql = "SELECT * FROM DOCS where cod_doc="+cod_doc+"";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getAuthor(String cod_author) throws Exception{
        String sql = "SELECT * FROM author where cod_author="+cod_author+"";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getUniv(String cod_univ) throws Exception{
        String sql = "SELECT * FROM univ where cod_univ="+cod_univ+"";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();
        
        return resultSet;
    }

    public  ResultSet ListarPais() throws Exception{
        String sql = "SELECT * FROM Country order by cod_country";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet listarArea() throws Exception{
        String sql = "SELECT * FROM Area order by cod_area";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getArea(String cod_area) throws Exception{
        System.out.println(cod_area);
        String sql = "SELECT * FROM area where cod_area="+cod_area+"";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getCountry(String cod_country) throws Exception{
        String sql = "SELECT * FROM country where cod_country = " + cod_country + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getType(String cod_type) throws Exception{
        String sql = "SELECT * FROM doctype where cod_type="+cod_type+"";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getUser(String username) throws Exception{
        String sql = "SELECT * FROM usersB where username='"+username+"'";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getSpecific(String cod_spec) throws Exception{
        String sql = "SELECT * FROM specific where cod_specific="+cod_spec;

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    //novas

    public  void createDoc(String name, String desc, String data, String area, String specific ,String univ, String author, String cod_type, String user) throws Exception{
        String sql = "INSERT INTO DOCS VALUES (new_docs.nextval, '" + name + "', '" + desc + "', TO_DATE('" + data + "', 'RR.MM.DD'), '" + area + "', '" + specific + "', '" + univ + "', '" + author + "', '" + cod_type + "', '" + user + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "doc";
        this.setChanged();
        this.notifyObservers();
    }

    public  void createAuthor(String fName, String data, String cod_count) throws Exception{
        String sql = "INSERT INTO AUTHOR VALUES (new_author.nextval, '" + fName + "', TO_DATE('" + data + "', 'RR.MM.DD'), '" + cod_count + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "author";
        this.setChanged();
        this.notifyObservers();
    }

    public  void createUniv(String name, String cod_count) throws Exception{
        String sql = "INSERT INTO UNIV VALUES (new_univ.nextval, '" + name + "', " + cod_count + ", null)";

        System.out.println(sql);
        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "univ";
        this.setChanged();
        this.notifyObservers();
    }

    public  void createArea(String name) throws Exception{
        String sql = "INSERT INTO AREA VALUES (new_area.nextval, '" + name + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "area";
        this.setChanged();
        this.notifyObservers();
    }


    public  void createSpecific(String name, String cod_area) throws Exception{
        String sql = "INSERT INTO SPECIFIC VALUES (new_specific.nextval, '" + name + "', '" + cod_area + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "specific";
        this.setChanged();
        this.notifyObservers();
    }

    public  void createDocType(String name) throws Exception{
        String sql = "INSERT INTO DOCTYPE VALUES (new_doctype.nextval, '" + name + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "type";
        this.setChanged();
        this.notifyObservers();
    }


    public  void createUser(String userName, String fName, String lName, String data, String phoneN, String sex, String mail, String pass, String cod_count) throws Exception{
        String sql = "INSERT INTO USERSB VALUES ('" + userName + "', '" + fName + "', '" + lName + "', TO_DATE('" + data + "', 'RR.MM.DD'), '" + phoneN + "', '" + sex + "', '" + mail + "', '" + pass + "', '" + cod_count + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "user";
        this.setChanged();
        this.notifyObservers();
    }

    public  void createCountry(String name) throws Exception{
        String sql = "INSERT INTO COUNTRY VALUES (new_country.nextval, '" + name + "', null)";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "country";
        this.setChanged();
        this.notifyObservers();
    }

    public  void updateDoc(String cod_doc, String name, String desc, String data, String area, String specific ,String univ, String author, String cod_type, String user) throws Exception{
        String sql = "UPDATE DOCS SET Doc_Name = '" + name + "', Description = '" + desc + "', Upload_date =  TO_DATE('" + data + "', 'RR.MM.DD'), cod_area = " + area + ", cod_specific = " + specific + ", cod_univ = " + univ + ", cod_author = " + author + ", cod_type = " + cod_type + ", username = '" + user + "' WHERE cod_doc = " + cod_doc + "";

        System.out.println(sql);
        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "doc";
        this.setChanged();
        this.notifyObservers();
    }

    public  void updateAuthor(String cod_author, String fName, String data, String cod_count) throws Exception{
        String sql = "UPDATE AUTHOR SET author_name = '" + fName + "', birth_date = TO_DATE('" + data + "', 'RR.MM.DD'), cod_country = '" + cod_count + "' WHERE cod_author = '" + cod_author + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "author";
        this.setChanged();
        this.notifyObservers();
    }

    public  void updateUniv(String cod_univ, String name, String cod_count) throws Exception{
        String sql = "UPDATE UNIV SET Univ_name = '" + name + "', cod_country = '" + cod_count + "' WHERE cod_univ = '" + cod_univ + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "univ";
        this.setChanged();
        this.notifyObservers();
    }

    public  void updateArea(String cod_area, String name) throws Exception{
        String sql = "UPDATE AREA SET Area_name = '" + name + "' WHERE cod_area = '" + cod_area + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "area";
        this.setChanged();
        this.notifyObservers();
    }

    public  void updateSpecific(String cod_spec, String name, String cod_area) throws Exception{
        String sql = "UPDATE SPECIFIC SET Name_Specific = '" + name + "', cod_area = " + cod_area + " WHERE cod_specific = " + cod_spec + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "specific";
        this.setChanged();
        this.notifyObservers();
    }

    public  void updateDocType(String cod_type, String name) throws Exception{
        String sql = "UPDATE DOCTYPE SET name_doc = '" + name + "' WHERE cod_type = '" + cod_type + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "type";
        this.setChanged();
        this.notifyObservers();
    }


    //PROBLEMA RESOLVER DPS
    public  void updateUser(String userName, String fName, String lName, String data, String phoneN, String sex, String mail, String pass, String cod_count) throws Exception{
        String sql = "UPDATE USERSB SET first_name = '" + fName + "', last_name = '" + lName + "', birth_date = TO_DATE('" + data + "', 'RR.MM.DD'), phone_number = '" + phoneN + "', sex =  '" + sex + "', email = '" + mail + "', cod_country = '" + cod_count + "' WHERE username = '" + userName + "'";


        System.out.println(sql);
        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "user";
        this.setChanged();
        this.notifyObservers();
    }


    public  void updateCountry(String cod_country, String name) throws Exception{
        String sql = "UPDATE COUNTRY SET Country_name = '" + name + "' WHERE cod_country = '" + cod_country + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "country";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarTipo(String cod_tipo, String data) throws Exception{
        String sql = "UPDATE DOCTYPE SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_type = " + cod_tipo + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "type";
        this.setChanged();
        this.notifyObservers();
    }

    public void ativarTipo(String cod_tipo) throws Exception{
        String sql = "UPDATE DOCTYPE SET deleted = null WHERE cod_type = " + cod_tipo + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "type";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarTema(String cod_tema, String data) throws Exception{
        String sql = "UPDATE AREA SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_area = " + cod_tema + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "area";
        this.setChanged();
        this.notifyObservers();
    }

    public void ativarTema(String cod_tema) throws Exception{
        String sql = "UPDATE AREA SET deleted = null WHERE cod_area = " + cod_tema + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "area";
        this.setChanged();
        this.notifyObservers();
    }
    
    public void apagarAutor(String cod_autor, String data) throws Exception{
        String sql = "UPDATE Author SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_author = " + cod_autor + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "author";
        this.setChanged();
        this.notifyObservers();
    }

    public void ativarAutor(String cod_autor) throws Exception{
        String sql = "UPDATE Author SET deleted = null WHERE cod_author = " + cod_autor + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "author";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarEspec(String cod_espec, String data) throws Exception{
        String sql = "UPDATE specific SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_specific = " + cod_espec + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "specific";
        this.setChanged();
        this.notifyObservers();
    }

    public void ativarEspec(String cod_espec) throws Exception{
        String sql = "UPDATE specific SET deleted = null WHERE cod_specific = " + cod_espec + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "specific";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarUniv(String cod_univ, String data) throws Exception{
        String sql = "UPDATE univ SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_univ = " + cod_univ + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "univ";
        this.setChanged();
        this.notifyObservers();
    }
    
    public void ativarUniv(String cod_univ) throws Exception{
        String sql = "UPDATE univ SET deleted = null WHERE cod_univ = " + cod_univ + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "univ";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarDoc(String cod_doc, String data) throws Exception{
        String sql = "UPDATE docs SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_doc = " + cod_doc + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "docs";
        this.setChanged();
        this.notifyObservers();
    }

    public void ativarDoc(String cod_doc) throws Exception{
        String sql = "UPDATE docs SET deleted = null WHERE cod_doc = " + cod_doc + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "docs";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarCountry(String cod_country, String data) throws Exception{
        String sql = "UPDATE country SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_country = " + cod_country + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "country";
        this.setChanged();
        this.notifyObservers();
    }

    public void ativarCountry(String cod_country) throws Exception{
        String sql = "UPDATE country SET deleted = null WHERE cod_country = " + cod_country + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "country";
        this.setChanged();
        this.notifyObservers();
    }

    public void apagarUser(String user, String data) throws Exception{
        String sql = "UPDATE usersB SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE username = '" + user + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "user";
        this.setChanged();
        this.notifyObservers();

    }

    //estatisticas

    public  ResultSet getMdownloads() throws Exception{
        String sql = "select * from mDownloads";
        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }


    public  ResultSet getMficheios() throws Exception{
        String sql = "select * from mFicheiros";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getMutilizados() throws Exception{
        String sql = "select * from mUtilizados";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public  ResultSet getMedia() throws Exception{
        String sql = "select * from media";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public void apagaSpec(String data, String codigo) throws Exception{
        String sql = "CREATE OR REPLACE PROCEDURE apagaSpec(" + data + " date, " + codigo + " number) BEGIN UPDATE specific SET deleted = data WHERE cod_area = codigo END apagaSpec;";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
        alterado = "specific";
        this.setChanged();
        this.notifyObservers();
    }

    //comments

    public  ResultSet ListarComments(String codigo) throws Exception{
        String sql = "SELECT cod_coment , username, post_date, comment_user FROM comments where cod_doc = '" + codigo + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }

    public void deleteComment(String data, String codigo) throws Exception{
        String sql = "UPDATE comments SET deleted = TO_DATE('" + data + "', 'RR.MM.DD') WHERE cod_coment = '" + codigo + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        stmt.executeQuery();
    }

    public String getComment(String cod) throws Exception{
        String sql = "Select comment_user FROM comments WHERE cod_coment = '" + cod + "'";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        String res="";
        while(resultSet.next()){
            res=resultSet.getString(1);
        }

        return res;
    }

    public ResultSet getDocInfo(String cod) throws Exception{
        String sql = "Select * From documents where cod_doc = " + cod + "";

        PreparedStatement stmt =con.prepareStatement(sql);
        ResultSet resultSet = stmt.executeQuery();

        return resultSet;
    }


}
