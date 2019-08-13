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
$query="SELECT ID, NOME, SENHA, PERMISSAO_ID FROM USUARIO WHERE LOGIN='".$_POST['usuario']."' AND SENHA=md5(".$_POST['senha'].") AND SITUACAO<>'Desligado'";
$result = mysqli_query($phpmyadmin, $query);
$row = mysqli_num_rows($result);
if($row == 1){//ADICIONAR INFORMAÇÕES DE ACESSO NA TABELA.
	$cnx= $result->fetch_array();
	$_SESSION["loggedInUser"]=$cnx["ID"];
	$_SESSION["nameUser"]=$cnx["NOME"];
	$_SESSION["permissao"]=$cnx["PERMISSAO_ID"];
	$countCheck="SELECT MAX(ACESSO_TOTAL) AS ACESSO_TOTAL FROM ACESSO WHERE USUARIO_ID=".$cnx["ID"].";";
	$monthCheck="SELECT ANO_MES, ACESSO FROM ACESSO WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';";
	$check=mysqli_query($phpmyadmin, $countCheck);
	$check2=mysqli_query($phpmyadmin, $monthCheck);
	$cc=$check->fetch_array();
	$cm=$check2->fetch_array();	
	$acessoTotal=$cc["ACESSO_TOTAL"]+1;		
	if(mysqli_num_rows($check2)!=0){//SE JÁ HOUVE REGISTRO DE ACESSO NO MÊS, O MESMO REGISTRO SERÁ ATUALIZADO.
		$acesso=$cm["ACESSO"]+1;
		$upAcesso="UPDATE ACESSO SET ULTIMO_LOGIN='".date('Y-m-d H:i:s')."', ACESSO=".$acesso.", ACESSO_TOTAL=".$acessoTotal." WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';";
		$up=mysqli_query($phpmyadmin, $upAcesso);		
	}
	else{//CASO SEJA O PRIMEIRO ACESSO DO MÊS, INSERE UM NOVO REGISTRO NA TABELA.		
		$addAcesso="INSERT INTO ACESSO(USUARIO_ID, ULTIMO_LOGIN, ANO_MES ,ACESSO, ACESSO_TOTAL) VALUES(".$cnx["ID"].", '".date('Y-m-d H:i:s')."','".date('Y-m')."',1,".$acessoTotal.")";
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