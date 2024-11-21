# Documentação da API de Receitas e Usuários

## Endpoints de Usuários

### 1. Listar Todos os Usuários
- **URL:** `http://localhost:8000/src/api/user`
- **Método:** `GET`
- **Descrição:** Retorna uma lista de todos os usuários cadastrados.
- **Resposta de Sucesso:**
  ```json
  [
      {
          "id": 1,
          "name": "João",
          "email": "joao@example.com",
          "date": "2024-11-07 15:00:00"
      },
      {
          "id": 2,
          "name": "Maria",
          "email": "maria@example.com",
          "date": "2024-11-07 16:00:00"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
          "error": "Cadastro não encontrado"
      }
  ]

### 2. Criar Usuário
- **URL:** `http://localhost:8000/src/api/user`
- **Método:** `POST`
- **Descrição:** Cria um novo usuário com nome, email e senha.
- **Dados de Entrada:**
  ```json
  [ 
      {
           "name": "Carlos",
           "email": "carlos@example.com",
           "password": "senha123"
      }
  ]

- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Usuário cadastrado com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
          "error": "Erro ao cadastrar usuario", 
          "error": "Dados incompletos."
      }
  ]


### 4. Visualizar Usuário
- **URL:** ``http://localhost:8000/src/api/user?id=${id}`
- **Método:** `GET`
- **Descrição:** Retorna os dados de um usuário específico pelo ID.
- **Resposta de Sucesso:**
  ```json
  [
      {
          "id": 1,
          "name": "João",
          "email": "joao@example.com",
          "date": "2024-11-07 15:00:00"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Cadastro não encontrado"
      }
  ]

### 5. Atualizar Usuário
- **URL:** `http://localhost:8000/src/api/user`
- **Método:** `PUT`
- **Descrição:** Atualiza os dados de um usuário existente.
- **Dados de Entrada:**
  ```json
  [ 
      {
          "name": "João da Silva",
          "email": "joao.silva@example.com",
          "password": "novasenha123"
      }
  ]

- **Resposta de Sucesso:**
  ```json
  [
      {
            "message": "Cadastro atualizado com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Erro ao atualizar cadastro"
      }
  ]


### 6. Excluir Usuário
- **URL:** `http://localhost:8000/src/api/user`
- **Método:** `DELETE`
- **Descrição:** Exclui um usuário específico pelo ID.
- **Dados de Entrada:**
  ```json
  [ 
      {
        "id": 2
      }
  ]

- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Cadastro deletado com sucesso."
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Erro ao deletar Cadastro"
      }
  ]


## Endpoints de Receitas

### 1. Listar Todas as Receitas
- **URL:** `http://localhost:8000/src/api/receita`
- **Método:** `GET`
- **Descrição:** Retorna uma lista de todas as receitas cadastradas.
- **Resposta de Sucesso:**
  ```json
  [
      {
        "id": 1,
        "category": "Sobremesa",
        "title": "Bolo de Chocolate",        
        "ingredients": ["farinha", "açúcar", "chocolate"],
        "description": "Um delicioso bolo de chocolate...",
        "preparation_mode": "Misture tudo e asse...",
        "user_id": 1,
        "date": "2024-11-07 15:00:00"
    },
    {
         "id": 2,
        "category": "Prato principal",
        "title": "Macarrão ao Alho e Óleo",        
        "ingredients": ["macarrão", "alho", "azeite"],
        "description": "Uma receita rápida e saborosa...",
        "preparation_mode": "Cozinhe o macarrão e refogue o alho...",
        "user_id": 2,
        "date": "2024-11-07 16:00:00"
    }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Receita não encontrada."
      }
  ]

### 2. Criar Receitas
- **URL:** `http://localhost:8000/src/api/receita`
- **Método:** `POST`
- **Descrição:** Cria uma nova receita com título, descrição, ingredientes e modo de preparo.
- **Dados de Entrada:**
  ```json
  [ 
      {
          "category": "Lanche",
          "title": "Pizza de Calabresa",          
          "ingredients": ["farinha", "queijo", "calabresa", "molho"],
          "description": "Uma pizza caseira deliciosa.",
          "preparation_mode": "Prepare a massa, acrescente os ingredientes...",
          "user_id": 1,
          "date": "2024-11-07 17:00:00"
      }
  ]
- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Receita cadastrada com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
        "error": "Erro ao cadastrar receita",
        "error": "Dados incompletos."
      }
  ]


### 3. Visualizar Receitas
- **URL:** `http://localhost:8000/src/api/receita?id=${id}`
- **Método:** `GET`
- **Descrição:** Retorna os dados de uma receita específica pelo ID.
- **Resposta de Sucesso:**
  ```json
  [
      {
        "id": 1,
        "category": "Sobremesa",
        "title": "Bolo de Chocolate",        
        "ingredients": ["farinha", "açúcar", "chocolate"],
        "description": "Um delicioso bolo de chocolate...",
        "preparation_mode": "Misture tudo e asse...",
        "user_id": 1,
        "date": "2024-11-07 15:00:00"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Receita não encontrada"
      }
  ]



### 4. Atualizar Receitas
- **URL:** `http://localhost:8000/src/api/receita`
- **Método:** `PUT`
- **Descrição:** Atualiza os dados de uma receita existente.
- **Dados de Entrada:**
  ```json
  [ 
      {
        "id": 1,
        "category": "Petisco",
        "title": "Bolo de Chocolate",        
        "ingredients": ["farinha", "açúcar", "chocolate"],
        "description": "Um delicioso bolo de chocolate...",
        "preparation_mode": "Misture tudo e asse...",
        "user_id": 1
      }
  ]
- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Cadastro atualizado com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
        "error": "Erro ao atualizar cadastro",
        "error": "Dados incompletos."
      }
  ]


### 5. Excluir Receitas
- **URL:** ``http://localhost:8000/src/api/receita`
- **Método:** `DELETE`
- **Descrição:** Exclui uma receita específica pelo ID.
- **Dados de Entrada:**
  ```json
  [ 
      {
        "id": 2
      }
  ]
- **Resposta de Sucesso:**
  ```json
  [
      {
         "message": "Cadastro deletado com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
          "error": "Erro ao deletar Cadastro",
          "error": "Dados incompletos."
      }
  ]
