<?php
	include_once('includes/header.php');
	if (isset($_GET['acao'])) {
		$acao = $_GET['acao'];
		if ($acao == 'bemvindo') {
		include_once('paginas/principal.php');
		}elseif ($acao == 'cadastro') {
		include_once('paginas/cadastro.php');
		}elseif ($acao == 'editar') {
		include_once('paginas/editar.php');
		}elseif ($acao == 'editar-perfil') {
		include_once('paginas/editar-perfil.php');
		}
	}else{
		include_once('paginas/principal.php');
	}
	include_once('includes/footer.php');