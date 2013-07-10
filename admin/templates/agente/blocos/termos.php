<?php
	require_once( "./classes/DAO/UtilsDAO.php" );
	$oUtilsDAO		= new UtilsDAO();
	
	$hQry = mysql_query ("SELECT TRM_TEXTO FROM tb_termos");
	$jQry = mysql_fetch_array ($hQry);
	$TRM_TEXTO = $jQry['TRM_TEXTO'];
?>

<script src="templates/agente/js/ckeditor/ckeditor.js"></script>
<div class="span8">
<br /><Br />
<br />
<fieldset>
	<legend>Termos de Uso</legend>
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
    <form name="sobre" method="post" action="cTermos.php">
<textarea class="ckeditor" cols="30" id="TRM_TEXTO" name="TRM_TEXTO" rows="10"><?php echo ($TRM_TEXTO); ?></textarea><br />
<button class="btn btn-primary" type="submit">Atualizar</button>
</form>
</fieldset>
</div>