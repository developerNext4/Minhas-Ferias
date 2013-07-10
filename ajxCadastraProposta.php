<?php
	session_start();
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oCriarDestinoDAO= new CriarDestinoDAO();
	// ==================== //
	
	// Declaraчуo de variсveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$CPP_TITULO				= ( isset( $_REQUEST['CPP_TITULO'] ) ) ? $_REQUEST['CPP_TITULO'] : null;
		$CPP_DESCRICAO			= ( isset( $_REQUEST['CPP_DESCRICAO'] ) ) ? $_REQUEST['CPP_DESCRICAO'] : null;
		$CPP_VALOR				= ( isset( $_REQUEST['CPP_VALOR'] ) ) ? $_REQUEST['CPP_VALOR'] : null;
		$CPP_OBS				= ( isset( $_REQUEST['CPP_OBS'] ) ) ? $_REQUEST['CPP_OBS'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
				
		$arrValores 									= array();
		$arrValores["USR_ID"] 							= $USR_ID;
		$arrValores["CTC_ID"] 							= $CTC_ID;
		$arrValores["CPP_TITULO"] 						= $CPP_TITULO;
		$arrValores["CPP_DESCRICAO"] 					= $CPP_DESCRICAO;
		$CPP_VALOR = str_replace (".","",$CPP_VALOR);
		$CPP_VALOR = str_replace (",",".",$CPP_VALOR);
		$arrValores["CPP_VALOR"] 						= $CPP_VALOR;
		$arrValores["CPP_OBS"]							= $CPP_OBS;
	// ======================= //
	
				
		$IdCli = $oCriarDestinoDAO->insertProposta( $arrValores );
		
	// ======================== //
		
?>