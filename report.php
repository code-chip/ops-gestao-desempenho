<?php
session_start();
include('verifica_login.php');
$menuInicio="is-active";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatórios</title>
</head>
<body>
<div>
	<br/>
	<form id='form1' action='report.php' method='GET' >
		<div class="field is-horizontal">
			<!--SELEÇÃO PERÍODO-->
			<div class="field-label is-normal">
				<label class="label" for="periodo">Período:</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select">
						<select name='periodo'>
							<option value='proximo'><?php echo strftime('%h', strtotime("+1 months"))?></option>
							<option selected='selected' value='atual'><?php echo strftime('%h')?></option>
							<option value='ultimo'><?php echo strftime('%h', strtotime("-1 months"))?></option>
							<option value='penultimo'><?php echo strftime('%h', strtotime("-2 months"))?></option>
						</select>	
					</div>
				</div>
			</div>
			</div>
			<!--SELEÇÃO ATIVIDADE-->
			<div class="field-label is-normal">
				<label class="label">Atividade:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="agrupado">Agrupado</option>	
								<option value="separado">Separado</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--SELEÇÃO ORDENAÇÃO-->
			<div class="field-label is-normal">
				<label for="odernacao" class="label">Ordenação:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="agrupado">Nome</option>	
								<option value="separado">Alcançado</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label for="odernacao" class="label">Turno:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="agrupado">Todos</option>	
								<option value="separado">Matutino</option>
								<option value="separado">Vespetino</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>	
			<!--SELEÇÃO META-->
			<div class="field-label is-normal">
				<label class="label" for="meta">Meta:</label>
			</div>
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control">
							<div class="select">
								<select name='meta'>
									<option selected="selected"value="">Ambos</option>
									<option value="and b.alcancado>=100">Atingida</option>
									<option value="and b.alcancado<100">Não atingida ;/</option>
								</select>	
							</div>
						</div>
					<div class="control">
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Filtrar"/>
					</div>
				</div>						
			</div>
		</div>
	</form>		
</div>
</body>
</html>


