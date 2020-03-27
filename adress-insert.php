<?php
$menuAtivo="configuracoes";
require('menu.php');
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Inserir Endereço</title>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones -->
    <script type="text/javascript" src="js/myjs.js"></script>
    <style type="text/css">
    	.layout{
    		display: block;
    		margin: 0 auto;
			width: 80%; /* Valor da Largura */
    	}
    </style>	
</head>
<body>
<div>
<section class="section">
	<section class="section">
	<div class="container">
	<main>
	<form id="form1" action="adress-insert.php" method="POST">
	<div class="layout">
	<h3 class="title"><i class="fas fa-plus-square"></i>&nbsp&nbsp  ENDEREÇO</h3>
	<h3 class="label"><?php echo $_SESSION["filter"][2];?></h3>
	<hr>		
		<div class="field is-horizontal">
		  	<div class="field-label is-normal"><!--SELEÇÃO SEXO-->
				<label for="sexo" class="label">Endereço*</label>
			</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left has-icons-right" id="endereco">
						<input name="endereco" onkeypress="addLoadField('endereco')" onkeyup="rmvLoadField('endereco')" type="text" class="input" placeholder="Rua Holdercim"  maxlength="50" onblur="checkAdress(form1.endereco, 'msgAdressOk','msgAdressNok')" id="inputAdress">
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
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO MATRICULA-->
				<label class="label" for="matricula">Número*</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left has-icons-right" style="max-width:9em;" id="numero">
						<input name="numero" type="text" class="input numero" placeholder="840" maxlength="4" onkeypress="addLoadField('numero')" onkeyup="rmvLoadField('numero')" onblur="checkAdress(form1.numero, 'msgNumberOk','msgNumberNok')" id="inputNumber">
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
			</div>	  	
		</div>
<div class="field is-horizontal">
		  	<div class="field-label is-normal"><!--SELEÇÃO SEXO-->
				<label for="sexo" class="label">Complemento</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left has-icons-right" id="referencia">
						<input name="complemento" type="text" class="input" placeholder="Ao lado do galpão Móveis Simonetti"  maxlength="50" onkeypress="addLoadField('referencia')" onkeyup="rmvLoadField('referencia')" onblur="checkAdress(form1.complemento, 'msgComplementOk','msgComplementNok')" id="inputComplement">
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
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO MATRICULA-->
				<label class="label" for="quadra">Quadra</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left has-icons-right" style="max-width:9em;" id="quadra">
						<input name="quadra" type="text" class="input numero" placeholder="3" maxlength="4" onblur="checkAdress(form1.quadra, 'msgBlockOk','msgBlockNok')" id="inputBlock">
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
			</div>	  	
		</div><!--FINAL DIVISÃO EM HORIZONTAL-->
		<!--DIVISÃO EM HORIZONTAL-->
		<div class="field is-horizontal"><!--SELEÇÃO CARGO-->			
			<div class="field-label is-normal">
				<label for="cargo" class="label">Bairro*</label>
			</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			<div class="field-body">
				<div class="field is-grouped">
				<div class="control has-icons-left">
				    <div class="select">
				      	<select name="bairro">							
							<?php $gdBairro="SELECT ID, BAIRRO FROM BAIRRO;"; 
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
				</div>
			</div>&nbsp&nbsp&nbsp
			<div class="field-label is-normal"><!--SELEÇÃO TURNO-->
				<label for="turno" class="label">Cidade*</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left">
						<div class="select">
							<select name="cidade">
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
			</div>						
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->
		<!---->
		<div class="field is-horizontal"><!--SELEÇÃO CARGO-->
			<div class="field-label is-normal"><!--SELEÇÃO SEXO-->
				<label for="observacao" class="label">Observação</label>
			</div>&nbsp&nbsp
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left has-icons-right" id="observacao">
						<input name="observacao" onkeypress="addLoadField('observacao')" onkeyup="rmvLoadField('observacao')" type="text" class="input" placeholder="Galpão"  maxlength="50" onblur="checkAdress(form1.observacao, 'msgNoteOk','msgNoteNok')" id="inputNote">
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
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO MATRICULA-->
				<label class="label" for="matricula">CEP*</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left has-icons-right" style="max-width:9em;" id="cep">
						<input name="cep" type="text" class="input maskCep" placeholder="29166-066" maxlength="9" onkeypress="addLoadField('cep')" onkeyup="rmvLoadField('cep')" onblur="checkAdress(form1.cep, 'msgZipcodeOk','msgZipcodeNok')" id="inputZipcode">
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
			</div>			
		</div>	
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<input name="cadastrar" type="submit" class="button is-primary" value="Inserir"/>
				</div>
				<div class="control">
					<a href="adress-insert.php"><input name="limpar" type="submit" class="button is-primary" value="Limpar"></a>
				</div>
				<div class="control">
					<a href="user-filter-query.php" class="button is-primary">Voltar</a>										
				</div>									
			</div>
		</div>
		</div>							
		</form>
	</main>
	</div>	
</section>
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
	//VALIDAÇÃO SE LOGIN É ÚNICO.
	$checkLogin="SELECT LOGIN FROM USUARIO WHERE LOGIN='".$login."'";
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	if($endereco!="" && $numero!="" && $cep!=""){
		$inserirEndereco="INSERT INTO ENDERECO(USUARIO_ID, ENDERECO, NUMERO, QUADRA, COMPLEMENTO, BAIRRO_ID, CEP, OBSERVACAO, CADASTRADO_EM) VALUES(".$_SESSION["filter"][0].",'".$endereco."',".$numero.",".$quadra.",'".$complemento."',".$bairro.",'".$cep."','".$observacao."','".date('Y-m-d')."')";
		mysqli_query($phpmyadmin, $inserirEndereco);
		if(mysqli_error($phpmyadmin)==null){
			echo"<script language='Javascript'> alert('Endereço cadastrado com sucesso!!!'); window.location.href='register.php';</script>";
		}
		else{
			echo"<script language='Javascript'> alert('Erro ao cadastrar!!!');</script>";
			echo mysqli_error($phpmyadmin);				
		}
	}
	else if($endereco==""){
		echo"<script language='Javascript'> alert('Preenchimento do Endereço é obrigatório!');</script>"; 
	}
	else if($numero==""){
		echo"<script language='Javascript'> alert('Preenchimento do Número é obrigatório!');</script>";
	} 
	else{
		echo"<script language='Javascript'> alert('Preenchimento do CEP é obrigatório!');</script>";
	}	
}//FINAL DA VERIFICAÇÃO DO ENVIO DO FORMULÁRIO
?>