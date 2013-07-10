<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
		$oUtil 			= new Util();
	// ==================== //
	
	// Declaração de variáveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$USR_NOME_AGENTE		= ( isset( $_REQUEST['USR_NOME_AGENTE'] ) ) ? $_REQUEST['USR_NOME_AGENTE'] : null;
		$USR_EMAIL_AGENTE		= ( isset( $_REQUEST['USR_EMAIL_AGENTE'] ) ) ? $_REQUEST['USR_EMAIL_AGENTE'] : null;
		$USR_SENHA_AGENTE		= ( isset( $_REQUEST['USR_SENHA_AGENTE'] ) ) ? $_REQUEST['USR_SENHA_AGENTE'] : null;
		$USR_AGENCIA_AGENTE		= ( isset( $_REQUEST['USR_AGENCIA_AGENTE'] ) ) ? $_REQUEST['USR_AGENCIA_AGENTE'] : null;
		$USR_TELEFONE1_AGENTE	= ( isset( $_REQUEST['USR_TELEFONE1_AGENTE'] ) ) ? $_REQUEST['USR_TELEFONE1_AGENTE'] : null;
		$USR_TELEFONE2_AGENTE	= ( isset( $_REQUEST['USR_TELEFONE2_AGENTE'] ) ) ? $_REQUEST['USR_TELEFONE2_AGENTE'] : null;
		$USR_TELEFONE3_AGENTE	= ( isset( $_REQUEST['USR_TELEFONE3_AGENTE'] ) ) ? $_REQUEST['USR_TELEFONE3_AGENTE'] : null;
		$USR_NOTIFICACOES_AGENTE= ( isset( $_REQUEST['USR_NOTIFICACOES_AGENTE'] ) ) ? $_REQUEST['USR_NOTIFICACOES_AGENTE'] : 0;
				
		$arrValores 									= array();
		$arrValores["USR_NOME"] 						= $USR_NOME_AGENTE;
		$arrValores["USR_EMAIL"] 						= $USR_EMAIL_AGENTE;
		$arrValores["USR_SENHA"] 						= md5($USR_SENHA_AGENTE);
		$arrValores["USR_AGENCIA"] 						= $USR_AGENCIA_AGENTE;
		$arrValores["USR_TELEFONE1"] 					= $USR_TELEFONE1_AGENTE;
		$arrValores["USR_TELEFONE2"] 					= $USR_TELEFONE2_AGENTE;
		$arrValores["USR_TELEFONE3"] 					= $USR_TELEFONE3_AGENTE;
		$arrValores["USR_NOTIFICACOES"] 				= $USR_NOTIFICACOES_AGENTE;
		$arrValores["USR_TIPO"] 						= "2";
                
                // Busco os leads default
                $nuQry = mysql_query ("SELECT LDS_NUMERO FROM tb_leads LIMIT 1");
                $uiQry = mysql_fetch_array ($nuQry);
                $arrValores["USR_QTD_LEADS"] = $uiQry["LDS_NUMERO"];
	// ======================= //
	
	// Definindo a Ação da Tela //		
		switch( $acaoTela ){
			case "insert":{
				
				// CODIFICANDO O PADRÃO UTF8 DAS INFORMÇÕES //
				foreach( $arrValores as $ch => $vl ){
					$arrValores[$ch] = utf8_encode( $vl );
				}
				
				
				$IdCli = $oUsuario->insertAgente( $arrValores );
				
				$logo = 1;
				if (is_numeric ($IdCli)){
					$msgTxt = 1;
					if( $_FILES["USR_LOGO"] != "none" && !empty( $_FILES["USR_LOGO"]["name"] ) ){

						$type = $_FILES["USR_LOGO"]["type"];
						$size = $_FILES["USR_LOGO"]["size"];
						$temp = $_FILES["USR_LOGO"]["tmp_name"];
						
						if( $oUtil->validaUpload( $type, true ) ){
							if( $size <= 210000 ){
															
								// Crio a miniatura //
								$imagem = $_FILES['USR_LOGO']['tmp_name'];
															
								$newname = "logos/". $IdCli . ".jpg";
								$copied = copy($_FILES['USR_LOGO']['tmp_name'], $newname);
								
								$logo = 1;
								
								//$thumb = PhpThumbFactory::create("fotos/curriculos/". $IdCrr . ".jpg");
								//$thumb->resize(135, 150)->save("fotos/curriculos/". $IdCrr . ".jpg");								
	
							}
						}else{
							$logo = 2;
						}
						
					}
					
					// Envio e-mail de confirmação
					$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
					$max = strlen($CaracteresAceitos)-1;
					$codigo = null;
					for($i=0; $i < 20; $i++) {
						$codigo .= $CaracteresAceitos{mt_rand(0, $max)};
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
												<font face='tahoma' color='#666666'>Prezado (a) $USR_NOME_AGENTE,</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>Para confirmar seu cadastro na Vazzo, basta acessar o link abaixo<br/><br>
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
					$assunto = "Confirmação de Cadastro";
					mail($USR_EMAIL_AGENTE,$assunto,$corpo,$header);
					// =============== //
				}else{
					$msgTxt = 2;
				}

				header( "Location: index.php?pg=3&msgTxt=$msgTxt&logo=$logo"  );
				
				break;
			
			}
		}
	// ======================== //
		
?>