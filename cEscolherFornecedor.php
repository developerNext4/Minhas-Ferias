<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declaração de variáveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$SELECIONAR_FORNECEDOR	= ( isset( $_REQUEST['SELECIONAR_FORNECEDOR'] ) ) ? $_REQUEST['SELECIONAR_FORNECEDOR'] : null;
		$CONTATOEMAIL			= ( isset( $_REQUEST['CONTATOEMAIL'] ) ) ? $_REQUEST['CONTATOEMAIL'] : 0;
		$CONTATOTELEFONE		= ( isset( $_REQUEST['CONTATOTELEFONE'] ) ) ? $_REQUEST['CONTATOTELEFONE'] : 0;
		$CONTATOCELULAR			= ( isset( $_REQUEST['CONTATOCELULAR'] ) ) ? $_REQUEST['CONTATOCELULAR'] : 0;
		$pg						= ( isset( $_REQUEST['pg'] ) ) ? $_REQUEST['pg'] : null;
	// ======================= //
	
	// Fecho a cotação
	$hQry = mysql_query ("UPDATE tb_cotacao SET CTC_STATUS = '2' WHERE CTC_ID = '$CTC_ID'");
	
	// Atualiazo vencedor
	$jQry = mysql_query ("UPDATE tb_cotacao_proposta SET CPP_STATUS = '3', CPP_EMAIL = '$CONTATOEMAIL',
	CPP_TELEFONE = '$CONTATOTELEFONE', CPP_CELULAR = '$CONTATOCELULAR'
	WHERE CTC_ID = '$CTC_ID'
	AND USR_ID = '$SELECIONAR_FORNECEDOR'");
	
	// Atualizo perdedores
	$lQry = mysql_query ("UPDATE tb_cotacao_proposta SET CPP_STATUS = '2' WHERE CTC_ID = '$CTC_ID'
	AND CPP_STATUS = '1'");
        
        // Busco os perdedores
        $nQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID' AND CPP_STATUS = '2'");
        while ($mQry = mysql_fetch_array ($nQry)){
            $rQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$mQry[USR_ID]'");
            $tQry = mysql_fetch_array ($rQry);
            $corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Sua proposta n&atilde;o foi aprovada</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Sua proposta foi aprovada</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $tQry[USR_NOME],</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>Sua proposta n&atilde;o foi aprovada para a cota&ccedil;&atilde;o n&#176; $CTC_ID!</font></td>
											
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
					$assunto = "Sua proposta não foi aprovada";
					mail($tQry['USR_NOME'],$assunto,$corpo,$header);
        }
	
	$qQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$SELECIONAR_FORNECEDOR'");
	$wQry = mysql_fetch_array ($qQry);
	
	$corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Sua Proposta Foi Aprovada</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Sua proposta foi aprovada</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $wQry[USR_NOME],</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>Sua proposta foi aprovada! Acesse sua &aacute;rea para mais informa&ccedil;&otilde;es</font></td>
											
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
					$assunto = "Sua proposta foi aprovada";
					mail($wQry['USR_NOME'],$assunto,$corpo,$header);
	
	
				
	header( "Location: index.php?pg=$pg&CTC_ID=$CTC_ID&msgTxt=3"  );

		
?>