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
		$Codigo				= ( isset( $_REQUEST['Codigo'] ) ) ? $_REQUEST['Codigo'] : null;
		$CTC_ID				= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$msgTxt				= 2;
	// ======================= //
	
	// Definindo a Aчуo da Tela //
		if ($Codigo != NULL){
			$hQry = mysql_query ("SELECT USR_CONF_CADASTRO, USR_ID FROM tb_usuario
			WHERE USR_CONF_CADASTRO = '$Codigo'");
			if (mysql_num_rows($hQry) > 0){
				$mQry = mysql_fetch_array ($hQry);
				$jQry = mysql_query ("UPDATE tb_usuario SET USR_STATUS = '1', USR_CONF_CADASTRO = ''
									  WHERE USR_CONF_CADASTRO = '$Codigo'");
				$msgTxt = 1;
			}
			
			if ($CTC_ID != NULL){
				// Verifico se a cotaчуo щ deste usuсrio
				$qQry = mysql_query ("SELECT * FROM tb_cotacao WHERE CTC_ID = '$CTC_ID' 
				AND USR_ID = '$mQry[USR_ID]'");
				if (mysql_num_rows($qQry) > 0){
					$eQry = mysql_query ("UPDATE tb_cotacao SET CTC_STATUS = '1' WHERE CTC_ID = '$CTC_ID'");
					$msgTxt = 3;
				}
			}
		}
		header ("Location: index.php?pg=4&msgTxt=$msgTxt");
	// ======================== //
		
?>