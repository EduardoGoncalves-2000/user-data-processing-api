# User Data Processing API

API REST para importação e consulta de usuários a partir de arquivo JSON.

## Tecnologias

- PHP 8.0+
- Laravel 9
- MySQL (padrão no `.env.example`)

## Requisitos Implementados

- Importação de usuários via `multipart/form-data`
- Persistência em banco na tabela `imported_users`
- Busca individual por ID
- Validação de dados na importação
- Processamento em lotes (`upsert`) para melhor performance

## Estrutura dos Dados

Campos obrigatórios por usuário:

- `id` (mapeado de `_id` no JSON de entrada)
- `first_name`
- `last_name`
- `email`

## Endpoints

### 1. Importar usuários

`POST /api/users/import`

Recebe arquivo no campo `file` via `form-data`.

#### Regras de validação do arquivo

- obrigatório
- tipo arquivo
- máximo `20MB`
- extensões aceitas: `json` e `txt`

#### Exemplo cURL

```bash
curl --request POST \
  --url http://127.0.0.1:8000/api/users/import \
  --form "file=@./mock-data.json"
```

#### Exemplo de sucesso (`201`)

```json
{
  "message": "Importação concluída com sucesso.",
  "total_in_file": 32000,
  "processed_valid": 32000,
  "skipped_invalid": 0
}
```

#### Erros possíveis

- `400` arquivo inválido
- `400` JSON inválido
- `400` formato inválido (não é array de usuários)
- `422` arquivo sem usuários
- `422` falha de validação no request

### 2. Buscar usuário por ID

`GET /api/users/{id}`

#### Exemplo cURL

```bash
curl --request GET \
  --url http://127.0.0.1:8000/api/users/5df38f6e695566a48211da8f
```

#### Exemplo de sucesso (`200`)

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

#### Exemplo não encontrado (`404`)

```json
{
  "error": "Usuário não encontrado."
}
```

## Como executar localmente

1. Entrar na pasta da API:

```bash
cd api
```

2. Instalar dependências:

```bash
composer install
```

3. Criar arquivo de ambiente:

```bash
cp .env.example .env
```

4. Gerar chave da aplicação:

```bash
php artisan key:generate
```

5. Configurar banco no `.env` (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

6. Rodar migrations:

```bash
php artisan migrate
```

7. Subir servidor local:

```bash
php artisan serve
```

A API ficará disponível em:

- `http://127.0.0.1:8000`

## Testes

Executar testes:

```bash
php artisan test
```

## Observações de implementação

- A importação usa `upsert` por `id`, então reimportar atualiza `first_name`, `last_name`, `email` e `updated_at`.
- O processamento é feito em lotes de 1000 registros.
- Registros inválidos são ignorados e contabilizados em `skipped_invalid`.
