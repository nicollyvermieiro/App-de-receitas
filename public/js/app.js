// Base URL da API
const apiUrl = 'http://localhost/api/usuarios';  // ajuste conforme a URL do seu backend

// Função para Listar Usuários
async function listarUsuarios() {
    const response = await fetch(apiUrl);
    const usuarios = await response.json();

    const tbody = document.querySelector('#user-list tbody');
    tbody.innerHTML = '';

    usuarios.forEach(usuario => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${usuario.id}</td>
            <td>${usuario.nome}</td>
            <td>${usuario.email}</td>
            <td>
                <button onclick="editarUsuario(${usuario.id})" class="btn btn-warning btn-sm">Editar</button>
                <button onclick="excluirUsuario(${usuario.id})" class="btn btn-danger btn-sm">Excluir</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Função para Cadastrar Usuário
document.getElementById('form-create').addEventListener('submit', async (event) => {
    event.preventDefault();

    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    const response = await fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nome, email, senha })
    });

    if (response.ok) {
        listarUsuarios();
        document.getElementById('form-create').reset();
    } else {
        alert('Erro ao cadastrar usuário');
    }
});

// Função para Excluir Usuário
async function excluirUsuario(id) {
    const response = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
    if (response.ok) {
        listarUsuarios();
    } else {
        alert('Erro ao excluir usuário');
    }
}

// Função para Editar Usuário (exemplo simplificado)
async function editarUsuario(id) {
    const nome = prompt("Novo nome:");
    const email = prompt("Novo email:");

    if (nome && email) {
        const response = await fetch(`${apiUrl}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nome, email })
        });

        if (response.ok) {
            listarUsuarios();
        } else {
            alert('Erro ao editar usuário');
        }
    }
}

// Carrega a lista ao iniciar a página
listarUsuarios();
