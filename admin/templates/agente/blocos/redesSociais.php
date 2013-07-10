<script src="templates/agente/js/jquery.price_format.js"></script>
<script>

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
            <legend>Definir Redes Sociais</legend>
            <?php

			$hQry = mysql_query ("SELECT * FROM tb_redes_sociais");
			$jQry = mysql_fetch_array ($hQry);
			$RDS_FACEBOOK = $jQry['RDS_FACEBOOK'];
                        $RDS_TWITTER = $jQry['RDS_TWITTER'];
                        $RDS_YOUTUBE = $jQry['RDS_YOUTUBE'];

			?>
            <?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Redes Sociais atualizadas com sucesso!
                </div>
        <?php
            }
        ?>
            
            <form name="pacote" id="pacote" method="post"  action="cRedesSociais.php">
              <label>Link Facebook: &nbsp;</label>
                <input type="text" name="RDS_FACEBOOK" id="RDS_FACEBOOK" value="<?php echo ($RDS_FACEBOOK); ?>" />
              <label>Link Twiiter: &nbsp;</label>
                <input type="text" name="RDS_TWITTER" id="RDS_TWITTER" value="<?php echo ($RDS_TWITTER); ?>" />
              <label>Link Google +: &nbsp;</label>
                <input type="text" name="RDS_YOUTUBE" id="RDS_YOUTUBE" value="<?php echo ($RDS_YOUTUBE); ?>" />
                
		<label><button class="btn btn-primary">Salvar</button></label>
            </form>
			
</div>