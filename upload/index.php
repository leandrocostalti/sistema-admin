<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Upload Simples</title>
</head>
<body>

	<form action="" method="POST" enctype="multipart/form-data">
		<input type="file" name="arquivo">
		<input type="text" name="descricao" placeholder="Descrição do Arquivo...">
		<input type="submit" name="upload" value="Enviar Arquivo">
	</form>
	<?php
		include_once('../config/conexao.php');
		if (isset($_POST['upload'])) {
			$descricao = $_POST['descricao'];
			$formatosPermitidos = array("png","jpeg","jpg","gif");
			$extensao = pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);
			if(in_array($extensao, $formatosPermitidos)){
				//echo "Formato {$extensao} válido ";
				$pasta = "img/";
				$temporario = $_FILES['arquivo']['tmp_name'];
				$novoNome = uniqid().".{$extensao}";
				if (move_uploaded_file($temporario, $pasta.$novoNome)) {
					//echo "Arquivo enviado!";
					$cadastro = "INSERT INTO tb_up (desc_up,img_up) VALUES (:desc_up,:img_up)";
					try{
						$result = $conect->prepare($cadastro);
						$result->bindParam(':desc_up',$descricao,PDO::PARAM_STR);
				        $result->bindParam(':img_up',$novoNome,PDO::PARAM_STR);
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
				}else{
					echo "Arquivo não enviado!";
				}
			}else{
				echo "Formato {$extensao} inválido ";
			}
			//var_dump($_FILES['arquivo']);
		}

	?>

	<table style="width: 100%; border:1px solid #ccc; text-align: center">
		<tr>
			<th>Descrição</th>
			<th>Imagem de Perfil</th>
		</tr>
		<?php
			$select = "SELECT * FROM tb_up ORDER BY id_up DESC";
			try{
                  $result = $conect->prepare($select);
                  $result->execute();
                  $contar = $result->rowCount();
                  if ($contar>0) {
                    while ($show = $result->FETCH(PDO::FETCH_OBJ)) {

		?>
		<tr>
			<td><?php echo $show->desc_up;?></td>
			<td><img src="img/<?php echo $show->img_up;?>" style="width: 40px; border-radius: 100px;"></td>
		</tr>
		<?php
					}
                }else{
                    echo 'Não há contatos cadastrados!';
                  }
                }catch(PDOException $e){
                  echo "<b>Erro de select do PDO</b>".$e->getMessage();
                }
		?>
	</table>
</body>
</html>