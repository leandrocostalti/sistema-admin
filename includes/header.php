<?php
ob_start();
session_start();
if (!isset($_SESSION['loginUser']) && (!isset($_SESSION['senhaUser']))) {
  header("Location: index.php?acao=negado");
  exit;
}
include_once('sair.php');
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
	<?php
		include_once('config/conexao.php');
		$userEmail = $_SESSION['loginUser'];
      	$senhaUser = $_SESSION['senhaUser'];
      	$select = "SELECT * FROM tb_admin WHERE email=:emailUser AND senha=:senhaUser";
      	try{
      	$resultado = $conect->prepare($select);
      	$resultado->bindParam(':emailUser',$userEmail,PDO::PARAM_STR);
        $resultado->bindParam(':senhaUser',$senhaUser,PDO::PARAM_STR);
        $resultado->execute();
        //CONTA REGISTRO
        $contar = $resultado->rowCount();
        if ($contar > 0) {
          while ($show = $resultado->FETCH(PDO::FETCH_OBJ)) {
            $idAdmin = $show->id_admin;
            $nome = $show->nome;
            $email = $show->email;
            $senha = $show->senha;
            $avatar = $show->foto_admin;
            $status = $show->status;
          }
        } else {
        	header("Location: ?sair");
        }
        
      	}catch(PDOException $e){
        echo "<b>ERRO DE PDO NO SELECT: </b>".$e->getMessage();
      }
	?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	        <a class="navbar-brand" href="home.php">Loja JMF</a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	            <span class="navbar-toggler-icon"></span>
	        </button>
	        <div id="navbarNavDropdown" class="navbar-collapse collapse">
	            <ul class="navbar-nav mr-auto">
	            </ul>
	            <ul class="navbar-nav">
	                <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	<img src="img/<?php echo $avatar; ?>" style="border-radius: 100%; width: 50px;">
				          </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a class="dropdown-item" href="home.php?acao=perfil&upperfil=<?php echo $idAdmin; ?>">Perfil</a>
				          <div class="dropdown-divider"></div>
				          <a class="dropdown-item" href="?sair" onclick="return confirm('Deseja realmente sair do sistema?')">Sair</a>
				        </div>
				      </li>
	            </ul>
	        </div>
	    </nav>
	
