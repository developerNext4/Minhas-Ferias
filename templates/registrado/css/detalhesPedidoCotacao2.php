
<div class="row">
    <div class="span8 contentLeft">
        
        <?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Alteração de cadastro concluída com sucesso!
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
        <?php
            }else if($msgTxt == 2){
        ?>
                <div class="alert alert-error">
                    Problema ao atualizar cadastro! Tente novamente mais tarde.
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
			
            $hQry = mysql_query ("SELECT * FROM tb_cotacao WHERE CTC_ID = '$CTC_ID'");
			if (mysql_num_rows($hQry) > 0){
				while ($jQry = mysql_fetch_array ($hQry)){
				
			?>
             <div class="row">
	             	 <div class="span5">
	             	 	<p>
		             	 	<strong>Data de Crição:</strong> <?php 	$DIA = substr ($jQry['CTC_DATA'],8,2); $MES = substr ($jQry['CTC_DATA'],5,2);
							$ANO = substr ($jQry['CTC_DATA'],0,4);		echo ($DIA.'/'.$MES.'/'.$ANO); ?>
					   </p>
					
	           		 
	           		 	 <p>
		           		 	<strong>Última Atualização:</strong> <?php $DIA = substr ($jQry['CTC_DATA'],8,2); $MES = substr ($jQry['CTC_DATA'],5,2);
							$ANO = substr ($jQry['CTC_DATA'],0,4);	echo ($DIA.'/'.$MES.'/'.$ANO); ?>
						</p>

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
                 	<p><strong>Desejo:</strong> <?php echo ($Desejo); ?></p>
                 	<p>
                 		<strong>Adultos:</strong> <?php echo ($jQry['CTC_ADULTOS']); ?><strong>De 0 a 23 meses:</strong> <?php echo ($jQry['CTC_ZERO_TRES']); ?><strong>Crianças de 2 a 12 anos:</strong> <?php echo ($jQry['CTC_CRIANCAS']); ?>
                 	</p>
                 	 <div>
                 	<?php
						if ($jQry['CTC_OBS'] != NULL){
							echo ("<strong>Observações:</strong> $jQry[CTC_OBS]");
						}
					?>
                 </div>
                 </div>
               

              	
                 	<div class="span3">
	                 	<?php
							if ($jQry['CTC_PASSAGEM'] == 1){
								$Passagem = "Ida e Volta";
							}else{
								$Passagem = "Somente Ida";
							}
						?>
                 	<p><strong>Passagem:</strong> <?php echo ($Passagem); ?></p>                    
                 	<p><?php echo ("<strong>De:</strong> ".$jQry["CTC_DE"]);?></p>
                	<?php 
					// Busco os destinos
								$iQry = mysql_query ("SELECT * FROM tb_cotacao_para 
								WHERE CTC_ID = '$jQry[CTC_ID]'");
								$CTP_PARA = NULL;
								while ($oQry = mysql_fetch_array ($iQry)){
									echo ("<p><strong>Para:</strong> $oQry[CTP_PARA]</p>
										 <p><strong>Qtde Noites:</strong> 4 </p>");
								}
						?>                               
	               <p><strong>Data de Partida:</strong>
		                <?php
							if ($jQry['CTC_PARTIDA_DIA'] == 0){
								echo ("Não definido/");
							}else{
								echo $jQry['CTC_PARTIDA_DIA'].'/';
							}
							echo $jQry['CTC_PARTIDA_MES'].'/'.$jQry['CTC_PARTIDA_ANO'];
						?>
					</p>	

					<p>
                		<strong>Data de Volta:</strong> <?php 
							echo $oUtil->codificadata ($jQry['CTC_DATA_VOLTA']); ?>

					</p>

           		 <strong>Datas Flexíveis:</strong> <?php 
					if ($jQry['CTC_DATA_FLEXIVEIS'] == "1"){
						echo ("Sim");
					}else{
						echo ("Não");
					} ?>
                </div>       
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




<div class="span4 colRight">

	<div style="visibility:hidden"><a href="#myProposta" role="button" id="fazerProposta"  data-toggle="modal"> Fazer Proposta</a></div>
		<?php
			// Verifico se agente ja fez proposta //
			$lQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'
			AND USR_ID = '$_SESSION[USR_ID]'");
			if (mysql_num_rows($lQry) > 0){}else{
		?>
    		<p align="center"><button class="btn btn-primary btn-large" onclick='fazerProposta();' type="button">Fazer Proposta</button></p>
    <?php
		}
	?>
    <div>
    	<h4>Perguntas enviadas a você</h4>
        
        <?php
			// Verifico se existe pergunta
			$zQry = mysql_query ("SELECT * FROM tb_cotacao_pergunta WHERE CTC_ID = '$CTC_ID' AND
			USR_ID_PARA = '$_SESSION[USR_ID]'");
			if (mysql_num_rows($zQry) > 0){
				while ($xQry = mysql_fetch_array ($zQry)){
					?>
                    <strong>
                    <?php
					echo ($xQry['CPR_PERGUNTA']);
					?>
                    </strong><br />
                    <?php
					
					// Verifico se existem respostas
					$cQry = mysql_query ("SELECT CPT_RESPOSTA FROM tb_cotacao_pergunta_resposta 
					WHERE CPR_ID = '$xQry[CPR_ID]'");
					while ($vQry = mysql_fetch_array ($cQry)){
						//echo ($vQry['CPT_RESPOSTA');
					}
					?>
                    <br />
                    <textarea name="RESPONDER" id="RESPONDER"></textarea>
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
        
    
