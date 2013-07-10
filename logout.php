<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtil 		= new Util();
		$oUtilsDAO	= new UtilsDAO();
	// ==================== //
	
		session_destroy();
		
		setcookie("USR_ID");
		setcookie("USR_NOME");
		setcookie("USR_TIPO");
		setcookie("PAINEL");
		
		header( "Location: index.php"  );
	// ======================== //
		
?>