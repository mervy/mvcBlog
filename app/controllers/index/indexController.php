<?php

class Index extends Controller
{
    public $aux;
    public $config;

    public function init()
    {
        $this->aux = new auxHelper();
        $this->config = new configHelper();
    }

    public function Index_action()
    {
        $posts = new blogModel();
        $posts->_tabela = 'artigos';
        $img = new imagensModel();
        $img->_tabela = 'albuns';
        $vid = new videosModel();
        $vid->_tabela = 'videos';

        $artigos = $posts->mostrarArtigosIndex(5);
        $imagens = $img->mostrarAlbunsIndex(3);
        $videos = $vid->mostrarVideosIndex(6);

        $dados['art_content'] = $artigos;
        $dados['img_content'] = $imagens;
        $dados['vid_content'] = $videos;

        $this->showPages('index', $dados);
    }
}
