
<div class="row">
    <div class="span8 contentLeft">

        <?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Pergunta enviada com sucesso!
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
        <?php
            }else if($msgTxt == 2){
        ?>
                <div class="alert alert-success">
                    Resposta enviada com sucesso!
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>

        <?php
            }else if($msgTxt == 3){
        ?>
        		<div class="alert alert-success">
                    Fornecedor selecionado com sucesso!
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
        <?php
			}else if($msgTxt == 4){
		?>

        		<div class="alert alert-success">
                    Avaliação realizada com sucesso!
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
        <?php
			}else if($msgTxt == 5){
		?>
                            <div class="alert alert-success">
                    Pedido cancelado com sucesso!
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
        <?php
                        }
        ?>
        <?php
			// Requisições de Arquivos Externos //
			require_once( "./classes/DAO/UtilsDAO.php" );
			require_once( "./classes/DAO/CriarDestinoDAO.php" );
			require_once( "./classes/Utils/Util.php" );
			// ================================ //

			// Instanciando Objetos //
			$oCriarDestinoDAO		= new CriarDestinoDAO();
			$oUtilsDAO				= new UtilsDAO();
			$oUtil 			= new Util();
			// ==================== //



		?>


            <fieldset class="left30">
            <legend>Detalhes Pedido</legend>
            <?php


			$CTC_ID = ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
			$CTC_STATUS = NULL;
            $hQry = mysql_query ("SELECT * FROM tb_cotacao WHERE CTC_ID = '$CTC_ID'");
			if (mysql_num_rows($hQry) > 0){
                                // Atualizo proposta como lida
                                $gQry = mysql_query ("UPDATE tb_cotacao_proposta SET CPP_LIDA = '1' WHERE CTC_ID = '$CTC_ID'");
                                $aQry = mysql_query("UPDATE tb_cotacao_pergunta SET CPR_LIDA = '1' WHERE CTC_ID = '$CTC_ID'");
				while ($jQry = mysql_fetch_array ($hQry)){
					$CTC_STATUS = $jQry['CTC_STATUS'];
					echo ("<input type='hidden' name='STATUS_COTACAO' id='STATUS_COTACAO' value='$jQry[CTC_STATUS]'>");
			?>
             <div class="row">
	             	 <div class="span8">
						<p><strong>Data de Criação:</strong> <?php 	$DIA = substr ($jQry['CTC_DATA'],8,2); $MES = substr ($jQry['CTC_DATA'],5,2);
							$ANO = substr ($jQry['CTC_DATA'],0,4);		echo ($DIA.'/'.$MES.'/'.$ANO); ?></p>
                        <p><strong>Data da Última Atualização:</strong> <?php $DIA = substr ($jQry['CTC_DATA'],8,2); $MES = substr ($jQry['CTC_DATA'],5,2);
							$ANO = substr ($jQry['CTC_DATA'],0,4);	echo ($DIA.'/'.$MES.'/'.$ANO); ?></p>
                         <p><strong>Desejo: </strong><?php

						if ($jQry['CTC_AEREO'] == "1"){
							$Desejo = "Aéreo,";
						}
						if ($jQry['CTC_HOTEL'] == "1"){
							$Desejo .= " Hotel,";
						}
						if ($jQry['CTC_ALUGUEL'] == "1"){
							$Desejo .= " Aluguel,";
						}
						if ($jQry['CTC_ATIVIDADE'] == "1"){
							$Desejo .= " Atividade,";
						}

						$Desejo = substr ($Desejo,0,-1);

						echo ($Desejo);

					?></p>
                    <p>
                    <?php echo ("<strong>De:</strong> ".$jQry["CTC_DE"]);?> <strong>Para:</strong>
                	<?php
					// Busco os destinos
								/*$iQry = mysql_query ("SELECT * FROM tb_cotacao_para
								WHERE CTC_ID = '$jQry[CTC_ID]'");
								$CTP_PARA = NULL;
								while ($oQry = mysql_fetch_array ($iQry)){
									$CTP_PARA .= $oQry['CTP_PARA'].',';
								}
								$CTP_PARA = substr ($CTP_PARA,0,-1);*/
								echo ($jQry["CTC_PARA"]);
						?>
                    </p>
                    <p>
                    	<h4><a href="index.php?pg=6&CTC_ID=<?php echo ($CTC_ID);?>">Alterar para visualização em carrousel</a></h4>
                    </p>
                    <p>
                    	<?php
						// Verifico os fornecedores
						$kQry = mysql_query ("SELECT * FROM tb_cotacao_proposta a
						INNER JOIN tb_usuario b ON a.USR_ID = b.USR_ID WHERE CTC_ID = '$jQry[CTC_ID]'");
						if (mysql_num_rows($kQry) > 0){
						?>
                        <div class="accordion" id="accordion2">




                        <?php
							$i = 1;
							$optionSelect = NULL;
							$DivsFornecedor = NULL;
							$optionSelectFornecedor = NULL;
							$FornecedorSelecionado = NULL;
                                                        $TotalAereo = NULL;
                                                        $TotalHotel = NULL;
                                                        $TotalAluguel = NULL;
                                                        $TotalAtividade = NULL;
							while ($lQry = mysql_fetch_array ($kQry)){
                                                                if ($jQry['CTC_AEREO'] == "1"){
                                                                    $TotalAereo = $lQry["CPP_TOTAL_AEREO"];
                                                                    $TotalAereo = str_replace (",",".",$TotalAereo);
                                                                }
                                                                if ($jQry['CTC_HOTEL'] == "1"){
                                                                    $TotalHotel = $lQry["CPP_TOTAL_HOTEL"];
                                                                    $TotalHotel = str_replace (",",".",$TotalHotel);
                                                                }
                                                                if ($jQry['CTC_ALUGUEL'] == "1"){
                                                                    $TotalAluguel = $lQry["CPP_TOTAL_ALUGUEL"];
                                                                    $TotalAluguel = str_replace (",",".",$TotalAluguel);
                                                                }
                                                                if ($jQry['CTC_ATIVIDADE'] == "1"){
                                                                    $TotalAtividade = $lQry["CPP_TOTAL_ATIVIDADE"];
                                                                    $TotalAtividade = str_replace (",",".",$TotalAtividade);
                                                                }
                                                                $TOTAL = $TotalAereo + $TotalAluguel + $TotalHotel + $TotalAtividade;
								$TOTAL = number_format ($TOTAL,2,',','.');
								$optionSelect .= "<option value='$lQry[USR_ID]'>".utf8_encode ($lQry['USR_NOME'])."</option>";
								$optionSelectFornecedor .= "<option value='$lQry[USR_ID]''>".utf8_encode ($lQry['USR_NOME'])."</option>";
								if ($lQry["USR_AGENCIA"] != NULL){
									$AGENCIA = "<p><strong>Agência:</strong> ".utf8_encode ($lQry['USR_AGENCIA'])."</p>";
								}else{ $AGENCIA = NULL; }
								if ($lQry["USR_ENDERECO"] != NULL){
									$ENDERECO = "<p><strong>Endereço:</strong> ".utf8_encode ($lQry['USR_ENDERECO'])."</p>";
								}else{ $ENDERECO = NULL; }
								if ($lQry["USR_SITE"] != NULL){
									$SITE = "<p><strong>Site:</strong> ".utf8_encode ($lQry['USR_SITE'])."</p>";
								}else{ $SITE = NULL; }

								$FONES = $lQry["USR_TELEFONE1"];
								if ($lQry["USR_TELEFONE2"] != NULL){
									$FONES .= " / ".$lQry["USR_TELEFONE2"];
								}
								if ($lQry["USR_TELEFONE3"] != NULL){
									$FONES .= " / ".$lQry["USR_TELEFONE3"];
								}
								$DivsFornecedor .= "<div style='display:none;' id='Fornecedor_$i'>
											<p><strong>Dados de Contato ".utf8_encode ($lQry['USR_NOME'])."</strong></p>
											$AGENCIA
											$ENDERECO
											$SITE
											<p><strong>E-mail: </strong>$lQry[USR_EMAIL]</p>
											<p><strong>Telefones: </strong>$FONES</p>
										 </div>";
								if ($lQry['CPP_STATUS'] == "3"){
									$FornecedorSelecionado = "<div >
											<p><strong>Dados de Contato ".utf8_encode ($lQry['USR_NOME'])."</strong></p>
											$AGENCIA
											$ENDERECO
											$SITE
											<p><strong>E-mail: </strong>$lQry[USR_EMAIL]</p>
											<p><strong>Telefones: </strong>$FONES</p>
										 </div>";
								}
						?>
                        		<div class="accordion-group">
                                    <div class="accordion-heading">

                                        <div class="span1"><input type="checkbox" name="CTP_<?php echo ($i); ?>" id="CTP_<?php echo ($i); ?>" value="<?php echo ($lQry["USR_ID"]); ?>" onclick="verificarComparar();" /></div>
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo ($i); ?>"> <?php echo (utf8_encode ($lQry['USR_NOME'])); ?> | R$ <?php echo ($TOTAL); ?> | 1 Resposta
                                        </a>
                                     </div>
                                    <div id="collapse<?php echo ($i); ?>" class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <p><strong>Descrição e Observações da Proposta:<br></strong> <?php 
                                                if ($jQry['CTC_AEREO'] == "1"){
                                                    ?>
                                            <div class="divAereo">
                                                    <h5>Aereo</h5>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Trecho</td>
                                                            <td>Compania</td>
                                                            <td>Partida</td>
                                                            <td>De / Para</td>
                                                            <td>Chegada</td>
                                                            <td>Saida</td>
                                                        </tr>
                                                <?php
                                                    if ($lQry['CPP_TRECHO_COMPANIA1'] != ''){
                                                        $lQry['CPP_TRECHO_PARTIDA1'] = $oUtil->codificadata ($lQry['CPP_TRECHO_PARTIDA1']);
                                                        ?><tr>
                                                            <td>Trecho 1</td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_COMPANIA1'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_PARTIDA1']); ?></td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_DEPARA1'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_CHEGADA1']); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_SAIDA1']); ?></td>
                                                          </tr>
                                                        <?php
                                                    }
                                                    if ($lQry['CPP_TRECHO_COMPANIA2'] != ''){
                                                        $lQry['CPP_TRECHO_PARTIDA2'] = $oUtil->codificadata ($lQry['CPP_TRECHO_PARTIDA2']);
                                                        ?><tr>
                                                            <td>Trecho 2</td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_COMPANIA2'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_PARTIDA2']); ?></td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_DEPARA2'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_CHEGADA2']); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_SAIDA2']); ?></td>
                                                          </tr>
                                                        <?php
                                                    }
                                                    if ($lQry['CPP_TRECHO_COMPANIA3'] != ''){
                                                        $lQry['CPP_TRECHO_PARTIDA3'] = $oUtil->codificadata ($lQry['CPP_TRECHO_PARTIDA3']);
                                                        ?><tr>
                                                            <td>Trecho 3</td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_COMPANIA3'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_PARTIDA3']); ?></td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_DEPARA3'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_CHEGADA3']); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_SAIDA3']); ?></td>
                                                          </tr>
                                                        <?php
                                                    }
                                                    if ($lQry['CPP_TRECHO_COMPANIA4'] != ''){
                                                        $lQry['CPP_TRECHO_PARTIDA4'] = $oUtil->codificadata ($lQry['CPP_TRECHO_PARTIDA4']);
                                                        ?><tr>
                                                            <td>Trecho 4</td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_COMPANIA4'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_PARTIDA4']); ?></td>
                                                            <td><?php echo(utf8_encode ($lQry['CPP_TRECHO_DEPARA4'])); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_CHEGADA4']); ?></td>
                                                            <td><?php echo($lQry['CPP_TRECHO_SAIDA4']); ?></td>
                                                          </tr>
                                                        <?php
                                                    }
                                                ?>
                                                    </table>
                                                    
                                                <?php
                                                   echo ("<strong>Valor da Passagem:</strong> R$ ".number_format ($lQry['CPP_VALOR_PASSAGEM'],2,',','.') . " | <strong>Taxa</strong> R$ ". number_format ($lQry['CPP_VALOR_TAXA'],2,',','.')." | <strong>Total Aereo</strong> R$ ". number_format ($lQry['CPP_TOTAL_AEREO'],2,',','.'));
                                                   echo ("</div>");
                                                }if ($jQry['CTC_HOTEL'] == "1"){
                                                ?>
                                                    <div class="divHotel">
                                                    <h5>Hotel</h5>
                                                    <table class="table"> 
                                                <?php
                                                    echo ("<tr><td width='50%'><strong>Nome: </strong>".utf8_encode($lQry['CPP_HOTEL'])."</td><td><strong>Link: </strong>".utf8_encode($lQry['CPP_HOTEL_LINK'])."</td></tr>");
                                                    echo (utf8_encode ("<tr><td><strong>Endere�o </strong>".$lQry['CPP_HOTEL_ENDERECO']));
                                                    echo (utf8_encode ("</td><td><strong>Classifica��o:</strong> "));
                                                    if ($lQry['CPP_HOTEL_CLASSIFICACAO'] == "1"){
                                                        echo ("1 Estrela");
                                                    }else if ($lQry['CPP_HOTEL_CLASSIFICACAO'] == "2"){
                                                        echo ("2 Estrelas");
                                                    }else if ($lQry['CPP_HOTEL_CLASSIFICACAO'] == "3"){
                                                        echo ("3 Estrelas");
                                                    }else if ($lQry['CPP_HOTEL_CLASSIFICACAO'] == "4"){
                                                        echo ("4 Estrelas");
                                                    }else if ($lQry['CPP_HOTEL_CLASSIFICACAO'] == "5"){
                                                        echo ("5 Estrelas");
                                                    }
                                                    echo ("</td></tr>");
                                       
                                                    echo ("<tr><td><strong>Check-in:</strong> ".$oUtil->codificadata ($lQry['CPP_HOTEL_CHECKIN'])."</td>");
                                                    echo ("<td><strong>Check-out:</strong> ".$oUtil->codificadata ($lQry['CPP_HOTEL_CHECKOUT'])."</td></tr>");
                                                    echo ("<tr><td><strong>Qtd de Noites:</strong> ".$lQry['CPP_HOTEL_QTD_NOITES']."</td>");
                                                    echo (utf8_encode ("<td><strong>M�dia Di�ria:</strong> R$ ".number_format ($lQry['CPP_HOTEL_MEDIA_DIARIA'],2,',','.')."</td></tr>"));
                                                    echo ("<tr><td colspan='2'><strong>Total Hotel:</strong> R$ ".number_format ($lQry['CPP_TOTAL_HOTEL'],2,',','.')."</td></tr></table>");
                                                ?>
                                                    </div>    
                                                <?php
                                                } if ($jQry['CTC_ALUGUEL'] == "1"){                                                
                                                ?>
                                                    <div class="divAluguel">
                                                    <h5>Aluguel</h5>
                                                    <table class="table">
                                                <?php
                                                     echo ("<tr><td><strong>Locadora: </strong>".utf8_encode ($lQry['CPP_ALUGUEL_LOCADORA'])."</td>");
                                                     echo (utf8_encode ("<td><strong>Classifica��o: </strong>Compacto</td></tr>"));
                                                     echo ("<tr><td><strong>Retirada:</strong> ".$oUtil->codificadata ($lQry['CPP_ALUGUEL_RETIRADA'])."</td>");
                                                     echo (utf8_encode ("<td><strong>Devolu��o:</strong> ".$oUtil->codificadata ($lQry['CPP_ALUGUEL_DEVOLUCAO'])."</td></tr>"));
                                                     echo ("<tr><td><strong>GPS:</strong> ");
                                                     if ($lQry['CPP_ALUGUEL_GPS'] == "1"){
                                                         echo ("Sim</td>");
                                                     }else{
                                                         echo (utf8_encode ("N�o</td>"));
                                                     }
                                                     echo (utf8_encode ("<td><strong>Di�rias:</strong> ".$lQry['CPP_ALUGUEL_DIARIAS']."</td></tr>"));
                                                     echo (utf8_encode ("<tr><td><strong>Entrega: </strong>".$lQry['CPP_ALUGUEL_ENTREGA']));
                                                     echo (utf8_encode ("<td><strong>Sistema: </strong>All inclusive</td></tr>"));
                                                     echo ("<tr><td colspan='2'><strong>Total Aluguel:</strong> R$ ".number_format ($lQry['CPP_TOTAL_ALUGUEL'],2,',','.')."</td></tr></table>");
                                                
                                                ?>
                                                    </table>
                                                    </div>
                                                <?php    
                                                }
                                                if ($lQry['CPP_OBSERVACOES'] != NULL){
                                                    echo (utf8_encode("<p><strong>Observa��es: </strong>". $lQry['CPP_OBSERVACOES']));
                                                }
                                            ?></p>
                                            <p><strong>Valor Total:</strong> R$ <?php echo ($TOTAL); ?>
                                            <p><strong><a href="#myProposta" role="button" id="fazerProposta"  data-toggle="modal">Nota média do fornecedor:</strong> Este fornecedor não possui nenhuma avaliação</a></p>
                                            <p><strong>Negócios fechados no site:</strong>
                                            <?php
                                            	$pQry = mysql_query ("SELECT COUNT(*) AS FECHADA FROM
												tb_cotacao_proposta WHERE USR_ID = '$lQry[USR_ID]' AND
												CPP_STATUS = '3'");
												$oQry = mysql_fetch_array ($pQry);
												echo ($oQry['FECHADA']);
											?></p>
                                        </div>
                                     </div>
                                 </div>

                        <?php
								$i++;
							}

							$CONTADOR = "<input type='hidden' name='CONTADOR' id='CONTADOR' value='$i'>";
						?>
                            </div>
                            <script>
								function verificarComparar(){
									var selecionados = '';
									for (i = 1; i < $('#CONTADOR').val(); i++){
										if (document.getElementById('CTP_'+i).checked == true){
											selecionados = selecionados + document.getElementById('CTP_'+i).value+',';
										}
									}

									$.ajax({
											url: "ajxCompararPropostas.php",
											global: false,
											type: "GET",
											data: ({CTC_ID: $('#CTC_ID').val(), SELECIONADOS: selecionados}),
											dataType: "html",
											success: function(data){
												document.getElementById('comparar').innerHTML = data;
											}
									 });
								}
							</script>
                            <div class="contentTable">
                              <h4>SELECIONE ACIMA AS PROPOSTAS QUE DESEJA COMPARAR</h4>
                              <div id="comparar">

                              </div>
                            </div>
                            <input type="hidden" name="PropostasPedido" id="PropostasPedido" value="1" />
                        <?php
						}else{
						?>
							        <div class="alert alert-error">
										Não existem propostas para este pedido
                                        <input type="hidden" name="PropostasPedido" id="PropostasPedido" value="0" />
									</div>
                        <?php
						}
						?>
                    </p>
                 	 <div>
                 </div>
                 </div>



                 	<!--<div class="span3">



                </div>-->
			 </div>



            <div id="myProposta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Fazer Proposta</h3>
        </div>
        <div class="modal-body">
      		<script src="templates/agente/js/jquery.price_format.js"></script>
            <script>
				$(document).ready(function(){
					$('#Salvar').click(function(){
						var erro = valida();
						if (erro != false){
							$.ajax({
								url: "ajxCadastraProposta.php",
								global: false,
								type: "GET",
								data: ({CPP_TITULO: $('#CPP_TITULO').val(), CPP_DESCRICAO: $('#CPP_DESCRICAO').val(), CPP_VALOR: $('#CPP_VALOR').val(), CPP_OBS: $('#CPP_OBS').val(), CTC_ID: $('#CTC_ID').val(), USR_ID: $('#USR_ID').val()}),
								dataType: "html",
								success: function(data){
									/*document.getElementById('formulario').style.display = 'none';
									document.getElementById('retorno').style.display = 'block';
									if (data == 1){
										document.getElementById('sucesso').style.display = 'block';
									}else if (data == 3){
										document.getElementById('cotacao').style.display = 'block';
									}else{
										document.getElementById('erro').style.display = 'block';
									}*/
									$('#fechar').click();
									document.location.href ="index.php?pg=4&CTC_ID="+$('#CTC_ID').val()+"&msgTxt=1";
								}
							 });
						}
					});
					$('#CPP_VALOR').priceFormat({
						prefix: '',
						centsSeparator: ',',
						thousandsSeparator: '.',
						limit: 8
					});
				});
				function valida(){
					if ($('#CPP_TITULO').val() == ''){
						alert ('O campo Título é obrigatório!');
						return false;
					}
					if ($('#CPP_VALOR').val() == ''){
						alert ('O campo Valor é obrigatório!');
						return false;
					}


				}


			</script>

            	<div id="formulario">
                    <form method="post" name="Usuario" action="cCadastroCliente.php">
                        <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>" />
                        <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>" />
                        <input type="hidden" name="pg" id="pg" value="5" />
                        <fieldset class="left30">
                        <label>Título</label>
                        <input type="text" class="input-xlarge" name="CPP_TITULO" id="CPP_TITULO">
                        <label>Descrição</label>
                        <textarea class="input-xlarge" name="CPP_DESCRICAO" id="CPP_DESCRICAO"></textarea>
                        <label>Valor Total da Proposta</label>
                        <input class="input-xlarge" type="text" name="CPP_VALOR" id="CPP_VALOR">
                        <label>Observações</label>
                        <textarea class="input-xlarge" name="CPP_OBS" id="CPP_OBS"></textarea>
                        <label></label>
                        <button type="button" id="Salvar" name="Salvar" class="btn btn-primary">Enviar Proposta</button>
                        </fieldset>
                    </form>
                 </div><!--Fecha div do Formulario-->

        </div>
    </div>
           <?php
		   		}
			}else{
			?>
            	<div>
                	<div class="alert alert-error">
                		Esta cotação não existe
                    </div>
                </div>
            <?php
			}
			?>


