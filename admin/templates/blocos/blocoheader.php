<script>
	function validaSenha(){
		if ($('#Email').val() == ''){
			alert ('Digite o e-mail');
			$('#Email').focus();
			return false;
		}
		if ($('#Senha').val() == ''){
			alert ('Digite a senha');
			$('#Senha').focus();
			return false;
		}
	}
</script>
<body>
<div class="container">
  <div class="row"><br><br><br><br><br><br>
    <div class="span4 offset4 areaLogin">
      <form class="form-inline form_Home" method="post" action="valida.php" onSubmit="return validaSenha();">
        <label class="titLogin">&Aacute;rea Administrativa </label>
        <label class="check">
          <input type="checkbox" name="Conectado" id="Conectado" value="1">
          Mantenha-me conectado </label>
        <br />
        <input type="text" class="input-small" name="Email" id="Email" placeholder="Digite seu email">
        <input type="password" class="input-small" name="Senha" id="Senha" placeholder="Senha">
        <button type="submit" class="btn btn-rky">Entrar</button>
      </form>
      <?php
	  	$login = ( isset( $_REQUEST['login'] ) ) ? $_REQUEST['login'] : null;
		if ($login == "2"){
	  ?>
      		<span class="colorRed">Senha incorreta! Se n&atilde;o lembra, utilize o esqueceu sua senha</span>
      <?php
	  	}
	  ?>
      
      <?php
	  	if ($login == "1"){
	  ?>
      		<span class="colorRed">Conta n&atilde;o confirmada! Caso n&atilde;o recebeu o e-mail <a href="index.php?pg=7">Clique Aqui</a></span>
      <?php
	  	}
	  ?>
      
      <?php
	  	if ($login == "3"){
	  ?>
      		<span class="colorRed">Usu&aacute;rio bloqueado! Entre em contato com o administrador</span>
      <?php
	  	}
	  ?>
      
       <?php
	  	if ($login == "4"){
	  ?>
      		<span class="colorRed">E-mail inexistente!</span>
      <?php
	  	}
	  ?>
      <div class="linksTop"><a href="index.php?pg=5"> Esqueceu sua senha?</a></div>
    </div>
  </div>
  <!---- Conteudo Principal Home ---->
  
  