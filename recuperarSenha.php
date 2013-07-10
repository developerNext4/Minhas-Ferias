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
		$CODIGO				= ( isset( $_REQUEST['CODIGO'] ) ) ? $_REQUEST['CODIGO'] : null;
		$USR_SENHA_NOVA	 	= md5(( isset( $_REQUEST['USR_SENHA_NOVA'] ) ) ? $_REQUEST['USR_SENHA_NOVA'] : null);
		$msgTxt				= 2;
	// ======================= //
	
	// Definindo a Aчуo da Tela //
		if ($CODIGO != NULL){
			$hQry = mysql_query ("SELECT * FROM tb_usuario
			WHERE USR_CODIGO_SENHA = '$CODIGO'");
			if (mysql_num_rows($hQry) > 0){
				$qQry = mysql_fetch_array ($hQry);
				$jQry = mysql_query ("UPDATE tb_usuario SET USR_SENHA = '$USR_SENHA_NOVA', USR_CODIGO_SENHA = ''
									  WHERE USR_CODIGO_SENHA = '$CODIGO'");
				$oQry = mysql_query ("INSERT INTO tb_log (USR_ID, LOG_DESCRICAO, LOG_DATA) VALUES
				('$qQry[USR_ID]','Resetar Senha',NOW())");
				$msgTxt = 1;
			}
		}
		header ("Location: index.php?pg=6&msgTxt=$msgTxt&Codigo=$CODIGO");
	// ======================== //
		
?>