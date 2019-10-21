<?php include_once("connection.php");
	$id_setor = $_REQUEST['setor'];	
	$queryUsuario = "SELECT ID, NOME FROM USUARIO WHERE SETOR_ID =$id_setor AND SITUACAO<>'Desligado' ORDER BY NOME;";
	$cnx= mysqli_query($phpmyadmin, $queryUsuario);
	
	while ($lista = mysqli_fetch_assoc($cnx)) {
		$usuarios[] = array(
			'id'	=> $lista['ID'],
			'nome_usuario' => utf8_encode($lista['NOME']),
		);
	}	
	echo(json_encode($usuarios));