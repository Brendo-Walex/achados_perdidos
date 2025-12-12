-- Criação do Banco (caso o Docker não tenha criado via ENV)
CREATE DATABASE IF NOT EXISTS achados_e_perdidos;
USE achados_e_perdidos;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Inserindo admin (Já com a senha final atualizada do seu script)
-- A senha hash abaixo parece ser 'password' ou similar gerado via password_hash
INSERT INTO usuarios (login, senha) 
VALUES ('admin', '$2y$10$927L6CKsDpBc/WKryXH6GOc29befUNF0mSCTdzvC.OPZl/F/1U3W.')
ON DUPLICATE KEY UPDATE login=login;

-- Tabela itens
CREATE TABLE IF NOT EXISTS itens (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    situacao TEXT, -- Ex: 'perdido', 'achado', 'devolvido'
    cor_predominante VARCHAR(30),
    foto VARCHAR(255),
    data_encontrado DATE,
    horario_aproximado TIME,
    pergunta_especifica VARCHAR(300),
    nome_de_quem_achou VARCHAR(150),
    descricao_curta VARCHAR(255)
);

-- Tabela solicitacoes
CREATE TABLE IF NOT EXISTS solicitacoes (
    id_solicitacao INT AUTO_INCREMENT PRIMARY KEY,
    id_item INT NOT NULL,
    nome_solicitante VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    cpf VARCHAR(15),
    data_nascimento DATE,
    descricao_detalhada TEXT,
    resposta_pergunta VARCHAR(150),
    arquivo_anexo VARCHAR(255),
    data_solicitacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_item) REFERENCES itens(id_item) ON DELETE CASCADE
);

-- Tabela devolucoes
CREATE TABLE IF NOT EXISTS devolucoes (
    id_devolucao INT AUTO_INCREMENT PRIMARY KEY,
    id_item INT NOT NULL,
    nome_receptor VARCHAR(100) NOT NULL,
    cpf VARCHAR(15) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_devolucao DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (id_item) REFERENCES itens(id_item) ON DELETE CASCADE
);