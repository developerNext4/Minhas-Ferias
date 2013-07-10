<script>
	function validaRadio(){
		var cont = document.getElementById('Contador').value - 1;
		var valores = '';
		for( i = 1; i <= cont; i++ ){
			if (document.getElementById("Check"+i).checked == true){
				var valores = valores + document.getElementById("Check"+i).value+",";
			}
		}
		if (valores == ''){
			alert ('Você precisa selecionar pelo menos uma proposta!');
		}else{
			$('#abrirModal').click();
			document.getElementById('valores').value = valores;
		}
		return false;
	}
</script>
<div class="span8"><br />
<br />
	<?php
			

			// Requisições de Arquivos Externos //
			require_once( "./classes/DAO/UtilsDAO.php" );
			require_once( "./classes/DAO/CriarDestinoDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
			$oCriarDestinoDAO		= new CriarDestinoDAO();
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
	?>
   	<?php
		
					$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
					if (  $msgTxt == 1){
				?>
						<div class="alert alert-success">
							Propostas realizadas com sucesso!
						</div>
				<?php
					}
				?>
	Ordernar <select name="" id="">
    			<option value="">Por Status</option>
                <option value="">Por Data de Criação</option>
                <option value="">Por Atualização</option>
             </select><br />
     Filtrar <select name="" id="" class="span2">
             </select>
             <select name="" id="" class="span2">
             </select>
             <select name="" id="" class="span2">
             </select>
             <select name="" id="" class="span2">
             </select><br />
             
      Listas Pré Definidas <select name="" id="" class="span6">
             </select><br />
       <form name="CotacaoMultipla" method="post" action="index.php?pg=1" onsubmit="return validaRadio();">      
             <button class="btn btn-primary" type="submit">Fazer Proposta Múltipla</button><br /><br />
             <div id="multipla" style="visibility:hidden">
             	<a href="#myProposta" name="abrirModal" id="abrirModal" role="button"  data-toggle="modal">Modal</a>
             </div>
             <?php
				$iPgnAtual		= ( isset( $_REQUEST['iPgn'] ) ) ? $_REQUEST['iPgn'] : "0";

				$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oCriarDestinoDAO->getQueryCount(), "index.php?pg=2&ORDENAR=T", '' );
			
			
			$i = 1;
            $hQry = mysql_query ("SELECT * FROM tb_cotacao 
			WHERE CTC_STATUS = '1' ORDER BY CTC_DATA DESC LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);
			if (mysql_num_rows($hQry) > 0){
				while ($jQry = mysql_fetch_array ($hQry)){
                                    
                                    $mQry = mysql_query ("SELECT COUNT(*) AS PROPOSTA FROM tb_cotacao_proposta 
							 WHERE CTC_ID = '$jQry[CTC_ID]'");
                                    $nQry = mysql_fetch_array ($mQry);
                                  
                                    if ($nQry['PROPOSTA'] >= $jQry['CTC_QTD_PROPOSTAS']){
                                        continue;
                                    }
                                    
			?>
             <div class="span8 line borderTop">
             	<span class="span8 right">
                	Status do Desejo: Ativo | Data de Criação: <?php 
					$DIA = substr ($jQry['CTC_DATA'],8,2);
					$MES = substr ($jQry['CTC_DATA'],5,2);
					$ANO = substr ($jQry['CTC_DATA'],0,4);
					echo ($DIA.'/'.$MES.'/'.$ANO); ?>
                </span>
             	<span class="span1">
                	<input type="checkbox" name="Check<?php echo ($i); ?>" id="Check<?php echo ($i); ?>" value="<?php echo ($jQry[CTC_ID]); ?>" />
                </span>
                <span class="span6">
                	<?php echo ("<strong>De:</strong> ".$jQry["CTC_DE"]." <strong>Para: </strong>" .$jQry["CTC_PARA"]); 						
					$Resultado = $oCriarDestinoDAO->pegaPrecoLead($jQry['CTC_ID']);
                                        
                                        //echo ($contaDistancia);
						?>
                </span>
                <span class="span8">
                	<?php 
								
								echo ($nQry['PROPOSTA']);
								
							?> Proposta(s) Recebida(s) | <?php
								$bQry = mysql_query ("SELECT COUNT(*) AS PERGUNTA FROM tb_cotacao_pergunta 
								WHERE CTC_ID = '$jQry[CTC_ID]' AND USR_ID_PARA = '$_SESSION[USR_ID]' 
                                                                AND CPR_LIDA = '0'");
								$vQry = mysql_fetch_array ($bQry);
								//echo ($vQry['PERGUNTA']);
							?> <!--Novas Perguntas |--> <strong><?php echo ($Resultado);?> leads necess&aacute;rios</strong> <a href="index.php?pg=4&CTC_ID=<?php echo ($jQry['CTC_ID']); ?>"><strong>Ver Detalhes</strong></a>
                </span>
             </div>
      
            
           <?php
		   	$i++;
		   		}
				echo ($aPaginacao[0]);
			?>
            <input type="hidden" name="Contador" id="Contador" value="<?php echo ($i); ?>" />
            
            <?php
			}else{
			?>
            	<div class="span8 line borderTop">
                	<div class="alert alert-error">
                		Não existem desejos cadastrados
                    </div>
                </div>
            <?php
			}
			?>
            </form>
			
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
								url: "ajxCadastraPropostaMultipla.php",
								global: false,
								type: "GET",
								data: ({CPP_TITULO: $('#CPP_TITULO').val(), CPP_DESCRICAO: $('#CPP_DESCRICAO').val(), CPP_VALOR: $('#CPP_VALOR').val(), CPP_OBS: $('#CPP_OBS').val(), USR_ID: $('#USR_ID').val(), valores: $('#valores').val()}),
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
									document.location.href ="index.php?pg=1&msgTxt=1";
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
                        <input type="hidden" name="valores" id="valores" value="" />
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
                 </div>
        
        </div>
    </div>