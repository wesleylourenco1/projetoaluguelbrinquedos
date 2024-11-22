<?php

namespace Src\Controller;

class Auth
{
    public $idusuario;
    public $idempresa;
    public $nome;
    public $responsavel;
    public $usuario;
    protected $user;

    public function __construct()
    {
        // Inicie a sessão, se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getUserLogin($user, $password)
    {
        $userData = \Src\Model\Sql::getOne('usuarios', [], ["usuario" => strtoupper($user)]);
        $auth = new Auth();

        if ($userData) {
            // confirmaSenha
            if (sha1($password) != $userData['senha']) {
                $auth->erroUserPassword();
                return false;
            }

            $authData = [
                'idusuario' => $userData['id'],
                'idempresa' => $userData['idempresa'],
                'nome' => $userData['nome'],
                'responsavel' => $userData['responsavel'],
                'usuario' => $userData['usuario'],
                'success' => true
            ];

            // Salvar a sessão
            $auth->saveSession($authData);

            echo json_encode($authData);
        } else {
            $auth->erroUserPassword();
        }
    }

    public static function getSessionData()
    {
        // Verificar se a sessão está configurada
        if (isset($_SESSION['authData'])) {
            $authData = $_SESSION['authData'];
            

            // Verificar se a sessão expirou
            if ($authData['expiration_time'] < time()) {
                // A sessão expirou, destrua a sessão e retorne uma mensagem de erro
                session_destroy();
                
                return false;
            }

            return $authData;
        } else {
            
            return false;
        }
    }


    public function erroUserPassword()
    {
        echo json_encode(['error' => 404, 'msg' => 'Usário / Senha não encontrados']);
    }

    private function saveSession($authData)
    {
        // Configura o tempo de expiração da sessão para 5 horas
        $expirationTime = time() + (5 * 60 * 60);

        // Salva os dados da sessão no array $_SESSION
        $_SESSION['authData'] = [
            'usuario' => $authData,
            'expiration_time' => $expirationTime
            // Adicione outros dados da sessão, se necessário
        ];
    }
}
