function upPlaceholder(selecao){//função usada no cadastro de usuário.
	if(selecao=="MATRICULA="){
		document.getElementById("filtro").placeholder="629";
	}
	else if(selecao=="LOGIN="){
		document.getElementById("filtro").placeholder="harry.will";
	}
	else if(selecao=="NOME LIKE"){
		document.getElementById("filtro").placeholder="Harry Will ou Harry%";
	}
	else{
		document.getElementById("filtro").placeholder="willvix@outlook.com ou will%";
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
	}

}
function addLoadField(id){//função p/ adicionar icone de carregamento ao digitar.
    document.getElementById(""+id).classList.add("is-loading");
}
function rmvLoadField(id){//função p/ remover icone de carregamento ao parar de digitar.
    document.getElementById(""+id).classList.remove("is-loading");
}