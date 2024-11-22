<?php

namespace Src\Controller;
class Response
{
    // Código de status HTTP
    private $statusCode;
    
    // Mensagem de resposta
    private $message;
    
    // Dados da resposta
    private $data;

    // Construtor que aceita código de status, mensagem e dados
    public function __construct($statusCode, $message, $data = null)
    {
        // Define o código de status HTTP
        http_response_code($statusCode);
        
        // Define o cabeçalho para conteúdo JSON
        header('Content-Type: application/json');
        
        // Atribui os valores passados
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;

        // Envia a resposta imediatamente
        echo $this->getResponse();
        exit;  // Interrompe a execução do código após enviar a resposta
    }

    // Método para criar a resposta como uma string JSON
    private function getResponse()
    {
        // Cria a resposta como um array
        $response = [
            'message' => $this->message,
            'data' => $this->data
        ];

        // Retorna a resposta JSON codificada
        return json_encode($response);
    }
}
