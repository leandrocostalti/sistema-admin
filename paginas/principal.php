	<h2 style="text-align: center; text-transform: uppercase; margin-top: 15px;">Cadastro de fornecedor</h2>
	<hr>
	<section class="cadastro">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<form action="" method="post">
						<div class="form-group">
							<label>Nome:</label>
							<input type="text" name="nome" class="form-control">
						</div>
						<div class="form-group">
							<label>Sobre nome:</label>
							<input type="text" name="sobrenome"  class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail:</label>
							<input type="email" name="email"  class="form-control">
						</div>
						<div class="form-group">
							<label>Data:</label>
							<input type="text" name="data"  class="form-control">
						</div>
						<div class="form-group">
							<label>Gênero:</label>
							<select name="genero"  class="form-control">
								<option value="" disabled="" selected="">Selecione um gênero</option>
								<option value="M">Masculino</option>
								<option value="F">Feminino</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" name="botao" class="btn btn-warning">Cadastrar</button>
						</div>
					</form>
					<?php
						include_once('config/conexao.php');
						if(isset($_POST['botao'])){
							$nome = trim(strip_tags($_POST['nome']));
							$sobrenome = trim(strip_tags($_POST['sobrenome']));
							$email = trim(strip_tags($_POST['email']));
							$datan = trim(strip_tags($_POST['data']));
							$genero = trim(strip_tags($_POST['genero']));

							$cadastro = "INSERT INTO fornecedor (nome,sobre_nome,email,data_n,genero) VALUES (:nome,:snome,:email,:datan,:genero)";

				            try{
				            	$result = $conect->prepare($cadastro);
				                $result->bindParam(':nome',$nome,PDO::PARAM_STR);
				                $result->bindParam(':snome',$sobrenome,PDO::PARAM_STR);
				                $result->bindParam(':email',$email,PDO::PARAM_STR);
				                $result->bindParam(':datan',$datan,PDO::PARAM_STR);
				                $result->bindParam(':genero',$genero,PDO::PARAM_STR);
				                $result->execute();

				                $contar = $result->rowCount();
				                if($contar>0){
				                	echo '<div class="alert alert-success" role="alert">Dados cadastrados com sucesso!</div>';
				                }else{
				                	echo '<div class="alert alert-danger" role="alert">Dados não cadastrados!</div>';
				                }
				            }catch(PDOException $e){
				                echo "<b>ERRO DE PDO= </b>".$e->getMessage();
				            }
						}
					?>
				</div>
				<div class="col-lg-8">
					<table class="table display" id="table_id">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Sobre nome</th>
								<th>E-mail</th>
								<th>Editar</th>
								<th>Deletar</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$select = "SELECT * FROM fornecedor ORDER BY codigo DESC";
								try{
									$result = $conect->prepare($select);
    								$result->execute();
    								$contar = $result->rowCount();
    								if ($contar>0) {
    									while($show = $result->FETCH(PDO::FETCH_OBJ)){
							?>
							<tr>
								<td><?php echo $show->nome;?></td>
								<td><?php echo $show->sobre_nome;?></td>
								<td><?php echo $show->email;?></td>
								<td><a href="home.php?acao=update&editar=<?php echo $show->codigo; ?>" class="btn btn-success">Editar</a></td>
								<td><a href="paginas/delete.php?deletar=<?php echo $show->codigo; ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente deletar o Registro')">Deletar</a></td>
							</tr>
							<?php

    									}
    								} else {
    									echo '<div class="alert alert-danger" role="alert">Não há dados!
											</div>';
    								}
								}catch(PDOException $e){
						         echo "<b>Erro de select do PDO</b>".$e->getMessage();
						        }

							?>
						</tbody>
					</table>
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
	<script src="js/datatables.min.js"></script>
	<script>
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
	</script>
</body>
</html>










