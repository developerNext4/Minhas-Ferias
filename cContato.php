<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
	// ==================== //
	
	// Declaração de variáveis //
		$GOSTARIA_FALAR		= ( isset( $_REQUEST['GOSTARIA_FALAR'] ) ) ? $_REQUEST['GOSTARIA_FALAR'] : null;
		$ASSUNTO			= ( isset( $_REQUEST['ASSUNTO'] ) ) ? $_REQUEST['ASSUNTO'] : null;
		$EMAIL_RETORNO		= ( isset( $_REQUEST['EMAIL_RETORNO'] ) ) ? $_REQUEST['EMAIL_RETORNO'] : null;
		$NOME				= ( isset( $_REQUEST['NOME'] ) ) ? $_REQUEST['NOME'] : null;
		$MENSAGEM			= ( isset( $_REQUEST['MENSAGEM'] ) ) ? $_REQUEST['MENSAGEM'] : null;
	// ======================= //
	
	// Definindo a Ação da Tela //		
			if ($GOSTARIA_FALAR == "1"){
				$EMAIL = "andryonheavy@hotmail.com";
			}else if ($GOSTARIA_FALAR == "2"){
				$EMAIL = "andryon@gmail.com";
			}else{
				$EMAIL = "teste@hotmail.com";
			}
		
			$header = "MIME-Version: 1.0\n";
			$header .= "Content-type: text/html; charset=iso-8859-1\n";
			$header .= "From: $NOME <$EMAIL_RETORNO>\n";
			$corpo = $NOME.'<br>'.$EMAIL_RETORNO.'<br><br>'.$ASSUNTO.'<br><br>'.$MENSAGEM.'<br><br>';
			if (mail($EMAIL,utf8_decode ($ASSUNTO),utf8_decode ($corpo),$header)){
				$msgTxt = 1;
			}else{
				$msgTxt = 2;
			}
			header ("Location: index.php?pg=11&msgTxt=$msgTxt");
	// ======================== //
		
?>