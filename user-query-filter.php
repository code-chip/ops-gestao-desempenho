<?php
$menuAtivo = 'configuracoes';
require('menu.php');
//array_push($_SESSION["filter"],null);

if ($_SESSION["permissao"] == 1) {
	$checkAdress = "SELECT USUARIO_ID FROM ENDERECO WHERE USUARIO_ID = ".$_SESSION["userId"];
	$cnx = mysqli_query($phpmyadmin, $checkAdress);
	$endereco = $cnx->fetch_array();
	$hasAdress = mysqli_num_rows($cnx);
	list($nome, $sobrenome) = explode(' ', $_SESSION["nameUser"],2);
	
	if ($_SESSION["filter"][1] == "adress-insert.php") {//CASO SEJA INSERIR, VERIFICA SE JÁ EXISTE CADASTRO.		
		if ($hasAdress == 0) {
			$_SESSION["filter"][3] = $_SESSION["userId"];
			array_push($_SESSION["filter"],$_SESSION["nameUser"]);
			echo "<script>window.location.href='".$_SESSION["filter"][1]."';</script>";
		} else {			
			echo "<script>alert('".$nome." seu endereço já está cadastrado!'); window.location.href='register.php';</script>";
		}
	} else {//Caso seja opções de consultar e atualizar.
		if ($hasAdress > 0) {
			$_SESSION["filter"][3] = $_SESSION["userId"];
			array_push($_SESSION["filter"],$_SESSION["nameUser"]);
			echo "<script>window.location.href='" . $_SESSION["filter"][1] . "'; </script>";
		} else {
			echo "<script>alert('".$nome." seu endereço não foi cadastrado!'); window.location.href='register.php';</script>";
		}	
	}
} 

$filtro = trim($_REQUEST['filtro']);
$busca= trim($_REQUEST['busca']);

?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - <?php echo $_SESSION["filter"][0];?></title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones -->
	<script type="text/javascript" src="js/myjs.js"></script>
	<style type="text/css">
		.button{
			width: 128px;
		}
	</style>
</head>
<body>
</br>
<div>
<?php if($filtro =="" && isset($_POST['consultar'])==null ): ?>
<section class="section">
  	<div class="container">  		
	<form id="form1" action="user-query-filter.php" method="POST">
		<div class="field">				
			<label class="label is-size-7-touch">Filtro*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select onchange="upPlaceholder(this.value)" name="filtro" id="tipoCampo">
						<option value="MATRICULA=">Matricula</option>
						<option value="LOGIN=">Login</option>
						<option value="NOME LIKE">Nome</option>
						<option value="EMAIL=">E-mail</option>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-filter"></i>
					</span>
				</div>
			</div>
		</div>			
		<div class="field">
			<label class="label is-size-7-touch">Buscar*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth"><!--SELEÇÃO OU PESQUISA DE NOME-->
					<input name="busca" type="text" class="input" id="filtro" placeholder="629">
					<span class="icon is-small is-left">
						<i class="fas fa-search"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<button name="search" type="submit" class="button is-primary btn128">Pesquisar</button>
				</div>
				<div class="control">
					<button name="search" type="reset" class="button is-primary btn128">Limpar</button>
				</div>
				<div class="control">
					<a href="register.php" class="button is-primary btn128">Cancelar</a>	
				</div>
			</div>
		</div>						
	</form>
	</div>
</section>	
<?php 
endif;
echo "</div>";	

if ( $busca != "") {
	function checkQuery($cx) {
		if (mysqli_error($cx) != null) {
			echo "<script>alert('Erro, o valor inserido no campo buscar é inválido!'); window.location.href=window.location.href;</script>";
		}
	}

	if ($filtro == "MATRICULA=") {
		$f = "U." . $filtro . "" . $busca . " LIMIT 1;";
	} else {
		$f = "U." . $filtro . "'" . $busca . "' LIMIT 1;";
	}	
	
	$cnx2 = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM USUARIO U WHERE " . $f);
	checkQuery($phpmyadmin);
	$dados = $cnx2->fetch_array();
	
	$cnx3 = mysqli_query($phpmyadmin, "SELECT USUARIO_ID FROM ENDERECO WHERE USUARIO_ID = " . $dados["ID"]);
	checkQuery($phpmyadmin);
	$endereco = $cnx3->fetch_array();
	$cadastrado = mysqli_num_rows($cnx3);
	
	if (mysqli_num_rows($cnx) == 0) {		
		mysqli_error($phpmyadmin);		
		echo "<script>alert('Nenhum usuário encontrado com o filtro aplicado!'); window.location.href=window.location.href;</script>";			
	} else {		
		if ($_SESSION["filter"][1] == "adress-insert.php") {//CASO SEJA INSERIR, VERIFICA SE JÁ EXISTE CADASTRO.
			if ($cadastrado == 0) {//verifica se não tem endereço.
				$_SESSION["filter"][3] = $dados["ID"];
				$_SESSION["filter"][2] = $dados["NOME"];
				echo "<script>window.location.href='" . $_SESSION["filter"][1] . "';</script>";
			} else {
				echo "<script>alert('Já existe endereço cadastrado para " . $dados["NOME"] . "!'); window.location.href=window.location.href;</script>";
			}
		} else {//Caso seja consultar, atualizar e remover endereço.
			if ($cadastrado >= 1) {//verifica se existe endereço.
				$_SESSION["filter"][2] = $dados["NOME"];
				$_SESSION["filter"][3] = $dados["ID"];				
				echo "<script>window.location.href='" . $_SESSION["filter"][1] . "';</script>";
			} else {
				echo "<script>alert('Não existe endereço cadastrado para " . $dados["NOME"] . "!'); window.location.href='user-query-filter.php';</script>";
			}
		}
		
	}	
} else if (isset($_POST['consultar']) != null) {
	echo "<script>alert('O Preenchimento do campo busca é obrigatório.!'); window.location.href=window.location.href;</script>";	
}	
?>
