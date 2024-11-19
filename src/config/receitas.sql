CREATE DATABASE receitas;

USE receitas;

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(250) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    dataCriacao 
);

CREATE TABLE receitas (
    id SERIAL PRIMARY KEY,
    categoria
    titulo
    descricao
    ingredientes
    modo_preparo
    usuario_id
    dataCriacao
);
