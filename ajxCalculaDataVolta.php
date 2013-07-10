<?php
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
		$QTDE_NOITES = $_REQUEST['QTDE_NOITES'];
		$DIA = $_REQUEST['DIA'];
		$MES = $_REQUEST['MES'];
		$ANO = $_REQUEST['ANO'];
	
	// Verifico CPF na base //
		$hQry = mysql_query ("SELECT DATE_ADD('$ANO-$MES-$DIA', INTERVAL $QTDE_NOITES DAY) AS DATA_VOLTA");
		$jQry = mysql_fetch_array ($hQry);
		
		$jQry['DATA_VOLTA'] = substr($jQry['DATA_VOLTA'],8,2).'/'.substr ($jQry['DATA_VOLTA'],5,2).'/'.substr ($jQry['DATA_VOLTA'],0,4);
		echo $jQry['DATA_VOLTA'];
		
	// ==================== //	
    
?>