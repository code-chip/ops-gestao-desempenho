<?php
$menuAtivo="configuracoes";
require('menu.php');
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Inserir Endereço</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="js/myjs.js"></script>
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
	<form id="form1" action="adress-insert.php" method="POST" onsubmit="return checkForm(form1.cidade.value)">
	<div class="layout">
	<h3 class="title"><i class="fas fa-calendar-plus"></i>&nbsp&nbsp  ENDEREÇO</h3>
	<h3 class="label"><?php echo $_SESSION["filter"][2];?></h3>
	<hr>	
	<div class="field is-horizontal" style="margin-bottom: -7px;"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field">
			<label class="label" for="textInput">Endereço*</label>
			<div class="control has-icons-left has-icons-right" id="endereco">
				<input name="endereco" onkeypress="addLoadField('endereco')" onkeyup="rmvLoadField('endereco')" type="text" class="input required" placeholder="Rua Holdercim"  maxlength="200" onblur="checkAdress(form1.endereco, 'msgAdressOk','msgAdressNok')" id="inputAdress" style="width: 50em;" autofocus>
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
				<input name="numero" type="text" class="input numero required" placeholder="840" maxlength="4" onkeypress="addLoadField('numero')" onkeyup="rmvLoadField('numero')" onblur="checkAdress(form1.numero, 'msgNumberOk','msgNumberNok')" id="inputNumber" style="width:20em;">
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
				<input name="complemento" type="text" class="input required" placeholder="Ao lado do galpão Móveis Simonetti"  maxlength="100" onkeypress="addLoadField('referencia')" onkeyup="rmvLoadField('referencia')" onblur="checkAdress(form1.complemento, 'msgComplementOk','msgComplementNok')" id="inputComplement" style="width: 50em;">
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
				<input name="quadra" type="text" class="input numero" placeholder="3" maxlength="4" onkeypress="addLoadField('quadra')" onkeyup="rmvLoadField('quadra')" onblur="checkAdress(form1.quadra, 'msgBlockOk','msgBlockNok')" id="inputBlock">
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
						<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO WHERE CIDADE_ID=1;"; 
						$con = mysqli_query($phpmyadmin , $gdBairro); $x=0; 
						while($bairro = $con->fetch_array()):{?>
							<option value="<?php echo $vtId[$x]=$bairro["ID"];?>"><?php echo $vtBairro[$x]=$bairro["BAIRRO"];?></option>
							<?php $x;} endwhile;?>														
					</select>
					<select name="bairro" style="display: none; width:50em;" class="required" id="vitoria" hidden="true">							
						<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO WHERE CIDADE_ID=2;"; 
						$con = mysqli_query($phpmyadmin , $gdBairro); $x=0; 
						while($bairro = $con->fetch_array()):{?>
							<option value="<?php echo $vtId[$x]=$bairro["ID"];?>"><?php echo $vtBairro[$x]=$bairro["BAIRRO"];?></option>
							<?php $x;} endwhile;?>														
					</select>
					<select name="bairro" style="display: none; width:50em;" class="required" id="cariacica">							
						<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO WHERE CIDADE_ID=3;"; 
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
						<?php $gdCidade="SELECT ID, CIDADE FROM CIDADE"; 
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
				<input name="observacao" onkeypress="addLoadField('observacao')" onkeyup="rmvLoadField('observacao')" type="text" class="input" placeholder="Galpão"  maxlength="200" onblur="checkAdress(form1.observacao, 'msgNoteOk','msgNoteNok')" id="inputNote" style="width:50em;">
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
				<input name="cep" type="text" class="input maskCep required" placeholder="29166-066" maxlength="9" onkeypress="addLoadField('cep')" onkeyup="rmvLoadField('cep')" onblur="checkAdress(form1.cep, 'msgZipcodeOk','msgZipcodeNok')" id="inputZipcode">
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
	          			<input type="radio" name="vale" value="s" class="inputVale">Sim	          		
	        		</label>
	        		<label class="radio">
	          			<input type="radio" name="vale" value="n" class="inputVale">Não
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
	          			<input type="radio" name="veiculo" onclick="enableVehicle()" value="s" class="inputVehicle">Sim	          		
	        		</label>
	        		<label class="radio">
	          			<input type="radio" name="veiculo" onclick="disableVehicle()" value="n" class="inputVehicle">Não
	        		</label>
	      		</div>
	    	</div>
	  	</div>
	</div><!--FINAL DIVISÃO EM HORIZONTAL-->
	<div hidden class="field is-horizontal"><!--DIVISÃO EM HORIZONTAL-->
		<div class="field" style="display: none;" id="vehicleType">
			<label class="label" for="textInput">Tipo*</label>
			<div class="control has-icons-left">
				<div class="select">
				  	<select name="tipo" onchange="upIconVehicle(this.value)">							
						<?php $gdVeiculoTipo="SELECT ID, TIPO FROM VEICULO_TIPO;"; 
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
		<div class="field" style="display: none;" id="vehicleModel">
			<label class="label" for="textInput">Modelo*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:18em;" id="modelo">
				<input name="modelo" type="text" class="input required" placeholder="Fiat Uno" maxlength="40" onblur="checkAdress(form1.modelo, 'msgModelOk','msgModelNok')" id="inputModel">
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
		<div class="field" style="display: none;" id="vehicleBoard">
			<label class="label" for="textInput">Placa*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:11em;" id="placa">
				<input name="placa" type="text" class="input required maskPlaca" placeholder="MQD-2045" maxlength="8" onblur="checkAdress(form1.placa, 'msgBoardOk','msgBoardNok')" id="inputBoard" onkeyup="uppercase(this)">
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
		<div class="field" style="display: none;" id="vehicleColor">
			<label class="label" for="textInput">Cor*</label>
			<div class="control has-icons-left">
				<div class="select">
				  	<select name="cor">							
						<?php $gdCor="SELECT ID, COR FROM COR ORDER BY COR;"; 
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
		<div class="field" style="display: none;" id="vehicleYear">
			<label class="label" for="textInput">Ano*</label>
			<div class="control has-icons-left has-icons-right" style="max-width:9.6em;" id="ano">
				<input name="ano" type="text" class="input numero required" placeholder="2008" maxlength="4" onblur="checkAdress(form1.ano, 'msgYearOk','msgYearNok')" id="inputYear">
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
					<input name="cadastrar" type="submit" class="button is-primary" value="Inserir"/>
				</div>
				<div class="control">
					<a href="adress-insert.php"><input name="limpar" type="submit" class="button is-primary" value="Limpar"></a>
				</div>
				<div class="control">
					<a href="<?php if($_SESSION["permissao"]==1){ echo 'register.php';} else{ echo 'user-query-filter.php';} ?>" class="button is-primary">Voltar</a>										
				</div>
				<?php if($_SESSION["permissao"]>1):{?>
				<div class="control">
					<a href="register.php" class="button is-primary">Cancelar</a>										
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
				$inserirEndereco="INSERT INTO ENDERECO(USUARIO_ID, ENDERECO, NUMERO, QUADRA, COMPLEMENTO, BAIRRO_ID, CEP, OBSERVACAO, CADASTRADO_EM, VALE_TRANSPORTE) VALUES(".$_SESSION["filter"][3].",'".$endereco."',".$numero.",NULL,'".$complemento."',".$bairro.",'".$cep."','".$observacao."','".date('Y-m-d')."', '".$vale."')";
			}
			else{
				$inserirEndereco="INSERT INTO ENDERECO(USUARIO_ID, ENDERECO, NUMERO, QUADRA, COMPLEMENTO, BAIRRO_ID, CEP, OBSERVACAO, CADASTRADO_EM, VALE_TRANSPORTE) VALUES(".$_SESSION["filter"][3].",'".$endereco."',".$numero.",".$quadra.",'".$complemento."',".$bairro.",'".$cep."','".$observacao."','".date('Y-m-d')."', '".$vale."')";
			}
			mysqli_query($phpmyadmin, $inserirEndereco);
			$inserirVeiculo="INSERT INTO VEICULO(USUARIO_ID, VEICULO_TIPO_ID, COR_ID, MODELO, PLACA, ANO) VALUES(".$_SESSION["filter"][3].",".$tipo.",".$cor.",'".$modelo."','".$placa."','".$ano."')";
			mysqli_query($phpmyadmin, $inserirVeiculo);
			if(mysqli_error($phpmyadmin)==null){
				echo"<script language='Javascript'> alert('Endereço cadastrado com sucesso!!!'); window.location.href='register.php';</script>";
			}
			else{
				echo"<script language='Javascript'> alert('Erro ao cadastrar!!!');</script>";
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
			$inserirEndereco="INSERT INTO ENDERECO(USUARIO_ID, ENDERECO, NUMERO, QUADRA, COMPLEMENTO, BAIRRO_ID, CEP, OBSERVACAO, CADASTRADO_EM, VALE_TRANSPORTE) VALUES(".$_SESSION["filter"][3].",'".$endereco."',".$numero.",NULL,'".$complemento."',".$bairro.",'".$cep."','".$observacao."','".date('Y-m-d')."', '".$vale."')";
		}
		else{
			$inserirEndereco="INSERT INTO ENDERECO(USUARIO_ID, ENDERECO, NUMERO, QUADRA, COMPLEMENTO, BAIRRO_ID, CEP, OBSERVACAO, CADASTRADO_EM, VALE_TRANSPORTE) VALUES(".$_SESSION["filter"][3].",'".$endereco."',".$numero.",".$quadra.",'".$complemento."',".$bairro.",'".$cep."','".$observacao."','".date('Y-m-d')."', '".$vale."')";
		}
		mysqli_query($phpmyadmin, $inserirEndereco);
		if(mysqli_error($phpmyadmin)==null){
			echo"<script language='Javascript'> alert('Endereço cadastrado com sucesso!!!'); window.location.href='register.php';</script>";
		}
		else{
			echo"<script language='Javascript'> alert('Erro ao cadastrar!!!');</script>";
			echo mysqli_error($phpmyadmin);				
		}
	}
}//FINAL DA VERIFICAÇÃO DO ENVIO DO FORMULÁRIO
?>