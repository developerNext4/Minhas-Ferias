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
		$SBR_TEXTO	= ( isset( $_REQUEST['SBR_TEXTO'] ) ) ? $_REQUEST['SBR_TEXTO'] : null;
	// ======================= //
	
	// Definindo a A��o da Tela //		
		$hQry = mysql_query ("UPDATE tb_sobre SET SBR_TEXTO = '$SBR_TEXTO' WHERE SBR_ID = '1'");
		header ("Location: index.php?pg=2&msgTxt=1");
	// ======================== //
		
?>