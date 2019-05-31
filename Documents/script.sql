CREATE TABLE desempenho (
  ID INTEGER   NOT NULL AUTO_INCREMENT ,
  NOME VARCHAR(60),
  ATIVIDADE VARCHAR(21),
  PRESENCA VARCHAR(8),
  DESEMPENHO INTEGER(3),
  META INTEGER(3),
  ALCANCADO FLOAT(3.2),
  REGISTRO DATE,
  OBSERVACAO VARCHAR(200),
PRIMARY KEY(ID));


correção do erro Código de erro: 1055 incompatível com sql_mode = only_full_group_by
#SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
#ou
#set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';

insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("28/12/18", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("02/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',200,160,125,STR_TO_DATE("03/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("04/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',200,160,125,STR_TO_DATE("05/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("07/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("08/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',200,160,125,STR_TO_DATE("09/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("10/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',217,160,135.63,STR_TO_DATE("11/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("12/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("14/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("15/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',200,160,125,STR_TO_DATE("16/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("17/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("18/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("19/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',200,160,125,STR_TO_DATE("21/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("22/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("23/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("24/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',217,160,135.63,STR_TO_DATE("25/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("26/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',217,160,135.63,STR_TO_DATE("28/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("29/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("30/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',217,160,135.63,STR_TO_DATE("31/01/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("01/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("02/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',200,160,125,STR_TO_DATE("04/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("05/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("06/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("07/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("08/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("09/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("11/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("12/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',217,160,135.63,STR_TO_DATE("13/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("14/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',180,160,112.5,STR_TO_DATE("16/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will','PBL',170,160,106.25,STR_TO_DATE("18/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 8,7,114.28,STR_TO_DATE("19/02/19", "%d/%m/%Y"));																																  
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 46,38,121.05,STR_TO_DATE("20/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 8,7,114.28,STR_TO_DATE("21/02/19", "%d/%m/%Y"));	
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 8,7,114.28,STR_TO_DATE("25/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 38,38,100,STR_TO_DATE("22/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 5,7,71.43,STR_TO_DATE("23/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 39,38,102.63,STR_TO_DATE("26/02/19", "%d/%m/%Y"));																																	  
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 7,7,100,STR_TO_DATE("27/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 40,38,105.26,STR_TO_DATE("28/02/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 6,7,85.71,STR_TO_DATE("01/03/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 37,38,97.37,STR_TO_DATE("02/03/19", "%d/%m/%Y"));																																	  
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 9,7,128.57,STR_TO_DATE("06/03/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 46,38,121.05,STR_TO_DATE("07/03/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 8,7,114.28,STR_TO_DATE("08/03/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Checkout', 38,38,100,STR_TO_DATE("11/03/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'Separação', 7,7,100,STR_TO_DATE("12/03/19", "%d/%m/%Y"));
insert into desempenho(nome, atividade, desempenho, meta, alcancado, registro) values('Lwcyano Will', 'PBL', 200,160,125,STR_TO_DATE("13/03/19", "%d/%m/%Y"));

