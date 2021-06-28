<?php 
$menuAtivo="configuracoes";
require('menu.php');
if(isset($_GET["tag"])){//VERIFICA SE O MENU PRINCIPAL FOI CLICADO
	echo "<script>alert('OK 2');</script>";
	$menu = $_GET['tag'];
	$permissao= $_GET['permissao'];	
	$situacao= array_filter($_GET['menuAtivo']);	
	$upMenu="UPDATE MENU SET LIBERADO='".$situacao[0]."' WHERE PERMISSAO_ID=".$permissao." AND TAG='".$menu."'";
	mysqli_query($phpmyadmin, $upMenu);	
	if($situacao[0]=="n"){
		$upItem="UPDATE MENU_ITEM SET LIBERADO='".$situacao[0]."' WHERE PERMISSAO_ID=".$permissao." AND MENU_ID IN(SELECT ID FROM MENU WHERE TAG='".$menu."');";
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
				$upItem="UPDATE MENU_ITEM SET LIBERADO='".$situacao[$x]."' WHERE PERMISSAO_ID=".$permissao." AND ID=".$xId["ID"];
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
	<title>Gestão de Desempenho - Permissões de Acesso</title>
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
	    	<div class="container user" id="list">
	    		<div class="box">
	    			<div class="has-text-righ">
	    				<label class="is-size-5 "><center><strong>Permissões de acesso Usuário</strong></center></label>	    			
		    			<div class="columns">	    			
						<?php $x=0; $y=0;
							$checkMenu="SELECT ID, MENU, TAG, LIBERADO, ATIVO FROM MENU WHERE PERMISSAO_ID=1 AND ID NOT IN(1,2,3,4,29,30,31,32) GROUP BY MENU ORDER BY POSICAO";
							$cnx=mysqli_query($phpmyadmin, $checkMenu);						
							while($loadMenu=$cnx->fetch_array()):{ ?>
							<div class="column" id="user">							
								<label class="is-size-5"><strong><?php echo $loadMenu["MENU"]?></strong></label>
						    	<input id="switch-shadow<?php echo $x?>" class="<?php echo $loadMenu["TAG"]."1";?> switch switch--shadow" <?php if($loadMenu["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','1')">
					  			<label for="switch-shadow<?php echo $x?>"></label><?php
								$checkItem="SELECT * FROM MENU_ITEM WHERE PERMISSAO_ID=1 AND MENU_ID IN(SELECT ID FROM MENU WHERE MENU='".$loadMenu["MENU"]."') GROUP BY ITEM ORDER BY POSICAO;";
								$cnx2=mysqli_query($phpmyadmin, $checkItem);
								while ($loadItem=$cnx2->fetch_array()):{ ?>
									<label class="is-size-5"><?php echo $loadItem["ITEM"]?></label>
						    		<input id="switch-flat<?php echo $y?>" class="<?php echo $loadMenu["TAG"]."1";?> switch switch--flat" <?php if($loadItem["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','1')">
					  				<label for="switch-flat<?php echo $y?>"></label>
								<?php $y++; }endwhile; ?>
							</div><?php	$x++;
							}endwhile;
						?>
					</div><!--columns user-->					    
	    		</div><!--Final div box-->
	    	</div><!--Final div container-->
	    	<div id="container">
	    		<div class="box">
	    			<div class="has-text-righ">
	    			<label class="is-size-5 "><center><strong>Permissões de acesso Líder</strong></center></label>	    			
	    		<div class="columns ">	    			
					<?php //$x=0; $y=0;
						$checkMenu="SELECT ID, MENU, TAG, LIBERADO, ATIVO FROM MENU WHERE PERMISSAO_ID=2 AND ID NOT IN(1,2,3,4,29,30,31,32) GROUP BY MENU ORDER BY POSICAO";
						$cnx=mysqli_query($phpmyadmin, $checkMenu);						
						while($loadMenu=$cnx->fetch_array()):{ ?>
						<div class="column leader">							
							<label class="is-size-5"><strong><?php echo $loadMenu["MENU"]?></strong></label>
					    	<input id="switch-shadow<?php echo $x?>" class="<?php echo $loadMenu["TAG"]."2";?> switch switch--shadow" <?php if($loadMenu["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','2')">
				  			<label for="switch-shadow<?php echo $x?>"></label><?php
							$checkItem="SELECT * FROM MENU_ITEM WHERE PERMISSAO_ID=2 AND MENU_ID IN(SELECT ID FROM MENU WHERE MENU='".$loadMenu["MENU"]."') GROUP BY ITEM ORDER BY POSICAO;";
							$cnx2=mysqli_query($phpmyadmin, $checkItem);
							while ($loadItem=$cnx2->fetch_array()):{ ?>
								<label class="is-size-5"><?php echo $loadItem["ITEM"]?></label>
					    		<input id="switch-flat<?php echo $y?>" class="<?php echo $loadMenu["TAG"]."2";?> switch switch--flat" <?php if($loadItem["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','2')">
				  				<label for="switch-flat<?php echo $y?>"></label>
							<?php $y++; }endwhile; ?>
						</div><?php	$x++;
						}endwhile;
					?>					    
				</div>
	    		</div><!--Final div box-->	    		
	    	</div><!--Final div container-->
	    	<div class="container">
	    		<div class="box">
	    			<div class="has-text-righ">
	    			<label class="is-size-5 "><center><strong>Permissões de acesso Gestor</strong></center></label>	    			
	    		<div class="columns">	    			
					<?php //$x=0; $y=0;
						$checkMenu="SELECT ID, MENU, TAG, LIBERADO, ATIVO FROM MENU WHERE PERMISSAO_ID=3 AND ID NOT IN(1,2,3,4,29,30,31,32) GROUP BY MENU ORDER BY POSICAO";
						$cnx=mysqli_query($phpmyadmin, $checkMenu);						
						while($loadMenu=$cnx->fetch_array()):{ ?>
						<div class="column">							
							<label class="is-size-5"><strong><?php echo $loadMenu["MENU"]?></strong></label>
					    	<input id="switch-shadow<?php echo $x?>" class="<?php echo $loadMenu["TAG"]."3";?> switch switch--shadow" <?php if($loadMenu["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','3')">
				  			<label for="switch-shadow<?php echo $x?>"></label><?php
							$checkItem="SELECT * FROM MENU_ITEM WHERE PERMISSAO_ID=3 AND MENU_ID IN(SELECT ID FROM MENU WHERE MENU='".$loadMenu["MENU"]."') GROUP BY ITEM ORDER BY POSICAO;";
							$cnx2=mysqli_query($phpmyadmin, $checkItem);
							while ($loadItem=$cnx2->fetch_array()):{ ?>
								<label class="is-size-5"><?php echo $loadItem["ITEM"]?></label>
					    		<input id="switch-flat<?php echo $y?>" class="<?php echo $loadMenu["TAG"]."3";?> switch switch--flat" <?php if($loadItem["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','3')">
				  				<label for="switch-flat<?php echo $y?>"></label>
							<?php $y++; }endwhile; ?>
						</div><?php	$x++;
						}endwhile;
					?>					    
				</div>
	    		</div><!--Final div box-->	    		
	    	</div><!--Final div container-->
	    	<div class="container">
	    		<div class="box">
	    			<div class="has-text-righ">
	    			<label class="is-size-5 "><center><strong>Permissões de acesso Administrador</strong></center></label>	    			
	    		<div class="columns">	    			
					<?php //$x=0; $y=0;
						$checkMenu="SELECT ID, MENU, TAG, LIBERADO, ATIVO FROM MENU WHERE PERMISSAO_ID=4 AND ID NOT IN(1,2,3,4,29,30,31,32) GROUP BY MENU ORDER BY POSICAO"; 
						$cnx=mysqli_query($phpmyadmin, $checkMenu);						
						while($loadMenu=$cnx->fetch_array()):{ ?>
						<div class="column" id="4">							
							<label class="is-size-5"><strong><?php echo $loadMenu["MENU"]?></strong></label>
					    	<input id="switch-shadow<?php echo $x?>" class="<?php echo $loadMenu["TAG"]."4";?> switch switch--shadow" <?php if($loadMenu["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','4')">
				  			<label for="switch-shadow<?php echo $x?>"></label><?php
							$checkItem="SELECT * FROM MENU_ITEM WHERE PERMISSAO_ID=4 AND MENU_ID IN(SELECT ID FROM MENU WHERE MENU='".$loadMenu["MENU"]."') GROUP BY ITEM ORDER BY POSICAO;";
							$cnx2=mysqli_query($phpmyadmin, $checkItem);
							while ($loadItem=$cnx2->fetch_array()):{ ?>
								<label class="is-size-5"><?php echo $loadItem["ITEM"]?></label>
					    		<input id="switch-flat<?php echo $y?>" class="<?php echo $loadMenu["TAG"]."4";?> switch switch--flat" <?php if($loadItem["LIBERADO"]=="s"){ echo "CHECKED";}?> type="checkbox" onclick="update('<?php echo $loadMenu["TAG"];?>','4')">
				  				<label for="switch-flat<?php echo $y?>"></label>
							<?php $y++; }endwhile; ?>
						</div><?php	$x++;
						}endwhile;
					?>					    
				</div>
	    		</div><!--Final div box-->	    		
	    	</div><!--Final div container-->		
	  	</div>
	</div>
	<script type="text/javascript">		
		var tag; var selecao; var ativo; permissao=1;	
		function carregaSelecao(tag){
			let meta = document.querySelectorAll("."+tag+permissao);
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
		function update(mytag, p){
			permissao=p;
			let dashboard = document.querySelectorAll("."+mytag+p);
			for (let i = 0; i < dashboard.length; i++) {
			    if (dashboard[0].checked && i+1 < dashboard.length){
				    dashboard[i+1].removeAttribute("disabled");
			    } else {
			    	if (i+1 < dashboard.length) {
			        for (let j = i+1; j < dashboard.length; j++) {
			          dashboard[j].checked = false;
			          dashboard[j].setAttribute("disabled", "true");
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
		    xmlhttp.open("GET", "permissions.php?tag="+str+"&permissao="+permissao+"&menuAtivo[]="+ativos[0]+"&menuAtivo[]="+ativos[1]+"&menuAtivo[]="+ativos[2]+"&menuAtivo[]="+ativos[3]+"&menuAtivo[]="+ativos[4]+"&menuAtivo[]="+ativos[5]+"&menuAtivo[]="+ativos[6], true);	    
		    xmlhttp.send();
		    		   	
		  }
		  setTimeout(function(){
		  	window.location.reload('menu.php');
		  },1000);
		}
	</script>
</body>
</html>