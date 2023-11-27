DROP DATABASE IF EXISTS bdlabora;
CREATE DATABASE IF NOT EXISTS bdlabora;
USE bdlabora;
CREATE TABLE Endereco
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	cep CHAR(8) NOT NULL UNIQUE, 
	uf CHAR(2) NOT NULL,
	cidade VARCHAR(100) NOT NULL,	
	bairro VARCHAR(100) NOT NULL,
	rua VARCHAR(100) NOT NULL,
	status BIT NOT NULL
);

CREATE TABLE Funcionario
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	rg VARCHAR(10) NOT NULL,
	cpf CHAR(11) NOT NULL UNIQUE,
	email VARCHAR(50) NOT NULL,
	senha CHAR(64) NOT NULL,
	dataNasc DATE NOT NULL,
	genero CHAR(1) NOT NULL,
	estadoCivil VARCHAR(13) NOT NULL,
	telefone CHAR(10),
	celular CHAR(11) NOT NULL,
	nResidencial INT NOT NULL,
	idEnd INT NOT NULL, FOREIGN KEY (idEnd) REFERENCES Endereco(id),
	complemento VARCHAR(128),
	status BIT NOT NULL,
	nivelAcesso INT NOT NULL
);

CREATE TABLE Cliente
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	rg VARCHAR(10) NOT NULL,	
	cpf CHAR(11) NOT NULL,
	dataNasc DATE NOT NULL,
	genero CHAR(1) NOT NULL,
	telefone CHAR(10),
	celular CHAR(11) NOT NULL,
	email VARCHAR(50) NOT NULL,
	senha VARCHAR(64) NOT NULL,
	nResidencial INT NOT NULL,
	idEnd INT NOT NULL, FOREIGN KEY (idEnd) REFERENCES Endereco(id),
	complemento VARCHAR(128)
);

CREATE TABLE Clinica
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL UNIQUE,
    telefone CHAR(10) NOT NULL UNIQUE,
	servicos TEXT NOT NULL,
    nRes INT NOT NULL,
	idEnd INT NOT NULL, FOREIGN KEY (idEnd) REFERENCES Endereco(id),
	status BIT NOT NULL
);

CREATE TABLE Exame
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	tipoExame VARCHAR(100) NOT NULL,
	token CHAR(64) NOT NULL,
	dataHoraExame datetime NOT NULL,
	idClinica INT NOT NULL, FOREIGN KEY (idClinica) REFERENCES Endereco(id),
	idCliente INT NOT NULL, FOREIGN KEY (idCliente) REFERENCES Endereco(id),
	status BIT NOT NULL
);

INSERT INTO Endereco (cep, uf, cidade, bairro, rua, status)
	VALUES ('00000000', 'RT', 'root', 'roor', 'root', 1);

INSERT INTO Cliente(nome, rg, cpf, email, senha, dataNasc, genero, telefone, celular, nResidencial, idEnd, complemento) 
	VALUES ('root', '0000000000', '00000000000', 'root@root', '4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2', '2023-01-01', 'root', '0000000000', '00000000000', 0, 1, 'root');
INSERT INTO Funcionario(nome, rg, cpf, email, senha, dataNasc, genero, estadoCivil, telefone, celular, nResidencial, idEnd, complemento, status, nivelAcesso) 
	VALUES ('root', '0000000000', '00000000000', 'root@root', '4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2', '2023-01-01', 'R', 'root', '0000000000', '00000000000', 0, 1, 'root', 1, 10);