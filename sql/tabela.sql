CREATE DATABASE wda_crud;
USE wda_crud;


CREATE TABLE customers (
id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(255) NOT NULL,
cpf_cnpj varchar(14) NOT NULL,
birthdate datetime NOT NULL,
address varchar(255) NOT NULL,
hood varchar(100) NOT NULL,
zip_code varchar(9) NOT NULL,
city varchar(100) NOT NULL,
state varchar(2) NOT NULL,
phone varchar(14) NOT NULL,
mobile varchar(15) NOT NULL,
ie varchar(15) NOT NULL,
created datetime NOT NULL,
modified datetime NOT NULL
);


CREATE TABLE usuarios(
    id int AUTO_INCREMENT not null PRIMARY KEY,
    nome varchar(50) not null,
    user varchar(50) not null,
    password varchar(100) not null,
    foto varchar(50) );
 

CREATE TABLE carros(
    id int AUTO_INCREMENT not null PRIMARY KEY,
    modelo varchar(50) not null,
    marca varchar(50) not null,
    ano INT,
    data_cad DATETIME,
    foto varchar(50) 
);
 

INSERT INTO `usuarios`(`nome`, `user`, `password`)
VALUES ('Pedro','admin','admin'),
