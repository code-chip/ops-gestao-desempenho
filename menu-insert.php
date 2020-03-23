<?php 
$menuAtivo="is-active";
require('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Menu</title>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
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
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="option-insert.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<input type="text" class="input" name="nome" placeholder="RH" maxlength="20">
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
							<div class="control" style="max-width:17em;">
								<div class="select" id="exibeMenu">
									<select onchange="ocultarExibir(this.value)" name="tipoMenu">
										<option selected="selected" value="">Selecione</option>
										<option value="MENU">Menu</option>
										<option value="MENU_ITEM">Item de menu</option>										
									</select>	
								</div>
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
							<div class="control" style="max-width:17em;">
								<div class="select">
									<select name="menu">
										<?php $loadMenu="SELECT ID, MENU FROM MENU WHERE ATIVO='s' GROUP BY MENU ORDER BY POSICAO;"; 
										$cnx=mysqli_query($phpmyadmin, $loadMenu);
										while ($menu=$cnx->fetch_array()):{?>										
										<option value="<?php echo $menu["ID"];?>"><?php echo $menu["MENU"];?></option>
										<?php }endwhile; ?>										
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Link:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<input type="text" class="input" name="link" placeholder="rh-relatorio.php" maxlength="50">
							</div>
						</div>
					</div>
				</div>								
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Status:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<div class="select">
									<select name="situacao">
										<option selected="selected" value="s">Ativo</option>
										<option value="n">Inativo</option>																			
									</select>	
								</div>
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
</body>
</html><?php }//ELSE - caso o usuário tenha permissão.?>