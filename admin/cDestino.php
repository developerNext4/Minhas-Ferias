<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/DAO/DestinoDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
		$oDestinoDAO 	= new DestinoDAO();
	// ==================== //
	// Declaraчуo de variсveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$DST_NOME				= ( isset( $_REQUEST['DST_NOME'] ) ) ? $_REQUEST['DST_NOME'] : null;
		$DST_ID					= ( isset( $_REQUEST['DST_ID'] ) ) ? $_REQUEST['DST_ID'] : null;
		$DST_VALOR				= ( isset( $_REQUEST['DST_VALOR'] ) ) ? $_REQUEST['DST_VALOR'] : null;
		$DST_STATUS				= ( isset( $_REQUEST['DST_STATUS'] ) ) ? $_REQUEST['DST_STATUS'] : null;
				
		$arrValores 									= array();
		$arrValores["DST_NOME"] 						= $DST_NOME;
		$arrValores["DST_VALOR"] 						= $DST_VALOR;
		$arrValores["DST_STATUS"] 						= $DST_STATUS;
		
		$ID					= NULL;
		$NOME				= NULL;
		$EMAIL				= NULL;

	// ======================= //

	// Definindo a Aчуo da Tela //		
		switch( $acaoTela ){
			case "inserir":{
								
				
				$IdCli = $oDestinoDAO->insert( $arrValores );
				
				if (is_numeric ($IdCli)){
					$msgTxt = 1;
					
				}else{
					$msgTxt = 2;
				}
				
				header( "Location: index.php?pg=9&msgTxt=$msgTxt"  );
				
				break;
			
			}case "update":{
				$msgTxt = 1;
				$oDestinoDAO->update( $arrValores, $DST_ID );
				header( "Location: index.php?pg=9&msgTxt=$msgTxt"  );
				break;
			}case "excluir":{
				$hQry = mysql_query ("UPDATE tb_destino SET DST_STATUS = '3' WHERE DST_ID = '$DST_ID'");
				$msgTxt = 3;
				header( "Location: index.php?pg=9&msgTxt=$msgTxt"  );
				break;
			}case "ativar":{
				$hQry = mysql_query ("UPDATE tb_destino SET DST_STATUS = '1' WHERE DST_ID = '$DST_ID'");
				$msgTxt = 2;
				header( "Location: index.php?pg=9&msgTxt=$msgTxt"  );
				break;
			}
		}
	// ======================== //
		
?>