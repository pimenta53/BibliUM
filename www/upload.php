<html>
	<Head>
	<title>upload</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>	
	</Head>
<body>	
	<?php require_once "header.php";
	require_once "HTML/QuickForm.php";
	require('HTTP/Upload.php');
	require_once "functions/date.php";
	require_once "functions/log.php";
	require_once "connection.php";
	echo "<h1>Upload documentos</h1><hr>";


	$stid = oci_parse($conn, "SELECT * FROM doctype where deleted is null");
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$docs_type[0]="Escolha um tipo";
	$cods_type[0]=NULL;
	while ($docs=oci_fetch_array($stid)) {  
		$docs_type[$i]=$docs['NAME_DOC'];
		$cods_type[$i]=$docs['COD_TYPE'];
		$i++;	
	}
	oci_free_statement($stid);

	$stid = oci_parse($conn, "SELECT * FROM area where deleted is null");
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$areas_name[0]="Escolha uma area";
	$cods_area[0]=NULL;
	while ($docs=oci_fetch_array($stid)) {  
		$areas_name[$i]=$docs['AREA_NAME'];
		$cods_area[$i]=$docs['COD_AREA'];
		$i++;	
	}
	oci_free_statement($stid);

	$i=1;
	while($cods_area[$i]){
		$stid = oci_parse($conn, "SELECT * FROM specific WHERE cod_area=:b1 and deleted is null");
		oci_bind_by_name($stid, ":b1",$cods_area[$i]);
		oci_execute($stid, OCI_DEFAULT);
		$j=1;
		$specific_name[$i][0]="Escolha";
		$cods_specific[$i][0]=NULL;
		while ($docs=oci_fetch_array($stid)) {  
			$specific_name[$i][$j]=$docs['NAME_SPECIFIC']; 
			$cods_specific[$i][$j]=$docs['COD_SPECIFIC'];
			$j++;	
		}
		oci_free_statement($stid);
		$i++;
	}

	$stid = oci_parse($conn, "SELECT * FROM univ where deleted is null");
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$univ_name[0]="Escolha uma Universidade";
	$cods_univ[0]=NULL;
	while ($docs=oci_fetch_array($stid)) {  
		$univ_name[$i]=$docs['UNIV_NAME'];
		$cods_univ[$i]=$docs['COD_UNIV'];
		$i++;	
	}
	oci_free_statement($stid);
	
	$stid = oci_parse($conn, 'SELECT * FROM COUNTRY order by country_name ');
	oci_execute($stid, OCI_DEFAULT);$i=1;
	$country_name[0]="Escolha um Pais";
	$cods_country[0]=NULL;
	while ($docs=oci_fetch_array($stid)) {  
		$country_name[$i]=$docs['COUNTRY_NAME'];
		$cods_country[$i]=$docs['COD_COUNTRY'];
		$i++;	
	}
	oci_free_statement($stid);


	$form = new HTML_QuickForm('uploader','POST');
 	$form->addElement('text', 'name', 'Nome do documento:');
	$checkbox=$form->addElement('checkbox','my','Da sua autoria?', '(Se selecionar esta opção deve ignorar os campos autor)'); 	
 	$form->addElement('text', 'author', 'Autor:');			
	$form->addElement('date','date', 'Data de nascimento(Autor):',array('minYear'=> 1900,'addEmptyOption' => 'true','emptyOptionText' => array('d'=>'Dia','M'=>'Mês','Y'=>'Ano')));
	$form->addElement('select','country','Localidade(Autor): ',$country_name);	
	$form->addElement('select','doc_type','Tipo do documento:',$docs_type);
	$form->addElement('select','univ','Universidade',$univ_name);	
	$select = $form->addElement('hierselect', 'area', 'Categoria:');
	$select->setOptions(array($areas_name, $specific_name));
	$form->addElement('textarea','description','Descrição: ','rows="5" cols="50"');  	
	$form->addElement('file','uploaded_file','Ficheiro a carregar:');	
	$form->addElement('submit','save','Guardar'); 	
 	
 	$form->setMaxFileSize('26214400');
 	$form->addRule('uploaded_file','<font face=verdana size=1 color=red>Tamanho maximo permitido é 25Mb','maxfilesize','26214400');
	$form->addRule('uploaded_file','<font face=verdana size=1 color=red>Por favor esolha o ficheiro que pretende carregar','uploadedfile');
	$form->addRule('name', '<font face=verdana size=1 color=red>Não preencheu o nome do ficheiro', 'required');
 	$form->addRule('doc_type', '<font face=verdana size=1 color=red>Não escolheu nenhum tipo para o documento', 'required');
 	$form->addRule('area', '<font face=verdana size=1 color=red>Não escolheu nenhuma categoria para o seu documento', 'required');
	$form->addRule('area', '<font face=verdana size=1 color=red>Tem de escolher uma categoria para o seu documento', 'callback', 'check');
	$form->addRule('doc_type', '<font face=verdana size=1 color=red>Tem de escolher uma tipo para o seu documento', 'callback', 'check');
	$form->addRule('name','<font face=verdana size=1 color=red>Só pode ter no maximo 25 caracteres','maxlength',25); 
	$form->addRule('desciption','<font face=verdana size=1 color=red>Só pode ter no maximo 500 caracteres','maxlength',500); 	
	$form->addRule('author','<font face=verdana size=1 color=red>Só pode ter no maximo 40 caracteres','maxlength',40); 	
	$form->setRequiredNote('<font face=verdana size=1 color=red>* Campos obrigatorios</font>');


