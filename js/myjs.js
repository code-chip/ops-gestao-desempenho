function upPlaceholder(selecao){//função usada no cadastro de usuário.
	if(selecao=="MATRICULA="){
		document.getElementById("filtro").placeholder="629";
		//document.getElementById("filtro").classList.add("numero");//adição de mascara restrigir a número.
	}
	else if(selecao=="LOGIN="){
		id=document.getElementById("filtro");
		//id.classList.remove("numero");//adição de mascara restrigir a número.
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