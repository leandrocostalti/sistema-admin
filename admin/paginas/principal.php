	<h2 style="text-align: center; text-transform: uppercase; margin-top: 15px;">Usuarios do Sistema</h2>
	<hr>
	<section class="cadastro">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<table class="table display" id="table_id">
						<thead>
							<tr>
								<th>Avatar</th>
								<th>Nome User</th>
								<th>E-mail</th>
								<th>Status</th>
								<th>Deletar</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$select = "SELECT * FROM tb_admin ORDER BY id_admin DESC";
								try{
									$result = $conect->prepare($select);
    								$result->execute();
    								$contar = $result->rowCount();
    								if ($contar>0) {
    									while($show = $result->FETCH(PDO::FETCH_OBJ)){
							?>
							<tr>
								<td style="text-align: center"> <img style="width: 100px; border-radius: 100%" src="../img/<?php echo $show->foto_admin;?>" alt="">  </td>
								<td><?php echo $show->nome;?></td>
								<td><?php echo $show->email;?></td>
								<td>
		<?php
			$status = $show->status;
			if($status==0){
				echo '<a href="home.php?acao=update&idUp='.$show->id_admin.'" class="btn btn-danger">Desativado</a>';
			}elseif ($status == 1) {
				echo '<a href="home.php?acao=update&idUp='.$show->id_admin.'" class="btn btn-success">Ativado</a>';
			}else{
				echo '<a href="#" class="btn btn-primary">Administrador</a>';
			}
		?>
								</td>
								<td><a href="paginas/delete.php?deletar=<?php echo $show->id_admin; ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente deletar o Registro')">Deletar</a></td>
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
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/datatables.min.js"></script>
	<script>
		$(document).ready( function () {
		    $('#table_id').DataTable();
		} );
	</script>
</body>
</html>










