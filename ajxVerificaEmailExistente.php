<?php
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
		$USR_EMAIL = $_REQUEST['USR_EMAIL'];
		$EMAIL_ATUAL = $_REQUEST['EMAIL_ATUAL'];
	
	// Verifico CPF na base //
		if ($EMAIL_ATUAL != ''){
			$jQry = mysql_query ("SELECT USR_EMAIL FROM tb_usuario 
			WHERE USR_EMAIL = '$USR_EMAIL' AND USR_EMAIL != '$EMAIL_ATUAL'");
			if (mysql_num_rows($jQry) > 0){
				echo ("1");
			}else{
				echo ("2");
			}
		}else{
			$jQry = mysql_query ("SELECT USR_EMAIL FROM tb_usuario WHERE USR_EMAIL = '$USR_EMAIL'");
			if (mysql_num_rows($jQry) > 0){
				echo ("1");
			}else{
				echo ("2");
			}
		}
	// ==================== //	
    
?>