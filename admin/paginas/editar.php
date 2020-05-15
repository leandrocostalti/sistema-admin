	<section class="cadastro">
		<div class="container">
			<div class="row">
				<?php
					include_once('../config/conexao.php');
					if(!isset($_GET['idUp'])){
						/*header é uma função de redirecionamento*/
						header("Location: home.php");
						/*Oculta todos os dados da página depois da linha do erro*/
				        exit;
					}
					$id = $_GET['idUp'];

					$select = "SELECT * FROM tb_admin WHERE id_admin=:id";
				      try{
				        $resultado = $conect->prepare($select);
				        $resultado->bindParam(':id',$id,PDO::PARAM_INT);
				        $resultado->execute();
				        //CONTA REGISTRO
				        $contar = $resultado->rowCount();
				        if($contar > 0){
				          while ($show = $resultado->FETCH(PDO::FETCH_OBJ)) {
				            $idAdmin = $show->id_admin;
				            $nome = $show->nome;
				            $email = $show->email;
				            $senha = $show->senha;
				            $imgP = $show->foto_admin;
				            $status = $show->status;
				          }
				        }else{
				          echo '<div class="alert alert-danger"> <strong>Aviso!</strong> Não há dados com o id(parametro) informado :( </div>';
				        }
				        // -----------
				      }catch(PDOException $e){
				        echo "<b>ERRO DE PDO NO SELECT: </b>".$e->getMessage();
				      }
				?>
				<div class="col-lg-6">
					<form action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Avatar:</label>
							<input type="file" name="avatar" class="form-control">
						</div>
						<div class="form-group">
							<label>Nome:</label>
							<input disabled="" value="<?php echo $nome; ?>" type="text" name="nome" class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail:</label>
							<input disabled="" value="<?php echo $email; ?>" type="email" name="email"  class="form-control">
						</div>
						<div class="form-group">
							<label>Senha:</label>
							<input disabled="" value="<?php echo $senha; ?>" type="password" name="senha"  class="form-control">
						</div>
						<div class="form-group">
							<label>Status:</label>
							<select name="status"  class="form-control">
								<option value="" disabled="">Selecione um gênero</option>
								<option value="<?php $statusu = 0; echo $statusu; ?>" <?php echo ($statusu == $status) ? 'selected':''?> >Inativo</option>
								<option value="<?php $statusu = 1; echo $statusu; ?>" <?php echo ($statusu == $status) ? 'selected':''?> >Ativo</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" name="botao" class="btn btn-warning">Editar</button>
						</div>
					</form>
					<?php
						if(isset($_POST['botao'])){
							
							$status = trim(strip_tags($_POST['status']));

							$update = "UPDATE tb_admin SET status=:status WHERE id_admin=:id";

				            try{
				            	$result = $conect->prepare($update);
				                $result->bindParam(':id',$id,PDO::PARAM_INT);
				                $result->bindParam(':status',$status,PDO::PARAM_INT);
				                $result->execute();

				                $contar = $result->rowCount();
				                if($contar>0){
				                	echo '<div class="alert alert-success" role="alert">Dados atualizados com sucesso!</div>';
				                	header("Refresh: 3; home.php");
				                }else{
				                	echo '<div class="alert alert-danger" role="alert">Dados não atualizados!</div>';
				                }
				            }catch(PDOException $e){
				                echo "<b>ERRO DE PDO= </b>".$e->getMessage();
				            }
						}
					?>
				</div>
				<div class="col-lg-6" style="text-align: center">
					<h1><?php echo $nome; ?></h1>
					<hr>
					<img style="width: 200px; border-radius: 100%" src="../img/<?php echo $imgP; ?>" alt="">
					<p><?php echo $email; ?></p>
					<p>
						<?php
								if($status == 0){
									echo 'Desativado';
								}elseif($status == 1){
								 echo 'Ativado';
								}else{
								 echo 'Administrador';
								}
							?>
					</p>
				</div>
			</div>
		</div>
	</section>
	<footer class="rodape">

	</footer>
	<!-- ARQUIVOS JS-->
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/popper.min.js"></script>
</body>
</html>