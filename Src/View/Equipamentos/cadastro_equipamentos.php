<div class="card-header">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cadastroEquipamentoModal">
        Cadastrar Equipamento
    </button>
</div>
<div class="input-group" style="display: flex; align-items: center;">
    <input type="text" id="pesquisaEquipamento" placeholder="Pesquisar Equipamento" class="form-control" style="width: 200px;">
    <button class="btn btn-danger" id="btnpesquisaEquipamento" style="margin-left: 5px;">Pesquisar</button>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Categoria</th>
            <th>Descrição</th>
            <th>Disponibilidade</th>
            <th>Motivo de Indisponibilidade</th>
            <th>Valor Diário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="tabelaEquipamentos">
        <!-- Resultados da pesquisa serão inseridos aqui -->
    </tbody>
</table>


<!-- Modal de Cadastro de Equipamento -->
<div class="modal fade" id="cadastroEquipamentoModal" tabindex="-1" role="dialog" aria-labelledby="cadastroEquipamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroEquipamentoModalLabel">Cadastro de Equipamento</h5>
                <button type="button" id="x_btn_fechar_modal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCadastroEquipamento">
                    <input type="hidden" id="equipamentoId"> <!-- ID do equipamento para edição -->
                    <div class="form-group">
                        <label for="categoria">Categoria do Equipamento</label>
                        <select name="categoria_id" class="form-control" id="categoria" required>
                            <option value="" disabled selected>Selecione a Categoria</option>
                            <!-- As categorias serão preenchidas dinamicamente -->
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="disponibilidade" id="disponibilidade" value="disponivel" checked>
                        <label for="disponibilidade">Disponível</label>
                    </div>

                    <div class="form-group">
                        <label for="motivo">Motivo da Indisponibilidade</label>
                        <textarea name="motivo" class="form-control" id="motivo" rows="3" placeholder="Descreva o motivo"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_fechar_modal" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarEquipamento">Salvar Equipamento</button>
            </div>
        </div>
    </div>
</div>

<script>
    let isEditingEquipamento = false;

    let checkbox = document.getElementById('disponibilidade');

    let inputPesquisaEquipamentoNome = document.getElementById('pesquisaEquipamento')

    document.getElementById("btnpesquisaEquipamento").addEventListener('click', function() {

        const nome = inputPesquisaEquipamentoNome.value; // Pega o valor digitado no campo de pesquisa

        buscarEquipamentosNomeCategoria(nome); // Passa o nome para a função de busca

    });
    inputPesquisaEquipamentoNome.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
   

            const nome = inputPesquisaEquipamentoNome.value; // Pega o valor digitado no campo de pesquisa

            buscarEquipamentosNomeCategoria(nome); // Passa o nome para a função de busca

        }

    });



    function buscarEquipamentosNomeCategoria(nomePesquisa) {

        enviarDados({
                'nome': nomePesquisa // Passa o valor de pesquisa para a requisição
            }, '/buscar_equipamentos_nome_categoria') // Rota que vai realizar a busca
            .then(response => {
                if (response.status === "sucesso" && Array.isArray(response.dadosRecebidos)) {
            

                    const tbody = document.querySelector('#tabelaEquipamentos');
                    tbody.innerHTML = '';

                    response.dadosRecebidos.forEach(equipamento => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${equipamento.id}</td>
                    <td>${equipamento.categoria_nome}</td>
                    <td>${equipamento.categoria_descricao}</td>
                    <td>${equipamento.disponibilidade == 0 ? 'Disponível' : 'Indisponível'}</td>
                    <td>${equipamento.motivo}</td>
                    <td>${equipamento.valor_diaria}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarEquipamento(${equipamento.id}, '${equipamento.categoria_id}', '${equipamento.disponibilidade}', '${equipamento.motivo}')">Editar</button>
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















    document.querySelectorAll('#btn_fechar_modal, #x_btn_fechar_modal').forEach(btn => {
        btn.addEventListener('click', fecharmodal);
    });

    function handleEquipamentoResponse(success, message) {
        alert(message);

        if (success) {
            fecharmodal();
        }
    }

    function fecharmodal() {
        const modal = document.getElementById('cadastroEquipamentoModal');
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
        document.getElementById('formCadastroEquipamento').reset();
        buscarEquipamentosNomeCategoria(inputPesquisaEquipamentoNome.value); // Atualiza a tabela
    }
    document.getElementById('salvarEquipamento').addEventListener('click', function() {
        const dados = {
            categoria_id: document.getElementById('categoria').value,
            disponibilidade: document.getElementById('disponibilidade').checked ? true : false,
            motivo: document.getElementById('motivo').value
        };

        const url = isEditingEquipamento ? '/edit_equipamento' : '/add_equipamento';
        if (isEditingEquipamento) dados.id = document.getElementById('equipamentoId').value;

        enviarDados(dados, url)
            .then(response => handleEquipamentoResponse(true, isEditingEquipamento ? 'Equipamento editado com sucesso!' : 'Equipamento salvo com sucesso!'))
            .catch(error => handleEquipamentoResponse(false, 'Erro ao salvar equipamento: ' + error.message));

        isEditingEquipamento = false;
    });

    function buscarEquipamentos(id) {
        enviarDados({
                'id': id
            }, '/buscar_equipamentos')
            .then(response => {
                if (response.status === "sucesso" && Array.isArray(response.dadosRecebidos)) {
                    const tbody = document.querySelector('#tabelaEquipamentos');

                    tbody.innerHTML = '';

                    response.dadosRecebidos.forEach(equipamento => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${equipamento.id}</td>
                        <td>${equipamento.categoria_nome}</td>
                        <td>${equipamento.categoria_descricao}</td>
                        <td>${equipamento.disponibilidade == 0? 'Disponível' : 'Indisponível'}</td>
                        <td>${equipamento.motivo}</td>
                        <td>${equipamento.valor_diaria}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editarEquipamento(${equipamento.id}, '${equipamento.categoria_id}', '${equipamento.disponibilidade}', '${equipamento.motivo}')">Editar</button>
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



    function editarEquipamento(id, categoria_id, disponibilidade, motivo) {
        isEditingEquipamento = true;
        document.getElementById('equipamentoId').value = id;
        document.getElementById('categoria').value = categoria_id;

        if (disponibilidade == 1) {
            checkbox.checked = false; // Desmarcar o checkbox
        } else {
            checkbox.checked = true; // Marcar o checkbox
        }


        document.getElementById('motivo').value = motivo;

        const modal = document.getElementById('cadastroEquipamentoModal');
        modal.classList.add('show');
        modal.style.display = 'block';
        document.body.classList.add('modal-open');
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }


    window.onload = function() {
        buscarEquipamentos('');
        carregarCategorias();
    };

    function carregarCategorias() {
        // Aqui você vai buscar as categorias via Ajax, ou pode preencher de forma estática se preferir.
        enviarDados({
                'nome': ''
            }, '/buscar_cat_equipamentos')
            .then(response => {
                if (response.status === "sucesso" && Array.isArray(response.dadosRecebidos)) {
                    const selectCategoria = document.getElementById('categoria');
                    response.dadosRecebidos.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nome;
                        selectCategoria.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao buscar categorias:', error);
            });
    }
</script>