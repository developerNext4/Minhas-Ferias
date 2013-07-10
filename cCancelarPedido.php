<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisi��es de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declara��o de vari�veis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$PRECOLEAD				= ( isset( $_REQUEST['PRECOLEAD'] ) ) ? $_REQUEST['PRECOLEAD'] : null;
		$MOTIVOCANCELAMENTO    	= utf8_decode (( isset( $_REQUEST['MOTIVOCANCELAMENTO'] ) ) ? $_REQUEST['MOTIVOCANCELAMENTO'] : null);
		$pg					= ( isset( $_REQUEST['pg'] ) ) ? $_REQUEST['pg'] : null;
	// ======================= //
        
        $qQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$USR_ID'");
        $wQry = mysql_fetch_array ($qQry);
        $corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Pedido Cancelado</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Pedido Cancelado</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $wQry[USR_NOME],</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>O pedido de cota&ccedil;&atilde;o n&deg; $CTC_ID foi cancelado. <br><br>
                                                                                            <strong>Motivo:</strong> $MOTIVOCANCELAMENTO </font></td>
											
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
					$assunto = "Pedido Cancelado";
					mail($wQry['USR_NOME'],$assunto,$corpo,$header);
	
	$hQry = mysql_query ("UPDATE tb_cotacao SET CTC_STATUS = '3',
                              CTC_MOTIVO_CANCELAMENTO = '$MOTIVOCANCELAMENTO' WHERE CTC_ID = '$CTC_ID'");
        // Busco todos os participantes da cotação e envio e-mail
        $uQry = mysql_query ("SELECT * FROM tb_cotacao_proposta a INNER JOIN TB_USUARIO b ON a.USR_ID = b.USR_ID WHERE CTC_ID = '$CTC_ID'");
        while ($iQry = mysql_fetch_array ($uQry)){
            $corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Pedido Cancelado</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Pedido Cancelado</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $iQry[USR_NOME],</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td ><font face='tahoma' color='#666666'>O pedido de cota&ccedil;&atilde;o n&deg; $CTC_ID foi cancelado. <br><br>
                                                                                            <strong>Motivo:</strong> $MOTIVOCANCELAMENTO <br><br>
                                                                                            Os pontos que utilizou para este pedido j&aacute; foram creditados em sua conta.</font></td>
											
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
					$assunto = "Pedido Cancelado";
					mail($iQry['USR_NOME'],$assunto,$corpo,$header);
                                        
                                        
                                        $nQry = mysql_query ("UPDATE tb_usuario SET USR_QTD_LEADS = USR_QTD_LEADS + $PRECOLEAD 
                                                              WHERE USR_ID = '$iQry[USR_ID]'");
        }
	
	
				
	header( "Location: index.php?pg=$pg&CTC_ID=$CTC_ID&msgTxt=5"  );

		
?>