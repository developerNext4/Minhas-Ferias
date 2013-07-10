<?php
	require_once( "./classes/DAO/UtilsDAO.php" );
	$oUtilsDAO		= new UtilsDAO();
	
	$hQry = mysql_query ("SELECT SBR_TEXTO FROM tb_sobre");
	$jQry = mysql_fetch_array ($hQry);
	$SBR_TEXTO = $jQry['SBR_TEXTO'];
?>

<script src="templates/agente/js/ckeditor/ckeditor.js"></script>
<div class="span8">
<br /><Br />
<br />
<fieldset>
	<legend>Sobre o Site</legend>
    <?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		if (  $msgTxt == 1){
	?>
    		<div class="alert alert-success">
            	Texto atualizado com sucesso!
            </div><br />
    <?php
		}
	?>
    <form name="sobre" method="post" action="cSobreSite.php">
<textarea class="ckeditor" cols="30" id="SBR_TEXTO" name="SBR_TEXTO" rows="10"><?php echo ($SBR_TEXTO); ?></textarea><br />
<button class="btn btn-primary" type="submit">Atualizar</button>
</form>
</fieldset>
</div>