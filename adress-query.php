<?php
$menuAtivo = 'configuracoes';
require('menu.php');

$cnx =mysqli_query($phpmyadmin, "SELECT E.*, B.BAIRRO, C.CIDADE FROM ENDERECO E INNER JOIN BAIRRO B ON B.ID=E.BAIRRO_ID INNER JOIN CIDADE C ON C.ID=B.CIDADE_ID WHERE USUARIO_ID=".$_SESSION["filter"][3]);
$endereco = $cnx->fetch_array();

$cnx2 = mysqli_query($phpmyadmin, "SELECT V.*, T.TIPO, C.COR FROM VEICULO V INNER JOIN VEICULO_TIPO T ON T.ID=V.VEICULO_TIPO_ID INNER JOIN COR C ON C.ID=V.COR_ID WHERE USUARIO_ID=".$_SESSION["filter"][3]);
$veiculo = $cnx2->fetch_array();
$car = mysqli_num_rows($cnx2);

if ($car == 0) {
	$display = "display: none;";
} else {
	$display = "display: block;";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>	
	<title>Gestão de Desempenho - Consultar Endereço</title>
    <style type="text/css">
    	.layout{
    		display: block;
    		margin: 0 auto;
			width: 85%; /* Valor da Largura */
    	}
    </style>	
</head>
<div>
<section class="section">
	<div class="container">
	<main>
	<form id="form1" action="adress-insert.php" method="POST" onsubmit="return checkForm()">
	<div class="layout">
	<h3 class="title"><i class="fas fa-calendar-check"></i>&nbsp&nbsp  ENDEREÇO</h3>
	<h3 class="label"><?php echo $_SESSION["filter"][2];?></h3>
	<hr>	
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field">
			<label class="label" for="textInput">Endereço*</label>
			<div class="control has-icons-left has-icons-right" id="endereco">
				<input class="input required" placeholder="Rua Holdercim"  maxlength="200" value="<?php echo $endereco["ENDERECO"];?>" style="width: 50em;" disabled>
				<span class="icon is-small is-left">
			   		<i class="fas fa-home"></i>
			   	</span>
			   	<div id="msgAdressNok" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-fw"></i>
			    	</span>
			    	<p class="help is-danger">O endereço é obrigatório</p>		    	
			   	</div>
			   	<div id="msgAdressOk" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-check"></i>
			    	</span>
			   	</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field">
			<label class="label" for="textInput">Número*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:9.6em;" id="numero">
				<input name="numero" type="text" class="input numero required" placeholder="840" style="width:20em;" value="<?php echo $endereco["NUMERO"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-list-ol"></i>
				</span>
				<div id="msgNumberNok" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-fw"></i>
				   	</span>
				   	<p class="help is-danger">O número é obrigatório</p>		    	
				</div>
				<div id="msgNumberOk" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-check"></i>
				   	</span>
				</div>
			</div>			
		</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field">
			<label class="label" for="textInput">Complemento</label>
			<div class="control has-icons-left has-icons-right" id="referencia">
				<input name="complemento" type="text" class="input" placeholder="Ao lado do galpão Móveis Simonetti"  maxlength="100" onkeypress="addLoadField('referencia')"  style="width: 50em;" value="<?php echo $endereco["COMPLEMENTO"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-road"></i>
				</span>				    	
				<div id="msgComplementOk" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-check"></i>
				  	</span>
				</div>
				<div id="msgComplementNok" style="display:none;">
				  	<span class="icon is-small is-right">
				   	</span>
				</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field">
			<label class="label" for="textInput">Quadra</label>
			<div id="quadra" class="control has-icons-left has-icons-right" style="max-width:10em;">
				<input name="quadra" type="text" class="input numero" placeholder="3" value="<?php echo $endereco["QUADRA"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-sort-numeric-up"></i>
				</span>
				<div id="msgBlockOk" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-check"></i>
					</span>
				</div>
				<div id="msgBlockNok" style="display:none;">
					<span class="icon is-small is-right">
					</span>
				</div>
			</div>			
		</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field">
			<label class="label" for="textInput">Bairro*</label>
			<div class="control has-icons-left">
				<div class="select">
				  	<select name="bairro" style="width:50em;" disabled>							
							<option value=""><?php echo $endereco["BAIRRO"];?></option>
					</select>
				</div>
				<div class="icon is-small is-left">
				  	<i class="fas fa-city"></i>
				</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field">
			<label class="label" for="textInput">Cidade*</label>
			<div class="control has-icons-left">
				<div class="select">
					<select name="cidade" style="width:9.6em;" disabled>
						<option value=""><?php echo $endereco["CIDADE"];?></option>
					</select>	
				</div>
				<span class="icon is-small is-left">
					<i class="fas fa-globe"></i>
				</span>
			</div>			
		</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field">
			<label class="label" for="textInput">Observação</label>
			<div class="control has-icons-left has-icons-right" id="observacao">
				<input name="observacao" type="text" class="input" placeholder="Galpão" style="width:50em;" value="<?php echo $endereco["OBSERVACAO"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-file-alt"></i>
				</span>
				<div id="msgNoteOk" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-check"></i>
					</span>
				</div>
				<div id="msgNoteNok" style="display:none;">
				   	<span class="icon is-small is-right">
				   	</span>
				</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field">
			<label class="label" for="textInput">CEP*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:10em;" id="cep">
				<input name="cep" type="text" class="input maskCep required" placeholder="29166-066" maxlength="9" value="<?php echo $endereco["CEP"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-map-marked-alt"></i>
				</span>
				<div id="msgZipcodeNok" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-fw"></i>
					</span>
				   	<p class="help is-danger">O CEP é obrigatório</p>		    	
				</div>
				<div id="msgZipcodeOk" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-check"></i>
				   	</span>
				</div>
			</div>			
		</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
	  	<div class="field">
	    	<label class="label">Optante por Vale Transporte?*</label>
	  	</div>&nbsp&nbsp
	  	<div class="field-body">
	    	<div class="field is-narrow">
	      		<div class="control">
	        		<label class="radio">
	          			<input type="radio" name="vale" value="s" class="inputVale" <?php if($endereco["VALE_TRANSPORTE"]=="s"){echo "CHECKED";}?>>Sim	          		
	        		</label>
	        		<label class="radio">
	          			<input type="radio" name="vale" value="n" class="inputVale" <?php if($endereco["VALE_TRANSPORTE"]=="n"){echo "CHECKED";}?>>Não
	        		</label>
	      		</div>
	    	</div>
	  	</div>
	  	<div class="field">
	    	<label class="label">Possui veículo?*</label>
	  	</div>&nbsp&nbsp
	  	<div class="field-body">
	    	<div class="field is-narrow">
	      		<div class="control">
	        		<label class="radio">
	          			<input type="radio" name="veiculo" onclick="enableVehicle()" value="s" class="inputVehicle" <?php if($car==1){echo "CHECKED";}?> disabled>Sim	          		
	        		</label>
	        		<label class="radio">
	          			<input type="radio" name="veiculo" onclick="disableVehicle()" value="n" class="inputVehicle" <?php if($car==0){echo "CHECKED";}?> disabled>Não
	        		</label>
	      		</div>
	    	</div>
	  	</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div hidden class="field is-horizontal"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field" style="<?php echo $display;?>" id="vehicleType">
			<label class="label" for="textInput">Tipo*</label>
			<div class="control has-icons-left">
				<div class="select">
				  	<select name="tipo" onchange="upIconVehicle(this.value)" disabled>							
						<option value=""><?php echo $veiculo["TIPO"];?></option>
					</select>
				</div>
				<div id="carVehicle">
					<span class="icon is-small is-left" >
					  	<i class="fas fa-car"></i>
					</span>
				</div>
				<div id="motoVehicle" style="display: none;">
					<span class="icon is-small is-left"  >
					  	<i class="fas fa-motorcycle"></i>
					</span>
				</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field" style="<?php echo $display;?>" id="vehicleModel">
			<label class="label" for="textInput">Modelo*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:18em;" id="modelo">
				<input name="modelo" type="text" class="input required" placeholder="Fiat Uno" maxlength="40" value="<?php echo $veiculo["MODELO"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-sort"></i>
				</span>
				<div id="msgModelOk" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-check"></i>
					</span>
				</div>
				<div id="msgModelNok" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-fw"></i>
					</span>
					<p class="help is-danger">O modelo é obrigatório</p>
				</div>
			</div>			
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field" style="<?php echo $display;?>" id="vehicleBoard">
			<label class="label" for="textInput">Placa*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:11em;" id="placa">
				<input name="placa" type="text" class="input required" placeholder="MQD-2045" maxlength="8" value="<?php echo $veiculo["PLACA"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-square"></i>
				</span>
				<div id="msgBoardOk" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-check"></i>
					</span>
				</div>
				<div id="msgBoardNok" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-fw"></i>
					</span>
					<p class="help is-danger">A placa é obrigatório</p>
				</div>
			</div>			
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field" style="<?php echo $display;?>" id="vehicleColor">
			<label class="label" for="textInput">Cor*</label>
			<div class="control has-icons-left">
				<div class="select">
				  	<select name="cor" disabled>							
						<option value=""><?php echo $veiculo["COR"];?></option>
					</select>
				</div>
				<div class="icon is-small is-left">
				  	<i class="fas fa-paint-roller"></i>
				</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field" style="<?php echo $display;?>" id="vehicleYear">
			<label class="label" for="textInput">Ano*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:9.6em;" id="ano">
				<input name="ano" type="text" class="input numero required" placeholder="2008" maxlength="4" value="<?php echo $veiculo["ANO"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-newspaper"></i>
				</span>
				<div id="msgYearOk" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-check"></i>
					</span>
				</div>
				<div id="msgYearNok" style="display:none;">
					<span class="icon is-small is-right">
						<i class="fas fa-fw"></i>
					</span>
					<p class="help is-danger">O ano é obrigatório</p>
				</div>
			</div>			
		</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<a href="<?php if($_SESSION["permissao"]==1){ echo 'register.php';} else{ echo 'user-query-filter.php';} ?>" class="button is-primary btn128">Voltar</a>										
				</div>
				<?php if($_SESSION["permissao"]>1):{?>
				<div class="control">
					<a href="register.php" class="button is-primary btn128">Cancelar</a>										
				</div><?php }endif;?>									
			</div>
		</div>								
	</div>							
	</form>
	</main>
	</div>	
</section>
</div>	
</div>
</section>
</div>
</body>
</html>