<?php
session_start();
include('connection.php');
if(empty($_POST['usuario']) || empty($_POST['senha'])){
	header('Location: index.php');
	exit();
}
//funcao p/ proteção de ataque sqlinject
$usuario = mysqli_real_escape_string($phpmyadmin, $_POST['usuario']);
$senha = mysqli_real_escape_string($phpmyadmin, $_POST['senha']);
//$query="select * from id8414870_projetoalfa.USUARIO where login='".$_POST['usuario']."' and senha=md5(".$_POST['senha'].")";
$query="SELECT ID, NOME, SENHA FROM gd.USUARIO WHERE LOGIN='".$_POST['usuario']."' AND SENHA=md5(".$_POST['senha'].") AND SITUACAO<>'Desligado'";

$result = mysqli_query($phpmyadmin, $query);
$cnx= $result->fetch_array();
$_SESSION["loggedInUser"]=$cnx["ID"];
$row = mysqli_num_rows($result);
//echo $row;
if($row == 1){
	$_SESSION['usuario'] = $_POST['usuario'];
	header('Location: home.php');
	exit();
}
else{
	$_SESSION['nao_autenticado']=true;
	header('Location: index.php');
}

?>