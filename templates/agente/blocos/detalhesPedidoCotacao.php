<script>
	function fazerProposta(){
		document.getElementById('fazerProposta').click();
	}
</script>
<div class="span6"><br /><br />
<?php
					$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
					if (  $msgTxt == 1){
				?>
						<div class="alert alert-success">
							Proposta realizada com sucesso!
						</div>
				<?php
					}else if($msgTxt == 2){
       			 ?>
		                <div class="alert alert-success">
		                    Resposta enviada com sucesso!
		                     <button type="button" class="close" data-dismiss="alert">&times;</button>
		                </div>

        		<?php
           			 }else if($msgTxt == 4){
				?>
                		<div class="alert alert-success">
		                    Avaliação enviada com sucesso!
		                     <button type="button" class="close" data-dismiss="alert">&times;</button>
		                </div>
                <?php
					}else if($msgTxt == 5){
				?>
                		<div class="alert alert-success">
		                    Proposta atualizada com sucesso!
		                     <button type="button" class="close" data-dismiss="alert">&times;</button>
		                </div>
                 <?php
				 	}else if($msgTxt == 6){
				?>
                                <div class="alert alert-success">
		                    Lead comprado com sucesso!
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
    	<?php


			$CTC_ID = ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
			$USUARIO_COTACAO = NULL;

            $hQry = mysql_query ("SELECT * FROM tb_cotacao WHERE CTC_ID = '$CTC_ID'");
			if (mysql_num_rows($hQry) > 0){
				while ($jQry = mysql_fetch_array ($hQry)){
					$CTC_STATUS = $jQry['CTC_STATUS'];
					$USUARIO_COTACAO = $jQry['USR_ID'];

			?>

				<input type="hidden" name="STATUS_COTACAO" id="STATUS_COTACAO" value="<?php echo ($jQry['CTC_STATUS']); ?>">

             <div class="span6 line borderTop">
             	<?php
				if ($CTC_STATUS == "2"){
					// verifico se foi vencedor
                    $qrQry = mysql_query ("SELECT * FROM tb_cotacao_proposta
                    WHERE USR_ID = '$_SESSION[USR_ID]' AND CPP_STATUS = '3'");
					if (mysql_num_rows ($qrQry) > 0){
				?>
                		<span class="span8">
			                <strong><font color='green'>Sua proposta foi aceita</font></strong>
			            </span>
                <?php
					}else{
				?>
                		<span class="span8">
			             	    <strong><font color='red'>Sua proposta não foi aceita</font></strong>
			             </span>
                <?php
					}
				}
				?>
				 <span class="span8">
                 
                 </span>
                 <fieldset class="span5">
                     <legend>Informações do Pedido</legend>
             	 <div class="span3"><strong>Data de Crição:</strong> <?php
					$DIA = substr ($jQry['CTC_DATA'],8,2);
					$MES = substr ($jQry['CTC_DATA'],5,2);
					$ANO = substr ($jQry['CTC_DATA'],0,4);
					echo ($DIA.'/'.$MES.'/'.$ANO); ?></div>
           		 <div class="span3"><strong>Última Atualização:</strong> <?php
					$DIA = substr ($jQry['CTC_DATA'],8,2);
					$MES = substr ($jQry['CTC_DATA'],5,2);
					$ANO = substr ($jQry['CTC_DATA'],0,4);
					echo ($DIA.'/'.$MES.'/'.$ANO); ?></div>
                 <span class="span8">
                 	<?php

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

					?>
                 	<strong>Desejo:</strong> <?php echo ($Desejo); ?>
                 </span>
                 <span class="span8">
                 	<?php
						if ($jQry['CTC_PASSAGEM'] == 1){
							$Passagem = "Ida e Volta";
						}else{
							$Passagem = "Somente Ida";
						}
					?>
                 	<strong>Passagem:</strong> <?php echo ($Passagem); ?>
                 </span>
                 <span class="span8">
                 	<?php echo ("<strong>De:</strong> ".$jQry["CTC_DE"]);?>
                 </span>
                 <span class="span8">
                	<?php echo ("<strong>Para:</strong> ".$jQry["CTC_PARA"]);?>

                </span>
		<span class="span8">
                	<?php echo ("<strong>Qtde de Noites:</strong> ".$jQry["CTC_QTD_NOITES"]);?>

                </span>
                <span class="span8">
                <strong>Data de Partida: </strong>
                <?php
					if ($jQry['CTC_PARTIDA_DIA'] == 0){
						echo ("Não definido/");
					}else{
						echo $jQry['CTC_PARTIDA_DIA'].'/';
					}
					echo $jQry['CTC_PARTIDA_MES'].'/'.$jQry['CTC_PARTIDA_ANO'];
				?>
                </span>
                <div class="span3"><strong>Data de Volta:</strong> <?php
					echo $oUtil->codificadata ($jQry['CTC_DATA_VOLTA']); ?></div>
           		 <div class="span4"><strong>Datas Flexíveis:</strong> <?php
					if ($jQry['CTC_DATA_FLEXIVEIS'] == "1"){
						echo ("Sim");
					}else{
						echo ("Não");
					} ?>
                 </div>
                 <span class="span8">
                 	<strong>Adultos:</strong> <?php echo ($jQry['CTC_ADULTOS']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>De 0 a 23 meses:</strong> <?php echo ($jQry['CTC_ZERO_TRES']); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Crianças de 2 a 12 anos:</strong> <?php echo ($jQry['CTC_CRIANCAS']); ?>
                 </span>
                 <span class="span8">
                 	<?php
						if ($jQry['CTC_OBS'] != NULL){
							echo ("<strong>Observações: </strong>". utf8_encode ($jQry['CTC_OBS']));
						}
					?>
                 </span>
                 </fieldset>
                 <fieldset class="span5">
                     <legend>Propostas Recebidas</legend>
                     <span class="span8">
                         <?php
                            $nQry = mysql_query ("SELECT * FROM tb_log WHERE CTC_ID = '$CTC_ID' AND USR_ID = '$_SESSION[USR_ID]'");
                            if (mysql_num_rows($nQry) > 0){
                               $ComprouLead = 1;
                            }else{
                               $ComprouLead = 0;
                            }
                            // Busco o número de propostas
                            $ljQry = mysql_query ("SELECT COUNT(*) AS NUMERO FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'");   
                            $llQry = mysql_fetch_array ($ljQry);
                            
                            if ($llQry['NUMERO'] > 0){
                                
                                ?>
                                <div class="alert"><?php echo ($llQry['NUMERO']); ?> proposta(s) recebida(s)</div>
                                <?php
                                // Verifico se usuário comprou lead
                                if ($ComprouLead == 0){
                                    ?>
                                        <div class="alert">Para visualizar os dados das propsotas é necessário comprar o lead</div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="accordion" id="accordion2">
                                    <?php
                                    $i = 1;
                                    // Busco as propostas
                                    $qwQry = mysql_query ("SELECT * FROM tb_cotacao_proposta A INNER JOIN tb_usuario B
                                        ON A.USR_ID = B.USR_ID INNER JOIN tb_cotacao C ON A.CTC_ID = C.CTC_ID WHERE A.CTC_ID = '$CTC_ID'");
                                    while ($wwQry = mysql_fetch_array ($qwQry)){
                                         $VALORES = NULL;
                                         $VALOR = NULL;
                                         if($wwQry['CTC_AEREO'] == "1"){
                                             $VALOR += $wwQry['CPP_TOTAL_AEREO'];
                                             $wwQry['CPP_TOTAL_AEREO'] = number_format ($wwQry['CPP_TOTAL_AEREO'],2,',','.');
                                             $VALORES = "<p><strong>Valor Aéreo:</strong> R$ $wwQry[CPP_TOTAL_AEREO]";
                                         }
                                         if($wwQry['CTC_HOTEL'] == "1"){
                                            $VALOR += $wwQry['CPP_TOTAL_HOTEL'];
                                            $wwQry['CPP_TOTAL_HOTEL'] = number_format ($wwQry['CPP_TOTAL_HOTEL'],2,',','.');
                                            $VALORES .= "<p><strong>Valor Hotel:</strong> R$ $wwQry[CPP_TOTAL_HOTEL]"; 
                                         }
                                         if($wwQry['CTC_ALUGUEL'] == "1"){
                                             $VALOR += $wwQry['CPP_TOTAL_ALUGUEL'];
                                             $wwQry['CPP_TOTAL_ALUGUEL'] = number_format ($wwQry['CPP_TOTAL_ALUGUEL'],2,',','.');
                                             $VALORES .= "<p><strong>Valor Aluguel:</strong> R$ $wwQry[CPP_TOTAL_ALUGUEL]";
                                         }
                                         if($wwQry['CTC_ATIVIDADE'] == "1"){
                                             $VALORES .= "";
                                         }
                                         $VALOR = "R$ ". number_format ($VALOR,2,',','.');
                                         
                                         $qpQry = mysql_query ("SELECT COUNT(*) AS RECEBIDAS FROM tb_avaliacao 
                                         WHERE AVL_AVALIADO = '$wwQry[USR_ID]'");
                                         $pqQry = mysql_fetch_array ($qpQry);
                                         
                                         $wpQry = mysql_query ("SELECT COUNT(*) AS FECHADOS FROM tb_cotacao_proposta 
                                         WHERE USR_ID = '$wwQry[USR_ID]' AND CPP_STATUS = '3'");
                                         $pwQry = mysql_fetch_array ($wpQry);
                                         
                                         $epQry = mysql_query ("SELECT AVG(AVL_NOTA) AS MEDIA FROM tb_avaliacao 
                                         WHERE AVL_AVALIADO = '$wwQry[USR_ID]'");
                                         $peQry = mysql_fetch_array ($epQry);
                                         if ($peQry['MEDIA'] == NULL){
                                                 $peQry['MEDIA'] = 0;
                                         }
				
                                         
                                    ?>
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo ($i); ?>">
                                                Proposta <?php echo ($i); ?>
                                                </a>
                                            </div>
                                            <div id="collapse<?php echo ($i); ?>" class="accordion-body collapse">
                                                <div class="accordion-inner">
                                                <p><strong>Nome do agente:</strong> <?php echo (utf8_encode ($wwQry['USR_NOME'])); ?></p>
                                                <p><strong>Data de criação da proposta:</strong> <?php echo ($oUtil->codificadata($wwQry['CPP_DATA'])); ?></p>
                                                <p><strong>Descrição da oferta:</strong> <?php echo (utf8_encode ($wwQry['CPP_OBSERVACOES'])); ?></p>
                                                <?php echo ($VALORES); ?>
                                                <p><strong>Valor Total da Proposta:</strong> <?php echo ($VALOR); ?></p>
                                                <p><strong>Score total do Agente:</strong> <?php echo (round($peQry['MEDIA'])); ?></p>
                                                <p><strong>Quantidade de avaliações que o Agente recebeu:</strong> <?php echo ($pqQry['RECEBIDAS']); ?></p>
                                                <p><strong>Quantidade de Negócios Fechados no site:</strong> <?php echo ($pwQry['FECHADOS']); ?></p>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                    </div>
                                    <?php
                                    
                                }
                            }else{
                                ?>
                                <div class="alert">Nenhuma proposta recebida</div>
                                <?php
                            }
                         ?>
                     </span>
                 </fieldset>
             </div>



            <div id="myProposta" class="modal1 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Fazer Proposta</h3>
        </div>
        <div class="modal-body" style="max-height:490px">
      		<script src="templates/agente/js/jquery.price_format.js"></script>
            <script>
				function mascaraData(campoData, campo){
					  var data = campoData.value;
					  if (data.length == 2){
						  data = data + '/';
						  document.getElementById(campo).value = data;
			 			 return true;              
					  }
					  if (data.length == 5){
						  data = data + '/';
						  document.getElementById(campo).value = data;
					  }
				 }
				$(document).ready(function(){
				
					/*$('#Salvar').click(function(){
						var erro = validaFormularioProposta();
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
									/*$('#fechar').click();
									document.location.href ="index.php?pg=4&CTC_ID="+$('#CTC_ID').val()+"&msgTxt=1";
								}
							 });
						}
					});*/
                                        
					
					
					if ($('#CTC_AEREO').val() == 1){
						$('#CPP_VALOR_PASSAGEM').priceFormat({
							prefix: '',
							centsSeparator: ',',
							thousandsSeparator: '.',
							limit: 8
						});
						$('#CPP_VALOR_TAXA').priceFormat({
							prefix: '',
							centsSeparator: ',',
							thousandsSeparator: '.',
							limit: 8
						});
						$('#CPP_TOTAL_AEREO').priceFormat({
							prefix: '',
							centsSeparator: ',',
							thousandsSeparator: '.',
							limit: 8
						});
					}
					if ($('#CTC_HOTEL').val() == 1){
						$('#CPP_TOTAL_HOTEL').priceFormat({
							prefix: '',
							centsSeparator: ',',
							thousandsSeparator: '.',
							limit: 8
						});
						$('#CPP_HOTEL_MEDIA_DIARIA').priceFormat({
							prefix: '',
							centsSeparator: ',',
							thousandsSeparator: '.',
							limit: 8
						});
					}
					if ($('#CTC_ALUGUEL').val() == 1){
						$('#CPP_TOTAL_ALUGUEL').priceFormat({
							prefix: '',
							centsSeparator: ',',
							thousandsSeparator: '.',
							limit: 8
						});
					}
				});
				function validaFormularioProposta(){
                                        var erroLead = 0;
                                        if ($('#ComprouLead').val() == 0){
                                               if($('#LeadsUsuario').val() < $('#QTD_LEADS').val()){
                                                    alert ('Você não tem pontos suficientes para comprar o lead!');
                                                }else{
                                                    erroLead = 1;
                                                    $('#LeadComprou').val(1);
                                                }
                                        }else{
                                            erroLead = 2;
                                            $('#LeadComprou').val(2);
                                        }    
                                        
                                        if (erroLead == 1 || erroLead == 2){
                                            if ($('#CTC_AEREO').val() == 1){
                                                    for (i = 1; i <= $('#ContadorTrechos').val(); i++){
                                                            if ($('#CPP_TRECHO_SIGLA'+i).val() == ''){
                                                                    alert ('O campo SIGLA é obrigatório!');
                                                                    $('#liaereo').click();
                                                                    $('#CPP_TRECHO_SIGLA'+i).focus();
                                                                    return false;
                                                            }
                                                            if ($('#CPP_TRECHO_COMPANIA'+i).val() == ''){
                                                                    alert ('O campo COMPANIA é obrigatório!');
                                                                    $('#liaereo').click();
                                                                    $('#CPP_TRECHO_COMPANIA'+i).focus();
                                                                    return false;
                                                            }
                                                            if ($('#CPP_TRECHO_PARTIDA'+i).val() == ''){
                                                                    alert ('O campo PARTIDA é obrigatório!');
                                                                    $('#liaereo').click();
                                                                    $('#CPP_TRECHO_PARTIDA'+i).focus();
                                                                    return false;
                                                            }
                                                            if ($('#CPP_TRECHO_DEPARA'+i).val() == ''){
                                                                    alert ('O campo DE / PARA é obrigatório!');
                                                                    $('#liaereo').click();
                                                                    $('#CPP_TRECHO_DEPARA'+i).focus();
                                                                    return false;
                                                            }
                                                            if ($('#CPP_TRECHO_SAIDA'+i).val() == ''){
                                                                    alert ('O campo SAIDA é obrigatório!');
                                                                    $('#liaereo').click();
                                                                    $('#CPP_TRECHO_SAIDA'+i).focus();
                                                                    return false;
                                                            }
                                                            if ($('#CPP_TRECHO_CHEGADA'+i).val() == ''){
                                                                    alert ('O campo CHEGADA é obrigatório!');
                                                                    $('#liaereo').click();
                                                                    $('#CPP_TRECHO_CHEGADA'+i).focus();
                                                                    return false;
                                                            }

                                                    } 
                                                    if ($('#CPP_VALOR_PASSAGEM').val() == ''){
                                                            alert ('O campo VALOR PASSAGEM é obrigatório!');
                                                            $('#liaereo').click();
                                                            $('#CPP_VALOR_PASSAGEM').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_VALOR_TAXA').val() == ''){
                                                            alert ('O campo TAXA é obrigatório!');
                                                            $('#liaereo').click();
                                                            $('#CPP_VALOR_TAXA').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_TOTAL_AEREO').val() == ''){
                                                            alert ('O campo TOTAL AÉREO é obrigatório!');
                                                            $('#liaereo').click();
                                                            $('#CPP_TOTAL_AEREO').focus();
                                                            return false;
                                                    }
                                            }
                                            if ($('#CTC_HOTEL').val() == 1){
                                                     //  CPP_HOTEL_CLASSIFICACAO 
                                                    if ($('#CPP_HOTEL').val() == ''){
                                                            alert ('O campo HOTEL é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_HOTEL_LINK').val() == ''){
                                                            alert ('O campo LINK é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL_LINK').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_HOTEL_ENDERECO').val() == ''){
                                                            alert ('O campo ENDEREÇO é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL_ENDERECO').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_HOTEL_CHECKIN').val() == ''){
                                                            alert ('O campo CHECK-IN é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL_CHECKIN').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_HOTEL_QTD_NOITES').val() == ''){
                                                            alert ('O campo QTD NOITES é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL_QTD_NOITES').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_HOTEL_CHECKOUT').val() == ''){
                                                            alert ('O campo CHECK-OUT é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL_CHECKOUT').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_HOTEL_MEDIA_DIARIA').val() == ''){
                                                            alert ('O campo MÉDIA DI�?RIA é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_HOTEL_MEDIA_DIARIA').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_TOTAL_HOTEL').val() == ''){
                                                            alert ('O campo TOTAL HOTEL é obrigatório!');
                                                            $('#lihotel').click();
                                                            $('#CPP_TOTAL_HOTEL').focus();
                                                            return false;
                                                    }
                                            }
                                            if ($('#CTC_ALUGUEL').val() == 1){
                                                    if ($('#CPP_ALUGUEL_LOCADORA').val() == ''){
                                                            alert ('O campo LOCADORA é obrigatório!');
                                                            $('#lialuguel').click();
                                                            $('#CPP_ALUGUEL_LOCADORA').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_ALUGUEL_RETIRADA').val() == ''){
                                                            alert ('O campo RETIRADA é obrigatório!');
                                                            $('#lialuguel').click();
                                                            $('#CPP_ALUGUEL_RETIRADA').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_ALUGUEL_DIARIAS').val() == ''){
                                                            alert ('O campo DI�?RIAS é obrigatório!');
                                                            $('#lialuguel').click();
                                                            $('#CPP_ALUGUEL_DIARIAS').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_ALUGUEL_DEVOLUCAO').val() == ''){
                                                            alert ('O campo DEVOLUÇÃO é obrigatório!');
                                                            $('#lialuguel').click();
                                                            $('#CPP_ALUGUEL_DEVOLUCAO').focus();
                                                            return false;
                                                    }  
                                                    if ($('#CPP_ALUGUEL_ENTREGA').val() == ''){
                                                            alert ('O campo ENTREGA é obrigatório!');
                                                            $('#lialuguel').click();
                                                            $('#CPP_ALUGUEL_ENTREGA').focus();
                                                            return false;
                                                    }
                                                    if ($('#CPP_TOTAL_ALUGUEL').val() == ''){
                                                            alert ('O campo TOTAL ALUGUEL é obrigatório!');
                                                            $('#lialuguel').click();
                                                            $('#CPP_TOTAL_ALUGUEL').focus();
                                                            return false;
                                                    }
                                            }
                                            
                                            if (erroLead == 1){
                                                if (!confirm ('Você ainda não comprou o lead. Ao fazer fazer a proposta está comprando o lead. Tem certeza que deseja fazer a proposta?')){
                                                    return false;
                                                }
                                            }
                                            
                                        } 
					
				}
				
				function abreTrecho (trecho){
					document.getElementById('tabelaTrecho'+trecho).style.display = 'block';
					document.getElementById('ContadorTrechos').value = trecho;
				}
				
				function fechaTrecho (trecho){
					if (trecho >= 2 && trecho != 4){
						document.getElementById('tabelaTrecho3').style.display = 'none';
						document.getElementById('tabelaTrecho4').style.display = 'none';
					}
					document.getElementById('ContadorTrechos').value = parseInt (trecho) - 1;
					document.getElementById('tabelaTrecho'+trecho).style.display = 'none';
				}
				
				function alterarTotalAerero (Total){
					document.getElementById('CPP_AEREO_TOTAL').value = Total;
				}
				function alterarTotalHotel (Total){
					document.getElementById('CPP_HOTEL_TOTAL').value = Total;
				}
				function alterarTotalCarro (Total){
					document.getElementById('CPP_ALUGUEL_TOTAL').value = Total;
				}


			</script>
            	<div id="formulario">
                    <form method="post" name="Usuario" action="cCadastroProposta.php" onsubmit="return validaFormularioProposta();">
                        <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>" />
                        <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>" />
                        <input type="hidden" name="ContadorTrechos" id="ContadorTrechos" value="1" />
                        <input type="hidden" name="LeadComprou" id="LeadComprou" value="0" />
                        <fieldset class="left30">
                            <div class="tabbable"> <!-- Only required for left/right tabs -->
                                <ul class="nav nav-tabs">
                                <?php
									// Verifico os itens para criar as tabs
									$qqQry = mysql_query ("SELECT * FROM tb_cotacao WHERE CTC_ID = '$CTC_ID'");
									$wwQry = mysql_fetch_array ($qqQry);
									if ($wwQry['CTC_AEREO'] == 1){
										?>
                                        <li class="active"><a href="#tab1" data-toggle="tab" id="liaereo">Aéreo</a></li>
                                        <?php
									}
									if ($wwQry['CTC_HOTEL'] == 1){
										?>
                                        <li><a href="#tab2" data-toggle="tab" id="lihotel">Hotel</a></li>
                                        <?php
									}
									if ($wwQry['CTC_ALUGUEL'] == 1){
										?>
                                        <li><a href="#tab3" data-toggle="tab" id="lialuguel">Aluguel</a></li>
                                        <?php
									}
									if ($wwQry['CTC_ATIVIDADE'] == 1){
										?>
                                        <li><a href="#tab4" data-toggle="tab" id="liatividade">Atividade</a></li>
                                        <?php
									}
								?>
                                </ul>
                                <input type="hidden" name="CTC_AEREO" id="CTC_AEREO" value="<?php echo ($wwQry['CTC_AEREO']); ?>" />
                                <input type="hidden" name="CTC_HOTEL" id="CTC_HOTEL" value="<?php echo ($wwQry['CTC_HOTEL']); ?>" />
                                <input type="hidden" name="CTC_ALUGUEL" id="CTC_ALUGUEL" value="<?php echo ($wwQry['CTC_ALUGUEL']); ?>" />
                                <input type="hidden" name="CTC_ATIVIDADE" id="CTC_ATIVIDADE" value="<?php echo ($wwQry['CTC_ATIVIDADE']); ?>" />
                                <div class="tab-content">
                                <?php
									if ($wwQry['CTC_AEREO'] == 1){
										?>
                                        <div class="tab-pane active" id="tab1">
                                        	<div class="contentTable">
                                            	<table class="table table-striped">
                                                	<tr>
                                                    	<td class="titTable" width="10%"><strong></strong></td>
                                                        <td class="titTable" width="8%"><strong>Sigla</strong></td>
                                                        <td class="titTable" width="20%"><strong>Compania</strong></td>
                                                        <td class="titTable" width="15%"><strong>Partida</strong></td>
                                                        <td class="titTable" width="15%"><strong>De / Para</strong></td>
                                                        <td class="titTable" width="15%"><strong>Saída</strong></td>
                                                        <td class="titTable"><strong>Chegada</strong></td>
                                                        <td class="titTable"></td>
                                                    </tr>
                                                </table>
                                                <table class="table table-striped" id="tabelaTrecho1">
                                                	<tr>
                                                    	<td class="titTable">Trecho 1:</td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SIGLA1" id="CPP_TRECHO_SIGLA1" value="" style="width:20px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_COMPANIA1" id="CPP_TRECHO_COMPANIA1" value="" style="width:120px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_PARTIDA1" id="CPP_TRECHO_PARTIDA1" OnKeyUp="mascaraData(this,'CPP_TRECHO_PARTIDA1');" maxlength="10" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_DEPARA1" id="CPP_TRECHO_DEPARA1" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SAIDA1" id="CPP_TRECHO_SAIDA1" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_CHEGADA1" id="CPP_TRECHO_CHEGADA1" value="" style="width:80px" /></td>
                                                        <td class="titTable"><a onclick="abreTrecho(2);"><img src="templates/images/botoes/icone-mais.gif" /></a></td>
                                                    </tr>
                                                </table>
                                                <table class="table table-striped" id="tabelaTrecho2" style="display:none">
                                                	<tr>
                                                    	<td class="titTable">Trecho 2:</td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SIGLA2" id="CPP_TRECHO_SIGLA2" value="" style="width:20px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_COMPANIA2" id="CPP_TRECHO_COMPANIA2" value="" style="width:120px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_PARTIDA2" id="CPP_TRECHO_PARTIDA2" OnKeyUp="mascaraData(this,'CPP_TRECHO_PARTIDA2');" maxlength="10" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_DEPARA2" id="CPP_TRECHO_DEPARA2" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SAIDA2" id="CPP_TRECHO_SAIDA2" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_CHEGADA2" id="CPP_TRECHO_CHEGADA2" value="" style="width:80px" /></td>
                                                        <td class="titTable"><a onclick="abreTrecho(3);"><img src="templates/images/botoes/icone-mais.gif" /></a><a onclick="fechaTrecho(2)"><img src="templates/images/botoes/menos.png" /></a></td>
                                                    </tr>
                                                </table>
                                                <table class="table table-striped" id="tabelaTrecho3" style="display:none">
                                                	<tr>
                                                    	<td class="titTable">Trecho 3:</td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SIGLA3" id="CPP_TRECHO_SIGLA3" value="" style="width:20px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_COMPANIA3" id="CPP_TRECHO_COMPANIA3" value="" style="width:120px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_PARTIDA3" id="CPP_TRECHO_PARTIDA3" OnKeyUp="mascaraData(this,'CPP_TRECHO_PARTIDA3');" maxlength="10" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_DEPARA3" id="CPP_TRECHO_DEPARA3" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SAIDA3" id="CPP_TRECHO_SAIDA3" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_CHEGADA3" id="CPP_TRECHO_CHEGADA3" value="" style="width:80px" /></td>
                                                        <td class="titTable"><div id="trechoAberto4"><a onclick="abreTrecho(4);"><img src="templates/images/botoes/icone-mais.gif" /></a><a onclick="fechaTrecho(3)"><img src="templates/images/botoes/menos.png" /></a</div></td>
                                                    </tr>
                                                </table>
                                                <table class="table table-striped" id="tabelaTrecho4" style="display:none">
                                                	<tr>
                                                    	<td class="titTable">Trecho 4:</td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SIGLA4" id="CPP_TRECHO_SIGLA4" value="" style="width:20px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_COMPANIA4" id="CPP_TRECHO_COMPANIA4" value="" style="width:120px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_PARTIDA4" id="CPP_TRECHO_PARTIDA4" OnKeyUp="mascaraData(this,'CPP_TRECHO_PARTIDA4');" maxlength="10" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_DEPARA4" id="CPP_TRECHO_DEPARA4" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_SAIDA4" id="CPP_TRECHO_SAIDA4" value="" style="width:80px" /></td>
                                                        <td class="titTable"><input type="text" name="CPP_TRECHO_CHEGADA4" id="CPP_TRECHO_CHEGADA4" value="" style="width:80px" /></td>
                                                        <td class="titTable"><a onclick="fechaTrecho(4)"><img src="templates/images/botoes/menos.png" /></a</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="span7">
                                                Valor Passagem: <input type="text" name="CPP_VALOR_PASSAGEM" id="CPP_VALOR_PASSAGEM" value="" style="width:80px" /> &nbsp; 
                                                Taxa: <input type="text" name="CPP_VALOR_TAXA" id="CPP_VALOR_TAXA" value="" style="width:80px" /> &nbsp;
                                                <strong>Total Aéreo:</strong> <input type="text" name="CPP_TOTAL_AEREO" id="CPP_TOTAL_AEREO" value="" style="width:80px" onblur="alterarTotalAerero(this.value);" /> &nbsp;
                                            </div>
                                            
                                        </div>
                                        <?php
									}
									if ($wwQry['CTC_HOTEL'] == 1){
										?>
                                        <div class="tab-pane" id="tab2">
                                            <table width="100%">
                                              <tr>
                                              	<td>
                                            	  Hotel:
                                                </td>
                                                <td colspan="3"> 
                                                  <input type="text" name="CPP_HOTEL" id="CPP_HOTEL" value="" style="width:400px" />
                                                </td> 
                                              </tr>
                                              <tr>
                                              	<td>
                                            	 Link:
                                                </td>
                                                <td colspan="3"> 
                                                  <input type="text" name="CPP_HOTEL_LINK" id="CPP_HOTEL_LINK" value="" style="width:400px" />
                                            	</td>
                                              </tr>
                                              <tr>
                                                <td>
                                            	 Endereço: 
                                                </td>
                                                <td colspan="3">
                                                 <input type="text" name="CPP_HOTEL_ENDERECO" id="CPP_HOTEL_ENDERECO" value="" style="width:400px" /> 
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>
                                                Classificação:
                                                </td>
                                                <td>
                                                 <select name="CPP_HOTEL_CLASSIFICACAO" id="CPP_HOTEL_CLASSIFICACAO" > 
                                                 	<option value="1">1 Estrela</option>
                                                    <option value="2">2 Estrelas</option>
                                                    <option value="3">3 Estrelas</option>
                                                    <option value="4">4 Estrelas</option>
                                                    <option value="5">5 Estrelas</option>
                                                 </select>
                                                </td>
                                                <td>Check-in:</td>
                                                <td><input type="text" name="CPP_HOTEL_CHECKIN" id="CPP_HOTEL_CHECKIN" value="" style="width:100px" OnKeyUp="mascaraData(this,'CPP_HOTEL_CHECKIN');" maxlength="10" /> </td>
                                              </tr>
                                              <tr>
                                              	<td>Qtd Noites:</td>
                                                <td><input type="text" name="CPP_HOTEL_QTD_NOITES" id="CPP_HOTEL_QTD_NOITES" value="" style="width:100px" /></td>
                                                <td>Check-out:</td> 
                                                <td><input type="text" name="CPP_HOTEL_CHECKOUT" id="CPP_HOTEL_CHECKOUT" value="" style="width:100px" OnKeyUp="mascaraData(this,'CPP_HOTEL_CHECKOUT');" maxlength="10" /> </td>
                                              </tr>
                                              <tr>
                                              	<td>Média Diária:</td>
                                                <td><input type="text" name="CPP_HOTEL_MEDIA_DIARIA" id="CPP_HOTEL_MEDIA_DIARIA" value="" style="width:100px" /></td> 
                                                <td><strong>Total Hotel:</strong></td>
                                                <td><input type="text" name="CPP_TOTAL_HOTEL" id="CPP_TOTAL_HOTEL" value="" style="width:100px" onblur="alterarTotalHotel(this.value);" /> </td>
                                              </tr>
                                            </table>
                             
                                        </div>
                                        <?php
									}
									if ($wwQry['CTC_ALUGUEL'] == 1){
										?>
                                        <div class="tab-pane" id="tab3">
                                            <table width="100%">
                                              <tr>
                                              	<td>
                                            	  Locadora:
                                                </td>
                                                <td colspan="3"> 
                                                  <input type="text" name="CPP_ALUGUEL_LOCADORA" id="CPP_ALUGUEL_LOCADORA" value="" style="width:400px" />
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>
                                                Classificação:
                                                </td>
                                                <td>
                                                 <select name="CPP_ALUGUEL_CLASSIFICACAO" id="CPP_ALUGUEL_CLASSIFICACAO" > 
                                                 	<option value="1">Compacto</option>
                                                 </select>
                                                </td>
                                                <td>Retirada:</td> 
                                                <td><input type="text" name="CPP_ALUGUEL_RETIRADA" id="CPP_ALUGUEL_RETIRADA" value="" style="width:100px" OnKeyUp="mascaraData(this,'CPP_ALUGUEL_RETIRADA');" maxlength="10" /> </td>
                                              </tr>
                                              <tr>
                                              	<td><input type="checkbox" name="CPP_ALUGUEL_GPS" id="CPP_ALUGUEL_GPS" value="1" /> GPS</td>
                                                <td>Diárias: <input type="text" name="CPP_ALUGUEL_DIARIAS" id="CPP_ALUGUEL_DIARIAS" value="" style="width:60px" /> </td>
                                                <td>Devolução:</td>
                                                <td><input type="text" name="CPP_ALUGUEL_DEVOLUCAO" id="CPP_ALUGUEL_DEVOLUCAO" value="" style="width:100px" OnKeyUp="mascaraData(this,'CPP_ALUGUEL_DEVOLUCAO');" maxlength="10" /> </td>
                                              </tr>
                                              <tr>
                                              	<td>
                                            	  Retirada/Entrega:
                                                </td>
                                                <td colspan="3"> 
                                                  <input type="text" name="CPP_ALUGUEL_ENTREGA" id="CPP_ALUGUEL_ENTREGA" value="" style="width:400px" />
                                                </td>
                                              </tr>
											  <tr>
                                                <td>
                                                Sistema:
                                                </td>
                                                <td>
                                                 <select name="CPP_ALUGUEL_SISTEMA" id="CPP_ALUGUEL_SISTEMA" > 
                                                 	<option value="1">All inclusive</option>
                                                 </select>
                                                </td>
                                                <td><strong>Total Aluguel:</strong></td>
                                                <td><input type="text" name="CPP_TOTAL_ALUGUEL" id="CPP_TOTAL_ALUGUEL" value="" style="width:100px" onblur="alterarTotalCarro(this.value);" /> </td>
                                                
                                              </tr>
                                            </table>
                                        </div>
                                        <?php
									}
									if ($wwQry['CTC_ATIVIDADE'] == 1){
										?>
                                        <div class="tab-pane" id="tab4">
                                            <p>Howdy, I'm in Section 2.</p>
                                        </div>
                                        <?php
									}
								?>
                                </div>
                            </div>
                        <!--<label>Título</label>
                        <input type="text" class="input-xlarge" name="CPP_TITULO" id="CPP_TITULO">
                        <label>Descrição</label>
                        <textarea class="input-xlarge" name="CPP_DESCRICAO" id="CPP_DESCRICAO"></textarea>
                        <label>Valor Total da Proposta</label>
                        <input class="input-xlarge" type="text" name="CPP_VALOR" id="CPP_VALOR">
                        <label>Observações</label>
                        <textarea class="input-xlarge" name="CPP_OBS" id="CPP_OBS"></textarea>
                        <label></label>
                        <button type="button" id="Salvar" name="Salvar" class="btn btn-primary">Enviar Proposta</button>-->
                        </fieldset>
                        <div class="tabbable"> <!-- Only required for left/right tabs -->
                            <ul class="nav nav-tabs">
                            	<li class="active"><a href="#tab5" data-toggle="tab">Pacote</a></li>
                            </ul>
                                  <div class="tab-pane active" id="tab5"><br />
                                	<div class="span7">
                                        Moeda: <select name="CPP_MOEDA" id="CPP_MOEDA" style="width:60px">
                                                	<option value="1">US</option>
                                                    <option value="2">R$</option>
                                                </select> &nbsp;
                                        <?php
											if ($wwQry['CTC_AEREO'] == 1){
										?>
                                                <strong>Total Aéreo:</strong> <input type="text" name="CPP_AEREO_TOTAL" id="CPP_AEREO_TOTAL" value="" readonly="readonly" style="width:60px" /> &nbsp;
                                        <?php
											}
										?>
                                        <?php
											if ($wwQry['CTC_HOTEL'] == 1){
										?>
                                                <strong>Total Hotel:</strong> <input type="text" name="CPP_HOTEL_TOTAL" id="CPP_HOTEL_TOTAL" value="" readonly="readonly" style="width:60px" /> &nbsp;
                                        <?php
											}
										?>
                                        <?php
											if ($wwQry['CTC_ALUGUEL'] == 1){
										?>
                                                <strong>Total Aluguel:</strong> <input type="text" name="CPP_ALUGUEL_TOTAL" id="CPP_ALUGUEL_TOTAL" value="" readonly="readonly" style="width:60px" /> &nbsp;
                                        <?php
											}
										?>
                                     </div>
                                        <div class="span7">
                                        	<strong>Total Pacote: </strong><input type="text" readonly="readonly" name="TOTAL" id="TOTAL" value="" />
                                        </div>
                                     
                                  </div>
                        </div>
                        <div class="tabbable"> <!-- Only required for left/right tabs -->
                            <ul class="nav nav-tabs">
                            	<li class="active"><a href="#tab6" data-toggle="tab">Todas as Informações</a></li>
                            </ul>
                                  <div class="tab-pane active" id="tab6">
                                  	<textarea name="CPP_OBSERVACOES" id="CPP_OBSERVACOES"></textarea><br />
                                    <button type="submit" id="Salvar" name="Salvar" class="btn btn-primary">Enviar Proposta</button>
                                  </div>
                        </div>
                    </form>
                 </div>

        </div>
    </div>
           <?php
		   		}
			}else{
			?>
            	<div class="span8 line borderTop">
                	<div class="alert alert-error">
                		Esta cotação não existe
                    </div>
                </div>
            <?php
			}
			?>


</div>
<div class="span3"><br />
<div style="visibility:hidden"><a href="#myProposta" role="button" id="fazerProposta"  data-toggle="modal"> Fazer Proposta</a></div>
	<?php
		// Verifico se agente ja fez proposta //
		$lQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'
		AND USR_ID = '$_SESSION[USR_ID]'");
		if (mysql_num_rows($lQry) > 0){}else{
                    $Resultado = $oCriarDestinoDAO->pegaPrecoLead($CTC_ID);
                    
                    // Busco a qtd de leads que o agente tem
                    $ntQry = mysql_query ("SELECT USR_QTD_LEADS FROM tb_usuario WHERE USR_ID = '$_SESSION[USR_ID]'");
                    $tnQry = mysql_fetch_array ($ntQry);
                    //if ($tnQry["USR_QTD_LEADS"] < $Resultado){
                         
                        ?>
                            <!--<div class="alert alert-error">
		                    Voc&ecirc; n&atilde;o tem leads suficientes!		                     
		                </div>-->
                        <?php
                    //}else{
                    ?>
<script>
    function comprarLeads(){
        if($('#LeadsUsuario').val() < $('#QTD_LEADS').val()){
            alert ('Você não tem pontos suficientes para comprar o lead!');
        }else{
            if (confirm ('Tem certeza que deseja comprar o lead?')){
                document.forms["formLeads"].submit();
            }
        }
    }
</script>
                      <p align="center"><button class="btn btn-primary btn-large" onclick='fazerProposta();' type="button">Fazer Proposta</button></p>
                      <?php
                      
                      
                      if ($ComprouLead == 0){
                      ?>
                        <p align="center"><a onclick="comprarLeads();"><button class="btn btn-primary btn-large"  type="button">Comprar Leads</button></a></p>
                      <?php
                      }
                      ?>
                      <?php
                      // Busco a quantidade de leads que ele tem
                      $nqQry = mysql_query ("SELECT USR_QTD_LEADS FROM tb_usuario WHERE USR_ID = '$_SESSION[USR_ID]'");
                      $qnQry = mysql_fetch_array ($nqQry);
                      ?>
                      <input type="hidden" name="ComprouLead" id="ComprouLead" value="<?php echo ($ComprouLead); ?>">
                      <input type="hidden" name="LeadsUsuario" id="LeadsUsuario"  value="<?php echo ($qnQry['USR_QTD_LEADS']); ?>">
                      <form name="formLeads" id="formLeads" action="cComprarLeads.php" method="post">
                          <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
                          <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
                          <input type="hidden" name="QTD_LEADS" id="QTD_LEADS" value="<?php echo ($Resultado); ?>"  />
                      </form>
                    <?php
                    //}
                    ?>
                    
                    <?php
                    if ($ComprouLead == 0){
                    ?>
                        <div class="alert"><strong>Custar&aacute; <?php echo ($Resultado); ?> leads</strong></div>
                    <?php
                    }else{                     
                    ?>
                        <div class="alert alert-success"><strong>Leads já adiquiridos</strong></div>
                    <?php
                    }
                    ?>
                    
    		
    <?php
     
		}
        
	?>
    
    <span>
    	<script>
			function avaliar (){
				$('#avaliarFornecedor').click();
			}
			
			function dadosCliente (){
				$('#DadosCliente').click();
			}
			
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
        <div style="visibility:hidden"><a href="#myAvaliar" role="button" id="avaliarFornecedor"  data-toggle="modal"> Avaliar</a></div>
        <div id="myAvaliar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Avaliar Cliente</h3>
            <?php
			// Verifico se já fez avaliação
			$mQry = mysql_query ("SELECT * FROM tb_avaliacao WHERE CTC_ID = '$CTC_ID' 
			AND AVL_AVALIADOR = '$_SESSION[USR_ID]'");
			if (mysql_num_rows($mQry) > 0){
			?>
            	<br />
            	<div class="alert alert-block">
                    Você já realizou a avaliação!
                </div>
            <?php
			}else{
			?>
            <form name="AvaliarFornecedorSelecionado" id="AvaliarFornecedorSelecionado" method="post" action="cAvaliarFornecedor.php" onsubmit="return AvaliarFornecedor();">
            	<input type="hidden" name="pg" id="pg" value="4" />
                <input type="hidden" name="FONTE" id="FONTE" value="AGENTE" />
            	<input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
                <input type="hidden" name="CTC_ID" id="CTC_ID" value="<?php echo ($CTC_ID); ?>"  />
                <br /><p><strong>Nota:</strong> </p><p>
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
			}
			
			// busco dados do cliente
			if ($CTC_STATUS == "2"){
				$zcQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$USUARIO_COTACAO'");
				$ccQry = mysql_fetch_array ($zcQry);
				
			?>
            	<strong>Dados do cliente</strong>
                <p><?php echo ($ccQry['USR_NOME']); ?></p>
                <p><?php echo ($ccQry['USR_EMAIL']); ?></p>
                <?php 
					if ($ccQry['USR_TELEFONE1'] != NULL){
						echo ("<p><strong>Fone:</strong> $ccQry[USR_TELEFONE1]");
						if ($ccQry['USR_TELEFONE2'] != NULL){
							echo (" | $ccQry[USR_TELEFONE2]");
						}
						if ($ccQry['USR_TELEFONE3'] != NULL){
							echo (" | $ccQry[USR_TELEFONE3]");
						}
						echo ("</p>");
					}
				?>
                <p><strong>Preferência de contato:</strong>
                	<?php
						$uuQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'
						AND CPP_STATUS = '3'");
						$iiQry = mysql_fetch_array ($uuQry);
						if ($iiQry['CPP_EMAIL'] == "1"){
							$PREFERENCIA = 'E-mail, ';
						}
						if ($iiQry['CPP_TELEFONE'] == "1"){
							$PREFERENCIA = 'Telefone, ';
						}
						if ($iiQry['CPP_CELULAR'] == "1"){
							$PREFERENCIA = 'Celular, ';
						}
						$PREFERENCIA = substr ($PREFERENCIA,0,-2);
						echo ($PREFERENCIA);
					?>
                </p>
            <?php
			}
			?>
        </div>
        <div class="modal-body">

        </div>
</div>

<div style="visibility:hidden"><a href="#myDados" role="button" id="DadosCliente"  data-toggle="modal"> Avaliar</a></div>
        <div id="myDados" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" name="fechar" id="fechar" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Dados do Cliente</h3>
			<?php
			
			// busco dados do cliente
			if ($CTC_STATUS == "2"){
				$zcQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$USUARIO_COTACAO'");
				$ccQry = mysql_fetch_array ($zcQry);
				
			?><br />
                <p><?php echo ($ccQry['USR_NOME']); ?></p>
                <p><?php echo ($ccQry['USR_EMAIL']); ?></p>
                <?php 
					if ($ccQry['USR_TELEFONE1'] != NULL){
						echo ("<p><strong>Fone:</strong> $ccQry[USR_TELEFONE1]");
						if ($ccQry['USR_TELEFONE2'] != NULL){
							echo (" | $ccQry[USR_TELEFONE2]");
						}
						if ($ccQry['USR_TELEFONE3'] != NULL){
							echo (" | $ccQry[USR_TELEFONE3]");
						}
						echo ("</p>");
					}
				?>
                <p><strong>Preferência de contato:</strong>
                	<?php
						$uuQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'
						AND CPP_STATUS = '3'");
						$iiQry = mysql_fetch_array ($uuQry);
						if ($iiQry['CPP_EMAIL'] == "1"){
							$PREFERENCIA = 'E-mail, ';
						}
						if ($iiQry['CPP_TELEFONE'] == "1"){
							$PREFERENCIA = 'Telefone, ';
						}
						if ($iiQry['CPP_CELULAR'] == "1"){
							$PREFERENCIA = 'Celular, ';
						}
						$PREFERENCIA = substr ($PREFERENCIA,0,-2);
						echo ($PREFERENCIA);
					?>
                </p>
            <?php
			}
			?>
        </div>
        <div class="modal-body">

        </div>
</div>
    	<?php
			if ($CTC_STATUS == "2"){
		?>
        		<p align="center"><button class="btn btn-primary btn-large" onclick='avaliar();' type="button">Avaliar Cliente</button></p>
                <p align="center"><button class="btn btn-primary btn-large" onclick='dadosCliente();' type="button">Dados do Cliente</button></p>

        <?php
			}
		?>
    	<h4>Perguntas enviadas a você</h4>

        <?php
			// Verifico se existe pergunta
			$zQry = mysql_query ("SELECT * FROM tb_cotacao_pergunta a INNER JOIN tb_usuario b
			ON a.USR_ID_DE = b.USR_ID WHERE CTC_ID = '$CTC_ID' AND
			USR_ID_PARA = '$_SESSION[USR_ID]'");
			if (mysql_num_rows($zQry) > 0){
				while ($xQry = mysql_fetch_array ($zQry)){
					?>


                    <p><strong>
                    <div class="accordion-group">
                       <div class="accordion-heading">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo ($xQry['CPR_ID']); ?>">

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
                        	<input type="hidden" name="pg" id="pg" value="4" />
                            <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>"  />
                            <input type="hidden" name="USR_ID_PARA" id="USR_ID_PARA" value="<?php echo ($xQry['USR_ID_DE']); ?>"  />
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
    </span>

</div>