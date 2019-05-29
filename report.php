<?php
session_start();
include('verifica_login.php');
include('menu.php');
$menuInicio="no-active";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatórios</title>
</head>
<body>
<div style='margin-bottom: 20px;'>
	<form id='form1' action='report.php' method='GET' >
		<table cellpadding="2" cellspacing="0"  style='border-spacing: 30px 0; margin: 0 -30px'>								
			<tr>
				<td>
					<label for='periodo'>Mês: </label>
					</td>
						<td>
							<select name='periodo'>
								<option value='proximo'><?php echo strftime('%h', strtotime("+1 months"))?></option>
								<option selected='selected' value='atual'><?php echo strftime('%h')?></option>
								<option value='ultimo'><?php echo strftime('%h', strtotime("-1 months"))?></option>
								<option value='penultimo'><?php echo strftime('%h', strtotime("-2 months"))?></option>	
							</select>
						</td>
					<td>
					<label for='atividade'>Atividade: </label>
				</td>
				<td>
					<select name='atividade'>
						<option selected='selected' value='agrupado'>Agrupado</option>	
						<option value='separado'>Separado</option>						
				</td>
					<td>
						<label for='ordernacao'>Ordenação: </label>
					</td>
				<td>					
					<select name='ordenacao'>
						<option value='nome'>Nome</option>
						<option value='alcancado desc, nome'>Alçancado</option>
				</td>
				<td>
					<label for='meta'>Meta: </label>
					<td>
						<select name='meta'>
							<option selected='selected'value=''>Ambos</option>
							<option value='and b.alcancado>=100'>Atingida</option>
							<option value='and b.alcancado<100'>Não atingida ;/</option>
					</td>
				</td>					
				<td rowspan='2' style='vertical-align:top;padding-left:-30px'>
					<input type='button' id='submitQuery' value='Filtrar' />
				</td>
			</tr>						
		</table>
	</form>
</div>
</body>
</html>


