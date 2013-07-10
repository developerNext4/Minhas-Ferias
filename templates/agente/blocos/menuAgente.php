<?php
$blocos = new Blocos();
?>
<div class="span2"><br /><br />
	<center><a href="index.php?pg=5"><button class="btn btn-primary" type="submit">Visualizar Meu Score</button></a></center><br />
    <ul class="nav nav-pills nav-stacked">
        <li <?php $blocos->get_current('index.php?pg=2') ?>>
        <a href="index.php?pg=2">Atualizar Cadastro</a>
        </li>
        <li <?php $blocos->get_current('index.php?pg=1') ?>>
        <a href="index.php?pg=1">Procurar Clientes</a>
        </li>
        <li <?php $blocos->get_current('index.php?pg=3') ?>>
        <a href="index.php?pg=3">Propostas Efetuadas</a>
        </li>
        <li <?php $blocos->get_current('index.php?pg=6') ?>>
        <a href="index.php?pg=6">Minha Conta</a>
        </li>
     </ul>
</div>