</div>
<script>
	function verifyMostraFornecedor (ID){
		for (i = 1; i < $('#CONTADOR').val(); i++){
			document.getElementById('Fornecedor_'+i).style.display = 'none';
		}

		if (ID != 'x'){
			document.getElementById('Fornecedor_'+ID).style.display = 'block';
		}
	}

	function validaEscolhaFornecedor(){
		if ($('#PropostasPedido').val() == 0){
			alert ('Não existem propostas para este pedido!');
			return false;
		}
		if ($('#SELECIONAR_FORNECEDOR').val() == 'x'){
			alert ('Você deve selecionar um fornecedor!');
			$('#SELECIONAR_FORNECEDOR').focus();
			return false;
		}

		if (document.getElementById('CONTATOEMAIL').checked == false && document.getElementById('CONTATOTELEFONE').checked == false && document.getElementById('CONTATOCELULAR').checked == false){
			alert ('Você precisa selecionar como quer ser contactado!');
			return false;
		}
	}
</script>
<div id="myEscolher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Escolher Fornecedor</h3>
        </div>
        <div class="modal-body">
        <form name="EscolherFornecedorForm" id="EscolherFornecedorForm" method="post" action="cEscolherFornecedor.php" onsubmit="return validaEscolhaFornecedor();">
        <input type="hidden" name="pg" id="pg" value="5" />
        <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
        <p>Selecione o fornecedor:
        <select name="SELECIONAR_FORNECEDOR" id="SELECIONAR_FORNECEDOR" onchange="verifyMostraFornecedor(this.value)">
        	<option value="x">Selecione ...</option>
        	<?php echo ($optionSelectFornecedor); ?>
        </select>
        </p>
        <p><?php echo ($DivsFornecedor); ?></p>
        <?php echo ($CONTADOR); ?>
        <p>
        	<strong>Como você quer ser contactado?</strong>
        </p>
        <p>
        	<input type="checkbox" name="CONTATOEMAIL" id="CONTATOEMAIL" value="1" /> E-mail
        </p>
        <p>
        	<input type="checkbox" name="CONTATOTELEFONE" id="CONTATOTELEFONE" value="1" /> Telefone Residencial
        </p>
        <p>
        	<input type="checkbox" name="CONTATOCELULAR" id="CONTATOCELULAR" value="1" /> Telefone Celular
        </p>
        <p>
        	<button type="submit" id="EnviarEscolha" name="EnviarEscolha" class="btn btn-primary">Enviar</button>
        </p>
        </form>
        </div>
