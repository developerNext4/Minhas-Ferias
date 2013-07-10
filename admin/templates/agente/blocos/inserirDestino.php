<script src="templates/agente/js/jquery.price_format.js"></script>
<script>

	function valida(){
		var erro = 0;
		if ($('#DST_NOME').val() == ''){
			alert ('O campo TITULO é obrigatório!');
			$('#DST_NOME').focus();
			return false;
		}
		if ($('#DST_VALOR').val() == ''){
			alert ('O campo VALOR é obrigatório!');
			$('#DST_VALOR').focus();
			return false;
		}
		if ($('#DST_STATUS').val() == ''){
			alert ('O campo LEADS é obrigatório!');
			$('#DST_STATUS').focus();
			return false;
		}
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
            <legend>Cadastro de Destino</legend>
            <?php
			$acaoTela		= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : NULL;
			$DST_ID			= ( isset( $_REQUEST['DST_ID'] ) ) ? $_REQUEST['DST_ID'] : NULL;
			$DST_NOME		= NULL;
			$DST_VALOR		= NULL;
			$DST_STATUS		= NULL;

			if ($acaoTela == "update"){
				$hQry = mysql_query ("SELECT * FROM tb_destino WHERE DST_ID = '$DST_ID'");
				while ($jQry = mysql_fetch_array ($hQry)){
					$DST_NOME = $jQry['DST_NOME'];
					$DST_VALOR = $jQry['DST_VALOR'];
					$DST_STATUS = $jQry['DST_STATUS'];
				}
			}
			
			$aStatus = array ("1" => "Ativo", "2" => "Aguardando Aprovação", "3" => "Excluído");
			$statusComboBox = $oUtilsDAO->montaSelectComboArray2( $aStatus, "$DST_STATUS");

	    ?>
            
            <form name="pacote" id="pacote" method="post" onSubmit='return valida()' action="cDestino.php">
		<input type="hidden" name="acaoTela" id="acaoTela" value="<?php echo ($acaoTela); ?>" />
		<input type="hidden" name="DST_ID" id="DST_ID" value="<?php echo ($DST_ID); ?>" />
                <label>Destino: &nbsp;</label>
                <input type="text" name="DST_NOME" id="DST_NOME" value="<?php echo ($DST_NOME); ?>" />
                
		<label>Valor: &nbsp;</label>
		<input type="text" name="DST_VALOR" id="DST_VALOR" value="<?php echo ($DST_VALOR); ?>" />
		<label>Status: &nbsp;</label>
		<select name="DST_STATUS" id="DST_STATUS">
        	<?php echo ($statusComboBox); ?>
        </select>
		<label><button class="btn btn-primary">Salvar</button>
            </form>
			
</div>