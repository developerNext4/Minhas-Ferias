<?php
$blocos = new Blocos();
?>
<body>
<div class="container">
  <div class="row">
    <div class="span6 offset6 areaLogin">
      <!--<form class="form-inline form_Home">
        <label class="titLogin">Área de Login </label>
        <label class="check">
          <input type="checkbox">
          Mantenha-me conectado </label>
        <br />
        <input type="text" class="input-small" placeholder="Digite seu email">
        <input type="password" class="input-small" placeholder="Senha">
        <button type="submit" class="btn btn-rky">Entrar</button>
      </form>
      <div class="linksTop"><a href="#"> Esqueceu sua senha?</a> | <a href="#"> Cadastre-se</a> | <a href="#">Cadastro Fornecedores</a></div>--><br><br><div class="socialMedia"><span class="socialTul"><?php echo ($_SESSION["USR_NOME"]);?> Seja Bem-Vindo <a href="logout.php">Sair</a></span></div><br><br>
    </div>
  </div>
  </div>
  <!---- Conteudo Principal Home ---->
  <div class="wrap_adminTop">
  <div class="container">
    <div class="menuAdmin">
      <ul class="nav nav-pills">
        <li <?php $blocos->get_current('index.php?pg=1') ?>></li>
        <li <?php $blocos->get_current('index.php?pg=2') ?> style="visibility:hidden">Teste</li>
        <li <?php $blocos->get_current('index.php?pg=3') ?>></li>
        <li <?php $blocos->get_current('index.php?pg=4') ?>></li>
      </ul>
    </div>
    <!--Menu do Admin--> 
  </div>
  <!--Fecha container 1º--> 
</div>
<!--Fecha wrap_adminTop-->