<div class="card-header">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cadastroModal">
        Cadastrar Categoria
    </button>
    <input type="text" id="pesquisa" placeholder="Pesquisar categoria" class="form-control" style="width: 200px; display: inline-block; margin-left: 15px;">
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Categoria</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="tabelaEquipamentos">
        <!-- Resultados da pesquisa serão inseridos aqui -->
    </tbody>
</table>

<!-- Modal para cadastro/edição -->
<div class="modal fade" id="cadastroModal" tabindex="-1" role="dialog" aria-labelledby="cadastroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroModalLabel">Cadastro de Equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCadastroEquipamento">
                    <input type="hidden" id="equipamentoId"> <!-- ID do equipamento para edição -->
                    <div class="form-group">
                        <label for="nome">Nome / Categoria do equipamento</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Insira a categoria do equipamento" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição / medidas do equipamento</label>
                        <textarea name="descricao" class="form-control" id="descricao" rows="3" placeholder="Insira a descrição / medidas do equipamento" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="valor_diaria">Valor da Diária (R$)</label>
                        <input type="number" name="valor_diaria" class="form-control" id="valor_diaria" step="0.01" placeholder="Valor da diária" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarCategoria">Salvar Categoria</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variável para armazenar o ID do equipamento em edição
    let isEditing = false;

    function handleResponse(success, message) {
        alert(message);

        if (success) {
            const modal = document.getElementById('cadastroModal');
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.getElementById('formCadastroEquipamento').reset();
            buscarEquipamentos(''); // Atualiza a tabela
        }
    }

    document.getElementById('salvarCategoria').addEventListener('click', function() {
        const dados = {
            nome: document.getElementById('nome').value,
            descricao: document.getElementById('descricao').value,
            valor_diaria: parseFloat(document.getElementById('valor_diaria').value)
        };

        const url = isEditing ? '/edit_cat_equipamentos' : '/add_cat_equipamentos';
        if (isEditing) dados.id = document.getElementById('equipamentoId').value;

        enviarDados(dados, url)
            .then(response => handleResponse(true, isEditing ? 'Categoria editada com sucesso!' : 'Categoria salva com sucesso!'))
            .catch(error => handleResponse(false, 'Erro ao salvar categoria: ' + error.message));

        isEditing = false;
    });

    function buscarEquipamentos(nome) {
        enviarDados({ nome }, '/buscar_cat_equipamentos')
            .then(response => {
                if (response.status === "sucesso" && Array.isArray(response.dadosRecebidos)) {
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = '';

                    response.dadosRecebidos.forEach(equipamento => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${equipamento.id}</td>
                        <td>${equipamento.nome}</td>
                        <td>${equipamento.descricao}</td>
                        <td>R$ ${parseFloat(equipamento.valor_diaria).toFixed(2)}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editarEquipamento(${equipamento.id}, '${equipamento.nome}', '${equipamento.descricao}', ${equipamento.valor_diaria})">Editar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    `;
                        tbody.appendChild(row);
                    });
                } else {
                    console.error('Erro ao buscar equipamentos: resposta inesperada', response);
                    alert('Erro ao buscar equipamentos.');
                }
            })
            .catch(error => {
                console.error('Erro ao buscar equipamentos:', error);
                alert('Erro ao buscar equipamentos: ' + error.message);
            });
    }

    function editarEquipamento(id, nome, descricao, valor_diaria) {
        isEditing = true;
        document.getElementById('equipamentoId').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.getElementById('valor_diaria').value = valor_diaria;
        
        const modal = document.getElementById('cadastroModal');
        modal.classList.add('show');
        modal.style.display = 'block';
        document.body.classList.add('modal-open');
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }

    document.getElementById('pesquisa').addEventListener('input', function() {
        const nome = this.value;
        buscarEquipamentos(nome);
    });

    window.onload = function() {
        buscarEquipamentos('');
    };
</script>
