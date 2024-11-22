<!--  Essa View cadastra/ pesquisa o cliente e permite que insira os dados de endereço e contatos  -->



<div class="container">

    <div class="card">
        <div class="card-header">


        </div>
        <div class="input-group 2-5 mb-3 mt-3" style="max-width: 80%;">
            <!-- Botão para abrir o modal -->
            <button type="button" class="btn btn-primary ml-3 mr-3" data-toggle="modal" data-target="#modalCadastroCliente">
                <i class="fas fa-user-plus"></i>
            </button>
            <input type="text" class="form-control" id="ipt_search_cliente" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="button-pesquisar">
            <button class="btn btn-primary" type="button" id="btn_search_cliente">Pesquisar</button>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-corpo">

                <!-- Adicione mais registros de clientes conforme necessário -->
            </tbody>
        </table>

    </div>



    <!-- Modal -->
    <div class="modal fade" id="modalCadastroCliente" tabindex="-1" role="dialog" aria-labelledby="modalCadastroClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="formCadastroCliente">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row" id="forCadCliente">
                                    <div class="form-group col-sm-3">
                                        <label for="ClienteTipoPessoa">Tipo de cliente</label>
                                        <select id="ClienteTipoPessoa" name="data.Cliente.tipo_pessoa" class="custom-select">
                                            <option value="">Selecione</option>
                                            <option value="PF">Pessoa física</option>
                                            <option value="PJ">Pessoa jurídica</option>
                                            <option value="ES">Estrangeiro</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="situacao">Situação</label>
                                        <select name="data.Cliente.situacao" class="custom-select" id="situacao">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="ClienteNome">Nome</label>
                                        <input id="ClienteNome" name="data.Cliente.nome" type="text" class="form-control" maxlength="100">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="ClienteEmail">E-mail</label>
                                        <input id="ClienteEmail" name="data.Cliente.email" type="email" class="form-control" maxlength="60">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="pf_cpf">CPF</label>
                                        <input name="data.Cliente.pf_cpf" type="text" class="form-control" maxlength="14" id="pf_cpf">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="pf_nome_social">Nome social</label>
                                        <input name="data.Cliente.pf_nome_social" type="text" class="form-control" maxlength="60" id="pf_nome_social">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="pf_rg">RG</label>
                                        <input name="data.Cliente.pf_rg" type="text" class="form-control" maxlength="18" id="pf_rg">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="pf_data_nascimento">Nascimento</label>
                                        <input name="data.Cliente.pf_data_nascimento" type="date" class="form-control" id="pf_data_nascimento">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mr-2"><i class="glyphicon glyphicon-ok"></i> Cadastrar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Cadastro de Cliente -->
<div class="modal fade" id="cadastroClienteModal" tabindex="-1" role="dialog" aria-labelledby="cadastroClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroClienteModalLabel">Cadastro de Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="processar_cadastro_cliente.php" method="POST">
                    <div class="form-group">
                        <label for="nome_completo">Nome Completo</label>
                        <input type="text" name="nome_completo" class="form-control" id="nome_completo" placeholder="Insira o nome completo" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Insira o CPF" required>
                    </div>

                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control" id="data_nascimento" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Cliente</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cadastro de Dados Pessoais -->
<div class="modal fade" id="cadastroDadosPessoaisModal" tabindex="-1" role="dialog" aria-labelledby="cadastroDadosPessoaisModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroDadosPessoaisModalLabel">Cadastro de Dados Pessoais</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="processar_cadastro_dados_pessoais.php" method="POST">
                    <div class="form-group">
                        <label for="cliente_id_dados">Cliente</label>
                        <select name="id_cliente" class="form-control" id="cliente_id_dados" required>
                            <option value="" disabled selected>Selecione o Cliente</option>
                            <option value="1">João da Silva</option>
                            <!-- Adicione mais opções de cliente conforme necessário -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rg">RG</label>
                        <input type="text" name="rg" class="form-control" id="rg" placeholder="Insira o RG">
                    </div>

                    <div class="form-group">
                        <label for="profissao">Profissão</label>
                        <input type="text" name="profissao" class="form-control" id="profissao" placeholder="Insira a profissão">
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Dados Pessoais</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cadastro de Contatos -->
<div class="modal fade" id="cadastroContatosModal" tabindex="-1" role="dialog" aria-labelledby="cadastroContatosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroContatosModalLabel">Cadastro de Contatos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCadastroContato" method="POST">
                    <div class="form-group">
                        <label for="cliente_id_contatos">Cliente</label>
                        <select name="id_cliente" class="form-control" id="cliente_id_contatos" required>
                            <option value="" disabled selected>Selecione o Cliente</option>
                            <!-- O JavaScript preencherá a opção do cliente selecionado aqui -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Insira o telefone">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Contato</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cadastro de Endereço -->
