	<h2 style="text-align: center; font-size: 40px; padding-top: 20px;">Editar Perfil</h2>
	<hr>
	<section class="cadastro">
		<div class="container">
			<div class="row">
				
				<div class="col-lg-6">
					<form action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Avatar:</label>
							<input type="file" name="avatar" class="form-control">
						</div>
						<div class="form-group">
							<label>Nome:</label>
							<input value="<?php echo $nome; ?>" type="text" name="nome" class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail:</label>
							<input value="<?php echo $email; ?>" type="text" name="email"  class="form-control">
						</div>
						<div class="form-group">
							<label>Senha:</label>
							<input value="<?php echo base64_decode($senha); ?>" type="password" name="senha"  class="form-control">
						</div>
						
						<div class="form-group">
							<button type="submit" name="botao" class="btn btn-warning">Editar Perfil</button>
						</div>
					</form>
					<?php
					include_once('config/conexao.php');

					if(!isset($_GET['upperfil'])){
						header("Location: home.php");
						exit;
					}
					$id = $_GET['upperfil'];

					if (isset($_POST['botao'])) {
						$nome = $_POST['nome'];
						$email = $_POST['email'];
						$senha = base64_encode($_POST['senha']);

						if(!empty($_FILES['avatar']['name'])){
							$formatosPermitidos = array("png","jpeg","jpg","gif");
							$extensao = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
							if(in_array($extensao, $formatosPermitidos)):
								$pasta = "img/";
								$temporario = $_FILES['avatar']['tmp_name'];
								$novoNome = uniqid().".{$extensao}";

								if (move_uploaded_file($temporario, $pasta.$novoNome)) {
									//Upload da Imagem
								}else{
									$mensagem = "Erro, não foi possivel fazer o upload do arquivo!";
								}
							else:
								echo  "Formato inválido";
							endif;
						}else{
							$novoNome = $avatar;
						}
						$update = "UPDATE tb_admin SET nome=:nome,email=:email,senha=:senha,foto_admin=:foto_admin WHERE id_admin=:id";

			            try{
			            	$result = $conect->prepare($update);
			                $result->bindParam(':id',$id,PDO::PARAM_STR);
			                $result->bindParam(':nome',$nome,PDO::PARAM_STR);
			                $result->bindParam(':email',$email,PDO::PARAM_STR);
			                $result->bindParam(':senha',$senha,PDO::PARAM_STR);
			                $result->bindParam(':foto_admin',$novoNome,PDO::PARAM_STR);
			                $result->execute();

			                $contar = $result->rowCount();
			                if($contar>0){
			                	echo '<div class="alert alert-success" role="alert">
									  Dados atualizados com sucesso!
								  </div>';
			                	header("Refresh: 4, home.php");
			                }else{
			                	echo '<div class="alert alert-success" role="alert">
									  Dados não atualizados!
								  </div>';
			                }
			            }catch(PDOException $e){
			                echo "<b>ERRO DE PDO= </b>".$e->getMessage();
			            }

						
						//var_dump($_FILES);
					}
				?>
				</div>
				<div class="col-lg-6" style="text-align: center;">
					<h1><?php echo $nome; ?></h1>
					<hr>
					<img style="border-radius: 100%; width: 200px" src="img/<?php echo $avatar; ?>" alt="">
					<p>Email: <?php echo $email; ?></p>
				</div>
			</div>
		</div>
	</section>
	<footer class="rodape">

	</footer>
	<!-- ARQUIVOS JS-->
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/popper.min.js"></script>
</body>
</html>