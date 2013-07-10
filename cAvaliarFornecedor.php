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
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$NOTA					= ( isset( $_REQUEST['NOTA'] ) ) ? $_REQUEST['NOTA'] : null;
		$COMENTARIOAVALIACAO	= utf8_decode (( isset( $_REQUEST['COMENTARIOAVALIACAO'] ) ) ? $_REQUEST['COMENTARIOAVALIACAO'] : null);
		$pg						= ( isset( $_REQUEST['pg'] ) ) ? $_REQUEST['pg'] : null;
		$FONTE					= ( isset( $_REQUEST['FONTE'] ) ) ? $_REQUEST['FONTE'] : null;
		$FORNECEDOR				= ( isset( $_REQUEST['FORNECEDOR'] ) ) ? $_REQUEST['FORNECEDOR'] : null;
	// ======================= //
	
	if ($FONTE == "AGENTE"){
		// Busco o comprador
		$qQry = mysql_query ("SELECT USR_ID FROM tb_cotacao WHERE CTC_ID = '$CTC_ID'");
		$wQry = mysql_fetch_array ($qQry);
		$hQry = mysql_query ("INSERT INTO tb_avaliacao (CTC_ID, AVL_AVALIADOR, AVL_AVALIADO, AVL_DATA, AVL_NOTA,
		AVL_OBSERVACAO) VALUES ('$CTC_ID','$USR_ID','$wQry[USR_ID]',NOW(),'$NOTA','$COMENTARIOAVALIACAO')");
	}else{
	
		/*// Busco vencedor
		$qQry = mysql_query ("SELECT USR_ID FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'
		AND CPP_STATUS = '3'");
		$wQry = mysql_fetch_array ($qQry);*/
		$hQry = mysql_query ("INSERT INTO tb_avaliacao (CTC_ID, AVL_AVALIADOR, AVL_AVALIADO, AVL_DATA, AVL_NOTA,
		AVL_OBSERVACAO) VALUES ('$CTC_ID','$USR_ID','$FORNECEDOR',NOW(),'$NOTA','$COMENTARIOAVALIACAO')");
		
	}
	
	
				
	header( "Location: index.php?pg=$pg&CTC_ID=$CTC_ID&msgTxt=4"  );

		
?>