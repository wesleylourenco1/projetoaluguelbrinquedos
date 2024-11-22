<div class="card">
    <div class="card-body">
        <!-- Botão para abrir o Modal de Pesquisa de Cliente -->
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <div class="input-group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCliente">Pesquisar Cliente</button>
                <button type="button" class="btn btn-secondary" id="exibir-cliente">Exibir Cliente</button>
            </div>
        </div>

        <!-- Exibição dos dados do cliente -->
        <div id="dados-cliente">
            <label class="form-label">Dados do Cliente</label>
            <div id="dados-pessoais">
                <p><strong>Nome:</strong> <span id="nome-cliente"></span></p>
                <p><strong>Tipo de Cliente:</strong> <span id="tipo-cliente">Selecione</span></p>
                <p><strong>Situação:</strong> <span id="situacao-cliente">Ativo</span></p>
                <p><strong>E-mail:</strong> <span id="email-cliente"></span></p>
                <p><strong>CPF:</strong> <span id="cpf-cliente"></span></p>
                <p><strong>Nome Social:</strong> <span id="nome-social-cliente"></span></p>
                <p><strong>RG:</strong> <span id="rg-cliente"></span></p>
                <p><strong>Data de Nascimento:</strong> <span id="nascimento-cliente"></span></p>
            </div>
        </div>

        <!-- Seleção de Endereço -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="endereco" class="form-label">Endereço</label>
                <select class="form-select" id="endereco" name="endereco">
                    <option value="">Selecione o Endereço</option>
                    <!-- Aqui vão as opções de endereços carregadas do sistema -->
                </select>
            </div>
        </div>

        <!-- Campos de Data/Hora de Entrega e Coleta -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="data-entrega" class="form-label">Data/Hora de Entrega</label>
                <input type="datetime-local" class="form-control" id="data-entrega" name="data-entrega">
            </div>
            <div class="col-md-6">
                <label for="data-coleta" class="form-label">Data/Hora de Coleta</label>
                <input type="datetime-local" class="form-control" id="data-coleta" name="data-coleta">
            </div>
        </div>


        <!-- Adicionar Brinquedos -->
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="brinquedos" class="form-label">Brinquedos</label>
                <div class="input-group">
                    <button type="button" class="btn btn-primary w-100" id="adicionar-brinquedo" data-bs-toggle="modal" data-bs-target="#modalEquipamentos" disabled>Adicionar</button>
                </div>
            </div>
        </div>

        <!-- Lista de Brinquedos Adicionados -->
        <!-- Tabela para exibir os brinquedos selecionados -->
        <!-- Tabela para exibir os brinquedos selecionados -->
        <div class="table-responsive">
            <table class="table table-bordered" id="tabela-brinquedos">
                <thead>
                    <tr>
                        <th>Brinquedo</th>
                        <th>Valor Período</th>
                        <th>Valor Total</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Brinquedos serão adicionados aqui dinamicamente -->
                </tbody>
            </table>
        </div>
        <!-- Total e Desconto -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="total" class="form-label">Sub-Total</label>
                <input type="number" step="0.01" class="form-control" id="input-sub-total" name="total" readonly>
            </div>
            <div class="col-md-6">
                <label for="desconto" class="form-label">Desconto</label>
                <input type="number" step="0.01" class="form-control" id="desconto" name="desconto">
            </div>
        </div>
        <div class="row">
            <div class="col-6 d-flex justify-content-end">
                <h1>TOTAL</h1>
            </div>
            <div class="col-6">
                <input type="number" step="0.01" style="padding:15px;  height: 50px; font-size:18px; font-weight:bold;" class="form-control" id="input-valor-total" name="valorTotal" readonly>

            </div>
        </div>


        <!-- Botão Gerar Contrato -->
        <div class="mb-3">
            <button type="submit" id='btnGerarPedido' class="btn btn-success w-100">Gerar Contrato</button>
        </div>
    </div>
</div>

<!-- Modal de Pesquisa de Clientes -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClienteLabel">Pesquisar Cliente</h5>
                <button type="button" id='fechar-modal-cliente' class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="pesquisa-cliente" class="form-label">Pesquisar por Nome, CPF ou Telefone</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="pesquisa-cliente" placeholder="Digite o nome, CPF ou telefone">
                        <button type="button" class="btn btn-primary" id="btn-pesquisar">Pesquisar</button>
                    </div>
                </div>

                <!-- Lista de Clientes Encontrados -->
                <ul class="list-group" id="clientes-lista">
                    <!-- A lista de clientes será carregada dinamicamente com base na pesquisa -->
                </ul>
            </div>
            <div class="modal-footer">
                <a href="/clientes" target="_blank" class="btn btn-secondary">Novo Cliente</a>
                <button type="button" class="btn btn-secondary" id="fechar-modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="selecionar-cliente">Selecionar Cliente</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Pesquisa de Equipamentos -->
