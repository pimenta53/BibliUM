<?php
	session_start();if(!$_SESSION['nome']) {Header("Location: index.php");   exit();}
	$conn = oci_connect('pimz', 'pimz53', 'localhost/XE');
	if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
 
	$filename =$_GET['id'];

	// Modify this line to indicate the location of the files you want people to be able to download
	// This path must not contain a trailing slash.  ie.  /temp/files/download
	$download_path = "docs/";
 
	// Make sure we can't download files above the current directory location.
	if(eregi("\.\.", $filename)) die("I'm sorry, you may not download that file.");
	$file = str_replace("..", "", $filename);
 
	// Make sure we can't download .ht control files.
	if(eregi("\.ht.+", $filename)) die("I'm sorry, you may not download that file.");
 
	// Combine the download path and the filename to create the full path to the file.
	$file = "$download_path$file";
 
	// Test to ensure that the file exists.
	if(!file_exists($file)) die("I'm sorry, the file doesn't seem to exist.");
 
	// Extract the type of file which will be sent to the browser as a header
	$type = filetype($file);
 
	// Get a date and timestamp
	$today = date("F j, Y, g:i a");
	$time = time();
 
	// Send file headers
	header("Content-type: $type");
	header("Content-Disposition: attachment;filename=$filename");
	header("Content-Transfer-Encoding: binary");
	header('Pragma: no-cache');
	header('Expires: 0');
	// Send the file contents.
	set_time_limit(0);
	readfile($file);
	
	$s = oci_parse($conn,"insert into logg values (new_logg.NEXTVAL,:b1,TO_DATE(:b2,'YYYY/MM/DD'),'d',:b3)");
	oci_bind_by_name($s, ":b1",$_SESSION['nome']);
	oci_bind_by_name($s, ":b2",date("Y/m/d"));
	oci_bind_by_name($s, ":b3",$filename);
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);

 
?>
