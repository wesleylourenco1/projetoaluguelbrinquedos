<?php

namespace Src\Controller;

use \Src\Model\Sql;

class Contrato
{
    private $table = 'contratos'; // Nome da tabela de cliente

    public static function getContratoData($tipo_pesquisa, $dataInicial, $dataFinal)
    {
        // Verifica se a data inicial é igual à data final
        if ($dataInicial == $dataFinal) {
            // Cria um objeto DateTime com a data final fornecida
            $data = new \DateTime($dataFinal);

            // Adiciona 1 dia à data final
            $data->modify('+1 day');

            // Atribui a nova data ao $dataFinal
            $dataFinal = $data->format('Y-m-d'); // Ou outro formato conforme sua necessidade
        }

        // Busca os contratos com as datas ajustadas
        $resultados = Sql::buscarContratos($tipo_pesquisa, $dataInicial, $dataFinal);

        // Exibe os resultados
        if (!empty($resultados)) {
            resp(200, 'Sucesso', $resultados);
        } else {
            resp(404, "Nenhum contrato localizado.");
        }
    }
}