<div class="modal fade" id="cadastroEnderecoModal" tabindex="-1" role="dialog" aria-labelledby="cadastroEnderecoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroEnderecoModalLabel">Cadastro de Endereço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCadastroEndereco" onsubmit="salvarEndereco(event)">
                    <div class="form-group">
                        <label for="cliente_id_endereco">Cliente</label>
                        <select name="id_cliente" class="form-control" id="cliente_id_endereco" required>
                            <option value="" disabled selected>Selecione o Cliente</option>
                            <option value="1">João da Silva</option>
                            <!-- Adicione mais opções de cliente conforme necessário -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" name="cep" class="form-control" id="cep" placeholder="Insira o CEP" required>
                    </div>

                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" name="logradouro" class="form-control" id="logradouro" placeholder="Insira o logradouro" required>
                    </div>

                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" class="form-control" id="numero" placeholder="Insira o número" required>
                    </div>

                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" class="form-control" id="complemento" placeholder="Insira o complemento">
                    </div>

                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Insira o bairro" required>
                    </div>

                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Insira a cidade" required>
                    </div>

                    <div class="form-group">
                        <label for="uf">Estado (UF)</label>
                        <input type="text" name="uf" class="form-control" id="uf" placeholder="Insira o estado (UF)" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Endereço</button>
                </form>
            </div>
        </div>
    </div>
</div>



</div>

