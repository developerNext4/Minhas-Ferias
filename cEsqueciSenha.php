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
		$USR_EMAIL				= ( isset( $_REQUEST['USR_EMAIL_SENHA'] ) ) ? $_REQUEST['USR_EMAIL_SENHA'] : null;
	// ======================= //
	
	// Definindo a Ação da Tela //		
		$hQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_EMAIL = '$USR_EMAIL'");
			if (mysql_num_rows($hQry) > 0){
				$jQry = mysql_fetch_array ($hQry);
					if ($jQry['USR_STATUS'] == "1"){
					
						// Envio e-mail de confirmação
						$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
						$max = strlen($CaracteresAceitos)-1;
						$codigo = null;
						for($i=0; $i < 20; $i++) {
							$codigo .= $CaracteresAceitos{mt_rand(0, $max)};
						}
						
						$kQry = mysql_query ("UPDATE tb_usuario SET USR_CODIGO_SENHA = '$codigo'
						WHERE USR_ID = '$jQry[USR_ID]'");
						
						$corpo = "<html>
									<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
									<title>Recupera&ccedil;&atilde;o de Senha</title>
									</head>
									<body >
									
									<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
									<tbody>
										<tr>
											<td>
													<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Recupera&ccedil;&atilde;o de Senha</font></strong><br/><br/>
													<font face='tahoma' color='#666666'>Prezado (a) $USR_NOME,</font><br/><br/>
											</td>
										</tr>
									</tbody>
									</table>
									
									<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
										<tbody>
											<tr>
												<td ><font face='tahoma' color='#666666'>Para recuperar sua senha basta acessar o link abaixo<br/><br>
									<a href='http://www.next4dev2.com/minhas_ferias/index.php?Codigo=$codigo&pg=6' target='_blank'>Clique Aqui Pra Confirmar Seu Cadastro</a></font></td>
												
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
						$assunto = "Recuperação de Senha";
						mail($USR_EMAIL,$assunto,$corpo,$header);
						$msgTxt = 1;
					}else if ($jQry['USR_STATUS'] == "2"){
						$msgTxt = 3;
					}else if ($jQry['USR_STATUS'] == "3"){
						$msgTxt = 4;
					}
			}else{
				$msgTxt = 2;
			}
			header ("Location: index.php?pg=5&msgTxt=$msgTxt");
	// ======================== //
		
?>