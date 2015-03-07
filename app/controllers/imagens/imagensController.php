<?php

class Imagens extends Controller {

    public $img, $cat, $aux, $config;
    protected $qtd, $contar, $atual; //Para a paginação

    public function init() {
        $this->aux = new auxHelper();
        $this->contador = new contadorHelper();
        $this->config = new configHelper();
    }

    public function __construct() {
        parent::__construct();
        $this->img = new imagensModel();
        $this->img->_tabela = 'albuns';
    }

    public function Index_action() {
        //Vai paginar os artigos do blog ou que se quiser!!!
        $qtd = 15; //Artigos por pagina
        $registros = $this->img->mostrarAlbuns(); //Retira os 4 registros da pagina home

        $pag_arquivo = array_chunk($registros, $qtd);

        $page = $this->getParam(2) ? $this->getParam(2) : NULL;
        $this->atual = (isset($page)) ? intval($page) : 1;
        $this->contar = count($pag_arquivo);
        $result = $pag_arquivo[$this->atual - 1];

        $dados['result'] = $result;

        $this->showPages('imagens', $dados);

        /*
         * Inserir o código abaixo onde se quer a paginação na view         
          for ($i = 1; $i <= $this->contar; $i++) {
          if ($i == $this->atual) {
          printf('<li><a href="#">[ %s ]</a></li>', $i, $i);
          } else {
          echo "<li><a href='/blog/index/$i'> $i </a></li>";
          }
          }
         */
    }

    public function ver() {
        if ($this->getParam(3)) {
            $id = $this->getParam(3);
        }
        $registros = $this->img->mostrarImagensPorAlbum($id);
        $dados['result'] = $registros[0];

        //Paginação das imagens apenas
        $qtd = 24; //Artigos por pagina
        $imagens = explode(', ', $registros[0]['imagens']); 
        $pag_arquivo = array_chunk($imagens, $qtd);       
        $page = $this->getParam(4) ? $this->getParam(4) : NULL; // url: /ver¹/album²/id³/paginacao
        $this->atual = (isset($page)) ? intval($page) : 1;
        $this->contar = count($pag_arquivo);
        $result = $pag_arquivo[$this->atual - 1];
        $dados['imagens'] = $result;
        //Fim da paginação das imagens
        
        $this->showPages('imagens_post', $dados);
    }

}
