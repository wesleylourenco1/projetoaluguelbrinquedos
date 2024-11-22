<?php

namespace Src\Controller;

use \Src\Model\Sql;

class Cliente
{
    private $table = 'clientes'; // Nome da tabela de clientes

    public function adicionar($data)
    {
        return Sql::insert($this->table, $data);
    }
    public function inserirCliente($dados)
    {
        $cpf = $dados['pf_cpf'];
        if (!$this->validarCPF($cpf)) {
            http_response_code(400); // Código de erro para CPF inválido
            echo json_encode(['error' => 'CPF incorreto']);
            exit; // Encerra a execução
        }
        $consultaduplicado = $this->buscarCpf(preg_replace('/[^0-9]/', '', $cpf));

        if ($consultaduplicado) {
            http_response_code(409); // Código de erro para CPF duplicado
            echo json_encode(['error' => 'CPF duplicado']);
            exit; // Encerra a execução

        }
        // Adiciona a pessoa e verifica se foi inserida com sucesso
        $id = $this->adicionar($dados);
        if ($id) {
            // Retorna os dados inseridos no formato JSON
            return json_encode([
                'status' => 'success',
                'message' => "Cliente '{$dados['nome']}' inserido com sucesso!",
                'data' => $dados,
                'id' => $id,
            ]);
        } else {
            // Retorna erro no formato JSON
            http_response_code(500); // Código de erro para erro ao salvar registro
            echo json_encode(['error' => 'Erro ao salvar registro do cliente']);
            exit; // Encerra a execução
        }
    }
    public function inserirTelefoneCliente($data)
    {
        $dados_inserir['cliente_id'] = $data['cliente_id'];
        $dados_inserir['telefone'] = $data['telefone'];
        return Sql::insert('telefones', $dados_inserir);
    }
    public function inserirEnderecosCliente($data)
    {

        return Sql::insert('enderecos', $data);
    }

    public function get_endereco_cliente_id($id)
    {
        // Consultar os endereços para o cliente
        $enderecos = Sql::getAll('enderecos', 'cliente_id', $id);

        if (empty($enderecos)) {
            // Se não encontrar resultados, retornar erro 404
            http_response_code(404);
            echo json_encode(['error' => 'Endereços não encontrados para o cliente com ID ' . $id]);
        } else {
            // Se encontrar resultados, retornar sucesso 200
            http_response_code(200);
            echo json_encode($enderecos);
        }
    }

    public function editar($id, $data)
    {
        return Sql::update($this->table, $data, 'id', $id);
    }


    public function buscar($id)
    {
        return Sql::getFirst($this->table, 'id', $id);
    }
    public function buscarLikeNome($nome)
    {
        return Sql::getAllLikeLimit($this->table, 'nome', $nome);
    }

    public function getClienteDadosCompletos($id)
    {
        return Sql::getClienteDadosCompletos($id);
    }




    public function buscarCpf($cpf)
    {
        return Sql::getFirst($this->table, 'pf_cpf', $cpf);
    }

    public function listar()
    {
        return Sql::getAllNoParans($this->table);
    }

    public function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se o CPF é uma sequência de números iguais
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // Validação dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true; // CPF válido
    }
}
