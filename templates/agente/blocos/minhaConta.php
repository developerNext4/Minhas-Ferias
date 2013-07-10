
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
			require_once( "./classes/DAO/MinhaContaDAO.php" );
			// ================================ //

			// Instanciando Objetos //
			$oMinhaContaDAO		= new MinhaContaDAO();
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
		?>


            <fieldset class="left30">
            <legend>Minha Conta</legend>
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

            <form name="ordenacao" id="ordenacao" method="get" action="cEnviaPagSeguro.php">
		<input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>">
                <!--<label>Ordernar &nbsp;
                <input type="hidden" name="pg" id="pg" value="2" />
                <select name="ORDENAR" onblur="ORDENAR" onchange="submeterForm();">
                    <option  value="STATUS">Por Status</option>
                    <option  value="DATA">Por Data de Criação</option>
                    <option  value="ATUALIZACAO">Por Atualização</option>
                </select></label> -->
                <p><h4>Comprar Créditos</h4></p>
                <p><strong>Selecione o pacote</strong></p>
                <p><select name="PCT_ID" id="PCT_ID">
		<?php
			$cQry = mysql_query ("SELECT * FROM tb_pacote WHERE PCT_STATUS = '1' ORDER BY PCT_VALOR");
			while ($vQry = mysql_fetch_array ($cQry)){
				echo ("<option value='$vQry[PCT_ID]'>$vQry[PCT_LEADS] leads | R$ $vQry[PCT_VALOR]</option>");
			}
		?>
		</select> <button class="btn btn-primary" type="submit">Comprar</button></p>
            </form>
	    <div class="contentTable">
 

			<?php

			$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oMinhaContaDAO->getQueryCount(), "index.php?pg=6&ORDENAR=T", '' );


	 
            $hQry = mysql_query ("SELECT * FROM tb_pagamento a INNER JOIN tb_pacote b ON a.PCT_ID = b.PCT_ID
			WHERE USR_ID = '$_SESSION[USR_ID]'
			ORDER BY PGM_ID DESC LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);
			if (mysql_num_rows($hQry) > 0){

	   ?>
		<table class="table table-striped">
   		 <tr>
      			<td class="titTable"><strong>Código</script></td>
      			<td class="titTable"><strong>Pacote</strong></td>
      			<td class="titTable"><strong>Leads</strong></td>
      			<td class="titTable"><strong>Valor</strong></td>
      			<td class="titTable"><strong>Status</strong></td>
			<td></td>
    		</tr>
	  <?php	
				$i = 1;
				while ($jQry = mysql_fetch_array ($hQry)){
					$Button = NULL;
					if ($jQry['PGM_STATUS'] == "0"){
						$jQry['PGM_STATUS'] = "Aguardando pagamento";
						/*$Button = '<form name="Paga_'.$i.'" method="post" action="cEnviaPagseguro.php">
								<input type="hidden" name="PCT_ID" id="PCT_ID" value="'.$jQry['PCT_ID'].'">
								<input type="hidden" name="PGM_VALOR" id="PGM_VALOR" value="'.$jQry['PGM_VALOR'].'">
								<input type="hidden" name="USR_ID" id="USR_ID" value="'.$_SESSION['USR_ID'].'" >
								<input type="hidden" name="FONTE" id="FONTE" value="1">
								<button class="btn btn-primary" type="submit">Pagar</button>
							   </form>';*/
                                                $Button = "<a href='https://pagseguro.uol.com.br/v2/checkout/payment.html?code=$jQry[PGM_CODIGO]' target='_blank'><button class='btn btn-primary' type='submit'>Pagar</button></a>";
					}else if ($jQry['PGM_STATUS'] == "1"){
						$jQry['PGM_STATUS'] = "Pago";
					}else if ($jQry['PGM_STATUS'] == "2"){
						$jQry['PGM_STATUS'] = "Cancelada";
					}else if ($jQry['PGM_STATUS'] == "3"){
						$jQry['PGM_STATUS'] = "Vencida";
					}

					?>
					<tr>
      						<td class="titleColun"><?php echo ($jQry['PGM_ID']); ?></td>
      						<td><?php echo (utf8_encode ($jQry['PCT_NOME'])); ?></td>
      						<td><?php echo ($jQry['PCT_LEADS']); ?></td>
      						<td>R$ <?php echo ($jQry['PCT_VALOR']); ?></td>
      						<td><?php echo ($jQry['PGM_STATUS']); ?></td>		
						<td><?php echo ($Button); ?></td>
    					</tr>
                    
   
                    <?php
					$i++;
				}
				?>
		  </table>
		</div>

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
