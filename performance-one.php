<?php
session_start();
include('verifica_login.php');
include('menu.php');
/*$userid = startPage();
$name = getActiveUser($userid);
$erro = '';
$contador = 0;
$totalAlcancado=0;
$currentStatus = '';
if( !validateOP() || !isset($_GET) ){
	setHeader();
	$periodo = trim($_REQUEST['periodo']);
	$atividade = trim($_REQUEST['atividade']);
	$meta = trim($_REQUEST['meta']);
set_time_limit(0);
*/
?>
<div style='margin-bottom: 20px;'>
	<form id='form1' action='performance-one.php' method='GET' >
		<table cellpadding="2" cellspacing="0"  style='border-spacing: 40px 0; margin: 0 -30px'>								
			<tr>
				<td>
					<label for='periodo'>Mês: </label>
					</td>
						<td>
							<select name='periodo'>
								<option selected='selected' value=''>Selecione</option>
								<option value='proximo'><?php echo strftime('%h', strtotime("+1 months"))?></option>
								<option value='atual'><?php echo strftime('%h')?></option>
								<option value='penultimo'><?php echo strftime('%h', strtotime("-1 months"))?></option>
								<option value='antipenultimo'><?php echo strftime('%h', strtotime("-2 months"))?></option>	
							</select>
						</td>
					<td>
					<label for='atividade'>Atividade: </label>
				</td>
				<td>
					<select name='atividade'>
						<option selected='selected' value='Todas'>Todas</option>	
						<option value='Checkout'>Checkout</option>
						<option value='Picking'>Picking</option>
						<option value='PBL'>PBL</option>
						<option value='Embalagem'>Embalagem</option>
						<option value='Recebimento'>Recebimento</option>
						<option value='Avarias e Devoluções'>Avaria/Devolução</option>						
						<option value='Expedição'>Expedição</option>	
						</select>
				</td>
				<td>
					<label for='meta'>Meta: </label>
					<select name='meta'>
						<option value=''>Ambas</option>
						<option value='and alcancado>=100'>Atingida</option>
						<option value='and alcancado<100'>Não atingida</option>
					</select>
				</td>	
					<td rowspan='2' style='vertical-align:top;padding-left:30px'>
						<input type='button' id='submitQuery' value='Pesquisar' />
					</td>
			</tr>						
		</table>
	</form>
</div>
<?php
if( $periodo != ""){
	if($periodo =="atual"){
		if($atividade !="Todas"){
			$consulta ="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta ="select * from evinops.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')".$meta." order by registro;";
		}
	}
	else if($periodo =="proximo"){
		if($atividade !="Todas"){
			$consulta="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta="select * from evinops.desempenho where nome='".$name."' and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		
	}
	else if($periodo =="penultimo"){
		if($atividade !="Todas"){
			$consulta="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta="select * from evinops.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}		
	}
	else{
		if($atividade !="Todas"){
			$consulta="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta="select * from evinops.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		
	}	
	$con = $mysqli->query($consulta) or die($mysqli->error);
	//echo "<table>";
	$x=0;
	while($dado = $con->fetch_array()){		
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorDesempenho[$x] = $dado["DESEMPENHO"];
		$vetorMeta[$x] = $dado["META"];
		$vetorAlcancado[$x] = $dado["ALCANCADO"];
		$totalAlcancado=$totalAlcancado+$dado["ALCANCADO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];
		$contador++;
		$x++;
	}
	if($contador==0){
		?><script type="text/javascript">alert('Nenhum resultado encontrado!');</script><?php
	}	
}
else{
	
}?>
<?php if( $periodo !='' && $contador !=0) : ?>
<hr/>
	<table class='list_table_b'>
		<tr>
			<td colspan='10' class='table_title'>
				<span class='title_left'><?php echo $ordersData[0]['increment_id'] ?>Colaborador: <?php echo $name?> Media: <?php echo round($totalAlcancado/$contador, 2)."%" ?>
				</span>
			</td>
		</tr>
	<tr>
		<th>Atividade</th>
		<th>Desempenho</th>
		<th>Meta</th>
		<th>Alacançado</th>
		<th>Data</th>
		<th style='width:250px;'>Observação</th>
	</tr>
<?php for( $i = 0; $i < sizeof($vetorAtividade); $i++ ) : ?>
	<tr>
		<td><?php echo $vetorAtividade[$i]?></td>			
		<td><?php echo $vetorDesempenho[$i]?></td>			
		<td><?php echo $vetorMeta[$i]?></td>
		<td><?php echo $vetorAlcancado[$i]."%"?></td>
		<td><?php echo $vetorRegistro[$i]?></td>			
	</tr>
<?php endfor; ?>
	</table>	
<?php endif; ?>	
<button id="go_top" onclick="$('body').scrollTop(0)" >Ir Ao Topo</button>
<div style='clear:both' ></div>
<div id='dialog_info' ></div>
<script>
		$('#submitQuery').button().click(function(){
				$('#form1').submit();
			});
			$('#cleanQuery').button().click(function(){
				$('#form1 input[type=text]').val("");
			});
			$('#form1 input[type=text]').keydown(function(e){
				if( e.keyCode == 13 )
					$('#form1').submit();
			});
			$('.title_right input').button();

			selectOrder = function(event,id) {
				$('#form1 input[type=text]').val("");
				$('#form1 input[name=order_number]').val(id);
				if( event.ctrlKey )
					$('#form1').attr('target','_blank');
				$('#form1').submit();
			}
            
            rePrintLabelsSuccess = function (data){
                hideOverlay();
                console.log(data);
            };
			trackOrder = function(event, id) {
				showOverlay();
				$.ajax({
					dataType: "json",
					url:'desempenho.php?option=track',
					data: {order_id : id},
					success: trackSuccess,
					error: errorCallback
				});
			}
			trackSuccess = function(data){
				var tbl = $("<table class='list_table'>");
				tbl.append( $("<tr class='table_title'>")
					.append( $("<th>").html("Data") )
					.append( $("<th>").html("Descrição") )
					.append( $("<th>").html("Volume") )
				);
				for( var i in data )
				{
					var tr = $("<tr class='modal_line'>");
					for( var j in data[i] )
						tr.append( $("<td>").html(data[i][j]) );
					tbl.append(tr);
				}

				$('#dialog_info').html('').append(tbl).dialog({
					width: '80%',
					modal: true,
					open: function(event, ui) { $('.ui-widget-overlay').bind('click', function(){ $("#dialog_info").dialog('close'); }); },
					close: function(event, ui) { $('#dialog_info').html('').dialog('destroy'); }
				});
				hideOverlay();
			}

			tr_ok = function(data){
				//console.log(data);
				alert(data.msg);
					$('#form1 input[type=text]').val("");
					$('#form1 input[name=order_id]').val(data.order_id);
					$('#form1').submit();
			}

			errorCallback = function(ret){
				console.log(ret);
				hideOverlay();
			}

			$('#go_top').button().css('width','100%');
</script>
		
<?php	
}
setFooter();


