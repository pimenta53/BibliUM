<?php 

function dataS( $date ){
	if($date['Y']!=NULL && $date['M']!=NULL && $date['d']!=NULL ){
		$newDate=$date['Y'].'/'.$date['M'].'/'.$date['d'];
		return $newDate;
	}
	else return NULL;
}



?>
