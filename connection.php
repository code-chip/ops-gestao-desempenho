<?php
define("DB_SERVER", "localhost"); 
define("DB_USERNAME", "id8414870_admin"); 
define("DB_PASSWORD", "ProjetoAlfa@2019");
define("DB_DATABASE", "id8414870_projetoalfa");  
//define("DB_DATABASE", "gestaodesempenho"); 
$phpmyadmin= new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);