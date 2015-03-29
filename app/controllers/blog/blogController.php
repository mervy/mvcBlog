<?php

class Blog extends Controller
{
    public $art, $cat, $aux, $config;
    protected $qtd, $contar, $atual; //Para a paginação

    public function init()
    {
        $this->aux = new auxHelper();
        $this->contador = new contadorHelper();
        $this->config = new configHelper();
    }

    public function __construct()
    {
        parent::__construct();
        $this->art = new blogModel();
        $this->art->_tabela = 'artigos';
        $this->cat = new blogModel();
        $this->cat->_tabela = 'categorias_artigos';
    }

    public function Index_action()
    {
        //Vai paginar os artigos do blog ou que se quiser!!!
        $qtd = 10; //Artigos por pagina
        $artigos = $this->art->mostrarArtigos(3); //Retira os 4 registros da pagina home

        $pag_arquivo = array_chunk($artigos, $qtd);

        $page = $this->getParam(2) ? $this->getParam(2) : null;
        $this->atual = (isset($page)) ? intval($page) : 1;
        $this->contar = count($pag_arquivo);
        $result = $pag_arquivo[$this->atual - 1];

        $dados['result'] = $result;

        //Categorias
        $categorias = $this->cat->mostrarTudo();
        $dados['categorias'] = $categorias;

        //Mais acessados
        $dados['acessos'] = $this->contador->contarLinks('blog');

        $this->showPages('blog', $dados);

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

    public function ver()
    {
        if ($this->getParam(4)) {
            $id = $this->getParam(4);
        }

        $result = $this->art->mostrarArtigosId($id);
        $dados['res'] = $result[0];

        //Categorias
        $categorias = $this->cat->mostrarTudo();
        $dados['categorias'] = $categorias;

        //Mais acessados
        $dados['acessos'] = $this->contador->contarLinks('blog');

        $this->showPages('blog_post', $dados);
    }

    public function categoria()
    {
        if ($this->getParam(2)) {
            $cat = $this->getParam(2);
        }
//Vai paginar os artigos do blog ou que se quiser!!!
        $qtd = 10; //Artigos por pagina
        $artigos = $this->art->mostrarArtigosCategoria($cat);
        $pag_arquivo = array_chunk($artigos, $qtd);
        $page = $this->getParam(3) ? $this->getParam(3) : null;
        $this->atual = (isset($page)) ? intval($page) : 1;
        $this->contar = count($pag_arquivo);
        $result = $pag_arquivo[$this->atual - 1];

//Para exibir as categorias
        $categorias = $this->cat->mostrarTudo();
        $dados['categorias'] = $categorias;

        $dados['result'] = $result;
        $this->showPages('blog', $dados);
    }

    public function adblock()
    {
        $this->showPages('adblock');
    }
}
