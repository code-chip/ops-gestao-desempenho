<?php
define("DB_SERVER", "DB_SERVER");
define("DB_USERNAME", "DB_USERNAME");
define("DB_PASSWORD", "DB_PASSWORD");
define("DB_DATABASE", "DB_DATABASE");
//define("DB_DATABASE", "gestaodesempenho"); 
$phpmyadmin= new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);