<?php 
$menuAtivo="Configurações";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Opções Habilitadas</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/personal.css">
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>	
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/options.jpg"/>
	  	<div class="hero-body">
	    	<div class="container">
	    		<div class="box">
	    		<div class="columns">
					<div class="column">
					    <label class="is-size-5"><strong>Meta</strong></label>
					    <input id="switch-shadow0" class="meta switch switch--shadow" type="checkbox">
				  		<label for="switch-shadow0"></label>				    
					    <label class="is-size-5">Consultar</label>
					    <input id="switch-flat0" class="meta switch switch--flat" disabled="disabled" type="checkbox">
				  		<label for="switch-flat0"></label>			    
					    <label class="meses is-size-5">Inserir</label>
					    <input id="switch-shadow1" class="meta switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow1"></label>   
				  		<label class="meses is-size-5">Atualizar</label>
					    <input id="switch-flat1" class="meta switch switch--flat" type="checkbox">
				  		<label for="switch-flat1"></label>			    
					    <label class="meses is-size-5">Remover</label>
					    <input id="switch-shadow2" class="meta switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow2"></label>    
					</div>
					<div class="column">
					    <label class="is-size-5"><strong>Desempenho</strong></label>
					    <input id="switch-shadow3" class="desempenho switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow3"></label>				    
					    <label class="is-size-5">Consultar</label>
					    <input id="switch-flat3" class="desempenho switch switch--flat" type="checkbox">
				  		<label for="switch-flat3"></label>			    
					    <label class="is-size-5">Inserir</label>
					    <input id="switch-shadow4" class="desempenho switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow4"></label>   
				  		<label class="is-size-5">Atualizar</label>
					    <input id="switch-flat4" class="desempenho switch switch--flat" type="checkbox">
				  		<label for="switch-flat4"></label>			    
					    <label class="is-size-5">Remover</label>
					    <input id="switch-shadow6" class="desempenho switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow6"></label>				    
					    <label class="is-size-5">Pedente</label>
					    <input id="switch-flat6" class="desempenho switch switch--flat" type="checkbox">
				  		<label for="switch-flat6"></label>			    
					</div>
					<div class="column">
					    <label class="is-size-5"><strong>Feedback</strong></label>
					    <input id="switch-shadow7" class="feedback switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow7"></label>				    
					    <label class="is-size-5">Aprovar</label>
					    <input id="switch-flat7" class="feedback switch switch--flat" type="checkbox">
				  		<label for="switch-flat7"></label>			    
					    <label class="is-size-5">Enviar</label>
					    <input id="switch-shadow8" class="feedback switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow8"></label>   
				  		<label class="is-size-5">Solicitar</label>
					    <input id="switch-flat8" class="feedback switch switch--flat" type="checkbox">
				  		<label for="switch-flat8"></label>			    
					    <label class="is-size-5">Consultar</label>
					    <input id="switch-shadow9" class="feedback switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow9"></label>				    
					    <label class="is-size-5">Avaliação</label>
					    <input id="switch-flat9" class="feedback switch switch--flat" type="checkbox">
				  		<label for="switch-flat9"></label>			    
					</div>
					<div class="column">
					    <label class="is-size-5"><strong>Dashboard</strong></label>
					    <input id="switch-shadow10" class="switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow10"></label>				    
					    <label class="is-size-5"><strong>Relatórios</strong></label>
					    <input id="switch-flat10" class="relatorios switch switch--flat" type="checkbox" CHECKED>
				  		<label for="switch-flat10"></label>			    
					    <label class="is-size-5">Gestão</label>
					    <input id="switch-shadow11" class="relatorios switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow11"></label>   
				  		<label class="is-size-5">Individual</label>
					    <input id="switch-flat11" class="relatorios switch switch--flat" type="checkbox">
				  		<label for="switch-flat11"></label>
				  		<label class="is-size-5">SQL</label>
					    <input id="switch-shadow12" class="relatorios switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow12"></label>			    
					</div>
					<div class="column">
					    <label class="is-size-5"><strong>Configurações</strong></label>
					    <input id="switch-shadow13" class="configuracoes switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow13"></label>				    
					    <label class="is-size-5">Cadastro</label>
					    <input id="switch-flat12" class="configuracoes switch switch--flat" type="checkbox">
				  		<label for="switch-flat12"></label>			    
					    <label class="is-size-5">Opções</label>
					    <input id="switch-shadow14" class="configuracoes switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow14"></label>   
				  		<label class="is-size-5">Backup</label>
					    <input id="switch-flat13" class="configuracoes switch switch--flat" type="checkbox">
				  		<label for="switch-flat13"></label>			    
					    <label class="is-size-5">Reportar</label>
					    <input id="switch-shadow15" class="configuracoes switch switch--shadow" type="checkbox" CHECKED>
				  		<label for="switch-shadow15"></label>
					</div>
				</div>
	    		</div>
	    	</div>	
	  	</div>
	</div>
	<script type="text/javascript">		
		$(".meta").click(function(){
		  let meta = document.querySelectorAll(".meta");		 
		  for (let i = 0; i < meta.length; i++) {
		    if (meta[0].checked && i+1 < meta.length){
		      meta[i+1].removeAttribute("disabled");
		    } else {
		      if (i+1 < meta.length) {
		        for (let j = i+1; j < meta.length; j++) {
		          meta[j].checked = false;
		          meta[j].setAttribute("disabled", "true");
		        }
		      }
		    }
		  }
		});
		$(".desempenho").click(function(){
		  let desempenho = document.querySelectorAll(".desempenho");		 
		  for (let i = 0; i < desempenho.length; i++) {
		    if (desempenho[0].checked && i+1 < desempenho.length){
		      desempenho[i+1].removeAttribute("disabled");
		    } else {
		      if (i+1 < desempenho.length) {
		        for (let j = i+1; j < desempenho.length; j++) {
		          desempenho[j].checked = false;
		          desempenho[j].setAttribute("disabled", "true");
		        }
		      }
		    }
		  }
		});
		$(".feedback").click(function(){
		  let feedback = document.querySelectorAll(".feedback");		 
		  for (let i = 0; i < feedback.length; i++) {
		    if (feedback[0].checked && i+1 < feedback.length){
		      feedback[i+1].removeAttribute("disabled");
		    } else {
		      if (i+1 < feedback.length) {
		        for (let j = i+1; j < feedback.length; j++) {
		          feedback[j].checked = false;
		          feedback[j].setAttribute("disabled", "true");
		        }
		      }
		    }
		  }
		});
		$(".relatorios").click(function(){
		  let relatorios = document.querySelectorAll(".relatorios");		 
		  for (let i = 0; i < relatorios.length; i++) {
		    if (relatorios[0].checked && i+1 < relatorios.length){
		      relatorios[i+1].removeAttribute("disabled");
		    } else {
		      if (i+1 < relatorios.length) {
		        for (let j = i+1; j < relatorios.length; j++) {
		          relatorios[j].checked = false;
		          relatorios[j].setAttribute("disabled", "true");
		        }
		      }
		    }
		  }
		});
		$(".configuracoes").click(function(){
		  let configuracoes = document.querySelectorAll(".configuracoes");		 
		  for (let i = 0; i < configuracoes.length; i++) {
		    if (configuracoes[0].checked && i+1 < configuracoes.length){
		      configuracoes[i+1].removeAttribute("disabled");
		    } else {
		      if (i+1 < configuracoes.length) {
		        for (let j = i+1; j < configuracoes.length; j++) {
		          configuracoes[j].checked = false;
		          configuracoes[j].setAttribute("disabled", "true");
		        }
		      }
		    }
		  }
		});
	</script>
</body>
</html>