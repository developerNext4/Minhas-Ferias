<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisi��es de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declara��o de vari�veis //
		$TRM_TEXTO	= ( isset( $_REQUEST['TRM_TEXTO'] ) ) ? $_REQUEST['TRM_TEXTO'] : null;
	// ======================= //
	
	// Definindo a A��o da Tela //		
		$hQry = mysql_query ("UPDATE tb_termos SET TRM_TEXTO = '$TRM_TEXTO' WHERE TRM_ID = '1'");
		header ("Location: index.php?pg=3&msgTxt=1");
	// ======================== //
		
?>