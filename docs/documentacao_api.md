# Documentação da API de Receitas e Usuários

## Endpoints de Usuários

### 1. Listar Todos os Usuários
- **URL:** `/api/usuarios`
- **Método:** `GET`
- **Descrição:** Retorna uma lista de todos os usuários cadastrados.
- **Resposta de Sucesso:**
  ```json
  [
      {
          "id": 1,
          "nome": "João",
          "email": "joao@example.com",
          "dataCriacao": "2024-11-07 15:00:00"
      },
      {
          "id": 2,
          "nome": "Maria",
          "email": "maria@example.com",
          "dataCriacao": "2024-11-07 16:00:00"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
          "error": "Nenhum usuário encontrado"
      }
  ]

### 2. Criar Usuário
- **URL:** `/api/usuarios`
- **Método:** `POST`
- **Descrição:** Cria um novo usuário com nome, email e senha.
- **Dados de Entrada:**
  ```json
  [ 
      {
           "nome": "Carlos",
           "email": "carlos@example.com",
           "senha": "senha123"
      }
  ]

- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Usuário criado com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Todos os campos são obrigatórios"
      }
  ]

### 3. Login de Usuário
- **URL:** `/api/usuarios/login`
- **Método:** `POST`
- **Descrição:** Realiza o login de um usuário com email e senha.
- **Dados de Entrada:**
  ```json
  [ 
      {
           "email": "joao@example.com",
           "senha": "senha123"
      }
  ]

- **Resposta de Sucesso:**
  ```json
  [
      {
            "message": "Login bem-sucedido",
            "user": {
                "id": 1,
                "nome": "João",
                "email": "joao@example.com",
                "dataCriacao": "2024-11-07 15:00:00"
            }
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Email ou senha inválidos"
      }
  ]


### 4. Visualizar Usuário
- **URL:** `/api/usuarios/{id}`
- **Método:** `GET`
- **Descrição:** Retorna os dados de um usuário específico pelo ID.
- **Resposta de Sucesso:**
  ```json
  [
      {
           "id": 1,
           "nome": "João",
           "email": "joao@example.com",
           "dataCriacao": "2024-11-07 15:00:00"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Usuário não encontrado"
      }
  ]

### 5. Atualizar Usuário
- **URL:** `/api/usuarios/{id}`
- **Método:** `PUT`
- **Descrição:** Atualiza os dados de um usuário existente.
- **Dados de Entrada:**
  ```json
  [ 
      {
           "nome": "João da Silva",
           "email": "joao.silva@example.com",
           "senha": "novasenha123"
      }
  ]

- **Resposta de Sucesso:**
  ```json
  [
      {
            "message": "Usuário atualizado com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Usuário não encontrado"
      }
  ]


### 6. Excluir Usuário
- **URL:** `/api/usuarios/{id}`
- **Método:** `DELETE`
- **Descrição:** Exclui um usuário específico pelo ID.
- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Usuário excluído com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Usuário não encontrado"
      }
  ]


## Endpoints de Receitas

### 1. Listar Todas as Receitas
- **URL:** `/api/receitas`
- **Método:** `GET`
- **Descrição:** Retorna uma lista de todas as receitas cadastradas.
- **Resposta de Sucesso:**
  ```json
  [
      {
        "id": 1,
        "titulo": "Bolo de Chocolate",
        "descricao": "Um delicioso bolo de chocolate...",
        "ingredientes": ["farinha", "açúcar", "chocolate"],
        "modo_preparo": "Misture tudo e asse...",
        "dataCriacao": "2024-11-07 15:00:00"
    },
    {
        "id": 2,
        "titulo": "Macarrão ao Alho e Óleo",
        "descricao": "Uma receita rápida e saborosa...",
        "ingredientes": ["macarrão", "alho", "azeite"],
        "modo_preparo": "Cozinhe o macarrão e refogue o alho...",
        "dataCriacao": "2024-11-07 16:00:00"
    }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Nenhuma receita encontrada"
      }
  ]

### 2. Criar Receitas
- **URL:** `/api/receitas`
- **Método:** `POST`
- **Descrição:** Cria uma nova receita com título, descrição, ingredientes e modo de preparo.
- **Dados de Entrada:**
  ```json
  [ 
      {
          "titulo": "Pizza de Calabresa",
          "descricao": "Uma pizza caseira deliciosa.",
          "ingredientes": ["farinha", "queijo", "calabresa", "molho"],
          "modo_preparo": "Prepare a massa, acrescente os ingredientes...",
          "dataCriacao": "2024-11-07 17:00:00"
      }
  ]
- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Receita criada com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Todos os campos são obrigatórios"
      }
  ]


### 3. Visualizar Receitas
- **URL:** `/api/receitas/{id}`
- **Método:** `GET`
- **Descrição:** Retorna os dados de uma receita específica pelo ID.
- **Resposta de Sucesso:**
  ```json
  [
      {
         "id": 1,
         "titulo": "Bolo de Chocolate",
         "descricao": "Um delicioso bolo de chocolate...",
         "ingredientes": ["farinha", "açúcar", "chocolate"],
         "modo_preparo": "Misture tudo e asse...",
         "dataCriacao": "2024-11-07 15:00:00"
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
- **URL:** `/api/receitas/{id}`
- **Método:** `PUT`
- **Descrição:** Atualiza os dados de uma receita existente.
- **Dados de Entrada:**
  ```json
  [ 
      {
          "titulo": "Bolo de Chocolate com Morango",
          "descricao": "Bolo de chocolate com morangos frescos.",
          "ingredientes": ["farinha", "chocolate", "morango"],
          "modo_preparo": "Prepare a massa e decore com morangos.",
          "dataCriacao": "2024-11-07 18:00:00"
      }
  ]
- **Resposta de Sucesso:**
  ```json
  [
      {
           "message": "Receita atualizada com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Receita não encontrada"
      }
  ]


### 5. Excluir Receitas
- **URL:** `/api/receitas/{id}`
- **Método:** `DELETE`
- **Descrição:** Exclui uma receita específica pelo ID.
- **Resposta de Sucesso:**
  ```json
  [
      {
         "message": "Receita excluída com sucesso"
      }
  ]
- **Resposta de Erro:**
  ```json
  [
      {
           "error": "Receita não encontrada"
      }
  ]
