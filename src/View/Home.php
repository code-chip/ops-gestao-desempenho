<?php 

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

$number = rand(1, 25);
$wallpaper = "/images/wallpaper/data-science$number-min.jpg";

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<link rel="shortcut icon" href="/images/favicon_codechip.ico"/>
	<link rel="stylesheet" href="/css/login.css" />
	<link rel="stylesheet" href="/css/animate.css" />	
	<link rel="stylesheet" href="/css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<title>Gestão de Desempenho - Início</title>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?= $wallpaper ?>" />
	  	<div class="hero-body">
	    	<div class="container">
		     	<h1 class="title animated bounceInDown">Olá</h1>
		      	<h3 class="subtitle animated bounceInRight">Bem vindo</h3>
	    	</div>
	  	</div>
	</div>
</body>
</html>
