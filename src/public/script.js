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
    let usuarios = await fetch("http://localhost:8000/src/api/user", {
        method: "GET",
    }).then(response => response);
    return usuarios.json();
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
    const tabela = document.querySelector("#usuarioTable tbody");
    tabela.innerHTML = '';
    let dado = await fetchUsuarios();
    dado.forEach((usuario) => {
        const linha = `<tr>
                <td>${usuario.id}</td>
                <td>${usuario.name}</td>
                <td>${usuario.email}</td>
                <td>${usuario.password}</td>
                <td><button onclick="removeUsuario(${usuario.id})">Deletar</button></td>
                <td><button onclick="window.location.href='/App-de-receitas/src/public/cadastrousuarios.html?id=${usuario.id}'">Editar</button></td>
                <td><button onclick="window.location.href='/App-de-receitas/src/public/viewreceita.html?id=${usuario.id}'">Visualizar</button></td>
            </tr>`;
        tabela.innerHTML += linha;
    });
}

async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        let id = parseInt(fromGet.get("id"));
        let usuarioData = await fetchUsuarios(id);
        document.getElementById('nome').value = usuarioData["name"]
        document.getElementById('email').value = usuarioData["email"]
        document.getElementById('senha').value = usuarioData["password"]
    }
}

async function editUsuario(id){
    const usuario = {
        id: id,
        name: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        password: document.getElementById('senha').value,
    };
    let data = await fetch("http://localhost:8000/src/api/user", {
        method: "PUT",
        body: JSON.stringify(usuario)
    }).then(resp => resp.text());
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