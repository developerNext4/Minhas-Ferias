<?php
	session_start();
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
		$oCriarDestinoDAO= new CriarDestinoDAO();
	// ==================== //
	
	// Declaração de variáveis //
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
	
	// Definindo a Ação da Tela //		
		switch( $acaoTela ){
			case "insert":{
				
				// CODIFICANDO O PADRÃO UTF8 DAS INFORMÇÕES //
				/*foreach( $arrValores as $ch => $vl ){
					$arrValores[$ch] = utf8_encode( $vl );
				}*/
				
				
				$IdCli = $oUsuario->insert( $arrValores );
				if (is_numeric ($IdCli)){
					$msgTxt = 1;
					// Envio e-mail de confirmação
					$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
					$max = strlen($CaracteresAceitos)-1;
					$codigo = null;
					for($i=0; $i < 20; $i++) {
						$codigo .= $CaracteresAceitos{mt_rand(0, $max)};
					}
					
					$Cotacao = NULL;
					// Verifico se tentou criar uma cotação
					if (isset ($_SESSION["CTC_AEREO"])){
						$oCriarDestinoDAO->criarPedidoNaoLogado($IdCli,$USR_NOME,$USR_EMAIL,6);
						$iQry = mysql_query ("SELECT CTC_ID FROM tb_cotacao ORDER BY CTC_ID DESC LIMIT 1");
						$uQry = mysql_fetch_array ($iQry);
						$Cotacao = "&CTC_ID=$uQry[CTC_ID]";
						$msgTxt = 3;
					}
					
					$kQry = mysql_query ("UPDATE tb_usuario SET USR_CONF_CADASTRO = '$codigo'
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
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Confirma&ccedil;&atilde;o de Cadastro</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $USR_NOME,</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>Para confirmar seu cadastro  basta acessar o link abaixo<br/><br>
								<a href='http://www.next4dev2.com/minhas_ferias/confirmarCadastro.php?Codigo=$codigo$Cotacao' target='_blank'>Clique Aqui Pra Confirmar Seu Cadastro</a></font></td>
											
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
					$assunto = "Confirmação de Cadastro";
					mail($USR_EMAIL,$assunto,$corpo,$header);
				}else{
					$msgTxt = 2;
				}
				
				echo ($msgTxt);
				
				break;
			
			}
		}
	// ======================== //
		
?>