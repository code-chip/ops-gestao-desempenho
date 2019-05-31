<?php
/*$user = "id8414870_admin"; 
$password = "ProjetoAlfa@2019"; 
$database = "gestaodesempenho"; 
$hostname = "localhost"; 
mysql_connect( $hostname, $user, $password ) or die( ' Erro na conexão ' );*/ 
define("DB_SERVER", "localhost"); 
define("DB_USERNAME", "id8414870_admin"); 
define("DB_PASSWORD", "ProjetoAlfa@2019"); 
define("DB_DATABASE", "gestaodesempenho"); 
$phpmyadmin= new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
//echo "DB_PASSWORD";

# Substitua abaixo os dados, de acordo com o banco criado

 
# O hostname deve ser sempre localhost 

 
# Conecta com o servidor de banco de dados 


// you could test connection eventually using a if and else conditional statement, // feel free to take out the code below once you see Connected! if ($db) { echo "Connected!"; } else { echo "Connection Failed"; } 
?>