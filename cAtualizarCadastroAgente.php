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
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$USR_NOME				= ( isset( $_REQUEST['USR_NOME'] ) ) ? $_REQUEST['USR_NOME'] : null;
		$USR_EMAIL				= ( isset( $_REQUEST['USR_EMAIL'] ) ) ? $_REQUEST['USR_EMAIL'] : null;
		$USR_SENHA				= ( isset( $_REQUEST['USR_SENHA'] ) ) ? $_REQUEST['USR_SENHA'] : null;
		$USR_AGENCIA			= ( isset( $_REQUEST['USR_AGENCIA'] ) ) ? $_REQUEST['USR_AGENCIA'] : null;
		$USR_TELEFONE1			= ( isset( $_REQUEST['USR_TELEFONE1'] ) ) ? $_REQUEST['USR_TELEFONE1'] : null;
		$USR_TELEFONE2			= ( isset( $_REQUEST['USR_TELEFONE2'] ) ) ? $_REQUEST['USR_TELEFONE2'] : null;
		$USR_TELEFONE3			= ( isset( $_REQUEST['USR_TELEFONE3'] ) ) ? $_REQUEST['USR_TELEFONE3'] : null;
		$USR_SITE				= ( isset( $_REQUEST['USR_SITE'] ) ) ? $_REQUEST['USR_SITE'] : null;
		$USR_ENDERECO			= ( isset( $_REQUEST['USR_ENDERECO'] ) ) ? $_REQUEST['USR_ENDERECO'] : null;
		/*$USR_NOTIFICACOES		= ( isset( $_REQUEST['USR_NOTIFICACOES'] ) ) ? $_REQUEST['USR_NOTIFICACOES'] : 0;
		$USR_NOTICIAS_NOVIDADES = ( isset( $_REQUEST['USR_NOTICIAS_NOVIDADES'] ) ) ? $_REQUEST['USR_NOTICIAS_NOVIDADES'] : 0;*/
				
		$arrValores 									= array();
		$arrValores["USR_NOME"] 						= $USR_NOME;
		$arrValores["USR_EMAIL"] 						= $USR_EMAIL;
		if ($USR_SENHA != NULL){
			$arrValores["USR_SENHA"] 					= md5($USR_SENHA);
		}
		$arrValores["USR_TELEFONE1"] 					= $USR_TELEFONE1;
		$arrValores["USR_TELEFONE2"] 					= $USR_TELEFONE2;
		$arrValores["USR_TELEFONE3"] 					= $USR_TELEFONE3;
		$arrValores["USR_SITE"] 						= $USR_SITE;
		$arrValores["USR_ENDERECO"] 					= $USR_ENDERECO;
		$arrValores["USR_AGENCIA"] 						= $USR_AGENCIA;
		/*$arrValores["USR_NOTIFICACOES"] 				= $USR_NOTIFICACOES;
		$arrValores["USR_NOTICIAS_NOVIDADES"] 			= $USR_NOTICIAS_NOVIDADES;*/
		
		$ID					= NULL;
		$NOME				= NULL;
		$EMAIL				= NULL;
	// ======================= //
	
	// Definindo a Ação da Tela //		
				
		$IdCli = $oUsuario->update( $arrValores, $USR_ID );
				
			$msgTxt = 1;
			$_SESSION["USR_NOME"] = $USR_NOME;
									
			$corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Altera&ccedil;&atilde;o de Cadastro</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Confirma&ccedil;&atilde;o de Cadastro</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $USR_NOME,</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>O seu cadastro foi alterado</font></td>
											
										</tr>
										<tr height='18'>
											<td></td>
											<td></td>
										</tr>
										
										<tr>
											<td><font face='tahoma' color='#666666'>Em caso de d&uacute;vidas acesse a central de ajuda do site. Se preferir, entre em contato atrav&eacute;s do fale conosco.</font></td>
											
											
										</tr>
										<tr height='40'>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' >
									<tbody>
										<tr>
											<td width='174'>
												Logo
											</td>
											
											<td><font face='tahoma' color='#666666' size='1'>
											Equipe Vazzo<br/>
								Especializada em Viagens!<br/>
								www.vazzo.com.br<br/>
								Em caso de d&uacute;vidas, cr&iacute;ticas ou sugest&otilde;es acesse nosso atendimento: <strong> <a href='http://www.vazzo.com.br' style='text-decoration:none; color:#2A4F5E'>fale conosco</a></strong>
											</font></td>
										</tr>
									</tbody>
								
								</table>
								
								</body>
								</html>";
			$header = "MIME-Version: 1.0\n";
			$header .= "Content-type: text/html; charset=iso-8859-1\n";
			$header .= "From: Vazzo <atende@vazzo.com.br>\n";
			$assunto = "Alteração de Cadastro";
			mail($USR_EMAIL,$assunto,$corpo,$header);
		
		header( "Location: index.php?pg=2&msgTxt=$msgTxt"  );	
	// ======================== //
		
?>