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
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
	// ======================= //

	// Definindo a Aчуo da Tela //		
		switch( $acaoTela ){
			case "banir":{
				
				$hQry = mysql_query ("UPDATE tb_cotacao SET CTC_STATUS = '4' WHERE CTC_ID = '$CTC_ID'");
				$msgTxt = "2";
				header( "Location: index.php?pg=8&msgTxt=$msgTxt"  );
				
				break;
			
			}case "ativar":{
			
				$hQry = mysql_query ("UPDATE tb_cotacao SET CTC_STATUS = '1' WHERE CTC_ID = '$CTC_ID'");
				$msgTxt = "1";
				header( "Location: index.php?pg=8&msgTxt=$msgTxt"  );
				
				break;
			}
		}
	// ======================== //
		
?>