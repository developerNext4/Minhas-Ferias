<?php
	session_start();
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oCriarDestinoDAO= new CriarDestinoDAO();
	// ==================== //
	
	// Declaração de variáveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$CPP_TITULO				= ( isset( $_REQUEST['CPP_TITULO'] ) ) ? $_REQUEST['CPP_TITULO'] : null;
		$CPP_DESCRICAO			= ( isset( $_REQUEST['CPP_DESCRICAO'] ) ) ? $_REQUEST['CPP_DESCRICAO'] : null;
		$CPP_VALOR				= ( isset( $_REQUEST['CPP_VALOR'] ) ) ? $_REQUEST['CPP_VALOR'] : null;
		$CPP_OBS				= ( isset( $_REQUEST['CPP_OBS'] ) ) ? $_REQUEST['CPP_OBS'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$valores				= ( isset( $_REQUEST['valores'] ) ) ? $_REQUEST['valores'] : null;
				
		$arrValores 									= array();
		$arrValores["USR_ID"] 							= $USR_ID;
		$arrValores["CPP_TITULO"] 						= $CPP_TITULO;
		$arrValores["CPP_DESCRICAO"] 					= $CPP_DESCRICAO;
		$CPP_VALOR = str_replace (".","",$CPP_VALOR);
		$CPP_VALOR = str_replace (",",".",$CPP_VALOR);
		$arrValores["CPP_VALOR"] 						= $CPP_VALOR;
		$arrValores["CPP_OBS"]							= $CPP_OBS;


		$valores = substr ($valores,0,-1);
		$aValores = explode (',',$valores);
		foreach ($aValores as $key => $value){
			$arrValores["CTC_ID"] 							= $value;
			$IdCli = $oCriarDestinoDAO->insertProposta( $arrValores );
		}
	// ======================= //
?>