<?php
$menuAtivo="configuracoes";
require('menu.php');
$checkAdress="SELECT E.*, B.BAIRRO, B.CIDADE_ID, C.CIDADE FROM ENDERECO E INNER JOIN BAIRRO B ON B.ID=E.BAIRRO_ID INNER JOIN CIDADE C ON C.ID=B.CIDADE_ID WHERE USUARIO_ID=".$_SESSION["filter"][3];
$cnx=mysqli_query($phpmyadmin, $checkAdress);
$endereco= $cnx->fetch_array();
$checkVehicle="SELECT V.*, T.TIPO, C.COR FROM VEICULO V INNER JOIN VEICULO_TIPO T ON T.ID=V.VEICULO_TIPO_ID INNER JOIN COR C ON C.ID=V.COR_ID WHERE USUARIO_ID=".$_SESSION["filter"][3];
$cnx2=mysqli_query($phpmyadmin, $checkVehicle);
$veiculo= $cnx2->fetch_array();
$car=mysqli_num_rows($cnx2);
if($car==0){//Define se os campos veículos devem aparecer.
	$display="display: none;";
}
else{
	$display="display: block;";
}
if($endereco["CIDADE_ID"]==1){//Define qual select de bairros deve aparecer.
	$dSerra="display: block;";
	$dVitoria="display: none;";
	$dCariacica="display: none;";
}
else if($endereco["CIDADE_ID"]==2){
	$dSerra="display: none;";
	$dVitoria="display: block;";
	$dCariacica="display: none;";
}
else{
	$dSerra="display: none;";
	$dVitoria="display: none;";
	$dCariacica="display: block;";
}
$optionVehicle="<option value=".$endereco["ID"].">".$endereco["BAIRRO"]."</option>";
if($car==1){
	$inputVehicleType="<option value=".$veiculo["VEICULO_TIPO_ID"].">".$veiculo["TIPO"]."</option>";
	$inputVehicleColor="<option value=".$veiculo["COR_ID"].">".$veiculo["COR"]."</option>";
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
	<title>Gestão de Desempenho - Inserir Endereço</title>
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
	<form id="form1" action="adress-update.php" method="POST" onsubmit="return checkForm(form1.cidade.value)">
	<div class="layout">
	<h3 class="title"><i class="fas fa-pen-square"></i>&nbsp&nbsp  ENDEREÇO</h3>
	<h3 class="label"><?php echo $_SESSION["filter"][2];?></h3>
	<hr>	
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field">
			<label class="label" for="textInput">Endereço*</label>
			<div class="control has-icons-left has-icons-right" id="endereco">
				<input name="endereco" onkeypress="addLoadField('endereco')" onkeyup="rmvLoadField('endereco')" type="text" class="input required" placeholder="Rua Holdercim"  maxlength="200" onblur="checkAdress(form1.endereco, 'msgAdressOk','msgAdressNok')" id="inputAdress" style="width: 50em;" autofocus value="<?php echo $endereco["ENDERECO"];?>">
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
				<input name="numero" type="text" class="input numero required" placeholder="840" maxlength="4" onkeypress="addLoadField('numero')" onkeyup="rmvLoadField('numero')" onblur="checkAdress(form1.numero, 'msgNumberOk','msgNumberNok')" id="inputNumber" style="width:20em;" value="<?php echo $endereco["NUMERO"];?>">
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
				<input name="complemento" type="text" class="input required" placeholder="Ao lado do galpão Móveis Simonetti"  maxlength="100" onkeypress="addLoadField('referencia')" onkeyup="rmvLoadField('referencia')" onblur="checkAdress(form1.complemento, 'msgComplementOk','msgComplementNok')" id="inputComplement" style="width: 50em;" value="<?php echo $endereco["COMPLEMENTO"];?>">
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
				  		<i class="fas fa-fw"></i>
				   	</span>
				   	<p class="help is-danger">O complemento é obrigatório</p>
				</div>
			</div>
		</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<div class="field">
			<label class="label" for="textInput">Quadra</label>
			<div id="quadra" class="control has-icons-left has-icons-right" style="max-width:10em;">
				<input name="quadra" type="text" class="input numero" placeholder="3" maxlength="4" onkeypress="addLoadField('quadra')" onkeyup="rmvLoadField('quadra')" onblur="checkAdress(form1.quadra, 'msgBlockOk','msgBlockNok')" id="inputBlock" value="<?php echo $endereco["QUADRA"];?>">
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
				  	<select name="bairro" style="width:50em;" class="required hidden" id="serra">
				  		<?php if($endereco["CIDADE_ID"]==1){ echo $optionVehicle;} ?>
						<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO WHERE CIDADE_ID=1 AND ID<>".$endereco["BAIRRO_ID"]; 
						$con = mysqli_query($phpmyadmin , $gdBairro); $x=0; 
						while($bairro = $con->fetch_array()):{?>
							<option value="<?php echo $vtId[$x]=$bairro["ID"];?>"><?php echo $vtBairro[$x]=$bairro["BAIRRO"];?></option>
						<?php $x;} endwhile;?>														
					</select>
					<select name="bairro" style="display: none; width:50em;" class="required" id="vitoria" hidden="true">
						<?php if($endereco["CIDADE_ID"]==2){ echo $optionVehicle;} ?>							
						<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO WHERE CIDADE_ID=2 AND ID<>".$endereco["BAIRRO_ID"]; 
						$con = mysqli_query($phpmyadmin , $gdBairro); $x=0; 
						while($bairro = $con->fetch_array()):{?>							
							<option value="<?php echo $vtId[$x]=$bairro["ID"];?>"><?php echo $vtBairro[$x]=$bairro["BAIRRO"];?></option>
						<?php $x;} endwhile;?>														
					</select>
					<select name="bairro" style="display: none; width:50em;" class="required" id="cariacica">
						<?php if($endereco["CIDADE_ID"]==3){ echo $optionVehicle;} ?>							
						<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO WHERE CIDADE_ID=3 AND ID<>".$endereco["BAIRRO_ID"]; 
						$con = mysqli_query($phpmyadmin , $gdBairro); $x=0; 
						while($bairro = $con->fetch_array()):{?>
							<option value="<?php echo $vtId[$x]=$bairro["ID"];?>"><?php echo $vtBairro[$x]=$bairro["BAIRRO"];?></option>
						<?php $x;} endwhile;?>														
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
					<select name="cidade" style="width:9.6em;" class="required" onchange="upList(this.value)">
						<option value="<?php echo $endereco["CIDADE_ID"];?>"><?php echo $endereco["CIDADE"];?></option>
						<?php $gdCidade="SELECT ID, CIDADE FROM CIDADE WHERE ID<>".$endereco["CIDADE_ID"]; 
						$con = mysqli_query($phpmyadmin , $gdCidade); $x=0; 
						while($cidade = $con->fetch_array()):{?>								
							<option value="<?php echo $vtId[$x]=$cidade["ID"];?>"><?php echo $vtCidade[$x]=$cidade["CIDADE"];?></option>
						<?php $x;} endwhile;?>	
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
				<input name="observacao" onkeypress="addLoadField('observacao')" onkeyup="rmvLoadField('observacao')" type="text" class="input" placeholder="Galpão"  maxlength="200" onblur="checkAdress(form1.observacao, 'msgNoteOk','msgNoteNok')" id="inputNote" style="width:50em;" value="<?php echo $endereco["OBSERVACAO"];?>">
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
				<input name="cep" type="text" class="input maskCep required" placeholder="29166-066" maxlength="9" onkeypress="addLoadField('cep')" onkeyup="rmvLoadField('cep')" onblur="checkAdress(form1.cep, 'msgZipcodeOk','msgZipcodeNok')" id="inputZipcode" value="<?php echo $endereco["CEP"];?>">
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
	          			<input type="radio" name="vale" value="s" class="inputVale" <?php if($endereco["VALE_TRANSPORTE"]=="s"){ echo "CHECKED";}?>>Sim	          		
	        		</label>
	        		<label class="radio">
	          			<input type="radio" name="vale" value="n" class="inputVale" <?php if($endereco["VALE_TRANSPORTE"]=="n"){ echo "CHECKED";}?>>Não
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
	          			<input type="radio" name="veiculo" onclick="enableVehicle()" value="s" class="inputVehicle" <?php if($car==1){ echo "CHECKED";}?>>Sim	          		
	        		</label>
	        		<label class="radio">
	          			<input type="radio" name="veiculo" onclick="disableVehicle()" value="n" class="inputVehicle" <?php if($car==0){ echo "CHECKED";}?>>Não
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
				  	<select name="tipo" onchange="upIconVehicle(this.value)">
						<?php if($car==1){ $fTipo="WHERE ID<>".$veiculo["VEICULO_TIPO_ID"]; echo $inputVehicleType;}
						else{ $fTipo=null;}
						$gdVeiculoTipo="SELECT ID, TIPO FROM VEICULO_TIPO ".$fTipo; 
						$con = mysqli_query($phpmyadmin , $gdVeiculoTipo); $x=0; 
						while($veiculoTipo = $con->fetch_array()):{?>
							<option value="<?php echo $vtId[$x]=$veiculoTipo["ID"];?>"><?php echo $vtVeiculoTipo[$x]=$veiculoTipo["TIPO"];?></option>
						<?php $x;} endwhile;?>
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
				<input name="modelo" type="text" class="input required" placeholder="Fiat Uno" maxlength="40" onblur="checkAdress(form1.modelo, 'msgModelOk','msgModelNok')" id="inputModel" value="<?php echo $veiculo["MODELO"];?>">
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
				<input name="placa" type="text" class="input required maskPlaca" placeholder="MQD-2045" maxlength="8" onblur="checkAdress(form1.placa, 'msgBoardOk','msgBoardNok')" id="inputBoard" value="<?php echo $veiculo["PLACA"];?>" onkeyup="uppercase(this)">
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
				  	<select name="cor">				  								
						<?php if($car==1){ $fCor=" WHERE ID<>".$veiculo["COR_ID"]." ORDER BY COR"; echo $inputVehicleColor;}
						else{ $fCor=null;}
						$gdCor="SELECT ID, COR FROM COR".$fCor; echo $gdCor;
						$con = mysqli_query($phpmyadmin , $gdCor); $x=0; 
						while($cor = $con->fetch_array()):{?>
							<option value="<?php echo $vtId[$x]=$cor["ID"];?>"><?php echo $vtCor[$x]=$cor["COR"];?></option>
						<?php $x;} endwhile;?>
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
				<input name="ano" type="text" class="input numero required" placeholder="2008" maxlength="4" onblur="checkAdress(form1.ano, 'msgYearOk','msgYearNok')" id="inputYear" value="<?php echo $veiculo["ANO"];?>">
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
					<input name="cadastrar" type="submit" class="button is-primary btn128" value="Atualizar"/>
				</div>
				<div class="control">
					<button name="clear" type="reset" class="button is-primary btn128">Limpar</button>
				</div>
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
<!--LÓGICA DE INSERÇÃO NO BANCO DE DADOS-->
<?php
if(isset($_POST['cadastrar'])){
	//<!--- DECLARAÇÃO DAS VARIAVEIS -->
	$endereco = trim($_POST['endereco']);
	$numero = trim($_POST['numero']);
	$complemento = trim($_POST['complemento']);
	$quadra = trim($_POST['quadra']);
	$bairro = trim($_POST['bairro']);
	$observacao = trim($_POST['observacao']);
	$cep = trim($_POST['cep']);
	$vale = trim($_POST['vale']);
	$veiculo = trim($_POST['veiculo']);
	//VALIDAÇÃO SE LOGIN É ÚNICO.
	$checkLogin="SELECT LOGIN FROM USUARIO WHERE LOGIN='".$login."'";
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	if($veiculo=="s"){
		$tipo = trim($_POST['tipo']);
		$cor = trim($_POST['cor']);
		$modelo = trim($_POST['modelo']);
		$placa = trim($_POST['placa']);
		$ano = trim($_POST['ano']);
		if($modelo!="" && $placa!="" && $ano!="" ){
			if($quadra==""){//Tratativa caso quadra seja nula.
				$updateAdress="UPDATE ENDERECO SET ENDERECO='".$endereco."', NUMERO=".$numero.", QUADRA=NULL, COMPLEMENTO='".$complemento."', BAIRRO_ID=".$bairro.", CEP='".$cep."', OBSERVACAO='".$observacao."', ATUALIZADO_EM='".date('Y-m-d')."', VALE_TRANSPORTE='".$vale."' WHERE USUARIO_ID=".$_SESSION["filter"][3];
			}
			else{
				$updateAdress="UPDATE ENDERECO SET ENDERECO='".$endereco."', NUMERO=".$numero.", QUADRA=".$quadra.", COMPLEMENTO='".$complemento."', BAIRRO_ID=".$bairro.", CEP='".$cep."', OBSERVACAO='".$observacao."', ATUALIZADO_EM='".date('Y-m-d')."', VALE_TRANSPORTE='".$vale."' WHERE USUARIO_ID=".$_SESSION["filter"][3];
			}			
			mysqli_query($phpmyadmin, $updateAdress);
			if($car==1){
				$updateVehicle="UPDATE VEICULO SET VEICULO_TIPO_ID=".$tipo.", COR_ID=".$cor.", MODELO='".$modelo."', PLACA='".$placa."', ANO='".$ano."' WHERE USUARIO_ID=".$_SESSION["filter"][3];
				mysqli_query($phpmyadmin, $updateVehicle);
			}
			else{
				$insertVehicle="INSERT INTO VEICULO(USUARIO_ID, VEICULO_TIPO_ID, COR_ID, MODELO, PLACA, ANO) VALUES(".$_SESSION["filter"][3].",".$tipo.",".$cor.",'".$modelo."','".$placa."','".$ano."')";
				mysqli_query($phpmyadmin, $insertVehicle);
			}
			if(mysqli_error($phpmyadmin)==null){
				echo"<script language='Javascript'> alert('Endereço atualizado com sucesso!!!'); window.location.href='register.php';</script>";
			}
			else{
				echo"<script language='Javascript'> alert('Erro ao atualizar!!!');</script>";
				echo mysqli_error($phpmyadmin);				
			}
		}
		else if($modelo==""){
			echo"<script language='Javascript'> alert('Preenchimento do modelo é obrigatório!');</script>";
		}
		else if($placa==""){
			echo"<script language='Javascript'> alert('Preenchimento da placa é obrigatório!');</script>";
		}
		else{
			echo"<script language='Javascript'> alert('Preenchimento do ano é obrigatório!');</script>";
		}	
	}
	else{
		if($quadra==""){//Tratativa caso quadra seja nula.
			$updateAdress="UPDATE ENDERECO SET ENDERECO='".$endereco."', NUMERO=".$numero.", QUADRA=NULL, COMPLEMENTO='".$complemento."', BAIRRO_ID=".$bairro.", CEP='".$cep."', OBSERVACAO='".$observacao."', ATUALIZADO_EM='".date('Y-m-d')."', VALE_TRANSPORTE='".$vale."' WHERE USUARIO_ID=".$_SESSION["filter"][3];
		}
		else{
			$updateAdress="UPDATE ENDERECO SET ENDERECO='".$endereco."', NUMERO=".$numero.", QUADRA=".$quadra.", COMPLEMENTO='".$complemento."', BAIRRO_ID=".$bairro.", CEP='".$cep."', OBSERVACAO='".$observacao."', ATUALIZADO_EM='".date('Y-m-d')."', VALE_TRANSPORTE='".$vale."' WHERE USUARIO_ID=".$_SESSION["filter"][3];
		}	
		mysqli_query($phpmyadmin, $updateAdress);
		if($car==1){
			$updateVehicle="DELETE FROM VEICULO WHERE USUARIO_ID=".$_SESSION["filter"][3];
			mysqli_query($phpmyadmin, $updateVehicle);
		}	
		if(mysqli_error($phpmyadmin)==null){
			echo"<script language='Javascript'> alert('Endereço atualizado com sucesso!!!'); window.location.href='register.php';</script>";
		}
		else{
			echo"<script language='Javascript'> alert('Erro ao atualizar!!!');</script>";
			echo mysqli_error($phpmyadmin);				
		}
	}
}//FINAL DA VERIFICAÇÃO DO ENVIO DO FORMULÁRIO
?>