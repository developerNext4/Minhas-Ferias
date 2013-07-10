<script>
	function adicionarNovo(){
		location.href="index.php?pg=8&acaoTela=inserir";
	}
function submeterForm(){
		document.forms["ordenacao"].submit();
	}
</script>
<div class="span8">

        
        <?php


			// Requisições de Arquivos Externos //
			require_once( "./classes/DAO/UtilsDAO.php" );
			require_once( "./classes/DAO/PedidoDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
			$oPedidoDAO		= new PedidoDAO();
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
		?>
    
    		<br />
            <fieldset class="left30">
            <legend>Listagem de Pedidos</legend>
<?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?><br>
                <div class="alert alert-success">
                    Pedido ativado com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?><br>
                <div class="alert alert-error">
                    Pedido banido com sucesso!
                </div>
        
        <?php
            }
        ?>
            <?php
			$iPgnAtual		= ( isset( $_REQUEST['iPgn'] ) ) ? $_REQUEST['iPgn'] : "0";
			$ORDENAR		= ( isset( $_REQUEST['ORDENAR'] ) ) ? $_REQUEST['ORDENAR'] : "T";
			$Ordem			= NULL;
			if ($ORDENAR != "T"){
				$ORDENACAO = "CTC_STATUS = '1' DESC, CTC_STATUS = '2' DESC, CTC_STATUS = '3', CTC_STATUS = '4', CTC_STATUS = '5'";
			}
			
			$selectStatus = NULL;
			$selectData = NULL;
			$selectAtualizacao = NULL;
			if ($ORDENAR == "T" || $ORDENAR == "STATUS"){
				$ORDENACAO = "CTC_STATUS = '1' DESC, CTC_STATUS = '2' DESC, CTC_STATUS = '3', CTC_STATUS = '4', CTC_STATUS = '5' ";
				$selectStatus = "selected";
			}else if ($ORDENAR == "DATA"){
				$ORDENACAO = "CTC_DATA DESC ";
				$selectData = "selected";
			}
			?>
            
            <form name="ordenacao" id="ordenacao" method="get" action="index.php">
                <label>Ordernar &nbsp;
                <input type="hidden" name="pg" id="pg" value="8" />
                <select name="ORDENAR" onblur="ORDENAR" onchange="submeterForm();">
                    <option <?php echo ($selectStatus); ?> value="STATUS">Por Status</option>
		    <option <?php echo ($selectData); ?> value="DATA">Data</option>
                   
		    
                </select></label>
            </form>
			<?php	
			
			$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oPedidoDAO->getQueryCount(), "index.php?pg=8&ORDENAR=T", '' );
			
			
			
            $hQry = mysql_query ("SELECT * FROM tb_cotacao
			
			ORDER BY $ORDENACAO LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);

			if (mysql_num_rows($hQry) > 0){
					
			?>
            	
            	<table class="table table-striped">
                    <tr>
                      <td class="titTable"><strong>Código</strong></td>
                      <td class="titTable"><strong>Desejo</strong></td>
                      <td class="titTable"><strong>Passagem</strong></td>
			<td class="titTable"><strong>Destino</strong></td>
                      <td class="titTable"><strong>Data</strong></td>
		      <td class="titTable"><strong>Status</strong></td>
                      <td class="titTable"><strong>Ação</strong></td>
                    </tr>
            <?php
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
					$DIA = substr ($jQry['CTC_DATA'],8,2);
					$MES = substr ($jQry['CTC_DATA'],5,2);
					$ANO = substr ($jQry['CTC_DATA'],0,4);
					$DATA = $DIA.'/'.$MES.'/'.$ANO;
					
					$Desejo = NULL;

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
		
					if ($jQry['CTC_PASSAGEM'] == 1){
						$Passagem = "Ida e Volta";
					}else{
						$Passagem = "Somente Ida";
					}
					

					
				
			?>	
                    
					<tr>
                      <td class="titleColun"><?php echo ($jQry['CTC_ID']); ?></td>
                      <td><?php echo ($Desejo); ?></td>
                      <td><?php echo ($Passagem); ?></td>
			<td><?php echo ("<strong>De:</strong> ".$jQry["CTC_DE"]." <strong>Para: </strong>".$jQry["CTC_PARA"]); ?></td>
                      <td><?php echo ($DATA); ?></td>
		      <td><?php echo ($STATUS); ?></td>
                      <td><a href='cPedido.php?CTC_ID=<?php echo ($jQry["CTC_ID"]); ?>&acaoTela=banir'><i class="icon-remove"></i></a> <a href='cPedido.php?CTC_ID=<?php echo ($jQry["CTC_ID"]); ?>&acaoTela=ativar'><i class="icon-chevron-down"></i></a></td>
                    </tr>
					<?php
				}	
				?>
                </table>
                <div class="span8">
					<?php echo ($aPaginacao[0]); ?>
                </div>
                <?php
			}else{
			?>
            	<div class="span8 line borderTop">
                	<div class="alert alert-error">
                		Não existem usuários cadastrados
                    </div>
                </div>
            <?php
			}
			?>       
</div>