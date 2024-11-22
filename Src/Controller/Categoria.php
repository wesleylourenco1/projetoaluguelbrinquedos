<?php

namespace Src\Controller;

use \Src\Model\Sql;

class Categoria
{
    protected static $table = 'categoria_equipamentos'; // Nome da tabela de clientes

    // Método de instância para adicionar categoria
    public function adicionar($data)
    {
        return Sql::insert(self::$table, $data); // Uso de self::$table para acessar a propriedade estática
    }

    // Método para inserir categoria
    public function inserirCategoria($dados)
    {
        // Adiciona a categoria e verifica se foi inserida com sucesso
        $id = $this->adicionar($dados); // Adiciona a categoria e recebe o ID inserido
        if ($id) {
            // Retorna os dados inseridos no formato JSON
            return json_encode([
                'status' => 'success',
                'message' => "Categoria '{$dados['nome']}' inserido com sucesso!",
                'data' => $dados,
                'id' => $id, // Retorna o ID da categoria inserida
            ]);
        } else {
            // Retorna erro no formato JSON
            http_response_code(500); // Código de erro para erro ao salvar registro
            echo json_encode(['error' => 'Erro ao salvar registro da categoria']);
            exit; // Encerra a execução
        }
    }

    // Método estático para editar categoria
    public static function editar($id, $data)
    {
        return Sql::update(self::$table, $data, 'id', $id); // Acesso correto à propriedade estática
    }

    // Método de instância para buscar categoria por ID
    public function buscar($id)
    {
        return Sql::getFirst(self::$table, 'id', $id); // Acesso correto à propriedade estática
    }

    // Método estático para buscar categorias com nome semelhante
    public static function buscarLikeNome($nome)
    {
        return Sql::getAllLikeLimit(self::$table, 'nome', $nome); // Acesso correto à propriedade estática
    }

    // Método de instância para listar todas as categorias
    public function listar()
    {
        return Sql::getAllNoParans(self::$table); // Acesso correto à propriedade estática
    }
}
