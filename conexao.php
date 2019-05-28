<?php

define("DB_SERVER", "localhost"); 
define("DB_USERNAME", "id8414870_admin"); 
define("DB_PASSWORD", "ProjetoAlfa@2019"); 
define("DB_DATABASE", "id8414870_projetoalfa"); 
$conexao = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE); 

// you could test connection eventually using a if and else conditional statement, // feel free to take out the code below once you see Connected! if ($db) { echo "Connected!"; } else { echo "Connection Failed"; } 