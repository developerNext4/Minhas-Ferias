<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/DAO/PacotesDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
		$oPacotesDAO 	= new PacotesDAO();
	// ==================== //
	// Declaraчуo de variсveis //
		$LDS_NUMERO				= ( isset( $_REQUEST['LDS_NUMERO'] ) ) ? $_REQUEST['LDS_NUMERO'] : null;
	// ======================= //
	
	$msgTxt = 1;
	
	$hQry = mysql_query ("UPDATE tb_leads SET LDS_NUMERO = '$LDS_NUMERO' WHERE LDS_ID = '1'");			
	header( "Location: index.php?pg=6&msgTxt=$msgTxt"  );
			
		
?>