<?php

class Noticias extends Controller
{
    public $not, $cat, $aux, $config;
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
        $this->not = new noticiasModel();
        $this->not->_tabela = 'noticias';
        $this->cat = new noticiasModel();
        $this->cat->_tabela = 'categorias_noticias';
    }

    public function Index_action()
    {
        ini_set('allow_url_fopen', 1);
        ini_set('allow_url_include', 1);

        $feeds = $this->not->mostrarNoticias();
        $dados['result'] = $feeds;
        $this->showPages('noticias', $dados);

        /*
         * Inserir o código abaixo na paǵina view
                <?php foreach ($view_result as $v): ?>
                <h2><?= $v['fonte'] ?></h2>
                <?php
                $rss = simplexml_load_file($v['feed']);
                foreach ($rss->channel->item as $rss2):
                    ?>
                    <h4><a href="<?php $rss2->link ?>" target="_blank"><?= $rss2->title ?></a></h4>
                    <p><?= $rss2->description ?></p>
                <?php
                endforeach;
            endforeach;
            ?>
         */
    }

    public function ver()
    {
        if ($this->getParam(4)) {
            $id = $this->getParam(4);
        }

        /*  $result = $this->art->mostrarArtigosId($id);
          $dados['res'] = $result[0];

          //Categorias
          $categorias = $this->cat->mostrarTudo();
          $dados['categorias'] = $categorias;

          //Mais acessados
          $dados['acessos'] = $this->contador->contarLinks('blog');

          $this->showPages('blog_post', $dados); */
    }

    public function categoria()
    {
        if ($this->getParam(2)) {
            $cat = $this->getParam(2);
        }
//Vai paginar os artigos do blog ou que se quiser!!!
        /*    $qtd = 10; //Artigos por pagina
          $artigos = $this->art->mostrarArtigosCategoria($cat);
          $pag_arquivo = array_chunk($artigos, $qtd);
          $page = $this->getParam(3) ? $this->getParam(3) : NULL;
          $this->atual = (isset($page)) ? intval($page) : 1;
          $this->contar = count($pag_arquivo);
          $result = $pag_arquivo[$this->atual - 1];

          //Para exibir as categorias
          $categorias = $this->cat->mostrarTudo();
          $dados['categorias'] = $categorias;

          $dados['result'] = $result;
          $this->showPages('blog', $dados); */
    }

    public function adblock()
    {
        $this->showPages('adblock');
    }
}
