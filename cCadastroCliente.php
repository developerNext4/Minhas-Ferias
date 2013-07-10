<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisi��es de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
		$oCriarDestinoDAO= new CriarDestinoDAO();
	// ==================== //
	
	// Declara��o de vari�veis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$USR_NOME				= ( isset( $_REQUEST['USR_NOME'] ) ) ? $_REQUEST['USR_NOME'] : null;
		$USR_EMAIL				= ( isset( $_REQUEST['USR_EMAIL'] ) ) ? $_REQUEST['USR_EMAIL'] : null;
		$USR_SENHA				= ( isset( $_REQUEST['USR_SENHA'] ) ) ? $_REQUEST['USR_SENHA'] : null;
				
		$arrValores 									= array();
		$arrValores["USR_NOME"] 						= $USR_NOME;
		$arrValores["USR_EMAIL"] 						= $USR_EMAIL;
		$arrValores["USR_SENHA"] 						= md5($USR_SENHA);
		
		$ID					= NULL;
		$NOME				= NULL;
		$EMAIL				= NULL;
	// ======================= //

	// Definindo a A��o da Tela //		
		switch( $acaoTela ){
			case "insert":{
				
				// CODIFICANDO O PADR�O UTF8 DAS INFORM��ES //
				/*foreach( $arrValores as $ch => $vl ){
					$arrValores[$ch] = utf8_encode( $vl );
				}*/
				
				
				$IdCli = $oUsuario->insert( $arrValores );
				
				if (is_numeric ($IdCli)){
					$msgTxt = 1;
					
					// Envio e-mail de confirma��o
					$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
					$max = strlen($CaracteresAceitos)-1;
					$codigo = null;
					for($i=0; $i < 20; $i++) {
						$codigo .= $CaracteresAceitos{mt_rand(0, $max)};
					}
					
					
					$kQry = mysql_query ("UPDATE TB_USUARIO SET USR_CONF_CADASTRO = '$codigo'
					WHERE USR_ID = '$IdCli'");
					
					$corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Confirma&ccedil;&atilde;o de Cadastro</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Recupera&ccedil;&atilde;o de senha</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $USR_NOME,</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>Para confirmar seu cadastro basta na Vazzo basta acessar o link abaixo<br/><br>
								<a href='http://www.next4dev2.com/minhas_ferias/confirmarCadastro.php?Codigo=$codigo' target='_blank'>Clique Aqui Pra Confirmar Seu Cadastro</a></font></td>
											
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
					$assunto = "Confirma��o de Cadastro";
					mail($USR_EMAIL,$assunto,$corpo,$header);
				}else{
					$msgTxt = 2;
				}
				
				header( "Location: index.php?pg=2&msgTxt=$msgTxt"  );
				
				break;
			
			}
		}
	// ======================== //
		
?>