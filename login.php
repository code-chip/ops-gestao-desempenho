<?php
session_start();
include('conexao.php');
if(empty($_POST['usuario']) || empty($_POST['senha'])){
	header('Location: index.php');
	exit();
}
//funcao p/ proteção de ataque sqlinject
$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
$query="select * from id8414870_projetoalfa.USUARIO where login='".$_POST['usuario']."' and senha=md5(".$_POST['senha'].")";

$result = mysqli_query($conexao, $query);
 
$row = mysqli_num_rows($result);
//echo $row;
if($row == 1){
	$_SESSION['usuario'] = $_POST['usuario'];
	header('Location: painel.php');
	exit();
}
else{
	$_SESSION['nao_autenticado']=true;
	header('Location: index.php');
}

?>