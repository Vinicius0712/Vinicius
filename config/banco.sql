-- Criação do banco de dados
CREATE DATABASE formas;
USE formas;

-- Criação de tabelas
CREATE TABLE unidade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    sigla VARCHAR(10) NOT NULL
);

CREATE TABLE quadrado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lado DECIMAL(10,2) NOT NULL,
    id_unidade INT NOT NULL,
    cor VARCHAR(7) NOT NULL,
    FOREIGN KEY (id_unidade) REFERENCES unidade(id)
);