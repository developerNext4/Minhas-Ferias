<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisi��es de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declara��o de vari�veis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$QTD_LEADS				= ( isset( $_REQUEST['QTD_LEADS'] ) ) ? $_REQUEST['QTD_LEADS'] : null;
	// ======================= //
        
        
        // Desconto os pontos //
                $hQry = mysql_query ("UPDATE tb_usuario SET USR_QTD_LEADS = USR_QTD_LEADS - $QTD_LEADS WHERE USR_ID = '$USR_ID'");
                
                // gravo log
                $jQry = mysql_query ("INSERT INTO tb_log (USR_ID, CTC_ID, LOG_DESCRICAO, LOG_DATA)
                                    VALUES('$USR_ID','$CTC_ID','Compra de lead',NOW())");
        // ================== //
	
				
	header( "Location: index.php?pg=4&CTC_ID=$CTC_ID&msgTxt=6"  );

		
?>