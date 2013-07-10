<?php
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
		$diaPartida = $_REQUEST['diaPartida'];
		$mesPartida = $_REQUEST['mesPartida'];
		$anoPartida = $_REQUEST['anoPartida'];
		$diaVolta	= $_REQUEST['diaVolta'];
		$mesVolta	= $_REQUEST['mesVolta'];
		$anoVolta	= $_REQUEST['anoVolta'];
	
	// Verifico CPF na base //
		$hQry = mysql_query ("SELECT DATEDIFF('$anoVolta-$mesVolta-$diaVolta','$anoPartida-$mesPartida-$diaPartida') AS DATA_VOLTA");
		$jQry = mysql_fetch_array ($hQry);
		
		echo $jQry['DATA_VOLTA'];
		
	// ==================== //	
    
?>