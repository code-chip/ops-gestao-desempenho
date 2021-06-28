<?php
$production = 'sql357.main-hosting.eu';
$staging = 'localhost';

define("DB_SERVER", $staging); 
define("DB_USERNAME", "u574423931_evino"); 
define("DB_PASSWORD", "ProjetoAlfa@2019");
define("DB_DATABASE", "u574423931_evino");

$phpmyadmin = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$phpmyadmin->set_charset('utf8');