CREATE TABLE USUARIO (
  ID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(30) NULL,
  SOBRENOME VARCHAR(60) NULL,
  LOGIN VARCHAR(80) NULL,
  SENHA VARCHAR(32) NULL,
  PERMISSAO VARCHAR(15) NULL,
  SITUACAO INTEGER UNSIGNED NULL,
  PRIMARY KEY(ID)
);


insert into USUARIO(nome, SOBRENOME, LOGIN, SENHA, PERMISSAO, SITUACAO) VALUES('Administrador','do Sistema','admin',md5('814172050'),'Administrador',1);



Refence
https://www.youtube.com/watch?v=TNwCGttYrlM
how to install LAMP + PHPMyAdmin on Ubuntu 18.04 LTS

# Install apache
sudo apt install apache2

# Install PHP
sudo apt-get install php php-curl php-xml libapache2-mod-php php-mysql php-mbstring php-gettext

# Install MySql
sudo apt-get install mysql-server mysql-client

sudo mysql_secure_installation

sudo phpenmod mbstring

sudo systemctl restart apache2

mysql -u root -p

# MySQL CLI

SELECT user,authentication_string,plugin,host FROM mysql.user;

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'yourpass';

exit; 

# Install PHPMyAdmin

sudo apt-get install phpmyadmin
