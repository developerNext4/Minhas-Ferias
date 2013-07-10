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
		$PCT_TITULO				= ( isset( $_REQUEST['PCT_TITULO'] ) ) ? $_REQUEST['PCT_TITULO'] : null;
		$PCT_ID					= ( isset( $_REQUEST['PCT_ID'] ) ) ? $_REQUEST['PCT_ID'] : null;
		$PCT_VALOR				= ( isset( $_REQUEST['PCT_VALOR'] ) ) ? $_REQUEST['PCT_VALOR'] : null;
		$PCT_LEADS				= ( isset( $_REQUEST['PCT_LEADS'] ) ) ? $_REQUEST['PCT_LEADS'] : null;
				
		$arrValores 									= array();
		$arrValores["PCT_NOME"] 						= $PCT_TITULO;
		$PCT_VALOR = str_replace (".","",$PCT_VALOR);
		$PCT_VALOR = str_replace (",",".",$PCT_VALOR);
		$arrValores["PCT_VALOR"] 						= $PCT_VALOR;
		$arrValores["PCT_LEADS"] 						= $PCT_LEADS;
		
		$ID					= NULL;
		$NOME				= NULL;
		$EMAIL				= NULL;

	// ======================= //

	// Definindo a Aчуo da Tela //		
		switch( $acaoTela ){
			case "inserir":{
								
				
				$IdCli = $oPacotesDAO->insert( $arrValores );
				
				if (is_numeric ($IdCli)){
					$msgTxt = 1;
					
				}else{
					$msgTxt = 2;
				}
				
				header( "Location: index.php?pg=4&msgTxt=$msgTxt"  );
				
				break;
			
			}case "update":{
				$msgTxt = 1;
				$oPacotesDAO->update( $arrValores, $PCT_ID );
				header( "Location: index.php?pg=4&msgTxt=$msgTxt"  );
				break;
			}case "excluir":{
				$hQry = mysql_query ("UPDATE tb_pacote SET PCT_STATUS = '3' WHERE PCT_ID = '$PCT_ID'");
				$msgTxt = 3;
				header( "Location: index.php?pg=4&msgTxt=$msgTxt"  );
				break;
			}
		}
	// ======================== //
		
?>