<div class="modal fade" id="modalEquipamentos" tabindex="-1" aria-labelledby="modalEquipamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEquipamentosLabel">Pesquisar Equipamentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nome-equipamento" class="form-label">Pesquisar por Nome</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nome-equipamento" name="nome" placeholder="Digite o nome do equipamento">
                        <button type="button" class="btn btn-primary" id="btn-pesquisar-equipamentos">Pesquisar</button>
                    </div>
                </div>

                <!-- Tabela de Resultados -->
                <table class="table table-bordered mt-3">
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
                    <tbody id="tabela-resultados">
                        <!-- Os resultados serão preenchidos aqui dinamicamente -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let fecharModalCliente = document.getElementById("fechar-modal-cliente");
        let btnPesquisar = document.getElementById('btn-pesquisar');
        let pesquisaCliente = document.getElementById('pesquisa-cliente');
        let listaClientes = document.getElementById('clientes-lista');
        let resposta = {};
        let dadosclientes = null;
        let idclienteativo = null;
        let dias = 0;
        let tabelaBrinquedosBody = document.querySelector('#tabela-brinquedos tbody');
        let exibirCliente = document.getElementById('exibir-cliente');
        let inputSubTotal = document.getElementById('input-sub-total');
        let inputDesconto = document.getElementById('desconto');
        let btnGerarPedido = document.getElementById('btnGerarPedido');
        let iptValorTotalPedido = document.getElementById('input-valor-total')
        inputDesconto.addEventListener('input', () => {
            calculaValorTotal();

        });

        function calculaValorTotal() {
            if (Number(inputDesconto.value) >= 0) {
                if (Number(inputSubTotal.value) > 0 & (Number(inputSubTotal.value) > Number(inputDesconto.value))) {
                    preencheInputValorTotal(Number(inputSubTotal.value) - Number(inputDesconto.value))
                } else {

                    preencheInputValorTotal(0);

                }
            } else {
                preencheInputValorTotal(inputSubTotal.value)
            }

        }

        function preencheInputValorTotal(valor) {

            document.getElementById('input-valor-total').value = parseFloat(Number(valor).toFixed(2));
        }
        exibirCliente.addEventListener('click', () => {
            verDadosCompletosCliente(idclienteativo);
        });




        const btnPesquisarEquipamentos = document.getElementById('btn-pesquisar-equipamentos');
        const nomeEquipamentoInput = document.getElementById('nome-equipamento');
        const tabelaResultados = document.getElementById('tabela-resultados');

        // Array para armazenar equipamentos selecionados
        let equipamentosSelecionados = [];

        // Função para buscar equipamentos
        btnPesquisarEquipamentos.addEventListener('click', function() {
            const nome = nomeEquipamentoInput.value;
            if (!nome) {
                alert("Por favor, insira o nome do equipamento.");
                return;
            }

            fetch('/buscar_equipamentos_nome_categoria', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nome
                    })
                })
                .then(response => response.json())
                .then(data => preencherTabelaResultados(data))
                .catch(error => console.error('Erro ao buscar equipamentos:', error));
        });

        // Função para preencher a tabela com os resultados da pesquisa
        function preencherTabelaResultados(data) {
            tabelaResultados.innerHTML = ''; // Limpa os resultados anteriores

            if (data.status === "sucesso" && data.dadosRecebidos.length > 0) {
                data.dadosRecebidos.forEach(equipamento => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${equipamento.id}</td>
                    <td>${equipamento.categoria_nome}</td>
                    <td>${equipamento.categoria_descricao || 'N/A'}</td>
                    <td>${equipamento.disponibilidade === 0 ? 'Disponível' : 'Indisponível'}</td>
                    <td>${equipamento.motivo || ''}</td>
                    <td>${equipamento.valor_diaria || 'N/A'}</td>
                    <td><button class="btn btn-primary btn-selecionar" data-id="${equipamento.id}">Selecionar</button></td>
                `;

                    tabelaResultados.appendChild(tr);
                });

                // Adiciona evento de clique para cada botão de "Selecionar"
                document.querySelectorAll('.btn-selecionar').forEach(button => {
                    button.addEventListener('click', function() {
                        const idEquipamento = this.getAttribute('data-id');
                        selecionarEquipamento(idEquipamento);
                        preencherTabelaBrinquedos();
                    });
                });
            } else {
                tabelaResultados.innerHTML = '<tr><td colspan="7">Nenhum equipamento encontrado</td></tr>';
            }
        }

        // Função para selecionar um equipamento e adicionar à lista
        function selecionarEquipamento(id) {
            const equipamento = Array.from(tabelaResultados.querySelectorAll('tr')).find(tr => tr.querySelector('.btn-selecionar').getAttribute('data-id') === id);

            if (equipamento) {
                const equipamentoSelecionado = {
                    id: equipamento.children[0].textContent,
                    categoria: equipamento.children[1].textContent,
                    descricao: equipamento.children[2].textContent,
                    disponibilidade: equipamento.children[3].textContent,
                    motivo: equipamento.children[4].textContent,
                    valorDiario: equipamento.children[5].textContent
                };

                // Adiciona o equipamento selecionado ao array, se ainda não estiver nele
                if (!equipamentosSelecionados.some(eq => eq.id === equipamentoSelecionado.id)) {
                    equipamentosSelecionados.push(equipamentoSelecionado);

                } else {
                    alert("Este equipamento já foi selecionado.");
                }
            }
        }



        // Função de pesquisa
        btnPesquisar.addEventListener('click', function(e) {
            e.preventDefault();
            const dados = {
                nome: pesquisaCliente.value
            };
            pesquisarClientes(dados);
        });

        // Função de pesquisa de clientes
        function pesquisarClientes(dados) {
            const rota = '/pesquisa_clientes';

            enviarDados(rota, dados, function(erro, resposta) {
                if (erro) {
                    console.error('Erro na pesquisa de clientes:', erro);
                    return;
                }
                processarRespostaPesquisa(resposta);
            });
        }

        // Enviar os dados via fetch
        function enviarDados(rota, dados, callback) {
            fetch(rota, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro na requisição');

                    return response.json();
                })
                .then(data => callback(null, data))
                .catch(error => callback(error, null));
        }

        // Processar a resposta da pesquisa de clientes
        function processarRespostaPesquisa(resposta) {
            if (resposta.status === "sucesso" && resposta.dadosRecebidos.length > 0) {
                dadosclientes = resposta.dadosRecebidos;
                listaClientes.innerHTML = '';
                resposta.dadosRecebidos.forEach(dado => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.innerHTML = `
                    <button class="btn btn-sm btn-primary float-start" onclick="selecionarCliente(${dado.id})">Selecionar</button>
                    ${dado.nome} - ${dado.pf_cpf || ''} - ${formatarData(dado.pf_data_nascimento)}
                    `;
                    listaClientes.appendChild(li);
                });
            } else {
                listaClientes.innerHTML = '<li class="list-group-item">Nenhum cliente encontrado</li>';
            }
        }

        // Função para formatar a data de nascimento
        function formatarData(data) {
            const d = new Date(data);
            return `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
        }

        // Função para selecionar um cliente
        window.selecionarCliente = function(idCliente) {
            // Encontrar o cliente na lista de dados recebidos

            const clienteSelecionado = dadosclientes.find(cliente => cliente.id === idCliente);

            if (clienteSelecionado) {
                // Preencher os campos com os dados do cliente
                document.getElementById('tipo-cliente').textContent = clienteSelecionado.tipo_pessoa === "PF" ? "Pessoa Física" : "Pessoa Jurídica";
                document.getElementById('situacao-cliente').textContent = clienteSelecionado.situacao === 1 ? "Ativo" : "Inativo";
                document.getElementById('nome-cliente').textContent = clienteSelecionado.nome;
                document.getElementById('email-cliente').textContent = clienteSelecionado.email;
                document.getElementById('cpf-cliente').textContent = clienteSelecionado.pf_cpf;
                document.getElementById('nome-social-cliente').textContent = clienteSelecionado.pf_nome_social;
                document.getElementById('rg-cliente').textContent = clienteSelecionado.pf_rg;
                document.getElementById('nascimento-cliente').textContent = formatarData(clienteSelecionado.pf_data_nascimento);

                idclienteativo = idCliente

                pesquisarEnderecos();

            }

            // Fechar o modal após a seleção
            fecharModalCliente.click();
        };

        function verDadosCompletosCliente(id) {
            // Criar um formulário dinâmico

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dados_cliente'; // Substitua com a URL para onde deseja enviar os dados

            // Criar o campo de input com o clienteId
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'clienteId';
            input.value = id;

            // Adicionar o campo ao formulário
            form.appendChild(input);

            // Abrir a nova aba
            var novaJanela = window.open('', '_blank');

            // Adicionar o formulário à nova janela
            novaJanela.document.body.appendChild(form);

            form.submit();
        }

        function pesquisarEnderecos() {
            const dados = {
                cliente_id: idclienteativo
            }; // O campo obrigatório cliente_id

            // Envia os dados e lida com a resposta
            enviarDados('/get_endereco_cliente_id', dados, function(error, data) {
                if (error) {
                    console.error("Erro ao pesquisar endereços:", error);
                    return;
                }

                if (data.error) {
                    console.log("Nenhum endereço encontrado:", data.error);
                    // Caso não haja endereços, podemos limpar o select e mostrar uma mensagem
                    limparSelectEnderecos();
                } else {
                    console.log("Endereços encontrados:", data);
                    // Preenche o select com os endereços retornados
                    preencherEnderecos(data);
                }
            });
        }

        // Função para limpar as opções do select (caso não haja endereços)
        function limparSelectEnderecos() {
            const selectEndereco = document.getElementById("endereco");
            selectEndereco.innerHTML = '<option value="">Nenhum endereço encontrado</option>';
        }

        // Função para preencher o select com as opções de endereços
        function preencherEnderecos(enderecos) {
            const selectEndereco = document.getElementById("endereco");

            // Limpando as opções anteriores (se houver)
            selectEndereco.innerHTML = '<option value="">Selecione o Endereço</option>';

            // Iterando sobre os endereços e criando as opções
            enderecos.forEach(endereco => {
                const option = document.createElement("option");
                option.value = endereco.id;
                option.textContent = `${endereco.logradouro}, ${endereco.numero} - ${endereco.bairro}, ${endereco.cidade} - ${endereco.uf}`;
                selectEndereco.appendChild(option);
            });
        }


        // Função para formatar a data de nascimento
        function formatarData(data) {
            const d = new Date(data);
            return `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
        }


        // Lógica para ativar/desativar a pesquisa de brinquedos
        const dataEntrega = document.getElementById('data-entrega');
        const dataColeta = document.getElementById('data-coleta');
        const adicionarBrinquedo = document.getElementById('adicionar-brinquedo');

        // Função para bloquear/desbloquear a pesquisa de brinquedos
        function verificarDatas() {
            preencherTabelaBrinquedos();
            if (dataEntrega.value && dataColeta.value) {
                adicionarBrinquedo.disabled = false;

            } else {
                adicionarBrinquedo.disabled = true;
            }

        }

        // Verificar as datas quando elas forem alteradas
        dataEntrega.addEventListener('change', verificarDatas);
        dataColeta.addEventListener('change', verificarDatas);

        // Inicializar a verificação
        verificarDatas();


        // Array para armazenar equipamentos selecionados
        // Função para preencher a tabela de brinquedos selecionados
        function preencherTabelaBrinquedos() {
            tabelaBrinquedosBody.innerHTML = ''; // Limpa a tabela
            valorTotalPedido = 0;


            // Itera sobre os equipamentos selecionados e adiciona cada um na tabela
            equipamentosSelecionados.forEach((equipamento) => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
            <td>${equipamento.categoria}</td>
            <td>${formatarValorMonetario(equipamento.valorDiario)}</td>
            <td>${formatarValorMonetario(calcularValorTotal(equipamento.valorDiario))}</td>
            <td><button class="btn btn-danger btn-remover" data-id="${equipamento.id}">Remover</button></td>
        `;

                valorTotalPedido += calcularValorTotal(equipamento.valorDiario);
                tabelaBrinquedosBody.appendChild(tr);
            });

            exibeValorTotalPedido();

            // Função para exibir o valor total do pedido
            function exibeValorTotalPedido() {

                inputSubTotal.value = parseFloat(valorTotalPedido).toFixed(2);
                calculaValorTotal();
            }

            // Adiciona evento de clique para cada botão de "Remover"
            document.querySelectorAll('.btn-remover').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    removerEquipamentoPorId(id);
                    preencherTabelaBrinquedos(); // Recarrega a tabela após a remoção
                });
            });
        }



        function removerEquipamentoPorId(id) {
            equipamentosSelecionados = equipamentosSelecionados.filter(equipamento => equipamento.id !== id);
            preencherTabelaBrinquedos();
            calculaValorTotal();

        }

        // Exemplo de uso
        removerEquipamentoPorId("3"); // Isso removerá o objeto com id "3"

        function formatarValorMonetario(valor) {
            // Converte para número caso o valor seja uma string
            const numero = parseFloat(valor);

            // Verifica se a conversão foi bem-sucedida
            if (isNaN(numero)) {
                return "Valor inválido";
            }

            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(numero);
        }


        function calcularValorTotal(valorDiario) {

            dias = calcularDiferencaDias();
            let valorNumerico = Number(parseFloat(valorDiario));
            return parseFloat(dias * valorNumerico);
        }
        // Função para calcular a diferença em dias entre as datas
        function calcularDiferencaDias() {
            const dataEntrega = document.getElementById('data-entrega').value;
            const dataColeta = document.getElementById('data-coleta').value;

            if (dataEntrega && dataColeta) {
                const dataInicio = new Date(dataEntrega);
                const dataFim = new Date(dataColeta);

                // Calcula a diferença em milissegundos e converte para dias
                const diferencaMilissegundos = dataFim - dataInicio;
                let diferencaDias = diferencaMilissegundos / (1000 * 60 * 60 * 24);

                // Arredonda para cima
                diferencaDias = Math.ceil(diferencaDias);

                // Se a diferença for menor que 1, define como 1
                if (diferencaDias < 1) {
                    diferencaDias = 1;
                }


                return diferencaDias;
                // Exibe a diferença no console
            }
        }

        btnGerarPedido.addEventListener('click', (e) => {
            e.preventDefault();
            salvaPedido()
        });

        function salvaPedido() {
            function adicionarValorTotal(equipamentos) {
                return equipamentos.map(equipamento => {
                    // Calcula o vlr_total multiplicando o valorDiario pelo multiplicador
                    const vlr_total = parseFloat(equipamento.valorDiario) * dias;

                    // Retorna o novo objeto com a propriedade vlr_total
                    return {
                        ...equipamento, // Mantém as propriedades originais
                        vlr_total: vlr_total.toFixed(2) // Adiciona a nova propriedade vlr_total com 2 casas decimais
                    };
                });
            }

            // Verificação dos dados
            let camposIncompletos = [];

            // Validação dos campos necessários
            if (!idclienteativo) camposIncompletos.push('ID Cliente');
            if (!inputSubTotal.value) camposIncompletos.push('SubTotal');
            if (!iptValorTotalPedido.value) camposIncompletos.push('Valor Total');
            if (!dias) camposIncompletos.push('Dias');
            if (!document.getElementById('endereco').value) camposIncompletos.push('Endereço');
            if (!dataEntrega.value) camposIncompletos.push('Data de Entrega');
            if (!dataColeta.value) camposIncompletos.push('Data de Coleta');
            if (equipamentosSelecionados.length === 0) camposIncompletos.push('Equipamentos');

            // Se algum campo estiver incompleto, exibe a mensagem de erro
            if (camposIncompletos.length > 0) {
                const camposFaltando = camposIncompletos.join(', ');
                alert(`Os seguintes campos estão incompletos: ${camposFaltando}`);
                return; // Interrompe a execução da função
            }

            // Se todos os dados estiverem completos, monta o objeto de dados
            let dadosContrato = {
                'idcliente': idclienteativo,
                'subTotal': inputSubTotal.value,
                'desconto': inputDesconto.value,
                'total': iptValorTotalPedido.value,
                'dias': dias,
                'id_endereco': document.getElementById('endereco').value,
                "produtos": adicionarValorTotal(equipamentosSelecionados),
                'data_entrega': dataEntrega.value,
                'data_coleta': dataColeta.value
            };



            // Enviar os dados via fetch
            fetch('/salva_contrato', {
                    method: 'POST', // Método POST
                    headers: {
                        'Content-Type': 'application/json', // Defina o tipo de conteúdo como JSON
                    },
                    body: JSON.stringify(dadosContrato) // Converte os dados em string JSON para envio
                })
                .then(response => response.json()) // Retorna a resposta em formato JSON
                .then(data => {
                    console.log('Resposta do servidor:', data); // Exibe a resposta do servidor
                })
                .catch((error) => {
                    console.error('Erro ao enviar os dados:', error); // Exibe erro em caso de falha
                });

        }

        // Adiciona eventos de mudança para recalcular a diferença quando uma data é alterada
        document.getElementById('data-entrega').addEventListener('change', calcularDiferencaDias);
        document.getElementById('data-coleta').addEventListener('change', calcularDiferencaDias);

    });
</script>