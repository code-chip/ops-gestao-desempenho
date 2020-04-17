<?php 
$menuAtivo="configuracoes";
require('menu.php');
require('connection.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
	if(!empty($_FILES['arquivo']['tmp_name']) && $_FILES['arquivo']['type']=="text/xml"){
		$registro=date('Y-m-d');
		$arquivo = new DomDocument();
		$arquivo->load($_FILES['arquivo']['tmp_name']);
		//var_dump($arquivo);
		$linhas = $arquivo->getElementsByTagName("Row");
		//var_dump($linhas);		
		$primeira_linha = true;		
		foreach($linhas as $linha){
			if($primeira_linha == false){
				$matricula = $linha->getElementsByTagName("Data")->item(0)->nodeValue;						
				$cupom = $linha->getElementsByTagName("Data")->item(2)->nodeValue;				
				$insertCoupon = "INSERT INTO CUPOM(MATRICULA_ID, CODIGO, REGISTRO) VALUES($matricula, '$cupom', '$registro');";
				mysqli_query($phpmyadmin, $insertCoupon);
			}
			$primeira_linha = false;
		}
		if(mysqli_error($phpmyadmin)!=""){
			echo "<script>alert('Erro:".mysqli_error($phpmyadmin)."')</script>";
			
		}
		else{
			echo "<script>alert('Cupons importados com sucesso')</script>";
		}
	}
	else if(!empty($_FILES['arquivo']['tmp_name']) && $_FILES['arquivo']['type']!="text/xml"){
		echo "<script>alert('O arquivo precisa está no formato XML.')</script>";
	}
	else if(isset($_POST['inserirCupom'])!=null){
		echo "<script>alert('Nenhum arquivo foi anexado!')</script>";
	}				
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Cupom</title>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones-->
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form enctype="multipart/form-data" action="coupon-insert.php" method="POST" id="form1" onsubmit="return menuInsertcheckForm()">
				<div class="field is-horizontal is-left">
					<div class="field-label is-normal">
						<label class="label">Arquivo</label>
					</div>
					<div class="field-body" style="width:28.5em;">
						<div class="field" style="width:28.5em;">	
							<div id="file-js-example" class="file has-name" style="width:28.5em;">
							  	<label class="file-label" style="width:28.5em;">
							  		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
							    	<input class="file-input" type="file" name="arquivo" style="width:28.5em;">
							    	<span class="file-cta">
							      		<span class="file-icon">
							        		<i class="fas fa-upload"></i>
							      		</span>
							      		<span class="file-label">
							        		Selecione…
							      		</span>
							    	</span>
							    	<span class="file-name">
							      		Nenhum arquivo selecionado
							    	</span>
							  	</label>
							  	
							</div>
						</div>						
					</div>
				</div>	
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label" ><hidden>Cupons</hidden></label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">
							<div class="control">
								<button name="inserirCupom" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
							</div>
							<div class="control">
								<a href="register.php" class="button is-primary">Voltar</a>
							</div>						
						</div>
					</div>
				</div>
	     	</form>
	   	</div>	   	
	</section>
	<script>
  	const fileInput = document.querySelector('#file-js-example input[type=file]');
  	fileInput.onchange = () => {
    	if (fileInput.files.length > 0) {
      		const fileName = document.querySelector('#file-js-example .file-name');
      	fileName.textContent = fileInput.files[0].name;
    	}
  	}
</script>	 	
</body>
</html><?php }//ELSE - caso o usuário tenha permissão.?>