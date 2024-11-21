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

async function fetchReceitas() {
    try {
        const response = await fetch("http://localhost:8000/src/api/receita", {
            method: "GET", 
        });

        if (!response.ok) {
            console.error(`Erro na API. Status: ${response.status}`);
            return [];  
        }

        const data = await response.json();
        console.log("Dados recebidos da API:", data);
        return data;
    } catch (error) {
        console.error("Erro ao buscar receitas:", error);
        return [];  
    }
}

async function carregarReceitas() {
    const tabela = document.querySelector('#receitaTable tbody');
    tabela.innerHTML = '';  

    let receitas = await fetchReceitas();

    console.log("Dados recebidos de fetchReceitas:", receitas);

    if (receitas && Array.isArray(receitas) && receitas.length > 0) {
        receitas.forEach((receita) => {
            const linha = `
                <tr>
                    <td>${receita.category}</td>
                    <td>${receita.title}</td>
                    <td>${receita.ingredients}</td>
                    <td>${receita.description}</td>
                    <td>${receita.preparation_mode}</td>
                    <td>${receita.user_id}</td>
                    <td><button onclick="removeReceita(${receita.id})">Deletar</button></td>
                    <td><button onclick="window.location.href='cadastroreceitas.html?id=${receita.id}'">Editar</button></td>
                </tr>`;
            tabela.innerHTML += linha;
        });
    } else {
        tabela.innerHTML = '<tr><td colspan="7">Nenhuma receita encontrada.</td></tr>';
    }
}

document.addEventListener('DOMContentLoaded', carregarReceitas);

async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.has("id")) {
        let id = parseInt(fromGet.get("id"));
        try {
            let receitaData = await fetchReceita(id);
            document.getElementById('categoria').value = receitaData["category"];
            document.getElementById('titulo').value = receitaData["title"];
            document.getElementById('ingredientes').value = receitaData["ingredients"];
            document.getElementById('descricao').value = receitaData["description"];
            document.getElementById('modo_preparo').value = receitaData["preparation_mode"];
            document.getElementById('usuarioId').value = receitaData["user_id"];
        } catch (error) {
            console.error("Erro ao carregar receita para edição:", error);
        }
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
    try{
        const response = await fetch("http://localhost:8000/src/api/receita", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(receita),
        });

        if (!response.ok) {
            console.error(`Erro na API. Status: ${response.status}`);
            console.log(await response.text()); // Detalhes do erro
        } else {
            console.log("Receita atualizada com sucesso.");
            alert("Receita editada com sucesso!");
            window.location.href = "crud_receitas.html"; // Redirecionar para a lista
        }
        } catch (error) {
            console.error("Erro ao tentar editar receita:", error);
        }
        
}
    

function detectType() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        editReceita(fromGet.get("id"));
    } else {
        registraReceita();
    }
}