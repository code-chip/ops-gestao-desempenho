<?php 
$menuConfiguracoes="is-active";
include('menu.php');
$query="SELECT NOME, EMAIL FROM USUARIO WHERE ID=".$_SESSION["userId"];
$cnx= mysqli_query($phpmyadmin, $query);
$usuario= $cnx->fetch_array();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Reportar Bug</title>
</head>
<body>
	<div>	
	<section class="section">
		<div class="container">
			<h3 class="title">Reportar Bug</h3>
		<hr>
	<main>
	<form id="form1" action="contact.php" method="POST">
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Nome</label>
			</div>
			<div class="field-body">
				<div class="field">
					<div class="control">
						<input type="text" class="input" id="textInput" placeholder="Ana Clara" value="<?php echo $usuario["NOME"]?>">
					</div>
				</div>
			</div>
			<div class="field-label is-normal">
				<label class="label">E-mail</label>
			</div>
			<div class="field-body">
				<div class="field">
					<div class="control">
						<input type="text" class="input" id="textInput" placeholder="anaclara@gmail.com" value="<?php echo $usuario["EMAIL"]?>">
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Módulo</label>
			</div>
			<div class="field-body">
				<div class="field">							
					<div class="control">
						<div class="select">
							<select name="modulo">
								<option selected="selected" value="Dashboard">Dashboard</option>	
								<option value="Meta">Meta</option>
								<option value="Feedback">Feedback</option>
								<option value="Desempenho">Desempenho</option>
								<option value="Relatório">Relatório</option>
								<option value="Configurações">Configurações</option>
							</select>	
						</div>
					</div>
				</div>
			</div>
			<div class="field-label is-normal">
				<label class="label">Prioridade</label>
			</div>
			<div class="field-body">
				<div class="field">							
					<div class="control">
						<div class="select">
							<select name="prioridade">
								<option selected="selected" value="Baixa">Baixa</option>	
								<option value="Normal">Normal</option>
								<option value="Alta">Alta</option>
								<option value="Urgente">Urgente</option>
							</select>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Mensagem</label>
				</div>
				<div class="field-body">
					<div class="field">
						<div class="control">
							<textarea name="mensagem" class="textarea" placeholder="Relate o problema apresentado..."></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label">						
				</div>
				<div class="field-body">
					<div class="field">
						<div class="control">
							<button name="Enviar" type="submit" class="button is-primary">Enviar</button>
						</div>
					</div>
				</div>
			</div>			
		</form>
	</main>
</div>
</section>
</div>
</body>
</html>
<?php
$modulo= trim($_POST['modulo']);
$prioridade= trim($_POST['prioridade']);
$mensagem= trim($_POST['mensagem']);
if(isset($_POST["Enviar"])!=null && $mensagem!=null){
	$registrar="INSERT INTO REPORTAR(USUARIO_ID, MODULO, PRIORIDADE, MENSAGEM, SITUACAO) VALUES(".$_SESSION["userId"].",'".$modulo."','".$prioridade."','".$mensagem."','Recebido');";
	$cnx=mysqli_query($phpmyadmin, $registrar);
	echo "<script>alert('Problema registrado, obrigado pela contribuição, em breve o desenvolvedor irá contato-lo com a solução.')</script>";
}
else if(isset($_POST["Enviar"])!=null){
	echo "<script>alert('O campo mensagem não pode está vazio!!')</script>";
}
?>