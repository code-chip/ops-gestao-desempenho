/*USER IN REGISTER USER AND ADRESS*/
function check() {
	var inputs = document.getElementsByClassName('required');
	
	for (var x = 0 ; x < inputs.length; x++) {
		if(!inputs[x].value){
			alert('Preencha todos os campos * obrigatórios');
			return false;
		}
	}
	
	return true;
}

function change(select) {// traz o valor selecionado.
	$.each( $( '.loadId' ), function() {//ler todos id's da classe.
    	if (select == this.id) {//habilita a div que tem o id e valor igual.
    		document.getElementById(this.id).style.display = 'block';
    	} else {
    		document.getElementById(this.id).style.display = 'none';
    	}
	});
}

//GOAL-COMPANY
function clearForm(){
	var inputs = document.getElementsByClassName('required').length;
	for (var x = 1; x < inputs+1 ; x++) {
		document.getElementById("msgOk"+x).style.display = "none";		
		document.getElementById("input"+x).classList.remove("is-success");
		document.getElementById("msgNok"+x).style.display = "none";
		document.getElementById("input"+x).classList.remove("is-danger");
	}
}

function upPlaceholder(selecao){//função usada no cadastro de usuário.
	if(selecao=="MATRICULA="){
		document.getElementById("filtro").placeholder="629";
		//document.getElementById("filtro").classList.add("numero");//adição de mascara restrigir a número.
	}
	else if(selecao=="LOGIN="){
		id=document.getElementById("filtro");
		//Adiid.classList.remove("numero");//adição de mascara restrigir a número.
		id.placeholder="harry.will";
		
	}
	else if(selecao=="NOME LIKE"){
		document.getElementById("filtro").placeholder="Harry Will ou Harry%";
		document.getElementById("filtro").classList.remove("numero");//adição de mascara restrigir a número.
	}
	else{
		document.getElementById("filtro").placeholder="willvix@outlook.com ou will%";
		document.getElementById("filtro").classList.remove("numero");//adição de mascara restrigir a número.
	}
}
function validacaoEmail(field) {//função usada no cadastro de usuário.
	usuario = field.value.substring(0, field.value.indexOf("@"));
	dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
	if ((usuario.length >=1) &&
	    (dominio.length >=3) && 
	    (usuario.search("@")==-1) && 
	    (dominio.search("@")==-1) &&
	    (usuario.search(" ")==-1) && 
	    (dominio.search(" ")==-1) &&
	    (dominio.search(".")!=-1) &&      
	    (dominio.indexOf(".") >=1)&& 
	    (dominio.lastIndexOf(".") < dominio.length - 1)) {
		document.getElementById("msgemail").style.display="none";
		document.getElementById("email").classList.remove("is-danger");
	}
	else{
		document.getElementById("msgemail").style.display="block";
		document.getElementById("email").classList.add("is-danger");
		document.getElementById("iconMail").classList.remove("fas fa-envelope");
		document.getElementById("iconMail").classList.add("fas fa-fw");		
	}

}
//FINAL ADRESS-INSERT;//
function addLoadField(id){//função p/ adicionar icone de carregamento ao digitar.
    document.getElementById(""+id).classList.add("is-loading");
}
function rmvLoadField(id){//função p/ remover icone de carregamento ao parar de digitar.
    document.getElementById(""+id).classList.remove("is-loading");
}
function checkAdress(field, msgOk, msgNok){//função p/ ativar ou desativar icones e cores nos campos.
	if(field.value.length>0){
		document.getElementById(""+msgOk).style.display="block";
		document.getElementById(""+msgNok).style.display="none";
		document.getElementById(""+field.id).classList.remove("is-danger");
		document.getElementById(""+field.id).classList.add("is-success");
	}
	else{
		document.getElementById(""+msgNok).style.display="block";
		document.getElementById(""+msgOk).style.display="none";
		document.getElementById(""+field.id).classList.remove("is-success");
		document.getElementById(""+field.id).classList.add("is-danger");
	}
}
function enableVehicle(){//função usada no módulo endereço.
	document.getElementById("vehicleType").style.display="block";
	document.getElementById("vehicleModel").style.display="block";
	document.getElementById("vehicleBoard").style.display="block";
	document.getElementById("vehicleColor").style.display="block";
	document.getElementById("vehicleYear").style.display="block";
}
function disableVehicle(){//função usada no módulo endereço.
	document.getElementById("vehicleType").style.display="none";
	document.getElementById("vehicleModel").style.display="none";
	document.getElementById("vehicleBoard").style.display="none";
	document.getElementById("vehicleColor").style.display="none";
	document.getElementById("vehicleYear").style.display="none";
}
function upIconVehicle(id){
	if(id==1){
		document.getElementById("motoVehicle").style.display="none"
		document.getElementById("carVehicle").style.display="block";		
	}
	else{
		document.getElementById("carVehicle").style.display="none";
		document.getElementById("motoVehicle").style.display="block"
	}
}
function checkForm(cidade){
	var inputs = document.getElementsByClassName('required');
	var vehicle= document.getElementsByClassName('inputVehicle');
	var vale= document.getElementsByClassName('inputVale');
  	var len = inputs.length;
  	var valid = true;
  	if(vehicle[0].checked==false && vehicle[1].checked==false){//caso tenha marcado não p/ veículo, desconsidera os 3 campos obrigatórios seguintes.
  		valid = false;
  	}
  	else if(vehicle[1].checked==true){//caso tenha marcado não p/ veículo, desconsidera os 3 campos obrigatórios seguintes.
  		len=len-3;
  	}
  	if(vale[0].checked==false && vale[1].checked==false){//
  		valid = false;
  	}
  	for(var i=0; i < len; i++){
    	if (!inputs[i].value){ valid = false; }
  	}
  	if (!valid){
  		alert('Por favor preencha todos os campos* obrigatórios.');
    	return false;
  	} 
  	else{ 
		if(cidade==1){
			$("#cariacica").empty();
			$("#vitoria").empty();
		}
		else if(cidade==2){
			$("#cariacica").empty();
			$("#serra").empty();
		}
		else{
			$("#serra").empty();
			$("#vitoria").empty();
		}
  		return true; 
  	}
}
function upList(valor){
	alert('Lista de bairros atualizada!');
	if(valor==1){
		document.getElementById("cariacica").style.display="none";
		document.getElementById("vitoria").style.display="none";
		document.getElementById("serra").style.display="block";
	}
	else if(valor==2){
		document.getElementById("serra").style.display="none";
		document.getElementById("cariacica").style.display="none";
		document.getElementById("vitoria").style.display="block"		
	}
	else{
		document.getElementById("serra").style.display="none";
		document.getElementById("vitoria").style.display="none"
		document.getElementById("cariacica").style.display="block";				
	}
}
function uppercase(word){
	up= word.value.toUpperCase();
	word.value=up;
}
//FINAL ADRESS-INSERT;//
//MENU-INSERT;//
function menuInsertOnOffSelected(div){
	if(div == 'MENU_ITEM'){	   			 				
		document.getElementById('menu').style.display='block';	   				
	   	document.getElementById('selecao').style.display='block';	
	}
	else{
		document.getElementById('menu').style.display='none';	   				
		document.getElementById('selecao').style.display='none';		
	}
}
function menuInsertcheckForm(){
	var inputs = document.getElementsByClassName('required');
  	var len = inputs.length;
  	var valid = true;
  	for(var i=0; i < len; i++){
    	if (!inputs[i].value){ valid = false; }
  	}
  	if (!valid){
  		alert('Por favor preencha todos os campos* obrigatórios.');
    	return false;
  	} 
  	else{ 
  		return true; 
  	}
}//FINAL MENU-INSERT;//