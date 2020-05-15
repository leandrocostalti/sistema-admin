<?php
ob_start(); //Inicia o cache para a sessão
session_start(); //Inicia a sessão da página(login)
if (isset($_SESSION['loginUser']) && (isset($_SESSION['senhaUser']) && (isset($_SESSION['status'])))) {
	header("Location: home.php");
	exit; //Oculta todo o código abaixo quando existe erro
}
?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CRUD com PHP e MySql</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- LOGIN -->
	<div class="container" style="margin-top:10%">
	<div class="col-md-12">
	    <div class="modal-dialog" style="margin-bottom:0;">
	        <div class="modal-content"  style="border: 0;">
	                    <div class="panel-heading">
	                        <h3 class="panel-title">Loja JMF</h3>
	                    </div>
	                    <div class="panel-body">
	                        <form role="form" action="" method="post">
							  <div class="form-group">
							    <label for="exampleInputEmail1">E-mail:</label>
							    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
							  </div>
							  <div class="form-group">
							    <label for="senha">Senha: </label>
							    <input type="password" class="form-control" id="senha" name="senha" placeholder="senha">
							  </div>
							  <input type="hidden" name="status" value="1">
							  <button type="submit" class="btn btn-warning btn-lg" name="login">Logar no Sistema</button> <a href="cadAdmin.php" class="">Solicitar Acesso</a>
							</form>
							<br>
							<?php
							include_once('config/conexao.php');
							if (isset($_GET['acao'])) {
								if (!isset($_POST['login'])){
									$acao = $_GET['acao'];
									if ($acao == 'negado') {
						            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(</div>';
						          }elseif ($acao == 'sair') {
						            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Volte sempre!</strong> esperamos o seu login ;(</div>';
						          }
								}
							}
								if (isset($_POST['login'])){
								$login = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
						        $senha = base64_encode(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));
						        $status = filter_input(INPUT_POST, 'status', FILTER_DEFAULT);
						        $select = "SELECT * FROM tb_admin WHERE email=:emailLogin AND senha=:senhaLogin AND status=:status";

						        try {
						          $resultLogin = $conect->prepare($select);
						          $resultLogin->bindParam(':emailLogin',$login, PDO::PARAM_STR);
						          $resultLogin->bindParam(':senhaLogin',$senha, PDO::PARAM_STR);
						          $resultLogin->bindParam(':status',$status, PDO::PARAM_INT);
						          $resultLogin->execute();

						          $verificar = $resultLogin->rowCount();
						          if ($verificar > 0) {
						          	$login = $_POST['email'];
						            $senha = base64_encode($_POST['senha']);
						          	$status = $_POST['status'];
						            //CRIANDO A SESSÃO DE LOGIN E SENHA
						            $_SESSION['loginUser'] = $login;
						            $_SESSION['senhaUser'] = $senha;
						            $_SESSION['status'] = $status;

						            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Logado com sucesso!</strong> Redirecionando para o sistema :)</div>';
						            header("Refresh: 3, home.php?acao=bemvindo");
						          }else{
						            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Erro!</strong> login ou senha incorretos, digite outro login ou consulte o administrador :(</div>';
						          }
						        } catch (PDOException $e){
						          echo "ERRO DE LOGIN DO PDO : ".$e->getMessage();
						        }
						      }

							?>
	                    </div>
	                </div>
	    </div>
	</div>
	</div>
<!-- LOGIN -->

<!-- ARQUIVOS JS-->
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/datatables.min.js"></script>
	<script>
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
	</script>
	<!-- https://datatables.net/ -->
	<!-- https://datatables.net/manual/installation -->
</body>
</html>