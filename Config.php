<?php

use Src\Controller\Categoria;
use Src\Controller\Equipamento;
use Src\Controller\Cliente;
use Src\Controller\Contrato;
use Src\Model\Sql;
use Src\Controller\Response;

// Inicie a sessão, se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifique se o usuário não está logado, exceto para a rota de confirmação de login
if (!\Src\Controller\Auth::getSessionData() && $_SERVER['REQUEST_URI'] !== '/confirmlogin') {
    // Se não estiver logado e não for a rota de confirmação de login, redirecione para a página de login
    require_once 'src/View/login/login.php';
    return;
}
function resp($statusCode, $message, $data = null)
{
    new Response($statusCode, $message, $data);
}


$router = new Router();
//Rota Index
$router->addRoute('/', function () {
    new \Src\Controller\LoadView('src/View/Index/viewIndex.php', 'Início');
});




// 
// 
// 
// 
//Rotas para lidar com clientes
// 
// 
// 
// 

$router->addRoute('/clientes', function () {
    new \Src\Controller\LoadView('src/View/Clientes/cadastro_clientes.php', 'Cadastrar cliente');
});



// Rota para exibir todos os dados do cliente
$router->addRoute('/dados_cliente', function () {

    $camposObrigatorios = ['clienteId'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $resultados = $request->processarRequisicao();

    // Supondo que o clienteId foi extraído de $resultados ou diretamente de $_POST
    $clienteId = $resultados['clienteId'] ?? null; // Aqui você pode pegar o clienteId da requisição

    // Passa o clienteId como um parâmetro para a view
    new \Src\Controller\LoadView('src/View/Clientes/dados_completos.php', 'Cadastrar cliente', ['clienteId' => $clienteId]);
});



$router->addRoute('/get_dados_cliente', function () {


    $camposObrigatorios = ['id'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $resultados = $request->processarRequisicao();
    $cliente = new Cliente();

    $retorno = $cliente->getClienteDadosCompletos($resultados['id']);

    echo json_encode($retorno);
});

//rota backend, para inserir cliente, 
$router->addRoute('/clientesadd', function () {
    $camposObrigatorios = ['pf_cpf',  'situacao', 'nome', 'email', 'pf_data_nascimento'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $resultados = $request->processarRequisicao();
    $cliente = new Cliente();

    $retorno = $cliente->inserirCliente($resultados);

    echo json_encode($retorno);
});


//Rotas para lidar com clientes
$router->addRoute('/detalhes_clientes', function () {
    new \Src\Controller\LoadView('src/View/Clientes/cadastra_cliente.php', '');
});


//Rotas pesquisa clientes por nome
$router->addRoute('/pesquisa_clientes', function () {
    $camposObrigatorios = ['nome'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();
    $cliente = new Cliente();

    $retorno = $cliente->buscarLikeNome($dados['nome']);


    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});


//Rota salva contato cliente
$router->addRoute('/salvarcontatosclientes', function () {
    // Definindo o cabeçalho de resposta como JSON
    header('Content-Type: application/json');

    // Lendo o conteúdo bruto da entrada
    $input = file_get_contents('php://input');

    // Decodificando o JSON recebido
    $dados = json_decode($input, true); // O parâmetro true converte para array associativo

    // Processando os dados ou realizando alguma lógica adicional, se necessário

    $cliente = new Cliente();
    $retorno = $cliente->inserirTelefoneCliente($dados);


    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});


//ROta Salva endereço Cliente

$router->addRoute('/salvarenderecosclientes', function () {
    // Definindo o cabeçalho de resposta como JSON
    header('Content-Type: application/json');

    // Lendo o conteúdo bruto da entrada
    $input = file_get_contents('php://input');

    // Decodificando o JSON recebido
    $dados = json_decode($input, true); // O parâmetro true converte para array associativo

    // Processando os dados ou realizando alguma lógica adicional, se necessário

    $cliente = new Cliente();
    $retorno = $cliente->inserirEnderecosCliente($dados);


    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});








/*****
 * Rotas para lidar com os contratos
 */



/**Rota que carrega a tela de pesquisar contratos */
$router->addRoute('/contratos', function () {
    new \Src\Controller\LoadView('src/View/Contratos/pesquisa_contratos.php', 'Pesquisar Contratos');
});
/**Rota que carrega a tela de gerar contratos */
$router->addRoute('/gerar_contratos', function () {
    new \Src\Controller\LoadView('src/View/Contratos/gerar_contrato.php', 'Gerar Contratos');
});

/**
 * Rota que salva contratos
 */

$router->addRoute('/salva_contrato', function () {
    // Certifique-se de que o conteúdo recebido seja JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Verifique se a função de inserção está presente
    if (isset($data) && !empty($data)) {


        $resultado = Sql::inserirContratoEProdutos($data);

        // Retorne a resposta em formato JSON
        echo json_encode($resultado);
    } else {
        // Caso os dados não sejam recebidos ou sejam inválidos
        echo json_encode(["erro" => "Dados inválidos ou ausentes."]);
    }
});

/**
 * Busca Contrato por data
 */

/**Rota que carrega a tela de pesquisar contratos */
$router->addRoute('/get_contratos_data', function () {
    $camposObrigatorios = ['tipo_pesquisa', 'data_inicial', 'data_final'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();


    
    Contrato::getContratoData($dados['tipo_pesquisa'], $dados['data_inicial'], $dados['data_final']);
   
});







$router->addRoute('/get_endereco_cliente_id', function () {
    $camposObrigatorios = ['cliente_id'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $resultados = $request->processarRequisicao();
    $cliente = new Cliente();


    $cliente->get_endereco_cliente_id($resultados['cliente_id']);
});






/***Fim de rotas para lidar com contratos */


//Rotas para lidar com categorias / equipamentos:

/**
 * 
 * Rota View Cadastro categoria
 */

$router->addRoute('/categorias_categorias_equipamentos', function () {
    new \Src\Controller\LoadView('src/View/Equipamentos/cadastro_categorias_equipamentos.php', 'Cadastrar equipamento');
});

/**
 * 
 *Rota View cadastro de equipamentos 
 */


$router->addRoute('/cadastro_equipamentos', function () {
    new \Src\Controller\LoadView('src/View/Equipamentos/cadastro_equipamentos.php', 'Cadastrar equipamento');
});

/**
 * 
 *Rota request que salva a categoria
 */
$router->addRoute('/add_cat_equipamentos', function () {
    $camposObrigatorios = ['nome', 'descricao', 'valor_diaria'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();

    $categoria = new Categoria();
    $retorno = $categoria->inserirCategoria($dados);


    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});

/**
 * 
 * Rota que busca categoria de equipamento pelo nome
 * 
 */
$router->addRoute('/buscar_cat_equipamentos', function () {
    $camposObrigatorios = ['nome'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();
    $retorno = Categoria::buscarLikeNome($dados['nome']);

    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});
/**
 * 
 * Rota que edita categoria de equipamento pelo id
 * 
 */
$router->addRoute('/edit_cat_equipamentos', function () {
    $camposObrigatorios = ['id', 'nome', 'descricao', 'valor_diaria'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();
    $retorno = Categoria::editar($dados['id'], $dados);

    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});

//Rota que busca todos os equipamentos
$router->addRoute('/buscar_equipamentos', function () {
    $camposObrigatorios = ['id'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();
    $retorno = Equipamento::listar();

    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});


//Rota que busca o equipamento pelo nome descrito na categoria
$router->addRoute('/buscar_equipamentos_nome_categoria', function () {
    $camposObrigatorios = ['nome'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();
    $retorno = Equipamento::listarNomeCategoria($dados['nome']);

    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});

// Rota que add equipamento 
$router->addRoute('/add_equipamento', function () {
    $camposObrigatorios = [];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();

    $categoria = new Equipamento();
    $retorno = $categoria->inserirCategoria($dados);


    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});


//Rota que edita o equipamento pelo ID
$router->addRoute('/edit_equipamento', function () {
    $camposObrigatorios = ['id'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $dados = $request->processarRequisicao();
    $retorno = Equipamento::editar($dados['id'], $dados);

    // Retornando os dados recebidos como JSON
    echo json_encode([
        'status' => 'sucesso',
        'dadosRecebidos' => $retorno
    ]);
});
//Fim de rotas para lidar com equipamentos


$router->addRoute('/confirmlogin', function () {
    $camposObrigatorios = ['usuario', 'senha'];
    $request = new \Src\Controller\RequestPost($camposObrigatorios);
    $resultados = $request->processarRequisicao();

    if ($resultados) {
        \Src\Controller\Auth::getUserLogin($resultados['usuario'], $resultados['senha']);
    }
});

$router->addRoute('/destroysession', function () {
    session_destroy();
    require_once 'src/View/login/login.php';
});




//rotas de teste, 
$router->addRoute('/teste', function () {
    return;
});


// Manipula a solicitação atual
$currentUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($currentUrl);
