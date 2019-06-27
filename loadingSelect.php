<?php
session_start();
include('conexao.php');
//require_once('js/loader.js');
include('verifica_login.php');
include('menu.php');
	/*CONSULTAS PARA CARREGAS AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/
	fuction querys(){
	echo "TESTE";
	$gdGestor="SELECT ID, NOME FROM gd.GESTOR WHERE SITUACAO='Ativo'";
	//$gdCargo="SELECT ID, NOME FROM gd.CARGO WHERE SITUACAO='Ativo'";
	//$gdTurno="SELECT ID, NOME FROM gd.TURNO WHERE SITUACAO='Ativo'";
	
	}
<?