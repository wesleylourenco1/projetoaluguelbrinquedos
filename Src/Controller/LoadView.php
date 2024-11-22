<?php
namespace Src\Controller;

class LoadView
{
    private $caminhoDoLayout;
    private $conteudo;
    private $parametros; // Armazena os parâmetros para a view

    public function __construct($conteudo = '', $title = '', $parametros = [], $caminhoDoLayout = 'src/View/layout/layout.php') {
        $this->caminhoDoLayout = $caminhoDoLayout;
        $this->conteudo = '';
        $this->parametros = $parametros; // Armazena os parâmetros recebidos
        $conteudo = (file_exists($conteudo)) ? file_get_contents($conteudo) : $conteudo;
        $this->carregarLayout();
        $this->substituirConteudo('{{TITULO}}', $title);
        $this->substituirConteudo('{{CONTEUDO}}', $conteudo);
        $this->substituirParametrosNasViews(); // Substitui parâmetros na view
        $this->exibirLayout();
    }

    public function carregarLayout()
    {
        ob_start();
        include $this->caminhoDoLayout;
        $this->conteudo = ob_get_contents();
        ob_end_clean();
    }

    public function substituirConteudo($placeholder, $novoConteudo)
    {
        $this->conteudo = str_replace($placeholder, $novoConteudo, $this->conteudo);
    }

    public function exibirLayout()
    {
        echo $this->conteudo;
    }

    public function salvarLayout($caminhoSalvar)
    {
        file_put_contents($caminhoSalvar, $this->conteudo);
    }

    // Novo método que substitui os parâmetros diretamente na view
    private function substituirParametrosNasViews()
    {
        foreach ($this->parametros as $chave => $valor) {
            $placeholder = '{{' . strtoupper($chave) . '}}';
            $this->substituirConteudo($placeholder, $valor);
        }
    }
}
