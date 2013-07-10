<script>
	function adicionarNovo(){
		location.href="index.php?pg=10&acaoTela=inserir";
	}
</script>
<div class="span8">

        
        <?php


			// Requisições de Arquivos Externos //
			require_once( "./classes/DAO/UtilsDAO.php" );
			require_once( "./classes/DAO/DestinoDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
			$oDestinoDAO		= new DestinoDAO();
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
		?>
    
    		<br />
            <fieldset class="left30">
            <legend>Listagem de Destinos</legend>
<?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?><br>
                <div class="alert alert-success">
                    Destino cadastrado com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?><br>
                <div class="alert alert-success">
                    Destino ativado com sucesso!
                </div>
        
        <?php
            }else if($msgTxt == 3){
        ?><br>
		<div class="alert alert-success">
                    Destino excluído com sucesso!
                </div>
	<?php
	    }
	?>
            <?php
			$iPgnAtual		= ( isset( $_REQUEST['iPgn'] ) ) ? $_REQUEST['iPgn'] : "0";

			?>
            

			<?php	
			
			$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oDestinoDAO->getQueryCount(), "index.php?pg=9&ORDENAR=T", '' );
			
			
			
            $hQry = mysql_query ("SELECT * FROM tb_destino WHERE DST_STATUS IN ('1','2')
			ORDER BY DST_ID DESC LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);

			if (mysql_num_rows($hQry) > 0){
			
			?>
            	<span class="span8" style="text-align:right"><button class="btn btn-primary" onclick="adicionarNovo();">Adicionar Novo</button>
                </span><br /><br />
            	<table class="table table-striped">
                    <tr>
                      <td class="titleColun">Código</td>
                      <td class="titTable"><strong>Destino</strong></td>
                      <td class="titTable"><strong>Valor</strong></td>
                      <td class="titTable"><strong>Status</strong></td>
                      <td class="titTable"><strong>Ação</strong></td>
                    </tr>
            <?php
				while ($jQry = mysql_fetch_array ($hQry)){
					if ($jQry['DST_STATUS'] == "1"){
						$jQry['DST_STATUS'] = "Ativo";
					}else if ($jQry['DST_STATUS'] == "2"){
						$jQry['DST_STATUS'] = "Aguardando Aprovação";
					}else{
						$jQry['DST_STATUS'] = "Excluído";
					}
			?>	
                    
					<tr>
                      <td class="titleColun"><?php echo ($jQry['DST_ID']); ?></td>
                      <td><?php echo ($jQry['DST_NOME']); ?></td>
                      <td><?php echo ($jQry['DST_VALOR']); ?></td>
                      <td><?php echo ($jQry['DST_STATUS']); ?></td>
                      <td><a href="cDestino.php?DST_ID=<?php echo ($jQry["DST_ID"]); ?>&acaoTela=ativar"><i class="icon-chevron-down"></i></a><a href='cDestino.php?DST_ID=<?php echo ($jQry["DST_ID"]); ?>&acaoTela=excluir'><i class="icon-remove"></i></a> <a href='index.php?pg=10&DST_ID=<?php echo ($jQry["DST_ID"]); ?>&acaoTela=update'><i class="icon-edit"></i></a></td>
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
                		Não existem pacotes cadastrados
                    </div>
                </div>
            <?php
			}
			?>       
</div>