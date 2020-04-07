<?php 
$menuAtivo="configuracoes";
require('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
if(isset($_POST["inserirMenu"])!=null){
	$nome=trim($_POST['nome']);
	$tipo=trim($_POST['tipoMenu']);
	$link=trim($_POST['link']);
	$menu=trim($_POST['menu']);
	$situacao=trim($_POST['situacao']);
	$upFile=trim($_POST['userfile']);
	function cleanString($text) {
    	$utf8 = array('/[áàâãªä]/u'=>'a', '/[ÁÀÂÃÄ]/u'=>'A', '/[ÍÌÎÏ]/u'=>'I', '/[íìîï]/u'=>'i', '/[éèêë]/u'=>'e','/[ÉÈÊË]/u'=>'E', '/[óòôõºö]/u'=>'o',
        '/[ÓÒÔÕÖ]/u'=>'O', '/[úùûü]/u'=>'u','/[ÚÙÛÜ]/u'=>'U', '/ç/'=>'c', '/Ç/'=>'C', '/ñ/'=>'n','/Ñ/'=>'N', '/@/u'=>'a','/–/'=>'-',
        '/[’‘‹›‚]/u'=>' ', '/[“”«»„]/u'=>' ', '/ /'=>' ',);
    	return preg_replace(array_keys($utf8), array_values($utf8), $text);
	}
	$tag= strtolower(cleanString($nome));
	if($nome!="" && $tipo!=""){
		if($tipo=="MENU"){
			$checkPermissoes="SELECT ID, (SELECT 1+MAX(POSICAO) FROM MENU WHERE TAG NOT IN('configuracoes','sair')) AS POSICAO FROM PERMISSAO;";
			$cnx= mysqli_query($phpmyadmin, $checkPermissoes);
		    while($permissao= $cnx->fetch_array()){
				$insMenu="INSERT INTO MENU(PERMISSAO_ID, MENU, TAG, POSICAO, LINK, SUBMENU, LIBERADO, ATIVO) VALUES(".$permissao["ID"].",'".$nome."','".$tag."',".$permissao["POSICAO"].",'".$link."','s','s','".$situacao."');";
				mysqli_query($phpmyadmin, $insMenu);
			}
		}
		else{
			$checkMenu="SELECT ID, PERMISSAO_ID, (SELECT 1+MAX(POSICAO) FROM MENU_ITEM WHERE MENU_ID=(SELECT ID FROM MENU WHERE TAG='".$menu."' LIMIT 1)) AS POSICAO FROM MENU WHERE TAG='".$menu."';";
			$cnx= mysqli_query($phpmyadmin, $checkMenu);
		    while($loadMenu= $cnx->fetch_array()){
				$insMenu="INSERT INTO MENU_ITEM(MENU_ID, PERMISSAO_ID, ITEM, POSICAO, LINK, LIBERADO, ATIVO) VALUES(".$loadMenu["ID"].",".$loadMenu["PERMISSAO_ID"].",'".$nome."', ".$loadMenu["POSICAO"].",'".$link."','n','".$situacao."');";
				mysqli_query($phpmyadmin, $insMenu);
			}
			
		}
		if($_FILES['userfile']['name']!=""){
			$uploaddir = 'up/';
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
			echo '<pre>';
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			    echo "Arquivo válido e enviado com sucesso.\n";
			} else {
			    echo "Possível ataque de upload de arquivo!\n";
			}/*echo 'Aqui está mais informações de debug:'; print_r($_FILES); print "</pre>";*/
		}		
		if(mysqli_error($phpmyadmin)==null){
			echo "<script>alert('Menu cadastrado com sucesso, libere as permissões p/ usar.!!') </script>";
		}
		else{
			$erro=mysqli_error($phpmyadmin);
			echo "<script>alert('Erro ".$erro."!!')</script>";
		}			
	}
	else if($nome==""){
		echo "<script>alert('Preencher o campo Nome é obrigatório!!')</script>";
	}
	else{
		echo "<script>alert('Preencher o campo Link é obrigatório!!')</script>";
	}		
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Menu</title>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones-->
	<script type="js/myjs.js"></script>
	<script type="text/javascript">
	   	function ocultarExibir(div){
	   		if(div == 'MENU_ITEM'){	   			 				
	   			document.getElementById('menu').style.display='block';	   				
	   			document.getElementById('selecao').style.display='block';	
	   		}
	   		else{
	   			document.getElementById('menu').style.display='none';	   				
	   			document.getElementById('selecao').style.display='none';		
	   		}
	   	}
	</script>
	<style type="text/css">
		input[type="file"].label {
  display: none;
}
.btnPerson {
}
	</style>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form enctype="multipart/form-data" action="menu-insert.php" method="POST" id="form1">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="nome">
								<input type="text" class="input required" name="nome" placeholder="RH" maxlength="20" onkeypress="addLoadField('nome')" onkeyup="rmvLoadField('nome')" onblur="checkAdress(form1.nome, 'msgAdressOk','msgAdressNok')" id="inputName">
								<span class="icon is-small is-left">
							   		<i class="fas fa-file-signature"></i>
							   	</span>
								<div id="msgAdressNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O nome é obrigatório</p>		    	
							   	</div>
							   	<div id="msgAdressOk" style="display:none;">
							    	<span class="icon is-small is-right">
							      		<i class="fas fa-check"></i>
							    	</span>
							   	</div>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Clique:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control has-icons-left">
								<div class="select" id="exibeMenu">
									<select name="clique" style="width:24.2em;">
										<option value="">Abrir na mesma aba</option>
										<option value="_blank">Abrir em nova aba</option>										
									</select>	
								</div>
								<span class="icon is-small is-left">
									<i class="fas fa-mouse-pointer"></i>
								</span>
							</div>						
						</div>
					</div>
				</div>	
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Tipo:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control has-icons-left">
								<div class="select" id="exibeMenu">
									<select onchange="ocultarExibir(this.value)" name="tipoMenu" style="width:24.2em;">
										<option selected="selected" value="">Selecione</option>
										<option value="MENU">Menu</option>
										<option value="MENU_ITEM">Item de menu</option>										
									</select>	
								</div>
								<span class="icon is-small is-left">
									<i class="fas fa-list-alt"></i>
								</span>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal" >
					<div class="field-label is-normal" id="menu" style="display: none;">
						<label class="label">Menu:</label>
					</div>
					<div class="field-body" id="selecao" style="display: none;">
						<div class="field" >							
							<div class="control has-icons-left">
								<div class="select">
									<select name="menu" style="width:24.2em;">
										<?php $loadMenu="SELECT TAG, MENU FROM MENU WHERE ATIVO='s' GROUP BY MENU ORDER BY POSICAO;"; 
										$cnx=mysqli_query($phpmyadmin, $loadMenu);
										while ($menu=$cnx->fetch_array()):{?>										
										<option value="<?php echo $menu["TAG"];?>"><?php echo $menu["MENU"];?></option>
										<?php }endwhile; ?>										
									</select>	
								</div>
								<span class="icon is-small is-left">
									<i class="fas fa-list"></i>
								</span>
							</div>						
						</div>
					</div>
				</div>				
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Link:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left">
								<input type="text" class="input" name="link" placeholder="up/rh-relatorio.php" maxlength="50">
								<span class="icon is-small is-left">
									<i class="fas fa-link"></i>
								</span>
							</div>
						</div>
					</div>
				</div>				
				<div class="field is-horizontal is-left">
					<div class="field-label is-normal">
						<label class="label">Arquivo:</label>
					</div>
					<div class="field-body" style="width:28.5em;">
						<div class="field" style="width:28.5em;">	
							<div id="file-js-example" class="file has-name" style="width:28.5em;">
							  	<label class="file-label" style="width:28.5em;">
							  		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
							    	<input class="file-input" type="file" name="userfile" style="width:28.5em;">
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
						<label class="label">Status:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control has-icons-left">
								<div class="select">
									<select name="situacao" style="width:13.7em;">
										<option selected="selected" value="s">Ativo</option>
										<option value="n">Inativo</option>																			
									</select>	
								</div>
								<span class="icon is-small is-left">
									<i class="fas fa-sort"></i>
								</span>
							</div>
							<div class="control">
								<button name="inserirMenu" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
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