<script>
    let btn_search_cliente = document.getElementById('btn_search_cliente');
    let ipt_search_cliente = document.getElementById('ipt_search_cliente');
    btn_search_cliente.addEventListener('click', (e) => {
        e.preventDefault();


        const rota = '/pesquisa_clientes';

        const dados = {
            nome: ipt_search_cliente.value,
        };

        // Chamada da função requisicaoBackend
        requisicaoBackend(dados, rota, respostaListaClientes);
 
       // testeFuncao(dados, rota, respostaListaClientes)

    });

    function requisicaoBackend(dados, rota, callback){
        
        fetch(rota, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => {
                if (!response.ok) { // Se a resposta não for ok, trata o erro
                    return response.json().then(error => {
                        throw new Error(error.error || 'Erro na requisição'); // Lança um erro com a mensagem de erro
                    });
                }
                return response.json(); // Converte a resposta para JSON
            })
            .then(data => {
                
                callback(null, data); // Chama o callback com os dados recebidos
            })
            .catch(error => {
                callback(error, null); // Chama o callback com o erro, se houver
            });
    }



    function respostaListaClientes(erro, resposta) {
        if (erro) {
            console.error('Ocorreu um erro:', erro);
            return;
        }


        // Verifica se a resposta possui dados recebidos
        if (resposta.status === "sucesso" && resposta.dadosRecebidos.length > 0) {
            const tabelaCorpo = document.getElementById('tabela-corpo');

            // Limpa o conteúdo atual da tabela
            tabelaCorpo.innerHTML = '';

            // Itera sobre os dados recebidos e insere cada linha na tabela
            resposta.dadosRecebidos.forEach(dado => {
                const tr = document.createElement('tr');

                // Adiciona colunas
                tr.innerHTML = `
                <td>${dado.id}</td>
                <td>${dado.nome}</td>
                <td>${dado.pf_cpf || ''}</td>
                <td>${dado.pf_data_nascimento ? formatarData(dado.pf_data_nascimento) : ''}</td>
                <td>
                    <button class="btn btn-info btn-sm" 
                            onclick="abrirModalContato(${dado.id}, '${dado.nome}')" 
                            data-toggle="modal" 
                            data-target="#cadastroContatosModal">
                        <i class='fa fa-plus'></i> Contato
                    </button>
                    <button class="btn btn-success btn-sm" 
                            onclick="abrirModalEndereco(${dado.id}, '${dado.nome}')" 
                            data-toggle="modal" 
                            data-target="#cadastroEnderecoModal">
                        <i class='fa fa-plus'></i> Endereço
                    </button>
                    <button class="btn btn-primary btn-sm" 
                            onclick="abrirDadosCliente(${dado.id})">
                        <i class='fa fa-user'></i> Dados Cliente
                    </button>
                </td>
            `;

                // Adiciona a linha à tabela
                tabelaCorpo.appendChild(tr);
            });
        } else {
            console.error('Nenhum dado foi retornado pelo servidor ou o status é inválido.');
        }
    }

    // Função para abrir a nova aba com o ID do cliente usando POST
    function abrirDadosCliente(idCliente) {
        // Cria um formulário de maneira dinâmica
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/dados_cliente";
        form.target = "_blank"; // Abre em nova aba

        // Cria um campo de entrada para o ID do cliente
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "clienteId";
        input.value = idCliente;

        // Adiciona o campo ao formulário
        form.appendChild(input);

        // Adiciona o formulário ao corpo do documento e o envia
        document.body.appendChild(form);
        form.submit();

        // Remove o formulário após o envio para não poluir o DOM
        document.body.removeChild(form);
    }


    /***
     *Funções para cadastro dos contatos do cliente 
     *
     *
     * 
     * 
     *  
     */


    // Função para abrir o modal e preencher o campo do cliente
    function abrirModalContato(idCliente, nomeCliente) {
        const clienteSelect = document.getElementById('cliente_id_contatos');

        // Limpa o campo e adiciona a opção com o cliente selecionado
        clienteSelect.innerHTML = '';
        const option = document.createElement('option');
        option.value = idCliente;
        option.textContent = nomeCliente;
        option.selected = true;
        clienteSelect.appendChild(option);
    }

    // Função auxiliar para formatar a data de nascimento
    function formatarData(data) {
        const partes = data.split('-');
        return `${partes[2]}/${partes[1]}/${partes[0]}`; // Formato DD/MM/AAAA
    }




    document.getElementById('formCadastroContato').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        // Coleta os dados do formulário
        const dados = {
            cliente_id: document.getElementById('cliente_id_contatos').value,
            telefone: document.getElementById('telefone').value,

        };

        // Define a rota para enviar os dados (ajuste conforme necessário)
        const rota = '/salvarcontatosclientes';

        // Chama a função requisicaoBackend
        requisicaoBackend(dados, rota, function(erro, resposta) {
            if (erro) {
                console.error('Erro ao salvar contato:', erro);
                return;
            }

            // Mostra a resposta do servidor
            console.log('Contato salvo com sucesso:', resposta);

            // Fecha o modal (se necessário)
            $('#cadastroContatosModal').modal('hide');
            document.getElementById('telefone').value = "";

            // Limpa o formulário (opcional)
            document.getElementById('formCadastroContato').reset();

            // Você pode adicionar outras ações após o sucesso, como atualizar a lista de contatos
        });
    });

    /**
     * Funções para abrir o cadastro de endereços do cliente
     * 
     * 
     * 
     */

    // Função para abrir o modal e preencher o campo do endereço
    function abrirModalEndereco(idCliente, nomeCliente) {
        const clienteSelect = document.getElementById('cliente_id_endereco');

        // Limpa o campo e adiciona a opção com o cliente selecionado
        clienteSelect.innerHTML = '';
        const option = document.createElement('option');
        option.value = idCliente;
        option.textContent = nomeCliente;
        option.selected = true;
        clienteSelect.appendChild(option);
    }
    //função para enviar os dados do endereço para o backend
    function salvarEndereco(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        // Captura os dados do formulário
        const form = event.target;
        const dados = {
            cliente_id: form.id_cliente.value,
            cep: form.cep.value,
            logradouro: form.logradouro.value,
            numero: form.numero.value,
            complemento: form.complemento.value,
            bairro: form.bairro.value,
            cidade: form.cidade.value,
            uf: form.uf.value
        };

        // Chama a função requisicaoBackend com os dados do formulário
        requisicaoBackend(dados, '/salvarenderecosclientes', (error, response) => {
            if (error) {
                alert('Erro ao salvar o endereço. Tente novamente.');
                console.error('Erro:', error);
            } else {
                alert('Endereço salvo com sucesso!');
                $('#cadastroEnderecoModal').modal('hide');
                form.reset(); // Limpa o formulário
            }
        });
    }
    // Função para aplicar a máscara de CEP (00000-000)
    document.getElementById('cep').addEventListener('input', function(event) {
        let cep = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos

        if (cep.length > 5) {
            cep = cep.slice(0, 5) + '-' + cep.slice(5, 8); // Adiciona o hífen
        }

        event.target.value = cep;
    });

    document.getElementById('cep').addEventListener('input', function() {
        const cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

        // Verifica se o CEP tem 8 dígitos para buscar o endereço automaticamente
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) { // Verifica se o CEP é válido
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('uf').value = data.uf;
                    } else {
                        alert('CEP não encontrado.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar o CEP:', error);
                });
        }
    });


    // Função para cadastrar o cliente
    function cadastrarCliente(event) {
        event.preventDefault();

        const form = document.getElementById('formCadastroCliente');
        const dadosCliente = {
            tipo_pessoa: form.ClienteTipoPessoa.value,
            situacao: form.situacao.value,
            nome: form.ClienteNome.value,
            email: form.ClienteEmail.value,
            pf_cpf: form.pf_cpf.value,
            pf_nome_social: form.pf_nome_social.value,
            pf_rg: form.pf_rg.value,
            pf_data_nascimento: form.pf_data_nascimento.value,
        };

        requisicaoBackend(dadosCliente, '/clientesadd', (erro, resposta) => {
            if (erro) {
                // Verifica se a resposta de erro contém a mensagem de erro no formato esperado
                const errorMessage = erro.error || erro.message || 'Erro desconhecido';
                alert('Erro: ' + errorMessage); // Exibe o alerta com a mensagem de erro
            } else {
                alert('Cliente cadastrado com sucesso!'); // Mensagem de sucesso
                form.reset(); // Limpa o formulário após o cadastro
            }
        });
    }

    // Adiciona o listener ao formulário de cadastro de cliente
    document.getElementById('formCadastroCliente').addEventListener('submit', cadastrarCliente);
</script>