<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declaraчуo de variсveis //
		$SBR_TEXTO	= ( isset( $_REQUEST['SBR_TEXTO'] ) ) ? $_REQUEST['SBR_TEXTO'] : null;
	// ======================= //
	
	// Definindo a Aчуo da Tela //		
		$hQry = mysql_query ("UPDATE tb_sobre SET SBR_TEXTO = '$SBR_TEXTO' WHERE SBR_ID = '1'");
		header ("Location: index.php?pg=2&msgTxt=1");
	// ======================== //
		
?>