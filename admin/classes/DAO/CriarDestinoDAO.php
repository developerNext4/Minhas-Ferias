<?php
   require_once("classe.conexao.php");
   class CriarDestinoDAO extends conexao{


		function CriarDestinoDAO(){
			$this->conexao();
		}
		
		function ler($id){
			$this->sql("SELECT * FROM tb_cotacao WHERE USR_ID = '$id'");
			$linha = $this->linha();
			
			return $linha;
		}
		
		function listar(){
			// DEFINIÇÃO DE VARIÁVEIS //
			$aDados	= array();
			$iCont	= 0;
		
			// INICIANDO A CONSTRUÇÃO DA QUERY //
			$sSQL = "SELECT * FROM TB_PLANO WHERE PLN_STATUS = '1'";
	
			// EXECUTANDO A QUERY //
			$this->sql( $sSQL );
			
			while( $linha = $this->linha() ){
								
				$aDados[] = $linha;
				$iCont++;
			}
			
			return $aDados;
		}
      
		function insert( $arrValores ){
			
			$lastId = $this->inserir( "tb_cotacao", $arrValores );
			
			return $lastId;
		}
		
		function insertProposta( $arrValores ){
			
			$lastId = $this->inserir( "tb_cotacao_proposta", $arrValores );
			
			return $lastId;
		}
		
		function update( $arrValores, $id ){
			$strCondicao = " CTC_ID = '" . $id . "' ";
			
			$this->alterar( "tb_cotacao", $arrValores, $strCondicao );
			
			return true;
		}
      
		function getWhere(  ){
			$sWhere = " WHERE USR_ID = '$_SESSION[USR_ID]' ";
			
						
			return $sWhere;
		}
		
		function getQueryCount(){
			$sQryCount = NULL;
			$sQryCount = "SELECT COUNT(*) AS QTDE FROM tb_cotacao  " . $this->getWhere(  );

			return $sQryCount;
		}
		
		function criarPedidoNaoLogado($USR_ID, $USR_NOME, $USR_EMAIL, $CTC_STATUS){
			$zQry = mysql_query ("INSERT INTO tb_cotacao (CTC_AEREO, CTC_HOTEL, CTC_ALUGUEL,
							CTC_ATIVIDADE, CTC_PASSAGEM, CTC_DE, CTC_PARTIDA_DIA, CTC_PARTIDA_MES,
							CTC_PARTIDA_ANO, CTC_DATA_VOLTA, CTC_DATA_FLEXIVEIS, CTC_ADULTOS, CTC_ZERO_TRES,
							CTC_CRIANCAS, CTC_QTD_PROPOSTAS, CTC_OBS, CTC_DATA, USR_ID, CTC_STATUS) 
							VALUES ('$_SESSION[CTC_AEREO]',
							'$_SESSION[CTC_HOTEL]','$_SESSION[CTC_ALUGUEL]','$_SESSION[CTC_ATIVIDADE]',
							'$_SESSION[CTC_PASSAGEM]','$_SESSION[CTC_DE]','$_SESSION[CTC_PARTIDA_DIA]',
							'$_SESSION[CTC_PARTIDA_MES]','$_SESSION[CTC_PARTIDA_ANO]','$_SESSION[CTC_DATA_VOLTA]',
							'$_SESSION[CTC_DATA_FLEXIVEIS]','$_SESSION[CTC_ADULTOS]','$_SESSION[CTC_ZERO_TRES]',
							'$_SESSION[CTC_CRIANCAS]','$_SESSION[CTC_QTD_PROPOSTAS]', '$_SESSION[CTC_OBS]',
							'$_SESSION[CTC_DATA]','$USR_ID','$CTC_STATUS')");
							
							$tQry = mysql_query ("SELECT DST_NOME FROM tb_destino 
							WHERE DST_NOME = '$_SESSION[CTC_DE]'");
							if (mysql_num_rows($tQry) > 0){}else{
								$yQry = mysql_query ("INSERT INTO tb_destino (DST_NOME) 
								values ('$_SESSION[CTC_DE]')");
							}
							
							$xQry = mysql_query ("SELECT CTC_ID FROM tb_cotacao ORDER BY CTC_ID DESC LIMIT 1");
							$cQry = mysql_fetch_array ($xQry);
							
							$Destinos = NULL;
							for ($i = 1; $i <= $_SESSION["CONTADOR"]; $i++){
								$CTC_PARA = $_SESSION["CTC_PARA".$i];
								$CTP_QTD_NOITES = $_SESSION["CTP_QTD_NOITES".$i];
								$vQry = mysql_query ("INSERT INTO tb_cotacao_para (CTC_ID, CTP_PARA,
								CTP_QTD_NOITES) VALUES ('$cQry[CTC_ID]','$CTC_PARA', '$CTP_QTD_NOITES')");
								$eQry = mysql_query ("SELECT DST_NOME FROM tb_destino 
													  WHERE DST_NOME = '$CTC_PARA'");
													  
								$Destinos .= "<tr>
										<td><b>Para:</b></td>
										<td>$CTC_PARA</td>
									  </tr>
									  <tr>
										<td><b>Qtde Noites:</b></td>
										<td>$CTP_QTD_NOITES</td>
									  </tr>";
									  
								if (mysql_num_rows($eQry) > 0){}else{
									$rQry = mysql_query ("INSERT INTO tb_destino (DST_NOME) 
														  values ('$CTC_PARA')");
								}
							}
							
							$DESEJOCOTAR = NULL;
							$CTC_PASSAGEM = NULL;
							$CTC_DATA_FLEXIVEIS = NULL;
							if ($_SESSION["CTC_AEREO"] == "1"){
								$DESEJOCOTAR .= "A&eacute;reo,";
							}
							if ($_SESSION["CTC_HOTEL"] == "1"){
								$DESEJOCOTAR .= " Hotel,";
							}
							if ($_SESSION["CTC_ALUGUEL"] == "1"){
								$DESEJOCOTAR .= " Aluguel,";
							}
							if ($_SESSION["CTC_ATIVIDADE"] == "1"){
								$DESEJOCOTAR .= " Atividades Locais,";
							}
							
							$DESEJOCOTAR = substr ($DESEJOCOTAR,0,-1);
							
							if ($_SESSION["CTC_PASSAGEM"] == "1"){
								$CTC_PASSAGEM = "Ida e Volta";
							}else{
								$CTC_PASSAGEM = "Somente Ida";
							}
							
							if ($_SESSION["CTC_DATA_FLEXIVEIS"] == "1"){
								$CTC_DATA_FLEXIVEIS = "Sim";
							}else{
								$CTC_DATA_FLEXIVEIS = "N&atilde;o";
							}
							
							$corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Pedido de Cota&ccedil;&atilde;o</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Pedido de Cota&ccedil;&atilde;o</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $USR_NOME,</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td><font face='tahoma' color='#666666'>O Pedido de Cota&ccedil;&atilde;o abaixo foi criado.<br><br>
											<table width='100%'>
												<tr>
													<td><b>Pedido nº:</b></td><td>$cQry[CTC_ID]</td>
												</tr>
												<tr>
													<td><b>Desejo de Cotar:</b></td><td>$DESEJOCOTAR</td>
												</tr>
												<tr>
													<td><b>Passagem:</b></td><td>$CTC_PASSAGEM</td>
												</tr>
												<tr>
													<td><b>De:</b></td><td>$_SESSION[CTC_DE]</td>
												</tr>
												<tr>
													<td><b>Data de Partida:</b></td><td>".$_SESSION["CTC_PARTIDA_DIA"]."/".$_SESSION["CTC_PARTIDA_MES"]."/".$_SESSION["CTC_PARTIDA_ANO"]."</td>
												</tr>
												<tr>
													<td><b>Data de Volta:</b></td><td>$_SESSION[CTC_DATA_VOLTA]</td>
												</tr>
											
													$Destinos
												<tr>
													<td><b>Adultos</b></td><td>$_SESSION[CTC_ADULTOS]</td>
												</tr>
												<tr>
													<td><b>De zero a 23 meses</b></td><td>$_SESSION[CTC_ZERO_TRES]</td>
												</tr>
												<tr>
													<td><b>Crian&ccedil;as de 2 a 12 anos</b></td><td>$_SESSION[CTC_CRIANCAS]</td>
												</tr>
												<tr>
													<td><b>Quantidade de Proposta:</b></td><td>$_SESSION[CTC_QTD_PROPOSTAS]</td>
												</tr>
												<tr>
													<td><b>Observa&ccedil;&otilde;es</b></td><td>$_SESSION[CTC_OBS]</td>
												</tr>
											</table>
											</font></td>
											
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
								$assunto = "Pedido de Cotação";
								mail($USR_EMAIL,$assunto,$corpo,$header);
								
								// Destruo as variaveis de sessão
								unset ($_SESSION["CTC_AEREO"]);
								unset ($_SESSION["CTC_HOTEL"]);
								unset ($_SESSION["CTC_ALUGUEL"]);
								unset ($_SESSION["CTC_ATIVIDADE"]);
								unset ($_SESSION["CTC_PASSAGEM"]);
								unset ($_SESSION["CTC_DE"]);
								unset ($_SESSION["CTC_PARTIDA_DIA"]);
								unset ($_SESSION["CTC_PARTIDA_MES"]);
								unset ($_SESSION["CTC_PARTIDA_ANO"]);
								unset ($_SESSION["CTC_DATA_VOLTA"]);
								unset ($_SESSION["CTC_DATA_FLEXIVEIS"]);
								unset ($_SESSION["CTC_ZERO_TRES"]);
								unset ($_SESSION["CTC_CRIANCAS"]);
								unset ($_SESSION["CTC_QTD_PROPOSTAS"]);
								unset ($_SESSION["CTC_OBS"]);
								unset ($_SESSION["CTC_DATA"]);
		}
				
   }
?>