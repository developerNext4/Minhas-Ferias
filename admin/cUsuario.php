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
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
	// ======================= //

	// Definindo a Aчуo da Tela //		
		switch( $acaoTela ){
			case "banir":{
				
				$hQry = mysql_query ("UPDATE tb_usuario SET USR_STATUS = '3' WHERE USR_ID = '$USR_ID'");
				$msgTxt = "2";
				header( "Location: index.php?pg=7&msgTxt=$msgTxt"  );
				
				break;
			
			}case "ativar":{
			
				$hQry = mysql_query ("UPDATE tb_usuaroi SET USR_STATUS = '1' WHERE USR_ID = '$USR_ID'");
				$msgTxt = "1";
				header( "Location: index.php?pg=7&msgTxt=$msgTxt"  );
				
				break;
			}
		}
	// ======================== //
		
?>