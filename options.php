<?php 
$menuAtivo="configuracoes";
require('menu.php');
if(isset($_GET["tag"])){//VERIFICA SE O MENU PRINCIPAL FOI CLICADO
	echo "<script>alert('OK 2');</script>";
	$menu = $_GET['tag'];	
	$situacao= array_filter($_GET['menuAtivo']);	
	$upMenu="UPDATE MENU SET ATIVO='".$situacao[0]."' WHERE TAG='".$menu."'";
	mysqli_query($phpmyadmin, $upMenu);	
	if($situacao[0]=="n"){
		$upItem="UPDATE MENU_ITEM SET ATIVO='".$situacao[0]."' WHERE MENU_ID IN(SELECT ID FROM MENU WHERE TAG='".$menu."');";
		mysqli_query($phpmyadmin, $upItem); echo "TESTE";
	}
	else{
		$chkMenu="SELECT ID FROM MENU WHERE TAG='".$menu."';";//SELECIONA OS ID's.
		$cnx=mysqli_query($phpmyadmin, $chkMenu);
		while($idMenu=$cnx->fetch_array()){
			$chkMenuItem="SELECT ID FROM MENU_ITEM WHERE MENU_ID=".$idMenu["ID"].";";
			$cnx2=mysqli_query($phpmyadmin, $chkMenuItem);
			$x=1;
			while($xId=$cnx2->fetch_array()) {
				$upItem="UPDATE MENU_ITEM SET ATIVO='".$situacao[$x]."' WHERE ID=".$xId["ID"];
				$cnx3=mysqli_query($phpmyadmin, $upItem); echo "</br> ".$upItem;
				$x++;	
			}
		}	
	}
}	
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
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/options1-min.jpg"/>
	  	<div class="hero-body">
	    	<div class="container">
	    		<div class="box">
	    			<div class="has-text-righ">
	    			<label class="is-size-5 "><center><strong>Habilitar/Desativar Menu e Item de menu</strong></center></label>	    			
	    		<div class="columns">	    			
					<?php $x=0; $y=0;
						$checkMenu="SELECT ID, MENU, TAG, ATIVO FROM MENU WHERE ID NOT IN(1,2,3,4,29,30,31,32) GROUP BY MENU ORDER BY POSICAO";
						$cnx=mysqli_query($phpmyadmin, $checkMenu);						
						while($loadMenu=$cnx->fetch_array()):{ ?>
						<div class="column">							
							<label class="is-size-5"><strong><?php echo $loadMenu["MENU"]?></strong></label>
					    	<input id="switch-shadow<?php echo $x?>" class="<?php echo $loadMenu["TAG"];?> switch switch--shadow" <?php if($loadMenu["ATIVO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="updateMenu('<?php echo $loadMenu["TAG"];?>')">
				  			<label for="switch-shadow<?php echo $x?>"></label><?php
							$checkItem="SELECT * FROM MENU_ITEM WHERE MENU_ID IN(SELECT ID FROM MENU WHERE MENU='".$loadMenu["MENU"]."') GROUP BY ITEM ORDER BY POSICAO;";
							$cnx2=mysqli_query($phpmyadmin, $checkItem);
							while ($loadItem=$cnx2->fetch_array()):{ ?>
								<label class="is-size-5"><?php echo $loadItem["ITEM"]?></label>
					    		<input id="switch-flat<?php echo $y?>" class="<?php echo $loadMenu["TAG"];?> switch switch--flat" <?php if($loadItem["ATIVO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="updateMenu('<?php echo $loadMenu["TAG"];?>')">
				  				<label for="switch-flat<?php echo $y?>"></label>
							<?php $y++; }endwhile; ?>
						</div><?php	$x++;
						}endwhile;
					?>					    
				</div>
	    		</div>
	    	</div>	
	  	</div>
	</div>
	<script type="text/javascript">
		var tag; var selecao; var ativo;		
		function carregaSelecao(tag){			
			let meta = document.querySelectorAll("."+tag);
			var menu = [];
			var r=0;
			while(r < meta.length){
				if(meta[r].checked==true){
					menu.push('s');
				}
				else{
					menu.push('n');
				}				
				r++;
			}			
			atualizaMenu(tag, menu);
		}
		function updateMenu(mytag){
			let menu = document.querySelectorAll("."+mytag);
			for (let i = 0; i < menu.length; i++) {
			    if (menu[0].checked && i+1 < menu.length){
				    menu[i+1].removeAttribute("disabled");
			    } else {
			    	if (i+1 < menu.length) {
			        for (let j = i+1; j < menu.length; j++) {
			          menu[j].checked = false;
			          menu[j].setAttribute("disabled", "true");
			        }
			      }
			    }		    
			}
			carregaSelecao(mytag);		  
		}					
		function atualizaMenu(str, ativos) {								
			if (str.length == 0) {
		    	document.getElementById("txtHint").innerHTML = "";
		    	return;
		  	}else {
		    	var xmlhttp = new XMLHttpRequest();
		    	xmlhttp.onreadystatechange = function() {
		      	if (this.readyState == 4 && this.status == 200) {
		        	document.getElementById("txtHint").innerHTML = this.responseText;
		      	}
		    };		    
		    xmlhttp.open("GET", "options.php?tag="+str+"&menuAtivo[]="+ativos[0]+"&menuAtivo[]="+ativos[1]+"&menuAtivo[]="+ativos[2]+"&menuAtivo[]="+ativos[3]+"&menuAtivo[]="+ativos[4]+"&menuAtivo[]="+ativos[5]+"&menuAtivo[]="+ativos[6], true);	    
		    xmlhttp.send();		   	
		  }
		  setTimeout(function(){
		  	window.location.reload('menu.php');
		  },1000);		  
		}
	</script>
</body>
</html>