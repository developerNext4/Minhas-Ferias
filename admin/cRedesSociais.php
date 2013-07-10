<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	// Declaraчуo de variсveis //
		$RDS_FACEBOOK	= ( isset( $_REQUEST['RDS_FACEBOOK'] ) ) ? $_REQUEST['RDS_FACEBOOK'] : null;
                $RDS_TWITTER	= ( isset( $_REQUEST['RDS_TWITTER'] ) ) ? $_REQUEST['RDS_TWITTER'] : null;
                $RDS_YOUTUBE	= ( isset( $_REQUEST['RDS_YOUTUBE'] ) ) ? $_REQUEST['RDS_YOUTUBE'] : null;
	// ======================= //
	
	$msgTxt = 1;
	
	$hQry = mysql_query ("UPDATE tb_redes_sociais SET RDS_FACEBOOK = '$RDS_FACEBOOK',
            RDS_TWITTER = '$RDS_TWITTER', RDS_YOUTUBE = '$RDS_YOUTUBE' WHERE RDS_ID = '1'");			
	header( "Location: index.php?pg=11&msgTxt=$msgTxt"  );
			
		
?>