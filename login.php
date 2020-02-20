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
$query="SELECT ID, NOME, SENHA, CARGO_ID, PERMISSAO_ID, MATRICULA FROM USUARIO WHERE LOGIN='".$_POST['usuario']."' AND SENHA=md5('".$_POST['senha']."') AND SITUACAO<>'Desligado'";
$result = mysqli_query($phpmyadmin, $query);
$row = mysqli_num_rows($result);
if($row == 1){//ADICIONAR INFORMAÇÕES DE ACESSO NA TABELA.
	$cnx= $result->fetch_array();
	$_SESSION["userId"]=$cnx["ID"];
	$_SESSION["nameUser"]=$cnx["NOME"];
	$_SESSION["cargo"]=$cnx["CARGO_ID"];
	$_SESSION["permissao"]=$cnx["PERMISSAO_ID"];
	$_SESSION["matriculaLogada"]=$cnx["MATRICULA"];
	$countCheck="SELECT MAX(ACESSO_TOTAL) AS ACESSO_TOTAL FROM ACESSO WHERE USUARIO_ID=".$cnx["ID"].";";
	$monthCheck="SELECT ANO_MES, ACESSO FROM ACESSO WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';";
	$check=mysqli_query($phpmyadmin, $countCheck);
	$check2=mysqli_query($phpmyadmin, $monthCheck);
	$cc=$check->fetch_array();
	$cm=$check2->fetch_array();	
	$acessoTotal=$cc["ACESSO_TOTAL"]+1;
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');		
	if(mysqli_num_rows($check2)!=0){//SE JÁ HOUVE REGISTRO DE ACESSO NO MÊS, O MESMO REGISTRO SERÁ ATUALIZADO.
		$acesso=$cm["ACESSO"]+1;
		$upAcesso="UPDATE ACESSO SET ULTIMO_LOGIN='".date('Y-m-d H:i:s', time())."', ACESSO=".$acesso.", ACESSO_TOTAL=".$acessoTotal." WHERE USUARIO_ID=".$cnx["ID"]." AND ANO_MES='".date('Y-m')."';";
		$up=mysqli_query($phpmyadmin, $upAcesso);		
	}
	else{//CASO SEJA O PRIMEIRO ACESSO DO MÊS, INSERE UM NOVO REGISTRO NA TABELA.		
		$addAcesso="INSERT INTO ACESSO(USUARIO_ID, ULTIMO_LOGIN, ANO_MES ,ACESSO, ACESSO_TOTAL) VALUES(".$cnx["ID"].", '".date('Y-m-d H:i:s',time())."','".date('Y-m')."',1,".$acessoTotal.")";
		$up=mysqli_query($phpmyadmin, $addAcesso);
	}
	//ADICIONA DATA E HORA NA TABELA ACESSO_HISTORICO.
	$queryDh="INSERT INTO ACESSO_HISTORICO(USUARIO_ID, DATA_HORA) VALUES(".$_SESSION["userId"].",'".date('Y-m-d H:i:s', time())."')";
	$upAcesso=mysqli_query($phpmyadmin, $queryDh);

	$_SESSION["$visualizou"]=false;//VARIAVEL P/ PÁGINA HOME.
	$_SESSION['usuario'] = $_POST['usuario'];
	header('Location: home.php');
	exit();
}
else{
	$_SESSION['nao_autenticado']=true;
	header('Location: index.php');
}
?>