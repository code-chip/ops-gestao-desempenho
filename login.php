<?php
session_start();
//curl_errno();
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
$_SESSION["nameUser"]=$cnx["NOME"];
//$count=1+$cnx["ACESSO"];
$row = mysqli_num_rows($result);
//echo $row;
if($row == 1){//ADICIONAR INFORMAÇÕES DE ACESSO NA TABELA.
	$countCheck="SELECT MAX(ACESSO_TOTAL) AS ACESSO_TOTAL FROM gd.ACESSO WHERE USUARIO_ID=".$cnx["ID"].";";
	$monthCheck="SELECT ANO_MES, ACESSO FROM gd.ACESSO WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';";
	$check=mysqli_query($phpmyadmin, $countCheck);
	$check2=mysqli_query($phpmyadmin, $monthCheck);
	$cc=$check->fetch_array();
	$cm=$check2->fetch_array();	
	$acessoTotal=$cc["ACESSO_TOTAL"]+1;		
	if(mysqli_num_rows($check2)!=0){//SE JÁ HOUVE REGISTRO NO MÊS, O MESMO REGISTRO SERÁ ATUALIZADO.
		$acesso=$cm["ACESSO"]+1;
		$upAcesso="UPDATE gd.ACESSO SET ULTIMO_LOGIN='".date('Y-m-d H:i:s')."', ACESSO=".$acesso.", ACESSO_TOTAL=".$acessoTotal." WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';";
		$up=mysqli_query($phpmyadmin, $upAcesso);		
	}
	else{//CASO SEJA O PRIMEIRO ACESSO DO MÊS, INSERE UM NOVO REGISTRO NA TABELA.		
		$addAcesso="INSERT INTO gd.ACESSO(USUARIO_ID, ULTIMO_LOGIN, ANO_MES ,ACESSO, ACESSO_TOTAL) VALUES(".$cnx["ID"].", '".date('Y-m-d H:i:s')."','".date('Y-m')."',1,".$acessoTotal.")";
		$up=mysqli_query($phpmyadmin, $addAcesso);
	}
	$_SESSION['usuario'] = $_POST['usuario'];
	header('Location: home.php');
	exit();
}
else{
	$_SESSION['nao_autenticado']=true;
	header('Location: index.php');
}
?>