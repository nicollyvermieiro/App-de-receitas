async function registraReceita() {
    const receita = {
        category: document.getElementById('categoria').value,
        title: document.getElementById('titulo').value,
        ingredients: document.getElementById('ingredientes').value,
        description: document.getElementById('descricao').value,
        preparation_mode: document.getElementById('modo_preparo').value,
        user_id: document.getElementById('usuarioId').value,
    };
    let data = await fetch("http://localhost:8000/src/api/receita", {
        method: "POST",
        body: JSON.stringify(receita)
    }).then(resp => resp.text());
    console.log(data)
}

async function fetchReceitas(id) {
    let receitas = await fetch(`http://localhost:8000/src/api/receita/user?id=${id}`, {
        method: "GET",
    }).then(response => response);
    return receitas.json();
}


async function fetchReceita(id) {
    let receitas = await fetch(`http://localhost:8000/src/api/receita?id=${id}`, {
        method: "GET",
    }).then(response => response);
    return receitas.json();
}

async function removeReceita(meuId) {
    let data = await fetch("http://localhost:8000/src/api/receita", {
        method: "DELETE",
        body: JSON.stringify({
            id: meuId
        })
    }).then(resp => resp.text());
    window.location.reload();
}

async function carregarReceitas() {
    const tabela = document.querySelector('#receitaTable tbody');
    tabela.innerHTML = '';

    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        let id = parseInt(fromGet.get("id"));
        let dado = await fetchReceitas(id);
        dado.forEach((receita) => {
            const linha = `<tr>
            <td>${receita.category}</td>
            <td>${receita.title}</td>
            <td>${receita.ingredients}</td>
            <td>${receita.description}</td>
            <td>${receita.preparation_mode}</td>
            <td>${receita.user_id}</td>
            <td><button onclick="removePeca(${receita.id})">Deletar</button></td>
            <td><button onclick="window.location.href='/App-de-receitas/src/public/cadastroreceitas.html?id=${receita.id}'">Editar</button></td>

        </tr>`;
            tabela.innerHTML += linha;
        });
    }
}

carregarReceitas()

async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        let id = parseInt(fromGet.get("id"));
        let receitaData = await fetchReceita(id);
        document.getElementById('categoria').value = receitaData["category"]
        document.getElementById('titulo').value = receitaData["title"]
        document.getElementById('ingredientes').value = receitaData["ingredients"]
        document.getElementById('descricao').value = receitaData["description"]
        document.getElementById('modo_preparo').value = receitaData["preparation_mode"]
        document.getElementById('usuarioId').value = receitaData["user_id"]
        document.getElementById('usuarioId').style = "display:none";
    }
}

async function editReceita(id) {
    const receita = {
        id: id,
        category: document.getElementById('categoria').value,
        title: document.getElementById('titulo').value,
        ingredients: document.getElementById('ingredientes').value,
        description: document.getElementById('descricao').value,
        preparation_mode: document.getElementById('modo_preparo').value,
        user_id: document.getElementById('usuarioId').value,
    };
    let data = await fetch("http://localhost:8080/src/api/receita", {
        method: "PUT",
        body: JSON.stringify(peca)
    }).then(resp => resp.text());
    console.log(data);
}

function detectType() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        editReceita(fromGet.get("id"));
    } else {
        registraReceita();
    }
}