<?php

session_start();
require_once('connection.php');

if (empty($_POST['usuario']) || empty($_POST['senha']))
{
	header('Location: index.php');
	exit();
}

$result = mysqli_query($phpmyadmin, "SELECT ID, NOME, CARGO_ID, GESTOR_ID, PERMISSAO_ID, MATRICULA FROM USUARIO WHERE LOGIN='".mysqli_real_escape_string($phpmyadmin, $_POST['usuario'])."' AND SENHA=md5('".mysqli_real_escape_string($phpmyadmin, $_POST['senha'])."') AND SITUACAO<>'Desligado'");

if (mysqli_num_rows($result) == 1) {//ADICIONAR INFORMAÇÕES DE ACESSO NA TABELA.
	$cnx = $result->fetch_array();

	$_SESSION['userId'] = $cnx['ID'];
    $_SESSION['nameUser'] = $cnx['NOME'];
	$_SESSION['cargo'] = $cnx['CARGO_ID'];
    $_SESSION['leaderId'] = $cnx['GESTOR_ID'];
	$_SESSION['permissao'] = $cnx['PERMISSAO_ID'];
	$_SESSION['matriclaLogada'] = $cnx['MATRICULA'];

	$totalAccess = mysqli_query($phpmyadmin, "SELECT MAX(ACESSO_TOTAL) AS ACESSO_TOTAL FROM ACESSO WHERE USUARIO_ID=".$cnx["ID"].";")->fetch_array();
    $access = mysqli_query($phpmyadmin, "SELECT ANO_MES, ACESSO FROM ACESSO WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';");

    date_default_timezone_set('America/Sao_Paulo');

    if (mysqli_num_rows($access) != 0) {//SE JÁ HOUVE REGISTRO DE ACESSO NO MÊS, O MESMO REGISTRO SERÁ ATUALIZADO.
        $monthAccess = $access->fetch_array();
		mysqli_query($phpmyadmin, "UPDATE ACESSO SET ULTIMO_LOGIN='".date('Y-m-d H:i:s', time())."', ACESSO=".$monthAccess["ACESSO"]."+1, ACESSO_TOTAL=".$totalAccess["ACESSO_TOTAL"]."+1 WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';");
	}
	else {//CASO SEJA O PRIMEIRO ACESSO DO MÊS, INSERE UM NOVO REGISTRO NA TABELA.
		mysqli_query($phpmyadmin, "INSERT INTO ACESSO(USUARIO_ID, ULTIMO_LOGIN, ANO_MES ,ACESSO, ACESSO_TOTAL) VALUES(".$cnx["ID"].", '".date('Y-m-d H:i:s',time())."','".date('Y-m')."',1,".$totalAccess["ACESSO_TOTAL"]."+1)");
	}

	mysqli_query($phpmyadmin, "INSERT INTO ACESSO_HISTORICO(USUARIO_ID, DATA_HORA) VALUES(".$_SESSION["userId"].",'".date('Y-m-d H:i:s', time())."')");

	$_SESSION['$messageRead'] = 0;//VARIAVEL P/ PÁGINA HOME.
	$_SESSION['usuario'] = $_POST['usuario'];
	header('Location: home.php');
	exit();
}
else{
	$_SESSION['nao_autenticado'] = true;
	header('Location: index.php');
}