if ($form->validate()) { 
	
	// hierarquia de categorias
	$area=($form->exportValue('area'));
	$a=$area[0];$e=$area[1];
	$cod_author=NULL;

	//proprio autor
	if ($form->exportValue('my')) {
		
		$stid = oci_parse($conn, "select first_name, last_name, birth_date, cod_country from usersB where username=:b1");	
		oci_bind_by_name($stid,':b1',$_SESSION['nome']);
		oci_execute($stid);	
		$userBD=oci_fetch_array($stid);
		oci_free_statement($stid);
		
		$n=$userBD['FIRST_NAME']." ".$userBD['LAST_NAME'];
		
		$stid2 = oci_parse($conn,"insert into author values (new_author.NEXTVAL,:b1,:dat,:country,null) returning cod_author into :b4");	
		oci_bind_by_name($stid2,':b1',$n);
		oci_bind_by_name($stid2,':dat',$userBD['BIRTH_DATE']);
		oci_bind_by_name($stid2,':country',$userBD['COD_COUNTRY']);
		oci_bind_by_name($stid2,':b4',$cod_author);	
		oci_execute($stid2);
		oci_free_statement($stid2);
	}
	else {
		if($form->exportValue('author')!=NULL){
			$s = oci_parse($conn,"insert into author values (new_author.NEXTVAL,:b1,TO_DATE(:b2,'YYYY/MM/DD'),:b3,null) returning cod_author into :b4");
			oci_bind_by_name($s, ":b1",($form->exportValue('author')));
			oci_bind_by_name($s,":b2",dataS($form->exportValue('date')));	
			oci_bind_by_name($s, ":b3",$cods_country[($form->exportValue('country'))]);	
			oci_bind_by_name($s,":b4",$cod_author);		
			oci_execute($s, OCI_DEFAULT);
			oci_commit($conn);
			oci_free_statement($s);
		}
	}

	//inserir documento
	$s = oci_parse($conn,"insert into docs values(new_docs.NEXTVAL,:b1,:b2,TO_DATE(:data,'YYYY/MM/DD'),:b3,:b4,:b5,:b6,:b7,:b8,0,0,null,0)returning cod_doc into :b9");
	oci_bind_by_name($s, ":b1",($form->exportValue('name')));
	oci_bind_by_name($s, ":b2",($form->exportValue('description')));
	oci_bind_by_name($s, ":b3",$cods_area[$a]);
	oci_bind_by_name($s, ":b4",($cods_specific[$a][$e]));
	oci_bind_by_name($s, ":b5",($cods_univ[$form->exportValue('univ')]));
	oci_bind_by_name($s, ":b6",$cod_author);
	oci_bind_by_name($s, ":b7",($cods_type[$form->exportValue('doc_type')]));   
	oci_bind_by_name($s, ":b8",$_SESSION['nome']);
	oci_bind_by_name($s, ":b9",$id);
	oci_bind_by_name($s, ":data",date("Y/m/d"));
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);

	//registar download
	$s = oci_parse($conn,"insert into logg values (new_logg.NEXTVAL,:b1,TO_DATE(:b2,'YYYY/MM/DD'),'u',:b3)");
	oci_bind_by_name($s, ":b1",$_SESSION['nome']);
	oci_bind_by_name($s, ":b2",date("Y/m/d"));
	oci_bind_by_name($s, ":b3",$id);
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);

	$upload = new HTTP_Upload("pt_BR");
	$file = $upload->getFiles('uploaded_file');
	$file->setName($id);

	if ($file->isValid()) {
		    
		$moved = $file->moveTo("/home/pimenta/Dropbox/Trabalhos de grupo/BD/docs");
		if (!PEAR::isError($moved)) {
			        
        echo "Ficheiro guardado na sua conta com sucesso";
		//$props = $file->getProp();
		//print_r($props);
    
    } else {        
        echo $moved->getMessage();
    }
} elseif ($file->isMissing()) {
    echo "No file was provided.";
} elseif ($file->isError()) {
    echo $file->errorMsg();

}   
   
    
} else { $form->display(); }

oci_close($conn);


?>
</body>
</html>
