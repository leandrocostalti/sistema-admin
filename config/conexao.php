<?php
	try{
		@DEFINE('HOST','localhost');
	    @DEFINE('DB','lojajmf');
	    @DEFINE('USER','');
	    @DEFINE('PASS','');

	    $conect = new PDO('mysql:host='.HOST.
	    ';dbname='.DB,USER,PASS);
	    $conect -> setAttribute(PDO::ATTR_ERRMODE,
	    PDO::ERRMODE_EXCEPTION);

	}catch(PDOException $e){
	    echo "<b>ERRO DE PDO = </b>".$e->getMessage();
	}
