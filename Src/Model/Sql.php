<?php

namespace Src\Model;

class Sql
{
    protected static $host = '';
    protected static $usuario = 'root';
    protected static $senha = 'root';
    protected static $banco = 'aluguelbrinquedos';
    protected static $conexao;

    private function __construct()
    {
        // Construtor privado para evitar instância direta da classe
    }

    private static function conectar()
    {
        try {
            self::$conexao = new \PDO("mysql:host=" . self::$host . ";dbname=" . self::$banco . ";charset=utf8", self::$usuario, self::$senha, array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // Configura o conjunto de caracteres
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // Ativa a exibição de erros
                \PDO::ATTR_EMULATE_PREPARES => false, // Desativa emulação de prepared statements
            ));
            self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Erro na conexão com o banco de dados: ' . $e->getMessage());
        }
    }

    public static function getOne($table, $campos = [], $condicao = [])
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT ";

        // Se o array de campos estiver vazio, seleciona todos os campos (*)
        if (empty($campos)) {
            $sql .= "*";
        } else {
            // Caso contrário, adiciona os campos ao SELECT
            $sql .= implode(", ", $campos);
        }

        $sql .= " FROM $table";

        // Se houver condições, adiciona a cláusula WHERE
        if (!empty($condicao)) {
            $sql .= " WHERE ";
            $condicoes = [];

            foreach ($condicao as $campo => $valor) {
                $condicoes[] = "$campo = :$campo";
            }

            $sql .= implode(" AND ", $condicoes);
        }

        $sql .= " LIMIT 1"; // Adiciona a cláusula LIMIT 1 para obter apenas um registro

        $stmt = self::$conexao->prepare($sql);

        // Binde os valores das condições
        foreach ($condicao as $campo => $valor) {
            $stmt->bindParam(":$campo", $valor, \PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }


    public static function getAllParans($table, $campos = [], $condicao = [])
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT ";

        // Se o array de campos estiver vazio, seleciona todos os campos (*)
        if (empty($campos)) {
            $sql .= "*";
        } else {
            // Caso contrário, adiciona os campos ao SELECT
            $sql .= implode(", ", $campos);
        }

        $sql .= " FROM $table";

        // Se houver condições, adiciona a cláusula WHERE
        if (!empty($condicao)) {
            $sql .= " WHERE ";
            $condicoes = [];

            foreach ($condicao as $campo => $valor) {
                $condicoes[] = "$campo = :$campo";
            }

            $sql .= implode(" AND ", $condicoes);
        }

        $stmt = self::$conexao->prepare($sql);

        // Binde os valores das condições
        foreach ($condicao as $campo => $valor) {
            $stmt->bindParam(":$campo", $valor, \PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }

    public static function getAllParansCarretaJoinEmpresa($campos)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        // Monta a consulta SQL com base nos campos fornecidos
        $sql = "SELECT " . implode(", ", array_map(function ($campo) {
            return "empresa.$campo";
        }, $campos['empresa'])) . ", " . implode(", ", array_map(function ($campo) {
            return "carretas.$campo";
        }, $campos['carreta'])) . "
                FROM carretas 
                LEFT JOIN empresa ON carretas.local = empresa.id ORDER BY carretas.local DESC";

        $stmt = self::$conexao->prepare($sql);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }


    public static function getAllNoParans($table)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT * FROM $table";
        $stmt = self::$conexao->prepare($sql);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }
    public static function getClienteDadosCompletos($id)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT 
            c.id AS cliente_id,
            c.tipo_pessoa,
            c.situacao,
            c.nome,
            c.email,
            c.pf_cpf,
            c.pf_nome_social,
            c.pf_rg,
            c.pf_data_nascimento,
            GROUP_CONCAT(t.telefone ORDER BY t.tipo SEPARATOR '||') AS telefones,
            GROUP_CONCAT(DISTINCT e.cep, ' ', e.logradouro, ', ', e.numero, ' ', e.complemento, ', ', e.bairro, ', ', e.cidade, ' - ', e.uf SEPARATOR '||') AS enderecos
        FROM 
            clientes c
        LEFT JOIN 
            telefones t ON c.id = t.cliente_id
        LEFT JOIN 
            enderecos e ON c.id = e.cliente_id
        WHERE 
            c.id = :id  -- Usa um placeholder nomeado
        GROUP BY 
            c.id";

        $stmt = self::$conexao->prepare($sql);

        try {
            // Vincula o parâmetro :id ao valor fornecido
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            // Retorna um único resultado
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ? $result : []; // Retorna um array vazio se não houver resultados
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }


    public static function getAllLikeLimit($table, $campo, $valor)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT * FROM $table WHERE $campo LIKE :valor LIMIT 50";
        $stmt = self::$conexao->prepare($sql);

        // Adiciona os caracteres '%' ao redor do valor para o uso com LIKE
        $valor = "%{$valor}%";
        $stmt->bindParam(':valor', $valor, \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }


    public static function getAll($table, $campo, $valor)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT * FROM $table WHERE $campo = :valor";
        $stmt = self::$conexao->prepare($sql);
        $stmt->bindParam(':valor', $valor, \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }
    public static function getEquipamentosAll()
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT 
        equipamentos.id,
        equipamentos.disponibilidade,
        equipamentos.motivo,
        equipamentos.categoria_id,
        categoria_equipamentos.nome AS categoria_nome,
        categoria_equipamentos.descricao AS categoria_descricao,
        categoria_equipamentos.valor_diaria AS valor_diaria
    FROM 
        equipamentos
    LEFT JOIN 
        categoria_equipamentos ON equipamentos.categoria_id = categoria_equipamentos.id;";

        $stmt = self::$conexao->prepare($sql);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }
    public static function buscarEquipamentosPorCategoria($categoriaPesquisa)
    {
        self::conectar();
        $sql = "SELECT 
                    equipamentos.id,
                    equipamentos.disponibilidade,
                    equipamentos.motivo,
                    equipamentos.categoria_id,
                    categoria_equipamentos.nome AS categoria_nome,
                    categoria_equipamentos.descricao AS categoria_descricao,
                    categoria_equipamentos.valor_diaria AS valor_diaria
                FROM 
                    equipamentos
                LEFT JOIN 
                    categoria_equipamentos ON equipamentos.categoria_id = categoria_equipamentos.id
                WHERE 
                    categoria_equipamentos.nome LIKE :categoria_nome"; // Usando LIKE na categoria

        $stmt = self::$conexao->prepare($sql);

        // Preparando a pesquisa com o operador LIKE
        try {
            $stmt->bindValue(':categoria_nome', '%' . $categoriaPesquisa . '%', \PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }




    public static function getAllMultasInnerVeiculos()
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT multas.id AS id_multa, multas.valor, multas.data, multas.hora, multas.local, multas.situacao, multas.descricao, carretas.placa
                FROM multas
                LEFT JOIN carretas ON multas.idcarreta = carretas.id;";

        $stmt = self::$conexao->prepare($sql);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }

    public static function getAllParansCarretaJoinEmpresaContratos($placa, $dataInicial, $dataFinal)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT 
                    contratos.ncontrato, 
                    contratos.datasaida, 
                    contratos.prev_retorno, 
                    contratos.data_retorno, 
                    carretas.placa, 
                    empresa.bairro 
                FROM 
                    carretas 
                LEFT JOIN 
                    contratos ON carretas.id = contratos.idcarreta 
                LEFT JOIN 
                    empresa ON empresa.id = contratos.loja
                WHERE 
                    carretas.placa = :placa 
                    AND contratos.datasaida <= :dataInicial 
                    AND contratos.data_retorno >= :dataFinal";

        $stmt = self::$conexao->prepare($sql);

        $stmt->bindParam(':placa', $placa, \PDO::PARAM_STR);
        $stmt->bindParam(':dataInicial', $dataInicial, \PDO::PARAM_STR);
        $stmt->bindParam(':dataFinal', $dataFinal, \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }

    public static function getFirst($table, $campo, $valor)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT * FROM $table WHERE $campo = :valor";
        $stmt = self::$conexao->prepare($sql);
        $stmt->bindParam(':valor', $valor, \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }

    public static function getFirstId($table, $campo, $valor)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        $sql = "SELECT id FROM $table WHERE $campo = :valor";
        $stmt = self::$conexao->prepare($sql);
        $stmt->bindParam(':valor', $valor, \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }


    public static function insert($table, $data)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        // Cria a lista de campos e valores
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $stmt = self::$conexao->prepare($sql);

        try {
            // Executa a consulta com os valores dos campos
            $stmt->execute(array_values($data));

            // Retorna o ID do último registro inserido
            return self::$conexao->lastInsertId(); // ID do novo registro
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }




    public static function update($table, $data, $whereField, $whereValue)
    {

        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta

        // Monta a lista de campos a serem atualizados
        $setClause = '';
        $values = [];
        foreach ($data as $field => $value) {
            $setClause .= "$field = ?, ";
            $values[] = $value;
        }
        $setClause = rtrim($setClause, ', ');

        $sql = "UPDATE $table SET $setClause WHERE $whereField = ?";
        $stmt = self::$conexao->prepare($sql);

        try {
            // Executa a consulta com os valores dos campos e da condição WHERE
            $stmt->execute([...$values, $whereValue]);
            return true; // Sucesso
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }

    public static function getDataChart($startDate, $endDate, $lojas)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes da execução da consulta



        // Criação da consulta SQL com placeholders posicionais
        $sql = "
            SELECT SUM(valor) as soma_valores 
            FROM financeiro 
            WHERE data BETWEEN ? AND ?
            AND loja IN (" . implode(',', array_fill(0, count($lojas), '?')) . ")
        ";

        // Preparação da consulta
        $stmt = self::$conexao->prepare($sql);

        // Bind dos parâmetros posicionais
        $params = array_merge([$startDate, $endDate], $lojas);

        // Execução da consulta
        $stmt->execute($params);

        // Recuperação do resultado
        $result = $stmt->fetch();

        // Exibição do resultado
        return $result['soma_valores'];
    }
    public static function inserirContratoEProdutos($data)
    {
        self::conectar(); // Garante que a conexão seja estabelecida antes de executar a inserção

        // Validação dos dados (checando se o campo não está vazio)
        if (empty($data['idcliente']) || empty($data['subTotal']) || empty($data['total']) || empty($data['dias']) || empty($data['id_endereco']) || empty($data['produtos']) || empty($data['data_entrega']) || empty($data['data_coleta'])) {
            return ["erro" => "Dados incompletos."];
        }

        try {
            self::$conexao->beginTransaction(); // Inicia a transação

            // Insere o contrato na tabela contratos
            $sqlContrato = "INSERT INTO contratos (idcliente, subTotal, desconto, total, dias, id_endereco, data_entrega, data_coleta) 
                            VALUES (:idcliente, :subTotal, :desconto, :total, :dias, :id_endereco, :data_entrega, :data_coleta)";

            $stmt = self::$conexao->prepare($sqlContrato);
            $stmt->bindParam(':idcliente', $data['idcliente']);
            $stmt->bindParam(':subTotal', $data['subTotal']);
            $stmt->bindParam(':desconto', $data['desconto']);
            $stmt->bindParam(':total', $data['total']);
            $stmt->bindParam(':dias', $data['dias']);
            $stmt->bindParam(':id_endereco', $data['id_endereco']);
            $stmt->bindParam(':data_entrega', $data['data_entrega']);
            $stmt->bindParam(':data_coleta', $data['data_coleta']);
            $stmt->execute();

            // Obtém o id do contrato inserido
            $idContrato = self::$conexao->lastInsertId();

            // Insere os produtos na tabela produtos_contrato
            $sqlProduto = "INSERT INTO produtos_contrato (id_contrato, categoria, descricao, disponibilidade, motivo, valorDiario, vlr_total)
                        VALUES (:id_contrato, :categoria, :descricao, :disponibilidade, :motivo, :valorDiario, :vlr_total)";

            $stmtProduto = self::$conexao->prepare($sqlProduto);

            // Itera sobre os produtos e insere cada um
            foreach ($data['produtos'] as $produto) {
                $stmtProduto->bindParam(':id_contrato', $idContrato);
                $stmtProduto->bindParam(':categoria', $produto['categoria']);
                $stmtProduto->bindParam(':descricao', $produto['descricao']);
                $stmtProduto->bindParam(':disponibilidade', $produto['disponibilidade']);
                $stmtProduto->bindParam(':motivo', $produto['motivo']);
                $stmtProduto->bindParam(':valorDiario', $produto['valorDiario']);
                $stmtProduto->bindParam(':vlr_total', $produto['vlr_total']);
                $stmtProduto->execute();
            }

            // Comita a transação para salvar as alterações no banco de dados
            self::$conexao->commit();

            return ["sucesso" => "Contrato e produtos salvos com sucesso."];
        } catch (\PDOException $e) {
            // Se ocorrer algum erro, reverte a transação
            self::$conexao->rollBack();
            return ["erro" => "Erro ao salvar dados: " . $e->getMessage()];
        }
    }
    /**
     * Busca contratos com base no campo de busca e intervalo de datas.
     *
     * @param string $campoBusca O campo pelo qual será feita a busca (ex.: 'idcliente', 'total').
     * @param string $valorBusca O valor do campo a ser buscado.
     * @param string $dataInicial Data inicial do intervalo (YYYY-MM-DD).
     * @param string $dataFinal Data final do intervalo (YYYY-MM-DD).
     * @return array Retorna os contratos encontrados ou um array vazio.
     */
    public static function buscarContratos($campoBusca, $dataInicial, $dataFinal)
    {
        // Garante que a conexão está configurada
        Sql::conectar();

        // Monta a consulta SQL dinâmica
        $sql = "
            SELECT 
                contratos.id, 
                contratos.data_entrega, 
                contratos.data_coleta, 
                contratos.total AS vlr_total, 
                clientes.nome AS nome_cliente
            FROM contratos
            LEFT JOIN clientes 
                ON contratos.idcliente = clientes.id
            WHERE $campoBusca BETWEEN :dataInicial AND :dataFinal
        ";


        $stmt = Sql::$conexao->prepare($sql);

        // Bind dos parâmetros da consulta
        $stmt->bindParam(':dataInicial', $dataInicial, \PDO::PARAM_STR);
        $stmt->bindParam(':dataFinal', $dataFinal, \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultados ?: []; // Retorna os resultados ou um array vazio
        } catch (\PDOException $e) {
            die('Erro na execução da consulta: ' . $e->getMessage());
        }
    }
}
