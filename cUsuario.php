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
		$oUsuario 		= new UsuarioDAO();
	// ==================== //
	
	// Declaraчуo de variсveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$USR_NOME				= ( isset( $_REQUEST['USR_NOME'] ) ) ? $_REQUEST['USR_NOME'] : null;
		$USR_EMAIL				= ( isset( $_REQUEST['USR_EMAIL'] ) ) ? $_REQUEST['USR_EMAIL'] : null;
		$USR_SENHA				= ( isset( $_REQUEST['USR_SENHA'] ) ) ? $_REQUEST['USR_SENHA'] : null;
				
		$arrValores 									= array();
		$arrValores["USR_NOME"] 						= $USR_NOME;
		$arrValores["USR_EMAIL"] 						= $USR_EMAIL;
		$arrValores["USR_SENHA"] 						= md5($USR_SENHA);
		
		$ID					= NULL;
		$NOME				= NULL;
		$EMAIL				= NULL;
	// ======================= //
	
	// Definindo a Aчуo da Tela //		
		switch( $acaoTela ){
			case "insert":{
				
				// CODIFICANDO O PADRУO UTF8 DAS INFORMЧеES //
				/*foreach( $arrValores as $ch => $vl ){
					$arrValores[$ch] = utf8_encode( $vl );
				}*/
				
				
				$IdCli = $oUsuario->insert( $arrValores );
				
				if (is_numeric ($IdCli)){
					$msgTxt = 1;
				}else{
					$msgTxt = 2;
				}
				
				header( "Location: index.php?pg=2&msgTxt=$msgTxt"  );
				
				break;
			
			}
		}
	// ======================== //
		
?>