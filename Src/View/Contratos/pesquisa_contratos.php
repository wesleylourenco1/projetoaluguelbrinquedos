<div class="p-3">
    <div class="mb-3">
        <a class="btn btn-primary" href="/gerar_contratos" target="_blank">Novo Contrato</a>
    </div>

    <!-- Formulário de Pesquisa -->
    <form id="form-pesquisa" action="#" method="GET">
        <!-- Tipo de Pesquisa -->
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="tipo-pesquisa" class="form-label">Pesquisar por</label>
                <select id="tipo-pesquisa" class="form-select">
                    <option value="data_entrega">Data de Retirada</option>
                    <option value="data_coleta">Data de Coleta</option>
                </select>
            </div>
        </div>

        <!-- Campos de Período e Botão de Pesquisa -->
        <div class="row mb-3 align-items-end">
            <div class="col-md-4">
                <label for="data-inicial" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="data-inicial" name="data_inicial">
            </div>
            <div class="col-md-4">
                <label for="data-final" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="data-final" name="data_final">
            </div>
            <div class="col-md-4">
                <button type="button" id="pesquisar-contratos" class="btn btn-success w-100">Pesquisar Contratos</button>
            </div>
        </div>
    </form>

    <!-- Formulário de Pesquisa por Cliente -->
    <form id="form-cliente" action="#" method="GET">
        <div class="row mb-3">
            <div class="col-md-8">
                <input type="text" class="form-control" id="pesquisa-cliente" placeholder="Pesquisar por Nome, CPF, Telefone, etc.">
            </div>
            <div class="col-md-4">
                <button type="button" id="pesquisar-cliente" class="btn btn-secondary w-100">Pesquisar Cliente</button>
            </div>
        </div>
    </form>

    <!-- Tabela de Resultados -->
    <table class="table table-bordered mt-4" id="tabela-resultados">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Cliente</th>
                <th>Data de Entrega</th>
                <th>Data de Coleta</th>
                <th>Valor</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            <!-- Resultados serão preenchidos dinamicamente -->
        </tbody>
    </table>
</div>

<script>
// Função para enviar dados
function consultarDados(dados, rota) {
    return fetch(rota, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => {
        // Verifica se a resposta foi bem-sucedida
        if (!response.ok) {
            return response.json().then(error => {
                // Se a resposta for um erro, lança um erro com a mensagem
                throw new Error(error.message || 'Erro desconhecido');
            });
        }
        // Caso a resposta seja bem-sucedida, retorna o JSON
        return response.json();
    })
    .catch(error => {
        // Aqui trata erros de rede ou outros erros inesperados
        console.error('Erro ao enviar dados:', error);
        throw new Error(error.message);
    });
}

// Função para formatar os dados e valores
function formatDataAndValue(data) {
    return data.map(item => {
        const { id, nome_cliente, data_entrega, data_coleta, vlr_total } = item;

        // Formata a data
        const formatarData = dataStr => {
            const [datePart, timePart] = dataStr.split(' ');
            const [year, month, day] = datePart.split('-');
            return `${day}/${month}/${year} ${timePart}`;
        };

        // Formata o valor para moeda brasileira
        const formatarValor = valor => {
            return `R$ ${parseFloat(valor).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`;
        };

        return {
            id,
            nome_cliente,
            data_entrega: formatarData(data_entrega),
            data_coleta: formatarData(data_coleta),
            vlr_total: formatarValor(vlr_total),
        };
    });
}

// Referências aos elementos
const tipoPesquisa = document.getElementById('tipo-pesquisa');
const dataInicial = document.getElementById('data-inicial');
const dataFinal = document.getElementById('data-final');
const btnPesquisarContratos = document.getElementById('pesquisar-contratos');
const pesquisaCliente = document.getElementById('pesquisa-cliente');
const btnPesquisarCliente = document.getElementById('pesquisar-cliente');
const tabelaResultados = document.getElementById('tabela-resultados').querySelector('tbody');
// Função para abrir detalhes do contrato em uma nova janela
function abrirDetalhesContrato(id) {
    // Cria um formulário invisível
    const form = document.createElement('form');
    form.action = '/detalhes_contrato'; // Substitua pela sua rota de detalhes do contrato
    form.method = 'POST';
    form.target = '_blank'; // Abre em uma nova janela

    // Cria um campo de input para o id do contrato
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'id_contrato'; // Nome do campo que será enviado
    input.value = id; // Atribui o id do contrato

    // Adiciona o campo de input ao formulário
    form.appendChild(input);

    // Submete o formulário, abrindo a nova janela
    document.body.appendChild(form);
    form.submit();
}

// Preencher tabela
function preencherTabela(dados) {
    tabelaResultados.innerHTML = ''; // Limpa a tabela antes de preencher
    const dadosFormatados = formatDataAndValue(dados); // Formata os dados

    if (dadosFormatados.length === 0) {
        alert('Nenhum registro encontrado');
        return;
    }

    dadosFormatados.forEach(dado => {
        const row = tabelaResultados.insertRow();
        row.innerHTML = `
            <td>${dado.id}</td>
            <td>${dado.nome_cliente}</td>
            <td>${dado.data_entrega}</td>
            <td>${dado.data_coleta}</td>
            <td>${dado.vlr_total}</td>
            <td>
                <button class='btn btn-info' onclick="abrirDetalhesContrato(${dado.id})">
                    <i class="fa fa-info-circle"></i>  Detalhes
                </button>
            </td>
        `;
    });
}


// Evento para pesquisar contratos
btnPesquisarContratos.addEventListener('click', () => {
    const dados = {
        tipo_pesquisa: tipoPesquisa.value,
        data_inicial: dataInicial.value,
        data_final: dataFinal.value
    };

    consultarDados(dados, '/get_contratos_data') // Substituir com a rota correta
        .then(response => {
            if (response.message && response.message !== 'Sucesso') {
                alert(response.message); // Exibe mensagem de erro caso a resposta não seja "Sucesso"
            } else {
                preencherTabela(response.data); // Acessa a data da resposta para preencher a tabela
            }
        })
        .catch(error => {
            
            alert(`Erro: ${error.message}`);
        });
});

// Evento para pesquisar clientes
btnPesquisarCliente.addEventListener('click', () => {
    const dados = {
        pesquisa: pesquisaCliente.value
    };

    consultarDados(dados, '/rota/clientes') // Substituir com a rota correta
        .then(response => {
            if (response.message && response.message !== 'Sucesso') {
                alert(response.message); // Exibe mensagem de erro caso a resposta não seja "Sucesso"
            } else {
                preencherTabela(response.data); // Acessa a data da resposta para preencher a tabela
            }
        })
        .catch(error => {

            alert(`Erro: ${error.message}`);
        });
});

</script>