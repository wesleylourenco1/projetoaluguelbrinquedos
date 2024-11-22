    <div class="container mt-5">
        <!-- Card com dados do cliente -->
        <div class="card mb-3">
            <div class="card-header">
                Dados do Cliente
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nome" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email" readonly>
                    </div>
                    <div class="form-group">
                        <label>CPF</label>
                        <input type="text" class="form-control" id="cpf" readonly>
                    </div>
                    <div class="form-group">
                        <label>Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" readonly>
                    </div>
                    <div class="form-group">
                        <label>RG</label>
                        <input type="text" class="form-control" id="rg" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Pessoa</label>
                        <input type="text" class="form-control" id="tipo_pessoa" readonly>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card com telefones -->
        <div class="card mb-3">
            <div class="card-header">
                Telefones
            </div>
            <div class="card-body" id="telefones">
                <!-- Os cards de telefones serão inseridos aqui -->
            </div>
        </div>

        <!-- Card com endereços -->
        <div class="card">
            <div class="card-header">
                Endereços
            </div>
            <div class="card-body">
                <div class="row" id="enderecosContainer">
                    <!-- Os cards de endereços serão inseridos aqui -->
                </div>
            </div>
        </div>
    </div>


    <script>
       // Função para buscar os dados do cliente
fetch('/get_dados_cliente', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        id: {{CLIENTEID}}
    })
})
.then(response => response.json())
.then(data => {
    // Preencher os dados do cliente
    document.getElementById('nome').value = data.nome;
    document.getElementById('email').value = data.email;
    document.getElementById('cpf').value = data.pf_cpf;
    document.getElementById('data_nascimento').value = data.pf_data_nascimento;
    document.getElementById('rg').value = data.pf_rg;
    document.getElementById('tipo_pessoa').value = data.tipo_pessoa;

    // Verifica se há telefones e preenche em cards
    const telefones = data.telefones ? data.telefones.split('||') : [];
    const telefonesContainer = document.getElementById('telefones');
    telefonesContainer.innerHTML = ''; // Limpa os telefones existentes
    telefones.forEach((telefone, index) => {
        const telefoneCard = document.createElement('div');
        telefoneCard.className = 'card mb-2';
        telefoneCard.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">Telefone ${index + 1}</h5>
                <p class="card-text">${telefone.trim()}</p>
            </div>
        `;
        telefonesContainer.appendChild(telefoneCard);
    });

    // Preencher os endereços formatados
    const enderecos = data.enderecos ? data.enderecos.split('||') : [];
    const enderecoContainer = document.getElementById('enderecosContainer');
    enderecoContainer.innerHTML = ''; // Limpa os endereços existentes
    enderecos.forEach((endereco, index) => {
        const enderecoPartes = endereco.split(',');

        // Extrai o CEP (primeiro item da primeira parte)
        const cep = enderecoPartes[0]?.trim().split(' ')[0] || ''; // Extrai o CEP

        // Extrai o logradouro (restante da primeira parte)
        const logradouro = enderecoPartes[0]?.trim().split(' ').slice(1).join(' ') || ''; // Extrai o logradouro

        // Extrai o número (segundo item após o logradouro)
        const numero = enderecoPartes[1]?.trim() || ''; // Extrai o número

        // Extrai o complemento (se houver, após o número)
        const complemento = enderecoPartes.length > 2 ? enderecoPartes.slice(2).join(',').trim() : ''; // Extrai o complemento

        // Extrai a cidade (último item após a vírgula)
        const cidade = enderecoPartes[enderecoPartes.length - 1]?.trim().split('-')[0].trim() || ''; // Extrai a cidade

        const enderecoCard = document.createElement('div');
        enderecoCard.className = 'col-12 mb-2';
        enderecoCard.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Endereço ${index + 1}</h5>
                    <p class="card-text">${logradouro}, Número: ${numero}, Complemento: ${complemento}, CEP: ${cep}, Cidade: ${cidade}</p>
                </div>
            </div>
        `;
        enderecoContainer.appendChild(enderecoCard);
    });
})
.catch(error => console.error('Erro ao buscar os dados do cliente:', error));

    </script>