<?php
session_start();
if($_SESSION["permissao"]==4){
$DBUSER="u574423931_evino";
$DBPASSWD="ProjetoAlfa@2019";
$DATABASE="u574423931_evino";

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