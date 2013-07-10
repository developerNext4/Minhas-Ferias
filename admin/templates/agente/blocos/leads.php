<script src="templates/agente/js/jquery.price_format.js"></script>
<script>
	function valida(){
		if ($('#LDS_NUMERO').val() == ''){
			alert ('O campo Leads adiquiridos no momento do cadastro é obrigatório!');
			$('#LDS_NUMERO').focus();
			return false;
		}
	}
</script>
<div class="span8">
      
        
        <?php


			// Requisições de Arquivos Externos //
			require_once( "./classes/DAO/UtilsDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
			$oUtilsDAO				= new UtilsDAO();
			// ==================== //
		?>
    
    		<br />
            <fieldset class="left30">
            <legend>Definir Leads</legend>
            <?php

			$hQry = mysql_query ("SELECT * FROM tb_leads");
			$jQry = mysql_fetch_array ($hQry);
			$LDS_NUMERO = $jQry['LDS_NUMERO'];

			?>
            <?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Leads atualizado com sucesso!
                </div>
        <?php
            }
        ?>
            
            <form name="pacote" id="pacote" method="post" onSubmit='return valida()' action="cLeads.php">
              <label>Leads adiquiridos no momento do cadastro: &nbsp;</label>
                <input type="text" name="LDS_NUMERO" id="LDS_NUMERO" value="<?php echo ($LDS_NUMERO); ?>" />
                
		<label><button class="btn btn-primary">Salvar</button></label>
            </form>
			
</div>