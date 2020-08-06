<?php 

$menuAtivo = 'configuracoes';
require('menu.php');

if($_SESSION['permissao'] == 1){
	echo "<script>alert('Usuário sem permissão'); window.location.href='register.php'; </script>";
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
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
	<section class="section">
		<div class="container">
			<h3 class="title"><i class="fas fa-calendar-plus"></i> Inserir Menu</h3>
		<hr>
		<main>
	   		<form enctype="multipart/form-data" action="menu-insert.php" method="POST" id="form1" onsubmit="return menuInsertcheckForm()">
	    		<div class="field">
					<label class="label is-size-7-touch">Nome*</label>
					<div class="control has-icons-left has-icons-right" id="nome">
						<input type="text" class="input required" name="nome" placeholder="RH" maxlength="20" onkeypress="addLoadField('nome')" onkeyup="rmvLoadField('nome')" onblur="checkAdress(form1.nome, 'msgNameOk','msgNameNok')" id="inputName" autofocus>
						<span class="icon is-small is-left">
							<i class="fas fa-file-signature"></i>
						</span>
						<div id="msgNameNok" style="display:none;">
						  	<span class="icon is-small is-right">
						  		<i class="fas fa-fw"></i>
						  	</span>
						   	<p class="help is-danger">O nome do menu é obrigatório</p>		    	
						</div>
						<div id="msgNameOk" style="display:none;">
						   	<span class="icon is-small is-right">
						   		<i class="fas fa-check"></i>
						   	</span>
						</div>
					</div>
				</div>
				<div class="field">
					<label class="label is-size-7-touch">Clique*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth" id="exibeMenu">
							<select name="clique">
								<option value="_self">Abrir na mesma aba</option>
								<option value="_blank">Abrir em nova aba</option>										
							</select>	
							<span class="icon is-small is-left">
								<i class="fas fa-mouse-pointer"></i>
							</span>
						</div>
					</div>
				</div>	
				<div class="field">
					<label class="label is-size-7-touch">Tipo*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth" id="exibeMenu">
							<select name="tipoMenu" onchange="menuInsertOnOffSelected(this.value)">
								<option selected="selected" value="MENU">Menu</option>
								<option value="MENU_ITEM">Item de menu</option>										
							</select>	
							<span class="icon is-small is-left">
								<i class="fas fa-list-alt"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="field" id="menu" style="display: none;">
					<label class="label is-size-7-touch">Menu</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="menu"><?php
								$cnx = mysqli_query($phpmyadmin, "SELECT TAG, MENU FROM MENU WHERE ATIVO='s' GROUP BY MENU ORDER BY POSICAO;");
								while ($menu = $cnx->fetch_array()) {									
									echo "<option value=" . $menu["TAG"] . ">" . $menu["MENU"] . "</option>";
								} ?>										
							</select>	
							<span class="icon is-small is-left">
								<i class="fas fa-list"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="field">
					<label class="label is-size-7-touch">Link*</label>
					<div class="control has-icons-left has-icons-right" id="link">
						<input type="text" class="input" name="link" placeholder="informativo.pdf ou rh-relatorio.php" maxlength="50" onkeypress="addLoadField('link')" onkeyup="rmvLoadField('link')" onblur="checkAdress(form1.link, 'msgLinkOk','msgLinkNok')" id="inputLink">
						<span class="icon is-small is-left">
							<i class="fas fa-link"></i>
						</span>
						<div id="msgLinkNok" style="display:none;">
						   	<span class="icon is-small is-right">
						   		<i class="fas fa-fw"></i>
						   	</span>
						</div>
						<div id="msgLinkOk" style="display:none;">
						   	<span class="icon is-small is-right">
						   		<i class="fas fa-check"></i>
						  	</span>
						</div>
					</div>
				</div>				
				<div class="field">
					<label class="label is-size-7-touch">Arquivo</label>
					<div class="field-body">
						<div class="field">	
							<div id="file-js-example" class="file has-name is-fullwidth">
							  	<label class="file-label is-fullwidth">
							  		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
							    	<input class="file-input is-fullwidth" type="file" name="userfile">
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
				<div class="field">
					<label class="label is-size-7-touch">Clique*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth" id="exibeMenu">
							<select name="clique">
								<option value="_self">Abrir na mesma aba</option>
								<option value="_blank">Abrir em nova aba</option>										
							</select>	
							<span class="icon is-small is-left">
								<i class="fas fa-mouse-pointer"></i>
							</span>
						</div>
					</div>
				</div>	
				<div class="field">
					<label class="label is-size-7-touch">Status*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="situacao">
								<option selected="selected" value="s">Ativo</option>
								<option value="n">Inativo</option>																			
							</select>	
							<span class="icon is-small is-left">
								<i class="fas fa-sort"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="field-body is-fullwidth">
					<div class="field is-grouped is-fullwidth">
						<div class="control is-fullwidth">
							<button name="insert" type="submit" class="button is-primary btn128" value="Inserir">Inserir</button>
						</div>
						<div class="control">
							<button name="clear" type="reset" class="button is-primary btn128">Limpar</button>
						</div>
						<div class="control">
							<a href="register.php" class="button is-primary btn128">Cancelar</a>										
						</div>									
					</div>
				</div>
	     	</form>
	     </main>	
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
</html><?php 

if(isset($_POST["insert"])!=null){
	$nome=trim($_POST['nome']);
	$tipo=trim($_POST['tipoMenu']);
	$target=trim($_POST['clique']);
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
	if($_FILES['userfile']['name']!=""){
		$uploaddir = 'up/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		//echo '<pre>';
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		    echo "<script>alert('Arquivo válido e enviado com sucesso.');</script>";
		} else {
		    //echo "Possível ataque de upload de arquivo!\n";
		}/*echo 'Aqui está mais informações de debug:'; print_r($_FILES); print "</pre>";*/
		if($link!=""){
			$link="up/".$link;
		}			
	}	
	if($tipo=="MENU"){
		$checkPermissoes="SELECT ID, (SELECT 1+MAX(POSICAO) FROM MENU WHERE TAG NOT IN('configuracoes','sair')) AS POSICAO FROM PERMISSAO;";
		$cnx= mysqli_query($phpmyadmin, $checkPermissoes);
	    while($permissao= $cnx->fetch_array()){
			$insMenu="INSERT INTO MENU(PERMISSAO_ID, MENU, TAG, POSICAO, TARGET, LINK, SUBMENU, LIBERADO, ATIVO) VALUES(".$permissao["ID"].",'".$nome."','".$tag."',".$permissao["POSICAO"].",'".$target."','".$link."','s','n','".$situacao."');";
			mysqli_query($phpmyadmin, $insMenu);
		}
	}
	else{
		$checkMenu="SELECT ID, PERMISSAO_ID, (SELECT 1+MAX(POSICAO) FROM MENU_ITEM WHERE MENU_ID=(SELECT ID FROM MENU WHERE TAG='".$menu."' LIMIT 1)) AS POSICAO FROM MENU WHERE TAG='".$menu."';";
		$cnx= mysqli_query($phpmyadmin, $checkMenu);		
	    while($loadMenu= $cnx->fetch_array()){
	    	$insMenu="INSERT INTO MENU_ITEM(MENU_ID, PERMISSAO_ID, ITEM, TARGET, LINK, LIBERADO, ATIVO) VALUES(".$loadMenu["ID"].",".$loadMenu["PERMISSAO_ID"].",'".$nome."', '".$target."','".$link."','n','".$situacao."');";
			mysqli_query($phpmyadmin, $insMenu);
		}		
	}
	if(mysqli_error($phpmyadmin)==null){
		echo "<script>alert('Menu cadastrado com sucesso, libere as permissões p/ usar!!'); window.location.href='menu-insert.php';</script>";
	}
	else{
		$erro=mysqli_error($phpmyadmin);
		echo "<script>alert('Erro ".$erro."!!')</script>";
	}			
}//Final if.

?>