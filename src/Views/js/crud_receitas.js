$(document).ready(function() {
    let receitas = [];
    let receitaAtual = null; 

    $('#form-receita').on('submit', function(e) {
        e.preventDefault();
        
        const receita = {
            id: receitaAtual ? receitaAtual.id : new Date().getTime(),
            titulo: $('#titulo').val(),
            categoria: $('#editar-categoria').val() === 'Outros' ? $('#categoria-personalizada').val() : $('#editar-categoria').val(),
            ingredientes: $('#ingredientes').val(),
            descricao: $('#descricao').val(),
            modo_preparo: $('#modo_preparo').val(),
            foto: $('#foto')[0].files[0] 
        };

        if (receitaAtual) {
            atualizarReceita(receita);
        } else {
            adicionarReceita(receita);
        }

        $('#form-receita')[0].reset();
        $('#categoria-personalizada').hide();
        receitaAtual = null;
    });

    // Função para adicionar uma nova receita
    function adicionarReceita(receita) {
        receitas.push(receita);
        exibirReceitas();
    }

    // Função para atualizar uma receita existente
    function atualizarReceita(receita) {
        receitas = receitas.map(r => r.id === receita.id ? receita : r);
        exibirReceitas();
    }

    // Função para excluir uma receita
    function excluirReceita(id) {
        receitas = receitas.filter(r => r.id !== id);
        exibirReceitas();
    }

    // Função para exibir receitas na tabela
    function exibirReceitas() {
        $('#receitas-list').empty();

        receitas.forEach(receita => {
            const fileUrl = receita.foto ? URL.createObjectURL(receita.foto) : '';
            const receitaRow = `
                <tr>
                    <td>${receita.id}</td>
                    <td>${receita.titulo}</td>
                    <td>${receita.categoria}</td>
                    <td>${receita.ingredientes}</td>
                    <td>${receita.descricao}</td>
                    <td>${receita.modo_preparo}</td>
                    <td>${fileUrl ? `<img src="${fileUrl}" alt="Imagem da receita" width="100">` : 'Sem imagem'}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarReceita(${receita.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="excluirReceita(${receita.id})">Excluir</button>
                    </td>
                </tr>
            `;
            $('#receitas-list').append(receitaRow);
        });
    }

    // Função para carregar uma receita no formulário para edição
    window.editarReceita = function(id) {
        receitaAtual = receitas.find(r => r.id === id);
        if (receitaAtual) {
            $('#titulo').val(receitaAtual.titulo);
            $('#editar-categoria').val(receitaAtual.categoria);
            if (receitaAtual.categoria === 'Outros') {
                $('#categoria-personalizada').val(receitaAtual.categoria);
                $('#categoria-personalizada').show();
            } else {
                $('#categoria-personalizada').hide();
            }
            $('#ingredientes').val(receitaAtual.ingredientes);
            $('#descricao').val(receitaAtual.descricao);
            $('#modo_preparo').val(receitaAtual.modo_preparo);
        }
    };

    // Função para excluir uma receita (chamada ao clicar em "Excluir")
    window.excluirReceita = function(id) {
        if (confirm('Tem certeza que deseja excluir esta receita?')) {
            excluirReceita(id);
        }
    };
});
