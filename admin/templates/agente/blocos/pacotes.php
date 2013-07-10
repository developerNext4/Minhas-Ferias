<script>
	function adicionarNovo(){
		location.href="index.php?pg=5&acaoTela=inserir";
	}
</script>
<div class="span8">

        
        <?php


			// Requisições de Arquivos Externos //
			require_once( "./classes/DAO/UtilsDAO.php" );
			require_once( "./classes/DAO/PacotesDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
			$oPacotesDAO		= new PacotesDAO();
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
		?>
    
    		<br />
            <fieldset class="left30">
            <legend>Listagem de Pacotes</legend>
<?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?><br>
                <div class="alert alert-success">
                    Pacote cadastrado com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?><br>
                <div class="alert alert-error">
                    Problema ao atualizar cadastro! Tente novamente mais tarde
                </div>
        
        <?php
            }else if($msgTxt == 3){
        ?><br>
		<div class="alert alert-success">
                    Pacote excluído com sucesso!
                </div>
	<?php
	    }
	?>
            <?php
			$iPgnAtual		= ( isset( $_REQUEST['iPgn'] ) ) ? $_REQUEST['iPgn'] : "0";

			?>
            

			<?php	
			
			$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oPacotesDAO->getQueryCount(), "index.php?pg=4&ORDENAR=T", '' );
			
			
			
            $hQry = mysql_query ("SELECT * FROM tb_pacote
			WHERE PCT_STATUS IN ('1','2')
			ORDER BY PCT_ID DESC LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);

			if (mysql_num_rows($hQry) > 0){
			
			?>
            	<span class="span8" style="text-align:right"><button class="btn btn-primary" onclick="adicionarNovo();">Adicionar Novo</button>
                </span><br /><br />
            	<table class="table table-striped">
                    <tr>
                      <td class="titleColun">Código</td>
                      <td class="titTable"><strong>Pacote</strong></td>
                      <td class="titTable"><strong>Valor</strong></td>
                      <td class="titTable"><strong>Leads</strong></td>
                      <td class="titTable"><strong>Ação</strong></td>
                    </tr>
            <?php
				while ($jQry = mysql_fetch_array ($hQry)){
			?>	
                    
					<tr>
                      <td class="titleColun"><?php echo ($jQry['PCT_ID']); ?></td>
                      <td><?php echo ($jQry['PCT_NOME']); ?></td>
                      <td>R$ <?php echo ($jQry['PCT_VALOR']); ?></td>
                      <td><?php echo ($jQry['PCT_LEADS']); ?></td>
                      <td><a href='cPacote.php?PCT_ID=<?php echo ($jQry["PCT_ID"]); ?>&acaoTela=excluir'><i class="icon-remove"></i></a> <a href='index.php?pg=5&PCT_ID=<?php echo ($jQry["PCT_ID"]); ?>&acaoTela=update'><i class="icon-edit"></i></a></td>
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