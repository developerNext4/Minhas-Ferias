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
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$CPR_ID					= ( isset( $_REQUEST['CPR_ID'] ) ) ? $_REQUEST['CPR_ID'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$USR_ID_PARA			= ( isset( $_REQUEST['USR_ID_PARA'] ) ) ? $_REQUEST['USR_ID_PARA'] : null;
		$RESPOSTA				= utf8_decode (( isset( $_REQUEST['RESPONDER_'.$CPR_ID] ) ) ? $_REQUEST['RESPONDER_'.$CPR_ID] : null);
		$pg						= ( isset( $_REQUEST['pg'] ) ) ? $_REQUEST['pg'] : null;
	// ======================= //
	
	
		$kQry = mysql_query ("INSERT INTO tb_cotacao_pergunta_resposta (CPR_ID, USR_ID_DE, USR_ID_PARA,
		CPT_RESPOSTA)
		VALUES ('$CPR_ID','$USR_ID','$USR_ID_PARA','$RESPOSTA')");
				
	header( "Location: index.php?pg=$pg&CTC_ID=$CTC_ID&msgTxt=2"  );

		
?>