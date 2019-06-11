<style type="text/css">
	/*$table-cell-padding: .75rem !default; $table-sm-cell-padding: .3rem !default; $table-bg: transparent !default; $table-bg-accent: rgba(0,0,0,.05) !default; $table-bg-hover: rgba(0,0,0,.075) !default; $table-bg-active: $table-bg-hover !default; $table-border-width: $border-width !default; $table-border-color: $gray-lighter !default;*/
	.coluna{
		max-width:7em;
	}
</style>
<?php
session_start();
include('conexao.php');
//require_once('js/loader.js');
include('verifica_login.php');
$menuDesempenho="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$turno = trim($_REQUEST['turno']);
//$atividade = trim($_REQUEST['atividade']);
//$ordenacao = trim($_REQUEST['ordenacao']);
//$meta = trim($_REQUEST['meta']);
$contador = 0;
$totalAlcancado=0;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Inserir Desempenho</title>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
	<br/>
	<span id="topo"></span>
<div>	
	<?php if($turno ==""): ?>
	<form id="form1" action="report-insert.php" method="GET" >
		<div class="field has-addons has-addons-centered">			
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label for="turno" class="label">Turno:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">
								<option selected="selected" value="">Selecione</option>	
								<option value="matutino">Matutino</option>
								<option value="vespetino">Vespetino</option>
								<option value="recebimento">Recebimento</option>	
								<option value="devolucao">Devoluções/Avarias</option>
							</select>	
						</div>
					<!--<div class="control">-->
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Filtrar"/>
					</div>
				</div>						
			</div>
		</div>
	</form>	
	<?php endif; ?>		
</div>

<?php
date('Y-m-d H:i');
if( $turno != ""){	
	$query="select nome from gestaodesempenho.desempenho limit 10";	
	$ajusteBD="set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';";
	$ajustes= mysqli_query($phpmyadmin, $ajusteBD);
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query); //or die($mysqli->error);
	while($operadores= $cnx->fetch_array()){
		$vtNome[$x]=$operadores["nome"];
		$contador=$x;		
		$x++;
	}	
}	
?>
<!--FINAL DO FORMULÁRIO-->
<?php if($contador !=0) : ?>
<hr/>	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">	
	<tr>
		<th>N°</th>
		<th>Operador</th>
		<th>Presença</th>
		<th>Atividade</th>		
		<th class="coluna">Meta</th>
		<th >Alcançado</th>
		<th>Desempenho</th>
		<th>Inserir</th>
		<th>Data</th> 			
	</tr>
<?php for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vtNome[$z]==$vtNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $vtNome[$i]?></td>			
		<td>
			<!--SELEÇÃO PRESENÇA-->			
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="Presente">Presente</option>	
								<option value="checkout">Ausente</option>
								<option value="separacao">Folga</option>										
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</td>
		<td>
			<!--SELEÇÃO ATIVIDADE-->			
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="">Selecione</option>	
								<option value="checkout">Checkout</option>
								<option value="separacao">Separação</option>	
								<option value="pbl">PBL</option>	
								<option value="recebimento">Recebimento</option>
								<option value="devolucao">Devolução</option>		
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</td>
		<td class="field" style="max-width:7em;">
			<div class="field"><!--COLUNA META-->				
				<div class="control">
					<input style="max-width:6em;" type="text" class="input" id="Meta" placeholder="Obrigatório">
				</div>				
			</div>
		</td>
		<td>
			<div class="field"><!--COLUNA ALCANÇADO-->					
				<div class="control">
					<input style="max-width:5em;" type="text" class="input" id="Alcancado" placeholder="Obrigatório">
				</div>				
			</div>
		</td>			
		<td>
			<div class="field"><!--COLUNA DESEMPENHO-->					
				<div class="control">
					<!--<input type="text" class="input" id="t" placeholder="Obrigatório" onkeypress="this.style.width = ((this.value.length + 3) * 8) + 'px';">-->
					<input style="max-width:5em;" type="text" class="input" id="t" placeholder="Obrigatório">
				</div>				
			</div>
		</td>		
		<td>
			<!--SELEÇÃO SALVAR-->			
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="todos">Todos</option>	
								<option value="sim">Sim</option>
								<option value="nao">Não</option>										
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</td>
		<td>
			<?php echo date('d/m/Y');?>
		</td>					
	</tr>
<?php endfor; ?>
	</table>
	<a href="#topo">
		<div class="field is-grouped is-grouped-right">
			<button class="button is-primary is-fullwidth">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<form id="form1" action="report-insert.php" method="GET" >
		<div class="field is-grouped is-grouped-right">			
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label for="turno" class="label">Inserção:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="inserir">
								<option selected="selected" value="todos">Todos</option>	
								<option value="especifico">Específico</option>								
							</select>	
						</div>
						<!--<div class="control">-->
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Atualizar" <?php $turno=$turno; ?>/>						
					</div>
					<input type="submit" class="button is-primary" id="submitQuery" value="Salvar Dados"/>
				</div>						
			</div>
		</div>
	</form>			
<?php endif; ?>
</body>
</html>


