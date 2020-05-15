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
	                        <h3 class="panel-title">Cadastrar Utilizador</h3>
	                    </div>
	                    <div class="panel-body">
	                        <form role="form" action="" method="post" enctype="multipart/form-data">
	                         <div class="form-group">
							    <label for="imgP">Foto de perfil:</label>
							    <input type="file" id="imgP" name="avatar" value="">
							  </div>
							  <div class="form-group">
							    <label for="nomeuser">Nome do utilizador:</label>
							    <input type="text" class="form-control" id="nomeuser" name="nomeuser" placeholder="Digite seu nome...">
							  </div>
							  <div class="form-group">
							    <label for="email">E-mail:</label>
							    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail...">
							  </div>
							  <div class="form-group">
							    <label for="senha">Senha: </label>
							    <input type="password" class="form-control" id="senha" name="senha" placeholder="senha">
							  </div>
							  <input type="hidden" name="status" value="0">
							  <button type="submit" class="btn btn-primary btn-lg" name="botao">Cadastrar Utilizador</button>
							  
							</form>
							<br>
							<?php
							include_once('config/conexao.php');
						      if (isset($_POST['botao'])) {
			$nome = $_POST['nomeuser'];
			$email = $_POST['email'];
			$senha = base64_encode($_POST['senha']);
			$status = $_POST['status'];
			$formatosPermitidos = array("png","jpeg","jpg","gif");
			$extensao = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
			if(in_array($extensao, $formatosPermitidos)):
				//echo "Existe a extenção .{$extensao}";
				$pasta = "img/";
				$temporario = $_FILES['avatar']['tmp_name'];
				$novoNome = uniqid().".{$extensao}";

				if (move_uploaded_file($temporario, $pasta.$novoNome)) {
							$cadastro = "INSERT INTO tb_admin (nome,email,senha,foto_admin,status) VALUES (:nome,:email,:senha,:foto_admin,:status)";

				            try{
				            	$result = $conect->prepare($cadastro);
				                $result->bindParam(':nome',$nome,PDO::PARAM_STR);
				                $result->bindParam(':email',$email,PDO::PARAM_STR);
				                $result->bindParam(':senha',$senha,PDO::PARAM_STR);
				                $result->bindParam(':foto_admin',$novoNome,PDO::PARAM_STR);
				                $result->bindParam(':status',$status,PDO::PARAM_INT);
				                $result->execute();

				                $contar = $result->rowCount();
				                if($contar>0){
				                	echo 'Dados cadastrados com sucesso';
				                	header("Refresh: 4, index.php");
				                }else{
				                	echo 'Dados não cadastrados!';
				                	header("Refresh: 4, index.php");
				                }
				            }catch(PDOException $e){
				                echo "<b>ERRO DE PDO= </b>".$e->getMessage();
				            }
					//$mensagem = "Upload feito com sucesso!";
				}else{
					$mensagem = "Erro, não foi possivel fazer o upload do arquivo!";
				}
			else:
				echo  "Formato inválido";
			endif;
			//var_dump($_FILES);
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