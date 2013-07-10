<?php
	require_once( "./classes/DAO/UtilsDAO.php" );
	$oUtilsDAO		= new UtilsDAO();
	
	$hQry = mysql_query ("SELECT * FROM tb_video");
	$jQry = mysql_fetch_array ($hQry);
	$VDO_TEXTO = $jQry['VDO_TEXTO'];
        $VDO_LINK = $jQry['VDO_LINK'];
?>

<script src="templates/agente/js/ckeditor/ckeditor.js"></script>
<script>
    function validaVideo(){
        if ($('#VDO_TEXTO').val() == ''){
            alert ('Digite o campo texto!');
            $('#VDO_TEXTO').focus();
            return false;
        }
        if ($('#VDO_LINK').val() == ''){
            alert ('Digite o campo link!');
            $('#VDO_LINK').focus();
            return false;
        }
    }
</script>
<div class="span8">
<br /><Br />
<br />
<fieldset>
	<legend>V&#237;deo</legend>
    <?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		if (  $msgTxt == 1){
	?>
    		<div class="alert alert-success">
            	V&#237;deo atualizado com sucesso!
            </div><br />
    <?php
		}
	?>
    <form name="sobre" method="post" action="cVideo.php" onSubmit="return validaVideo();">
        <label>Texto:</label>
<textarea class="ckeditor" cols="30" id="VDO_TEXTO" name="VDO_TEXTO" rows="10"><?php echo ($VDO_TEXTO); ?></textarea><br />
<label>Link Youtube:</label><input type="text" class="span5" name="VDO_LINK" id="VDO_LINK" value="<?php echo ($VDO_LINK); ?>"><br>
<button class="btn btn-primary" type="submit">Atualizar</button>
</form>
</fieldset>
</div>