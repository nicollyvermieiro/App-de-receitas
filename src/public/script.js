async function registrausuario() {
    const usuario = {
        name: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        password: document.getElementById('senha').value,
    };
    let data = await fetch("http://localhost:8000/src/api/user", {
        method: "POST",
        body: JSON.stringify(usuario)
    }).then(resp => resp.text());

}

async function fetchUsuarios() {
    try {
        const response = await fetch("http://localhost:8000/src/api/user", {
            method: "GET",  // Requisição GET para buscar os usuários
        });

        if (!response.ok) {
            console.error(`Erro na API. Status: ${response.status}`);
            return [];  // Se houver erro, retorna um array vazio
        }

        const data = await response.json();  // Converte a resposta em JSON
        console.log("Dados recebidos da API:", data);
        return data;
    } catch (error) {
        console.error("Erro ao buscar usuários:", error);
        return [];  // Se ocorrer algum erro, retorna um array vazio
    }
}

async function fetchUsuario(id) {
    let usuarios = await fetch(`http://localhost:8000/src/api/user?id=${id}`, {
        method: "GET",
    }).then(response => response);
    return usuarios.json();
}

async function removeUsuario(meuId) {
    let data = await fetch("http://localhost:8000/src/api/user", {
        method: "DELETE",
        body: JSON.stringify({
            id: meuId
        })
    }).then(resp => resp.text());
    window.location.reload();
}

async function carregarUsuarios() {
    const tabela = document.querySelector('#usuarioTable tbody');  // Obtém a tabela no HTML
    tabela.innerHTML = '';  // Limpa o conteúdo da tabela

    let usuarios = await fetchUsuarios();  // Busca os usuários usando a função fetchUsuarios

    console.log("Dados recebidos de fetchUsuarios:", usuarios);

    if (usuarios && Array.isArray(usuarios) && usuarios.length > 0) {
        usuarios.forEach((usuario) => {
            const linha = `
                <tr>
                    <td>${usuario.id}</td>
                    <td>${usuario.name}</td>
                    <td>${usuario.email}</td>
                    <td><button onclick="removeUsuario(${usuario.id})">Deletar</button></td>
                    <td><button onclick="window.location.href='cadastrousuarios.html?id=${usuario.id}'">Editar</button></td>
                </tr>`;
            tabela.innerHTML += linha;  
        });
    } else {
        tabela.innerHTML = '<tr><td colspan="5">Nenhum usuário encontrado.</td></tr>'; 
    }
}

// Carrega os usuários assim que a página for carregada
document.addEventListener('DOMContentLoaded', carregarUsuarios);


async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        let id = parseInt(fromGet.get("id"));
        let usuarioData = await fetchUsuarios(id);
        document.getElementById('nome').value = usuarioData["name"]
        document.getElementById('email').value = usuarioData["email"]
    }
}

async function editUsuario(id) {
    const usuario = {
        id: id,
        name: document.getElementById('nome').value,
        email: document.getElementById('email').value,
    };

    try {
        const response = await fetch("http://localhost:8000/src/api/user", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(usuario),
        });

        if (!response.ok) {
            console.error(`Erro na API. Status: ${response.status}`);
            console.log(await response.text()); // Detalhes do erro
        } else {
            console.log("Usuário atualizado com sucesso");
        }
    } catch (error) {
        console.error("Erro ao tentar editar usuário:", error);
    }
}


function detectType(){
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        editUsuario(fromGet.get("id"));
    }else {
        registrausuario();
    }
}

onUpdate();