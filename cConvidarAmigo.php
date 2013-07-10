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
		$NomeAmigo				= utf8_decode (( isset( $_REQUEST['NomeAmigo'] ) ) ? $_REQUEST['NomeAmigo'] : null);
		$EmailAmigo				= ( isset( $_REQUEST['EmailAmigo'] ) ) ? $_REQUEST['EmailAmigo'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
	// ======================= //
	
	$hQry = mysql_query ("SELECT USR_NOME FROM tb_usuario WHERE USR_ID = '$USR_ID'");
	$jQry = mysql_fetch_array ($hQry);

					
					$corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Voc&ecirc; recebeu um convite</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Voc&ecirc; recebeu um convite</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $NomeAmigo,</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>Informamos que $jQry[USR_NOME] convidou voc&ecirc; para conhecer o site xxxx. <br><br>
											<a href=''>Clique aqui para acessar o site</a></font></td>
											
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
					$assunto = "Você recebeu um convite";
					mail($EmailAmigo,$assunto,$corpo,$header);
					
					header ("Location: index.php?pg=4&msgTxt=1");
					// =============== //

	// ======================== //
		
?>