<script>
	function verifyMaisAvaliacoes(){
		$.ajax({
			url: "ajxVerificaMaisAvaliacoes.php",
			global: false,
			type: "GET",
			data: ({USR_ID: $('#USR_ID').val(), Contador: $('#Contador').val()}),
			dataType: "html",
			success: function(data){
				document.getElementById('avaliacaoes').innerHTML = data;
			}
		 });
	}
	function verifyMaisAvaliacoesModal(ID){
		$.ajax({
			url: "ajxVerificaMaisAvaliacoes.php",
			global: false,
			type: "GET",
			data: ({USR_ID: ID, Contador: $('#Contador').val(), FONTE: 1}),
			dataType: "html",
			success: function(data){
				document.getElementById('avaliacao').innerHTML = data;
			}
		 });
	}
</script>

<div class="span9">
<br />

        
        <?php
			ini_set('display_errors','Off'); 
			// Requisições de Arquivos Externos //
				require_once( "./classes/DAO/UtilsDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
				$oUtilsDAO		= new UtilsDAO();
			// ==================== //

			
		?>
    
            <fieldset class="left30">
            <legend>Meu Score</legend>
           	<p>Como funciona o score de fornecedores, XXXXX XXXX XX XX XXXX XX XXXXXXXXX XXXX XXXXXX XXXX XXXXX XXXX XX XXX XXXX XXXXXXX XXXXX XXXXXX XXXXXX XXX XXX XXX XX</p><br />
            <!--<p>Sua Posição nos rankings atualmente é XXXXXX e XXXXXXXX</p><br />-->
            <p>Você fechou <strong>
            <?php
				$hQry = mysql_query ("SELECT COUNT(*) AS FECHADOS FROM tb_cotacao_proposta 
				WHERE USR_ID = '$_SESSION[USR_ID]' AND CPP_STATUS = '3'");
				$jQry = mysql_fetch_array ($hQry);
				echo ($jQry['FECHADOS']);
			?>
             negócio(s)</strong> no site.</p><br />
            <p>Você possui <strong>
            <?php
				$qQry = mysql_query ("SELECT COUNT(*) AS RECEBIDAS FROM tb_avaliacao 
				WHERE AVL_AVALIADO = '$_SESSION[USR_ID]'");
				$wQry = mysql_fetch_array ($qQry);
				echo ($wQry['RECEBIDAS']);
			?> avaliações</strong>, sua nota média é <strong>
            <?php
            	$eQry = mysql_query ("SELECT AVG(AVL_NOTA) AS MEDIA FROM tb_avaliacao 
				WHERE AVL_AVALIADO = '$_SESSION[USR_ID]'");
				$rQry = mysql_fetch_array ($eQry);
				if ($rQry['MEDIA'] == NULL){
					$rQry['MEDIA'] = 0;
				}
				echo (round ($rQry['MEDIA']));
			?></strong></p><br />
            
            <p>Comentários dos consumidores:</p>
            <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>" />
            <div style="width:600px;" id="avaliacaoes">
            	<input type="hidden" name="Contador" id="Contador" value="2" />
            	<?php
					$pQry = mysql_query ("SELECT * FROM tb_avaliacao WHERE AVL_AVALIADO = '$_SESSION[USR_ID]'
					ORDER BY AVL_ID DESC LIMIT 2");
					if (mysql_num_rows($pQry) > 0){
						$iCont = 1;
						while ($oQry = mysql_fetch_array ($pQry)){
							if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
							else{ $back = "#FFFFCC"; }
				?>
                		   <div style="background-color:<?php echo ($back); ?>">
                			<p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
                			<p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
                           </div>
                <?php
							$iCont++;
						}
				?>
                		<p align="center">
                            <button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoes();">Ver Mais</button>
                        </p>
                <?php
					
					}else{
				?>
                	<p>Você não possui avaliações</p>
            	<p>Estrelas</p>
                
                <?php
					}
				?>

            </div><br />
            <div  style="border:1px solid">
            <table  width="100%">
                <tr>
                    <td width="50%">
                        <table width="95%" align="center" style="background-color:#F7F7F7">
                            <tr>
                                <td><strong>TOP 10 agentes que mais fecharam negócios</strong></td>
                                <?php
									$top = array ();
									$bem = array ();
									$i = 1;
									$tQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_TIPO = '2' AND USR_STATUS = '1'");
									while ($yQry = mysql_fetch_array ($tQry)){
										$uQry = mysql_query ("SELECT COUNT(*) AS COUNT FROM tb_cotacao_proposta WHERE USR_ID = '$yQry[USR_ID]'");
										$iQry = mysql_fetch_array ($uQry);
										$top[$i]['count'] = $iQry['COUNT'];
										$top[$i]['usuario'] = utf8_encode ($yQry['USR_NOME']);
										$top[$i]['id'] = $yQry['USR_ID'];
										
										$dQry = mysql_query ("SELECT AVG(AVL_NOTA) AS NOTA FROM tb_avaliacao WHERE AVL_AVALIADO = '$yQry[USR_ID]'");
										$fQry = mysql_fetch_array ($dQry);
										$bem[$i]['nota'] = $iQry['NOTA'];
										$bem[$i]['usuario'] = utf8_encode ($yQry['USR_NOME']);
										$bem[$i]['id'] = $yQry['USR_ID'];
										$i++;
									}
									arsort($top,'count');
									
									for ($i = 1; $i <= 10; $i++){
										$codigo = $top[$i]['id'];
										echo ("<tr><td><a href='#myModal$codigo' role='button'  data-toggle='modal'>".$top[$i]['usuario']."</a></td></tr>");
										?>
                                        <div id="myModal<?php echo ($top[$i]['id']); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                <h3 id="myModalLabel">Avaliações do Agente</h3>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                    if (file_exists("logos/$codigo.jpg")){
                                                ?>
                                                        <img src="logos/<?php echo ($codigo); ?>.jpg" width='100'>
                                                <?php
                                                    }
                                                ?>
                                                <p>O agente fechou <strong>
												<?php
                                                    $hQry = mysql_query ("SELECT COUNT(*) AS FECHADOS 
													FROM tb_cotacao_proposta 
                                                    WHERE USR_ID = '$codigo' AND CPP_STATUS = '3'");
                                                    $jQry = mysql_fetch_array ($hQry);
                                                    echo ($jQry['FECHADOS']);
                                                ?>
                                                 negócio(s)</strong> no site.</p>
                                                 <p>Possui <strong>
												<?php
                                                    $qQry = mysql_query ("SELECT COUNT(*) AS RECEBIDAS 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $wQry = mysql_fetch_array ($qQry);
                                                    echo ($wQry['RECEBIDAS']);
                                                ?> avaliações</strong>, sua nota média é <strong>
                                                <?php
                                                    $eQry = mysql_query ("SELECT AVG(AVL_NOTA) AS MEDIA 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $rQry = mysql_fetch_array ($eQry);
                                                    if ($rQry['MEDIA'] == NULL){
                                                        $rQry['MEDIA'] = 0;
                                                    }
                                                    echo (round ($rQry['MEDIA']));
                                                ?></strong></p>
                                                <p>Comentários dos consumidores:</p>
                                                    <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($codigo); ?>" />
                                                    <div style="width:500px;" id="avaliacao">
                                                        <input type="hidden" name="Contador" id="Contador" value="2" />
                                                        <?php
                                                            $pQry = mysql_query ("SELECT * FROM tb_avaliacao 
															WHERE AVL_AVALIADO = '$codigo'
                                                            ORDER BY AVL_ID DESC LIMIT 2");
                                                            if (mysql_num_rows($pQry) > 0){
                                                                $iCont = 1;
                                                                while ($oQry = mysql_fetch_array ($pQry)){
                                                                    if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
                                                                    else{ $back = "#FFFFCC"; }
                                                        ?>
                                                                   <div style="background-color:<?php echo ($back); ?>">
                                                                    <p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
                                                                    <p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
                                                                   </div>
                                                        <?php
                                                                    $iCont++;
                                                                }
                                                        ?>
                                                                <p align="center">
                                                                    <button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoesModal(<?php  echo ($codigo); ?>);">Ver Mais</button>
                                                                </p>
                                                        <?php
                                                            
                                                            }else{
                                                        ?>
                                                               <div class="alert">
                                                                <strong>Este agente não possui avaliações!</strong>
                                                                </div>
                                                        
                                                        <?php
                                                            }
                                                        ?>
                                            </div>
                                            
                                        </div>
                                        <?php
									}
								?>
                            </tr>
                        </table>
                    </td> 
                    <td>
                        <table width="95%" align="center" style="background-color:#F7F7F7">
                            <tr>
                                <td><strong>TOP 10 agentes mais bem avaliados</strong></td>
                                <?php
									
									arsort($bem,'nota');
									
									for ($i = 1; $i <= 10; $i++){
										$codigo = $bem[$i]['id'];
										echo ("<tr><td><a href='#myModal$codigo' role='button'  data-toggle='modal'>".$bem[$i]['usuario']."</a></td></tr>");
									}
								?>
                                	<div id="myModal<?php echo ($bem[$i]['id']); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                <h3 id="myModalLabel">Avaliações do Agente</h3>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                    if (file_exists("logos/$codigo.jpg")){
                                                ?>
                                                        <img src="logos/<?php echo ($codigo); ?>.jpg" width='100'>
                                                <?php
                                                    }
                                                ?>
                                                <p>O agente fechou <strong>
												<?php
                                                    $hQry = mysql_query ("SELECT COUNT(*) AS FECHADOS 
													FROM tb_cotacao_proposta 
                                                    WHERE USR_ID = '$codigo' AND CPP_STATUS = '3'");
                                                    $jQry = mysql_fetch_array ($hQry);
                                                    echo ($jQry['FECHADOS']);
                                                ?>
                                                 negócio(s)</strong> no site.</p>
                                                 <p>Possui <strong>
												<?php
                                                    $qQry = mysql_query ("SELECT COUNT(*) AS RECEBIDAS 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $wQry = mysql_fetch_array ($qQry);
                                                    echo ($wQry['RECEBIDAS']);
                                                ?> avaliações</strong>, sua nota média é <strong>
                                                <?php
                                                    $eQry = mysql_query ("SELECT AVG(AVL_NOTA) AS MEDIA 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $rQry = mysql_fetch_array ($eQry);
                                                    if ($rQry['MEDIA'] == NULL){
                                                        $rQry['MEDIA'] = 0;
                                                    }
                                                    echo (round ($rQry['MEDIA']));
                                                ?></strong></p>
                                                <p>Comentários dos consumidores:</p>
                                                    <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($codigo); ?>" />
                                                    <div style="width:500px;" id="avaliacao">
                                                        <input type="hidden" name="Contador" id="Contador" value="2" />
                                                        <?php
                                                            $pQry = mysql_query ("SELECT * FROM tb_avaliacao 
															WHERE AVL_AVALIADO = '$codigo'
                                                            ORDER BY AVL_ID DESC LIMIT 2");
                                                            if (mysql_num_rows($pQry) > 0){
                                                                $iCont = 1;
                                                                while ($oQry = mysql_fetch_array ($pQry)){
                                                                    if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
                                                                    else{ $back = "#FFFFCC"; }
                                                        ?>
                                                                   <div style="background-color:<?php echo ($back); ?>">
                                                                    <p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
                                                                    <p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
                                                                   </div>
                                                        <?php
                                                                    $iCont++;
                                                                }
                                                        ?>
                                                                <p align="center">
                                                                    <button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoesModal(<?php  echo ($codigo); ?>);">Ver Mais</button>
                                                                </p>
                                                        <?php
                                                            
                                                            }else{
                                                        ?>
                                                               <div class="alert">
                                                                <strong>Este agente não possui avaliações!</strong>
                                                                </div>
                                                        
                                                        <?php
                                                            }
                                                        ?>
                                            </div>
                                            
                                        </div><?php
								?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
         
          </div>
</div>

<!--<div class="span3" style="height:200px; background-color: #CCCCCC;">
	<h3>Conteudo de teste bloco span4</h3>
	
</div>-->