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
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Alteração de cadastro concluída com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?>
                <div class="alert alert-error">
                    Problema ao atualizar cadastro! Tente novamente mais tarde
                </div>

        <?php
            }
        ?>

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


            <fieldset class="left30">
            <legend>Propostas Efetuadas</legend>
            <?php
			$iPgnAtual		= ( isset( $_REQUEST['iPgn'] ) ) ? $_REQUEST['iPgn'] : "0";
			$ORDENAR		= ( isset( $_REQUEST['ORDENAR'] ) ) ? $_REQUEST['ORDENAR'] : "T";
			$Ordem			= NULL;
			if ($ORDENAR != "T"){
				$Ordem = "&ORDENAR=$ORDENAR";
			}

			$selectStatus = NULL;
			$selectData = NULL;
			$selectAtualizacao = NULL;
			if ($ORDENAR == "T" || $ORDENAR == "STATUS"){
				$ORDENACAO = "CTC_STATUS = '1' DESC, CTC_STATUS = '2' DESC, CTC_STATUS = '3' DESC,
CTC_STATUS = '4' DESC, CTC_STATUS = '5' DESC, CTC_STATUS = '6' DESC";
				$selectStatus = "selected";
			}else if ($ORDENAR == "DATA"){
				$ORDENACAO = "CTC_DATA DESC";
				$selectData = "selected";
			}else{
				$ORDENACAO = "CTC_DATA DESC";
				$selectAtualizacao = "selected";
			}
			?>

            <form name="ordenacao" id="ordenacao" method="get" action="index.php">
                <label>Ordernar &nbsp;
                <input type="hidden" name="pg" id="pg" value="2" />
                <select name="ORDENAR" onblur="ORDENAR" onchange="submeterForm();">
                    <option <?php echo ($selectStatus); ?> value="STATUS">Por Status</option>
                    <option <?php echo ($selectData); ?> value="DATA">Por Data de Criação</option>
                    <option <?php echo ($selectAtualizacao); ?> value="ATUALIZACAO">Por Atualização</option>
                </select></label>
            </form>
			<?php

			$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oCriarDestinoDAO->getQueryCount(), "index.php?pg=2&ORDENAR=T", '' );



            $hQry = mysql_query ("SELECT * FROM tb_cotacao A INNER JOIN tb_cotacao_proposta b
			ON A.CTC_ID = B.CTC_ID
			WHERE B.USR_ID = '$_SESSION[USR_ID]'
			ORDER BY $ORDENACAO LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);
			if (mysql_num_rows($hQry) > 0){
				while ($jQry = mysql_fetch_array ($hQry)){
					if ($jQry["CTC_STATUS"] == "1"){
						$STATUS = "Ativo";
					}else if ($jQry["CTC_STATUS"] == "2"){
						$STATUS = "Concluído";
					}else if ($jQry["CTC_STATUS"] == "3"){
						$STATUS = "Cancelado";
					}else if ($jQry["CTC_STATUS"] == "4"){
						$STATUS = "Banido";
					}else if ($jQry["CTC_STATUS"] == "5"){
						$STATUS = "Expirado";
					}else if ($jQry["CTC_STATUS"] == "6"){
						$STATUS = "Inativo";
					}

					?>
                     <div class="span8 line borderTop">
                     	<span class="span3"><strong>
                        <?php echo ("<a href='index.php?pg=4&CTC_ID=$jQry[CTC_ID]'>$jQry[CPP_TITULO] </a>"); ?></strong>
                        </span>
                        <span class="span4 right">
                            Status do Desejo: <?php
					if ($jQry["CTC_STATUS"] == "1"){
						echo "Ativo";
					}else if ($jQry["CTC_STATUS"] == "2"){
						echo "Concluído";
					}else if ($jQry["CTC_STATUS"] == "3"){
						echo "Cancelado";
					}else if ($jQry["CTC_STATUS"] == "4"){
						echo "Banido";
					}else if ($jQry["CTC_STATUS"] == "5"){
						echo "Expirado";
					}else if ($jQry["CTC_STATUS"] == "6"){
						echo "Inativo";
					}?> | Data de Criação: <?php
					$DIA = substr ($jQry['CTC_DATA'],8,2);
					$MES = substr ($jQry['CTC_DATA'],5,2);
					$ANO = substr ($jQry['CTC_DATA'],0,4);
					echo ($DIA.'/'.$MES.'/'.$ANO); ?>

                        </span>

                        <span class="span6">
                            <?php
								echo ("<strong>De:</strong> ".$jQry["CTC_DE"]." <strong>Para: </strong>".$jQry["CTC_PARA"]);
							
							?>
                        </span>
                        <?php
                        	if ($STATUS == "Concluído"){
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

                            <?php
								$bQry = mysql_query ("SELECT COUNT(*) AS PERGUNTA FROM tb_cotacao_pergunta
								WHERE CTC_ID = '$jQry[CTC_ID]' AND USR_ID_PARA = '$_SESSION[USR_ID]'
								AND CPR_STATUS = '2'");
								$vQry = mysql_fetch_array ($bQry);
								echo ("<span class='span4' style='margin-left: 0;'>".$vQry['PERGUNTA']);
							?>
                             Pergunta Pendente de Resposta</span><span class="span3"> <strong>Última Atualização:</strong> <?php echo ($DIA.'/'.$MES.'/'.$ANO); ?> </span>
                        </span>
                     </div>
                    <?php
				}
				?>
                <div class="span8
					<?php echo ($aPaginacao[0]); ?>
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
</div>
