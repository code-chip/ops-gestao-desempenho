<?php
$menuAtivo="configuracoes";
require('menu.php');
array_push($_SESSION["filter"],null);

if($_SESSION["permissao"]==1){
	if($_SESSION["filter"][1]=="adress-insert.php"){//CASO SEJA INSERIR, VERIFICA SE JÁ EXISTE CADASTRO.
		$checkAdress="SELECT USUARIO_ID FROM ENDERECO WHERE USUARIO_ID=".$_SESSION["userId"];
		$cnx2=mysqli_query($phpmyadmin, $checkAdress);
		$endereco= $cnx->fetch_array();
		if(mysqli_num_rows($cnx2)==0){
			$_SESSION["filter"][3]=$_SESSION["userId"];
			array_push($_SESSION["filter"],$_SESSION["nameUser"]);
			echo "<script>window.location.href='".$_SESSION["filter"][1]."';</script>";
		}
		else{
			list($nome, $sobrenome)=explode(' ', $_SESSION["nameUser"],2);
			echo "<script>alert('".$nome." seu endereço já está cadastrado!'); window.location.href='register.php';</script>";
		}
	}
	else{
		$_SESSION["filter"][3]=$_SESSION["userId"];
		array_push($_SESSION["filter"],$_SESSION["nameUser"]);
		header("Refresh:0;url=".$_SESSION["filter"][1]);
	}
}
else{
$filtro = trim($_REQUEST['filtro']);
$busca= trim($_REQUEST['busca']);
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - <?php echo $_SESSION["filter"][0];?></title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones -->
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
</br>
<div>
<?php if($filtro =="" && isset($_POST['consultar'])==null ): ?>
<section class="section">
  	<div class="container">  		
	<form id="form1" action="user-query-filter.php" method="POST">
		<div class="field is-horizontal">				
			<div class="field-label is-normal">
				<label class="label">Filtro:</label>
			</div>
			<div class="field-body">
				<div class="field" style="max-width:17em;">							
					<div class="control">
						<div class="select">
							<select onchange="upPlaceholder(this.value)" name="filtro" id="tipoCampo">
								<option value="MATRICULA=">Matricula</option>
								<option value="LOGIN=">Login</option>
								<option value="NOME LIKE">Nome</option>
								<option value="EMAIL=">E-mail</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>			
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Buscar:</label>
			</div>
			<div class="field-body">
				<div class="field">							
					<div class="control">
						<div class="select"><!--SELEÇÃO OU PESQUISA DE NOME-->
							<input id="filtro" name="busca" type="text" class="input" placeholder="629" autofocus>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label"></div>
				<div class="field-body">
					<div class="field is-grouped">
						<div class="control">
							<button name="consultar" type="submit" class="button is-primary">Consultar</button>
						</div>
						<div class="control">
							<a href="register.php" class="button is-primary">Voltar</a>	
						</div>
					</div>
				</div>
			</div>
		</div>						
	</form>
	</div>
</section>	
<?php endif;?>
</div>	
<?php
if( $busca != ""){
	if($filtro=="MATRICULA="){
		$f="U.".$filtro."".$busca." LIMIT 1;";
	}	
	else{
		$f="U.".$filtro."'".$busca."' LIMIT 1;";
	}	
	$query="SELECT ID, NOME FROM USUARIO U WHERE ".$f;
	$cnx=mysqli_query($phpmyadmin, $query);
	$dados= $cnx->fetch_array();
	if(mysqli_num_rows($cnx)==0){		
		mysqli_error($phpmyadmin);		
		echo "<script>alert('Nenhum usuário encontrado com o filtro aplicado!'); window.location.href=window.location.href;</script>";			
	}
	else{
		$checkAdress="SELECT USUARIO_ID FROM ENDERECO WHERE USUARIO_ID=".$dados["ID"];
		$cnx2=mysqli_query($phpmyadmin, $checkAdress);
		$endereco= $cnx->fetch_array();
		if($_SESSION["filter"][1]=="adress-insert.php"){//CASO SEJA INSERIR, VERIFICA SE JÁ EXISTE CADASTRO.
			if(mysqli_num_rows($cnx2)==0){//verifica se não tem endereço.
				$_SESSION["filter"][3]=$dados["ID"];
				$_SESSION["filter"][2]=$dados["NOME"];
				echo "<script>window.location.href='".$_SESSION["filter"][1]."';</script>";
			}
			else{
				echo "<script>alert('Já existe endereço cadastrado para ".$dados["NOME"]."!'); window.location.href=window.location.href;</script>";
			}
		}
		else{//Caso seja consultar, atualizar e remover endereço.
			if(mysqli_num_rows($cnx2)==1){//verifica se existe endereço.
				$_SESSION["filter"][2]=$dados["NOME"];
				$_SESSION["filter"][3]=$dados["ID"];				
				echo "<script>window.location.href='".$_SESSION["filter"][1]."';</script>";
			}
		}
		
	}	
}
else if(isset($_POST['consultar'])!=null){
	echo "<script>alert('O Preenchimento do campo busca é obrigatório.!'); window.location.href=window.location.href;</script>";	
}	
}//Chaves final ELSE;
?><!--FINAL DO FORM FILTRAR CONSULTA-->
<!--FINAL DO FORMULÁRIO DE FILTRAGEM-->