</div>
<script>
	function AvaliarFornecedor(){
		if ($('#NOTA').val() == 'x'){
			alert ('Selecione a nota!');
			$('#NOTA').focus();
			return false;
		}
		if ($('#COMENTARIOAVALIACAO').val() == ''){
			alert ('Digite um comentário!');
			$('#COMENTARIOAVALIACAO').focus();
			return false;
		}
	}
</script>
<div id="myAvaliar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Avaliar Fornecedor</h3>
            <?php
            $Option = NULL;
            // Busco todos os fornecedores
            $uhQry = mysql_query ("SELECT * FROM tb_cotacao_proposta A
            INNER JOIN tb_usuario B ON A.USR_ID = B.USR_ID WHERE CTC_ID = '$CTC_ID'");
            if (mysql_num_rows ($uhQry) > 0){
            ?>
             	<?php
	            while ($huQry = mysql_fetch_array ($uhQry)){
	            	// Verifico se já fez avaliação
					$mQry = mysql_query ("SELECT * FROM tb_avaliacao WHERE CTC_ID = '$CTC_ID'
					AND AVL_AVALIADO = '$huQry[USR_ID]'");

					if (mysql_num_rows($mQry) > 0){
					}else{

						$Option .= "<option value='$huQry[USR_ID]'>".utf8_encode($huQry['USR_NOME'])."</option>";
					}
	            }

				?>
            	<form name="AvaliarFornecedorSelecionado" id="AvaliarFornecedorSelecionado" method="post" action="cAvaliarFornecedor.php" onsubmit="return AvaliarFornecedor();">
	            	<input type="hidden" name="pg" id="pg" value="5" />
	            	<input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
	                <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
	                <br />
	                <p><strong>Fornecedor:</strong> </p>
	                <p>
	                	<select name="FORNECEDOR" FORNECEDOR="NOTA">
	                    	<?php echo ($Option); ?>
	                    </select>
	            	</p>
	                <p><strong>Nota:</strong> </p><p>
	                	<select name="NOTA" id="NOTA">
	                    	<option value="x">Escolha uma nota</option>
	                        <option value="1">1</option>
	                        <option value="2">2</option>
	                        <option value="3">3</option>
	                        <option value="4">4</option>
	                        <option value="5">5</option>
	                    </select>
	                </p>
	                <p><strong>Comentário:</strong></p><p>
	                <textarea rows="5" style="width:60%" name="COMENTARIOAVALIACAO" id="COMENTARIOAVALIACAO" placeholder="Insira um Comentário"></textarea></p>
	                <p><button class="btn btn-primary" type="submit">Enviar Avaliação</button></p>
	            </form>


	      	<?php
			}else{
				?>
				<div class="alert alert-block">
	                    Não existem fornecedores para avaliar!
	                </div>
			<?php
			}
			?>
        </div>
        <div class="modal-body">

        </div>
</div>
<script>
    function AvaliarCancelamento(){
        if ($('#MOTIVOCANCELAMENTO').val() == ''){
            alert ('O campo MOTIVO DO CANCELAMENTO é obrigatório!');
            $('#MOTIVOCANCELAMENTO').focus();
            return false;
        }
    }
</script>
<div id="myCancelar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Cancelar Pedido</h3>
            
            	<form name="CancelarPedidoCotacao" id="CancelarPedidoCotacao" method="post" action="cCancelarPedido.php" onsubmit="return AvaliarCancelamento();">
	            	<input type="hidden" name="pg" id="pg" value="5" />
	            	<input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
	                <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
                        <?php
                            $Resultado = $oCriarDestinoDAO->pegaPrecoLead($CTC_ID);
                        ?>
                        <input type="hidden" name="PRECOLEAD" id="PRECOLEAD" value="<?php echo ($Resultado); ?>"  />
	                <br />
	                
	                <p><strong>Motivo do cancelamento:</strong></p><p>
	                <textarea rows="5" style="width:60%" name="MOTIVOCANCELAMENTO" id="MOTIVOCANCELAMENTO" placeholder="Insira o motivo do cancelamento"></textarea></p>
	                <p><button class="btn btn-primary" type="submit">Confirmar Cancelar</button></p>
	            </form>	    
        </div>
        <div class="modal-body">

        </div>
</div>

<script>
	function escolherFornecedor (){
		$('#escolherFornecedor').click();
	}
	function avaliarFornecedor (){
		$('#avaliarFornecedor').click();
	}
	function visualizarFornecedor(){
		$('#fornecedorSelecionado').click();
	}
        function cancelarPedido (){
		$('#cancelarPedido').click();
	}
</script>

<div class="span4 colRight">

	<div style="visibility:hidden; display:none"><a href="#myProposta" role="button" id="fazerProposta"  data-toggle="modal"> Fazer Proposta</a></div>
    <div style="visibility:hidden"><a href="#myEscolher" role="button" id="escolherFornecedor"  data-toggle="modal"> Fazer Proposta</a></div>
    <div style="visibility:hidden"><a href="#myAvaliar" role="button" id="avaliarFornecedor"  data-toggle="modal"> Fazer Proposta</a></div>
    <div style="visibility:hidden"><a href="#myCancelar" role="button" id="cancelarPedido"  data-toggle="modal"> Fazer Proposta</a></div>

    <?php
		if ($CTC_STATUS == "1"){
	?>
        <p align="center"><button class="btn btn-primary btn-large" onclick='escolherFornecedor();' type="button">Escolher Fornecedor e Encerrar</button></p>
        <p align="center"><button class="btn btn-primary btn-large" onclick='cancelarPedido();' type="button">Cancelar Pedido</button>
    <?php
		}else if ($CTC_STATUS == "2"){
	?>
    		<div style="visibility:hidden; display:none"><a href="#mySelecionado" role="button" id="fornecedorSelecionado"  data-toggle="modal"> Selecionado</a></div>

        	<p align="center"><button class="btn btn-primary btn-large" onclick='visualizarFornecedor();' type="button">Fornecedor Selecionado</button>
    		</p>

            <div id="mySelecionado" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel">Fornecedor Selecionado</h3>
            </div>
            <div class="modal-body">
            	<?php echo ($FornecedorSelecionado); ?>
            </div>
    </div>
          

    <?php
		}
	?>
	<p align="center"><button class="btn btn-primary btn-large" onclick='avaliarFornecedor();' type="button">Avaliar Fornecedor</button>

    <p>
    	<script>
			function validaEnviaPergunta(){
				if ($('#PropostasPedido').val() == 0){
					alert ('Não existem propostas para este pedido!');
					return false;
				}
				if ($('#STATUS_COTACAO').val() != 1){
					alert ('A cotação foi encerrada! Você não pode mais enviar perguntas');
					return false;
				}
				if ($('#USR_ID_PARA').val() == 'x'){
					alert ('Você precisar selecionar o fornecedor!');
					$('#USR_ID_PARA').focus();
					return false;
				}
				if ($('#PERGUNTA').val() == ''){
					alert ('O campo PERGUNTA é obrigatório!');
					$('#PERGUNTA').focus();
					return false;
				}

			}
		</script>


    	<form name="EnviarPergunta" id="EnviarPergunta" method="post" action="cEnviarPergunta.php" onsubmit="return validaEnviaPergunta();">
        <input type="hidden" name="pg" id="pg" value="5" />
        <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
        <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
    	<select style="width:100%" name="USR_ID_PARA" id="USR_ID_PARA">
    		<option value="x">Comentário / Pergunta Para:</option>
            <option value="T">Todos</option>
            <?php echo ($optionSelect); ?>
    	</select>
        <textarea style="width:100%" name="PERGUNTA" id="PERGUNTA" placeholder="Escreva aqui sua pergunta ou comentário"></textarea>

    </p>
    <p>
        <button class="btn btn-primary" style="width:100%" onclick='fazerProposta();' type="submit">Enviar Pergunta</button>
        </form>
    </p>

    <div>
    	<h4>Perguntas enviadas</h4>

        <?php
			// Verifico se existe pergunta
			$zQry = mysql_query ("SELECT * FROM tb_cotacao_pergunta a INNER JOIN tb_usuario b
			ON a.USR_ID_PARA = b.USR_ID WHERE CTC_ID = '$CTC_ID' AND
			USR_ID_DE = '$_SESSION[USR_ID]'");
			if (mysql_num_rows($zQry) > 0){
				while ($xQry = mysql_fetch_array ($zQry)){
					?>


                    <p><strong>
                    <div class="accordion-group">
                       <div class="accordion-heading">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo ($xQry['CPR_ID']); ?>">
                          <p><strong>Para: </strong><?php
						echo (utf8_encode ($xQry['USR_NOME']));
					?>
                    </p>
                    <?php
					echo (utf8_encode ($xQry['CPR_PERGUNTA']));
					?>
                    </strong></p></a></div>

                    <?php
						// Verifico se existe resposta
						$poQry = mysql_query ("SELECT * FROM tb_cotacao_pergunta_resposta
						WHERE CPR_ID = '$xQry[CPR_ID]' ORDER BY CPR_ID DESC");
						if (mysql_num_rows($poQry) > 0){
						?>
                        <div id="collapse<?php echo ($xQry['CPR_ID']); ?>" class="accordion-body collapse">
                        		<div class="accordion-inner">
                        <?php
							while ($ooQry = mysql_fetch_array ($poQry)){
								if ($ooQry['USR_ID_DE'] == $_SESSION["USR_ID"]){
									$background = "#DBF0F2";
								}else{
									$background = "#FFFFCC";
								}
							?>
                                <p style="background-color:<?php echo ($background); ?>">

                                <?php
                                    echo (utf8_encode ($ooQry['CPT_RESPOSTA']));
                                ?>
                                </p>
                                <?php
							}
							?>
						<script>
							function validaResposta (CPR_ID){
								if ($('#STATUS_COTACAO').val() != 1){
									alert ('A cotação foi encerrada! Você não pode mais enviar perguntas');
									return false;
								}
								if ($('#RESPONDER_'+CPR_ID).val() == ''){
									alert ('Você precisa digitar uma resposta');
									$('#RESPONDER_'+CPR_ID).focus();
									return false;
								}
							}
						</script>
                        <form name="RESPONDERPERGUNTA" id="RESPONDERPERGUNTA" method="post" action="cResponderPergunta.php" onsubmit="return validaResposta(<?php echo ($xQry['CPR_ID']); ?>)">
                        	<input type="hidden" name="pg" id="pg" value="5" />
                            <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
                            <input type="hidden" name="USR_ID_PARA" id="USR_ID_PARA" value="<?php echo ($xQry['USR_ID_PARA']); ?>"  />
                            <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
                            <input type="hidden" name="CPR_ID" id="CPR_ID" value="<?php echo ($xQry['CPR_ID']); ?>"  />
                            <input type="text" name="RESPONDER_<?php echo ($xQry['CPR_ID']); ?>" id="RESPONDER_<?php echo ($xQry['CPR_ID']); ?>" style="width:100%" placeholder="Responder">
                        </form>
                       </div>
                     </div>
                    <?php
						}else{
							?>
                            <div id="collapse<?php echo ($xQry['CPR_ID']); ?>" class="accordion-body collapse">
                        		<div class="accordion-inner">
                                	Não existem respostas
                                </div>
                            </div>
                            <?php
						}
					?>
                   </div>
                    <?php
				}
			}else{
				?>
                <strong>Não existem perguntas</strong>
                <?php
			}
		?>
    </div>

</div>
</div>


