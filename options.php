<?php 
$menuAtivo="Configurações";
include('menu.php');
//function AtualizarMenu($menu){
//	$upMenu="UPDATE MENU SET ATIVO='n' WHERE MENU=".$menu;
//	$cnx=mysqli_query($phpmyadmin, $upMenu);
//	echo "CHAMADA DE FUNCAO";
//}
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
	    		<div class="columns">	    			
					<?php $x=0; $y=0;
						$checkMenu="SELECT ID, MENU, TAG, ATIVO FROM MENU WHERE ID NOT IN(1,2,3,4,29,30,31,32) GROUP BY MENU ORDER BY POSICAO";
						$cnx=mysqli_query($phpmyadmin, $checkMenu);						
						while($loadMenu=$cnx->fetch_array()):{ ?>
						<div class="column">							
							<label class="is-size-5"><strong><?php echo $loadMenu["MENU"]?></strong></label>
					    	<input id="switch-shadow<?php echo $x?>" class="<?php echo $loadMenu["TAG"];?> switch switch--shadow" <?php if($loadMenu["ATIVO"]=="s"){ echo "CHECKED";}?> type="checkbox">
				  			<label for="switch-shadow<?php echo $x?>"></label><?php
							$checkItem="SELECT * FROM MENU_ITEM WHERE MENU_ID IN(SELECT ID FROM MENU WHERE MENU='".$loadMenu["MENU"]."') GROUP BY ITEM ORDER BY POSICAO;";
							$cnx2=mysqli_query($phpmyadmin, $checkItem);
							while ($loadItem=$cnx2->fetch_array()):{ ?>
								<label class="is-size-5"><?php echo $loadItem["ITEM"]?></label>
					    		<input id="switch-flat<?php echo $y?>" class="<?php echo $loadMenu["TAG"];?> switch switch--flat" <?php if($loadItem["ATIVO"]=="s"){ echo "CHECKED";}?> type="checkbox">
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
		var tag2;		
		$(".meta").click(function(){
		  let meta = document.querySelectorAll(".meta");		 
		  for (let i = 0; i < meta.length; i++) {
		    if (meta[0].checked && i+1 < meta.length){
		      meta[i+1].removeAttribute("disabled");
		      tag='meta';
		    } else {
		      if (i+1 < meta.length) {
		        for (let j = i+1; j < meta.length; j++) {
		          meta[j].checked = false;
		          meta[j].setAttribute("disabled", "true");
		        }
		      }
		    }		     
		  }<?php $tag="meta";?>
		  tag2="meta";
		  atualizaMenu();		  
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
		  }<?php $tag="desempenho";?>
		  tag2="desempenho";
		  atualizaMenu();	
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
		  }<?php $tag="feedback";?>
		  tag2="feedback";
		  atualizaMenu();	
		});
		$(".relatorios").click(function(){
		  let relatorios = document.querySelectorAll(".relatorios");		 
		  for (let i = 0; i < relatorios.length; i++) {
		    if (relatorios[0].checked && i+1 < relatorios.length){
		      relatorios[i+1].removeAttribute("disabled");
		      tag="relatorios";
		    } else {
		      if (i+1 < relatorios.length) {
		        for (let j = i+1; j < relatorios.length; j++) {
		          relatorios[j].checked = false;
		          relatorios[j].setAttribute("disabled", "true");
		        }
		      }
		    }		    
		  }<?php $tag="relatorios";?>
		  tag2="relatorios";
		  atualizaMenu();	
		});
		$(".configuracoes").click(function(){
		  let configuracoes = document.querySelectorAll(".configuracoes");		 
		  for (let i = 0; i < configuracoes.length; i++) {
		    if (configuracoes[0].checked && i+1 < configuracoes.length){
		      configuracoes[i+1].removeAttribute("disabled");
		      <?php $tag="configuracoes2";?>
		    } else {
		      if (i+1 < configuracoes.length) {
		        for (let j = i+1; j < configuracoes.length; j++) {
		          configuracoes[j].checked = false;
		          configuracoes[j].setAttribute("disabled", "true");
		        }
		      }
		    }		    
		  }
		  tag2="configuracoes";
		  atualizaMenu();		  
		});
		function atualizaMenu(){
			alert('<?php echo $tag;?>');
			alert(tag2);			
			<?php
			$test=?>tag2<?php
			var_dump($test); 
			$upMenu="UPDATE MENU SET ATIVO='s' WHERE TAG='".$test."'";
			$cnx=mysqli_query($phpmyadmin, $upMenu);
			$upItem="UPDATE MENU_ITEM SET ATIVO='s' WHERE MENU_ID IN(SELECT ID FROM MENU WHERE TAG='".$test."');";
			$cnx=mysqli_query($phpmyadmin, $upItem); echo "TESTE";
			?>						
			//location.replace(location.href);
		}
	</script>
</body>
</html>
<?php 
function AtualizarMenu2(){
	$upMenu="UPDATE MENU SET ATIVO='n' WHERE MENU=Meta";
	$cnx=mysqli_query($phpmyadmin, $upMenu);
	echo "CHAMADA DE FUNCAO";
}
function meuA(){
	echo "<script>alert('TESTE55')</script>";
}

?>