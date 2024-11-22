<?php
namespace Src\Controller;

class RequestPost {
    private $requiredFields;

    public function __construct($requiredFields) {
        $this->requiredFields = $requiredFields;
    }

    public function processarRequisicao() {
        // Verifica se a requisição é do tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Tenta obter os dados do corpo da requisição como JSON
            $requestData = json_decode(file_get_contents('php://input'), true);

            // Se não for JSON (pode ser via formulário HTML), tenta pegar os dados de $_POST (formulários)
            if (empty($requestData)) {
                $requestData = $_POST;
            }

            // Verifica se todos os campos obrigatórios estão presentes nos dados recebidos
            if ($this->camposObrigatoriosPresentes($requestData)) {
                // Retorna os dados processados, sejam eles de $_POST ou JSON
                return $requestData;
            } else {
                // Caso algum campo obrigatório não esteja presente, retorna um erro
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Campos obrigatórios ausentes nos dados.'], JSON_UNESCAPED_UNICODE);
                exit;
            }
        } else {
            // Caso a requisição não seja do tipo POST, retorna um erro
            header('Content-Type: application/json; charset=utf-8');
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Método não permitido. Apenas solicitações POST são aceitas.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    private function camposObrigatoriosPresentes($requestData) {
        // Verifica se todos os campos obrigatórios estão presentes nos dados
        foreach ($this->requiredFields as $campo) {
            if (!isset($requestData[$campo])) {
                http_response_code(400); // Código de erro para campo não informado
                echo json_encode(['error' => 'Campo '. $campo . ' ausente']);
                exit; // Encerra a execução
            }
        }
        return true;
    }
}
