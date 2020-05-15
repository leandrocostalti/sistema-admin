	<section class="cadastro">
		<div class="container">
			<div class="row">
				<?php
					include_once('config/conexao.php');
					if(!isset($_GET['editar'])){
						/*header é uma função de redirecionamento*/
						header("Location: index.php");
						/*Oculta todos os dados da página depois da linha do erro*/
				        exit;
					}
					$id = $_GET['editar'];

				    $select = "SELECT * FROM fornecedor WHERE codigo=:id";

				    try{
				    	$resultado = $conect->prepare($select);
				        $resultado->bindParam(':id',$id,PDO::PARAM_INT);
				        $resultado->execute();
				        //CONTA REGISTRO
				        $contar = $resultado->rowCount();
				        if($contar > 0){
				          while ($show = $resultado->FETCH(PDO::FETCH_OBJ)) {
				            $codigo = $show->codigo;
				            $nome = $show->nome;
				            $snome = $show->sobre_nome;
				            $email = $show->email;
				            $datan = $show->data_n;
				            $genero = $show->genero;
				          }
				        }else{
				          echo '<div class="alert alert-danger"> <strong>Aviso!</strong> Não há dados com o id(parametro) informado :( </div>';
				        }
				    }catch(PDOException $e){
				        echo "<b>ERRO DE PDO NO SELECT: </b>".$e->getMessage();
				    }
				?>
				<div class="col-lg-6">
					<form action="" method="post">
						<div class="form-group">
							<label>Nome:</label>
							<input value="<?php echo $nome; ?>" type="text" name="nome" class="form-control">
						</div>
						<div class="form-group">
							<label>Sobre nome:</label>
							<input value="<?php echo $snome; ?>" type="text" name="sobrenome"  class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail:</label>
							<input value="<?php echo $email; ?>" type="email" name="email"  class="form-control">
						</div>
						<div class="form-group">
							<label>Data:</label>
							<input value="<?php echo $datan; ?>" type="text" name="data"  class="form-control">
						</div>
						<div class="form-group">
							<label>Gênero:</label>
							<select name="genero"  class="form-control">
								<option value="" disabled="">Selecione um gênero</option>
								<option value="<?php $sexo = "M"; echo $sexo; ?>" <?php echo ($sexo == $genero) ? 'selected':''?> >Masculino</option>
								<option value="<?php $sexo = "F"; echo $sexo; ?>"  <?php echo ($sexo == $genero) ? 'selected':''?> >Feminino</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" name="botao" class="btn btn-warning">Editar</button>
						</div>
					</form>
					<?php
						if(isset($_POST['botao'])){
							$nome = trim(strip_tags($_POST['nome']));
							$sobrenome = trim(strip_tags($_POST['sobrenome']));
							$email = trim(strip_tags($_POST['email']));
							$datan = trim(strip_tags($_POST['data']));
							$genero = trim(strip_tags($_POST['genero']));

							$update = "UPDATE fornecedor SET nome=:nome,sobre_nome=:snome,email=:email,data_n=:datan,genero=:genero WHERE codigo=:id";

				            try{
				            	$result = $conect->prepare($update);
				            	$result->bindParam(':id',$id,PDO::PARAM_INT);
				                $result->bindParam(':nome',$nome,PDO::PARAM_STR);
				                $result->bindParam(':snome',$sobrenome,PDO::PARAM_STR);
				                $result->bindParam(':email',$email,PDO::PARAM_STR);
				                $result->bindParam(':datan',$datan,PDO::PARAM_STR);
				                $result->bindParam(':genero',$genero,PDO::PARAM_STR);
				                $result->execute();

				                $contar = $result->rowCount();
				                if($contar>0){
				                	echo '<div class="alert alert-success" role="alert">Dados atualizados com sucesso!</div>';
				                }else{
				                	echo '<div class="alert alert-danger" role="alert">Dados não atualizados!</div>';
				                }
				            }catch(PDOException $e){
				                echo "<b>ERRO DE PDO= </b>".$e->getMessage();
				            }
						}
					?>
				</div>
				<div class="col-lg-6">
					<h1><?php echo $nome; ?> <?php echo $snome; ?></h1>
					<hr>
					<p><?php echo $email; ?></p>
					<p><?php echo $datan; ?></p>
					<p><?php echo $genero; ?></p>
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