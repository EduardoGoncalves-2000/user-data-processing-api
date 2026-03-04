# User Data Processing API

## Descrição

Este teste tem como objetivo avaliar:

- Boas práticas de programação
- Organização e estruturação de código
- Performance da aplicação
- Clareza na documentação

---

## Objetivo

Este repositório contém um arquivo `.json` com aproximadamente **32.000 usuários fictícios**.

O objetivo do projeto é desenvolver uma **REST API** capaz de:

1. Receber um arquivo `.json` por meio de uma URL enviada via `form-data`;
2. Processar e persistir os dados conforme os requisitos definidos;
3. Disponibilizar os dados processados para consulta através de endpoints.

---

## Requisitos Funcionais

### 1. Recebimento do arquivo `.json`

- O arquivo `.json` deverá ser enviado por meio de uma **URL**, utilizando `form-data`;
- Após o recebimento, a API deverá:
  - Processar seu conteúdo;
  - Armazenar todos os usuários no banco de dados.

#### Dados obrigatórios a serem armazenados:

- `id`
- `first_name`
- `last_name`
- `email`

---

### 2. Busca individual de usuário

- A API deverá disponibilizar um endpoint para consulta de um usuário específico;
- O **ID do usuário** deverá ser utilizado como parâmetro na URL;
- A resposta deverá ser retornada no formato JSON conforme o exemplo abaixo:

```json
{
  "user": {
    "id": "5df38f6e695566a48211da8f",
    "first_name": "Blankenship",
    "last_name": "Vincent",
    "email": "blankenshipvincent@rocklogic.com"
  }
}
```

---

## Endpoints

> A nomenclatura dos endpoints fica a critério do desenvolvedor, porém deve ser devidamente documentada.

Endpoints esperados:

- Endpoint para recebimento e processamento do arquivo `.json`
- Endpoint para busca individual de usuário por ID

---

## Requisitos Técnicos

- A linguagem de programação é de livre escolha;
- Todos os arquivos da API deverão estar dentro do diretório `api`;
- Não é necessária autenticação de usuário;
- A nomenclatura dos endpoints fica a critério do desenvolvedor, porém deve ser devidamente documentada;
- A aplicação deverá conter instruções claras para execução local do projeto.

---

## Critérios de Avaliação

- Organização da estrutura do projeto
- Clareza e padronização do código
- Tratamento de erros
- Validação de dados
- Performance no processamento do arquivo
- Documentação da API
- Boas práticas (ex: separação de camadas, uso de padrões, etc.)

---

## Execução do Projeto

O projeto deverá conter um `README.md` com:

- Pré-requisitos
- Passo a passo para instalação
- Como executar a aplicação localmente
- Como testar os endpoints
- Exemplos de requisições (ex: via cURL ou Postman)
