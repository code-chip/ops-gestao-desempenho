<?php
if($_SESSION["permissao"]==4){
$DBUSER="id8414870_admin";
$DBPASSWD="ProjetoAlfa@2019";
$DATABASE="id8414870_projetoalfa";

$filename = "backup-" . date("d-m-Y") . ".sql";
$mime = "application/x-gzip";
//header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

$cmd = "mysqldump -u $DBUSER --password=$DBPASSWD $DATABASE";   

passthru( $cmd );

exit(0);
}
else{
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh: 1;url=home.php");
}
?>