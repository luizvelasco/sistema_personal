# Sistema de Personal - PHP

Este projeto tem como objetivo o gerenciamento de alunos, professores e avaliações físicas em uma academia ou centro de treinamento.

## 📦 Estrutura do Banco de Dados

O sistema utiliza as seguintes tabelas principais:

### 1️⃣ `professores`

Armazena os dados dos professores responsáveis pelas avaliações físicas e treinos.

| Campo         | Tipo       | Descrição                  |
| ------------- | ---------- | -------------------------- |
| id            | INT        | Chave primária             |
| nome          | VARCHAR(255) | Nome completo             |
| email         | VARCHAR(255) | Email (único)            |
| telefone      | VARCHAR(20)  | Telefone de contato       |
| ativo         | BOOLEAN    | Status ativo/inativo       |
| criado_em     | TIMESTAMP  | Data de criação do registro|
| atualizado_em | TIMESTAMP  | Data da última atualização |

---

### 2️⃣ `alunos`

Armazena as informações dos alunos.

| Campo         | Tipo       | Descrição                  |
| ------------- | ---------- | -------------------------- |
| id            | INT        | Chave primária             |
| nome          | VARCHAR(255) | Nome completo             |
| email         | VARCHAR(255) | Email (único, opcional)  |
| telefone      | VARCHAR(20)  | Telefone de contato       |
| data_nascimento | DATE    | Data de nascimento         |
| genero        | VARCHAR(15)  | Gênero (Masculino, Feminino, Outro) |
| foto          | VARCHAR(255) | Caminho da foto do aluno |
| professor_id  | INT        | Relaciona o professor      |
| ativo         | BOOLEAN    | Status ativo/inativo       |
| criado_em     | TIMESTAMP  | Data de criação do registro|
| atualizado_em | TIMESTAMP  | Data da última atualização |

---

### 3️⃣ `avaliacoes`

Armazena cada avaliação física realizada para um aluno.

| Campo         | Tipo       | Descrição                  |
| ------------- | ---------- | -------------------------- |
| id            | INT        | Chave primária             |
| aluno_id      | INT        | Relaciona o aluno          |
| professor_id  | INT        | Relaciona o professor      |
| data_avaliacao | DATE      | Data da avaliação          |
| peso          | DECIMAL(5,2) | Peso em Kg              |
| percentual_gordura | DECIMAL(5,2) | % de gordura corporal |
| percentual_massa_magra | DECIMAL(5,2) | % de massa magra |
| observacoes   | TEXT       | Observações gerais         |
| ativo         | BOOLEAN    | Status ativo/inativo       |
| criado_em     | TIMESTAMP  | Data de criação            |
| atualizado_em | TIMESTAMP  | Data da última atualização |

---

### 4️⃣ `avaliacao_fotos`

Permite associar múltiplas fotos a cada avaliação.

| Campo         | Tipo       | Descrição                  |
| ------------- | ---------- | -------------------------- |
| id            | INT        | Chave primária             |
| avaliacao_id  | INT        | Relaciona com a avaliação  |
| foto          | VARCHAR(255) | Caminho da foto         |
| descricao     | VARCHAR(255) | Descrição opcional (ex: frente, costas) |
| criado_em     | TIMESTAMP  | Data de criação            |
| atualizado_em | TIMESTAMP  | Data da última atualização |

---

## ⚙️ Tecnologias utilizadas

- PHP 7.4.32 
- MySQL / MariaDB
- Bootstrap 4.5.3
- FontAwesome 5.15.1

## 🗂 Estrutura sugerida para upload de fotos

- `uploads/alunos/{id}.jpg` — Foto principal do aluno.
- `uploads/avaliacoes/{avaliacao_id}/{foto}.jpg` — Fotos das avaliações.

## 📄 Script SQL para criação do banco de dados

```sql
-- Criação do banco de dados (opcional)
CREATE DATABASE IF NOT EXISTS personal DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE personal;

-- Tabela: professores
CREATE TABLE IF NOT EXISTS professores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    password VARCHAR(200) NOT NULL,
    token VARCHAR(200),
    ativo BOOLEAN DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela: alunos (com referência ao professor)
CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    telefone VARCHAR(20),
    data_nascimento DATE,
    genero VARCHAR(15),
    foto VARCHAR(255),
    professor_id INT, -- Novo campo
    ativo BOOLEAN DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (professor_id) REFERENCES professores(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabela: avaliacoes
CREATE TABLE IF NOT EXISTS avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    data_avaliacao DATE NOT NULL,
    peso DECIMAL(5,2),
    percentual_gordura DECIMAL(5,2),
    percentual_massa_magra DECIMAL(5,2),
    observacoes TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela: avaliacao_fotos
CREATE TABLE IF NOT EXISTS avaliacao_fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    avaliacao_id INT NOT NULL,
    foto VARCHAR(255) NOT NULL,
    descricao VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (avaliacao_id) REFERENCES avaliacoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
