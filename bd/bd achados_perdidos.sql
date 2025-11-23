CREATE DATABASE achados_perdidos;
USE achados_perdidos;

-- Tabela de usuários do sistema (quem cadastra e gerencia os itens)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (login, senha)
VALUES ('admin', '$2y$10$kFFG5eOAP9r5QvM7IhOPIeXZ5RzTjYN5SiYDkOjLH5DnJdPUyFQyG');

UPDATE usuarios
SET senha = '$2y$10$927L6CKsDpBc/WKryXH6GOc29befUNF0mSCTdzvC.OPZl/F/1U3W.'
WHERE login = 'admin';




-- Tabela de itens encontrados
CREATE TABLE itens (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    situacao TEXT,
    cor_predominante VARCHAR(30),
	foto VARCHAR(255),
    data_encontrado DATE,
    horario_aproximado TIME,
    pergunta_especifica VARCHAR(300),
    nome_de_quem_achou VARCHAR(150)
);
ALTER TABLE itens 
ADD descricao_curta VARCHAR(255) AFTER nome,
ADD status ENUM('achado','perdido') AFTER descricao;

ALTER TABLE itens DROP COLUMN status;



-- Tabela de solicitações de devolução/reivindicação
CREATE TABLE solicitacoes (
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
    FOREIGN KEY (id_item) REFERENCES itens(id_item)
);

-- Tabela de registros de devoluções
CREATE TABLE devolucoes (
    id_devolucao INT AUTO_INCREMENT PRIMARY KEY,
    id_item INT NOT NULL,
    nome_receptor VARCHAR(100) NOT NULL,
    cpf VARCHAR(15)  NOT NULL,
    email VARCHAR(15) NOT NULL,
    telefone VARCHAR(20)  NOT NULL,
    data_devolucao DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (id_item) REFERENCES itens(id_item)
);

