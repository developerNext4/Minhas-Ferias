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
			require_once( "./classes/DAO/UsuarioDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
			$oUsuarioDAO		= new UsuarioDAO();
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
		?>
    
    		<br />
            <fieldset class="left30">
            <legend>Listagem de Usuários</legend>
<?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?><br>
                <div class="alert alert-success">
                    Usuário ativado com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?><br>
                <div class="alert alert-error">
                    Usuário banido com sucesso!
                </div>
        
        <?php
            }
        ?>
            <?php
			$iPgnAtual		= ( isset( $_REQUEST['iPgn'] ) ) ? $_REQUEST['iPgn'] : "0";
			$ORDENAR		= ( isset( $_REQUEST['ORDENAR'] ) ) ? $_REQUEST['ORDENAR'] : "T";
			$Ordem			= NULL;
			if ($ORDENACAO != "T"){
				$Ordem = "USR_STATUS = '1' DESC, USR_STATUS = '3' DESC, USR_STATUS = '2' DESC";
			}
			
			$selectStatus = NULL;
			$selectData = NULL;
			$selectAtualizacao = NULL;
			if ($ORDENAR == "T" || $ORDENAR == "STATUS"){
				$ORDENACAO = "USR_STATUS = '1' DESC, USR_STATUS = '3' DESC, USR_STATUS = '2' DESC";
				$selectStatus = "selected";
			}else if ($ORDENAR == "NOME"){
				$ORDENACAO = "USR_NOME ";
				$selectData = "selected";
			}else{
				$ORDENACAO = "USR_EMAIL ";
				$selectAtualizacao = "selected";
			}
			?>
            
            <form name="ordenacao" id="ordenacao" method="get" action="index.php">
                <label>Ordernar &nbsp;
                <input type="hidden" name="pg" id="pg" value="7" />
                <select name="ORDENAR" onblur="ORDENAR" onchange="submeterForm();">
                    <option <?php echo ($selectStatus); ?> value="STATUS">Por Status</option>
		    <option <?php echo ($selectAtualizacao); ?> value="LOGIN">Login</option>
                    <option <?php echo ($selectData); ?> value="NOME">Nome</option>
		    
                </select></label>
            </form>
			<?php	
			
			$aPaginacao = $oUtilsDAO->getPaginacao( $iPgnAtual, $oUsuarioDAO->getQueryCount(), "index.php?pg=7&ORDENAR=T", '' );
			
			
			
            $hQry = mysql_query ("SELECT * FROM tb_usuario
			
			ORDER BY $ORDENACAO LIMIT " . $aPaginacao[1] . ", " . $aPaginacao[2]);

			if (mysql_num_rows($hQry) > 0){
			
			?>
            	
            	<table class="table table-striped">
                    <tr>
                      <td class="titTable">Código</td>
                      <td class="titTable"><strong>Nome</strong></td>
                      <td class="titTable"><strong>Tipo</strong></td>
                      <td class="titTable"><strong>Login</strong></td>
		      <td class="titTable"><strong>Status</strong></td>
                      <td class="titTable"><strong>Ação</strong></td>
                    </tr>
            <?php
				while ($jQry = mysql_fetch_array ($hQry)){
					if ($jQry['USR_TIPO'] == "1"){
						$jQry['USR_TIPO'] = "Cliente";
					}else{
						$jQry['USR_TIPO'] = "Agente";
					}

					if ($jQry['USR_STATUS'] == "1"){
						$jQry['USR_STATUS'] = "Ativo";
					}else if ($jQry['USR_STATUS'] == "2"){
						$jQry['USR_STATUS'] = "Pendente";
					}else{
						$jQry['USR_STATUS'] = "Banido";
					}
			?>	
                    
					<tr>
                      <td class="titleColun"><?php echo ($jQry['USR_ID']); ?></td>
                      <td><?php echo (utf8_encode ($jQry['USR_NOME'])); ?></td>
                      <td><?php echo ($jQry['USR_TIPO']); ?></td>
                      <td><?php echo ($jQry['USR_EMAIL']); ?></td>
		      <td><?php echo ($jQry['USR_STATUS']); ?></td>
                      <td><a href='cUsuario.php?USR_ID=<?php echo ($jQry["USR_ID"]); ?>&acaoTela=banir'><i class="icon-remove"></i></a> <a href='cUsuario.php?USR_ID=<?php echo ($jQry["USR_ID"]); ?>&acaoTela=ativar'><i class="icon-chevron-down"></i></a></td>
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