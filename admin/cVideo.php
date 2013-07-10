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
		$VDO_TEXTO	= ( isset( $_REQUEST['VDO_TEXTO'] ) ) ? $_REQUEST['VDO_TEXTO'] : null;
                $VDO_LINK	= ( isset( $_REQUEST['VDO_LINK'] ) ) ? $_REQUEST['VDO_LINK'] : null;
	// ======================= //
	
	// Definindo a Aчуo da Tela //		
		$hQry = mysql_query ("UPDATE tb_video SET VDO_TEXTO = '$VDO_TEXTO', VDO_LINK = '$VDO_LINK' WHERE VDO_ID = '1'");
		header ("Location: index.php?pg=12&msgTxt=1");
	// ======================== //
		
?>