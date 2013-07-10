<script src="templates/agente/js/jquery.price_format.js"></script>
<script>
	$(document).ready(function(){
		$('#PCT_VALOR').priceFormat({
						prefix: '',
						centsSeparator: ',',
						thousandsSeparator: '.',
						limit: 8
					});
	});
	function valida(){
		var erro = 0;
		if ($('#PCT_TITULO').val() == ''){
			alert ('O campo TITULO é obrigatório!');
			$('#PCT_TITULO').focus();
			return false;
		}
		if ($('#PCT_VALOR').val() == ''){
			alert ('O campo VALOR é obrigatório!');
			$('#PCT_VALOR').focus();
			return false;
		}
		if ($('#PCT_LEADS').val() == ''){
			alert ('O campo LEADS é obrigatório!');
			$('#PCT_LEADS').focus();
			return false;
		}
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
            <legend>Cadastro de Pacotes</legend>
            <?php
			$acaoTela		= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : NULL;
			$PCT_ID			= ( isset( $_REQUEST['PCT_ID'] ) ) ? $_REQUEST['PCT_ID'] : NULL;
			$PCT_TITULO		= NULL;
			$PCT_VALOR		= NULL;
			$PCT_LEADS		= NULL;

			if ($acaoTela == "update"){
				$hQry = mysql_query ("SELECT * FROM tb_pacote WHERE PCT_ID = '$PCT_ID'");
				while ($jQry = mysql_fetch_array ($hQry)){
					$PCT_TITULO = $jQry['PCT_NOME'];
					$PCT_VALOR = $jQry['PCT_VALOR'];
					$PCT_LEADS = $jQry['PCT_LEADS'];
				}
			}

	    ?>
            
            <form name="pacote" id="pacote" method="post" onSubmit='return valida()' action="cPacote.php">
		<input type="hidden" name="acaoTela" id="acaoTela" value="<?php echo ($acaoTela); ?>" />
		<input type="hidden" name="PCT_ID" id="PCT_ID" value="<?php echo ($PCT_ID); ?>" />
                <label>Título: &nbsp;</label>
                <input type="text" name="PCT_TITULO" id="PCT_TITULO" value="<?php echo ($PCT_TITULO); ?>" />
                
		<label>Valor: &nbsp;</label>
		<input type="text" name="PCT_VALOR" id="PCT_VALOR" value="<?php echo ($PCT_VALOR); ?>" />
		<label>Leads: &nbsp;</label>
		<input type="text" name="PCT_LEADS" id="PCT_LEADS" value="<?php echo ($PCT_LEADS); ?>" />
		<label><button class="btn btn-primary">Salvar</button>
            </form>
			
</div>