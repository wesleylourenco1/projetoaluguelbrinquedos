<!--  Essa View tem os inputs para cadastro do cliente -->


<div class="container py-3">
    <section class="content">
        <form id="formCadastroCliente">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0"><i class="fa fa-pencil-square-o"></i> Dados gerais</h5>
                </div>
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
                    <a href="/clientes" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                </div>
            </div>
        </form>
    </section>
</div>

<script>
function enviarDados(dados, rota) {
    return fetch(rota, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dados)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(error => { throw new Error(error.error); });
        }
        return response.json();
    });
}

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

    enviarDados(dadosCliente, '/clientesadd')
        .then(resposta => {
            alert('Cliente cadastrado com sucesso!'); // Mensagem de sucesso
            form.reset(); // Limpa o formulário após o cadastro
        })
        .catch(error => {
            alert('Erro: ' + error.message); // Exibe um alerta com a mensagem de erro
        });
}

// Adiciona o listener ao formulário de cadastro de cliente
document.getElementById('formCadastroCliente').addEventListener('submit', cadastrarCliente);
</script>
