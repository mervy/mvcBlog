<?php

class Admin extends Controller {

    private $auth, $db;
    private $custo = 13; //custo de processamento da função crypt
    private $salt; //hash de criação da senha
    public $config;

    public function init() {
        $this->auth = new authHelper();
        $this->config = new configHelper();
        $this->auth->setLoginControllerAction('admin', 'login')
                ->checkLogin('redirect');

        $this->db = new adminModel();
    }

    public function __construct() {
        parent::__construct();
        $this->salt = hash('sha512', "O mundo é lindo");
        return $this;
    }

    public function showPages($page, $datas = null) {
        $this->view('templates/headerAdmin');
        $this->view($page, $datas);
        $this->view('templates/footerAdmin');
    }

    public function login() {
        if ($this->getParam(2) == "logar") {
            $user = (preg_match("/^[a-z]+?/i", filter_input(INPUT_POST, 'login', FILTER_DEFAULT))) ? filter_input(INPUT_POST, 'login', FILTER_DEFAULT) : "Usuário incorreto!!!"; // +? ->quantas quiser; /i ->case-insensitive
            $this->auth->setTableName('autores')
                    ->setUserColumn('login')
                    ->setPassColumn('senha')
                    ->setUser($user)
                    ->setPass(crypt(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT), '$2a$' . $this->custo . '$' . $this->salt . '$'))
                    ->setLoginControllerAction('admin', 'index')
                    ->login();
        }


        $this->showPages('login/adminLogin');
    }

    public function logout() {
        $this->auth->setLogoutControllerAction('index', 'index')
                ->logout();
    }

    public function Index_action() {
        $redirector = new redirectorHelper();
        $redirector->goToUrl('/admin/gerenciar/artigos');
    }

    public function upload() {
        $redirect = new redirectorHelper();
        if ($this->getParam(2) == "do") {
            if (count($_FILES) > 0) {
                $upload = new uploadMHelper();
                $upload->setFile($_FILES['files'])
                        ->setPath(filter_input(INPUT_POST, 'diretorio_padrao', FILTER_DEFAULT) . $_POST['diretorio_secundario'] . '/')
                        ->upload();

                $redirect->goToUrl('/admin/upload/');
            }
        }
        $this->showPages('upload/multiUpload');
    }

    public function gerenciar() {
        $secao = $this->getParam(2);
        $db = $this->db;

        switch ($secao) {
            case "artigos":
                $db->_tabela = $secao;
                $sql = $db->mostrarArtigos();
                break;
            case "videos":
                $db->_tabela = $secao;
                $sql = $db->mostrarVideos();
                break;
            default: # Servirá para as tabelas 'categorias_artigos', 'categorias_videos','albuns','autores'
                $db->_tabela = $secao;
                $sql = $db->listaDados();
        }

        $datas['secao'] = $secao;
        $datas['sql'] = $sql;

        $s = explode('_', $secao); //Para formar a lógica abaixo com categorias_artigos -> artigos/categorias, p.ex.
        $this->showPages((isset($s[1]) ? $s[1] . '/' . $s[0] : $s[0]) . '/gerenciar', $datas);
    }

    public function cadastrar() {
        $secao = $this->getParam(2);
        $redirect = new redirectorHelper();

        $db = $this->db;
        $db->_tabela = $secao;

        if ($this->getParam(3) == "do") {
            if (count($_FILES) > 0) {
                $upload = new uploadHelper();
                $upload->setFile($_FILES['imagem'])
                        ->setPath('/web_files/imagens/artigos/')
                        ->upload();
            }
            switch ($secao) {
                case 'artigos':
                    $db->inserirArtigos(addslashes($_POST['titulo']), addslashes($_POST['artigo']), $_FILES['imagem']['name'], $_POST['data'], $_POST['categorias_id'], $_POST['autor']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case 'categorias_artigos':
                    $db->inserirCategorias($_POST['categoria'], $_POST['slug_categoria'], $_POST['data']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case 'albuns':
                    $dirImagens = "web_files/imagens/albuns/" . $_POST['slug_titulo'];
                    $listaImagens = glob($dirImagens . '/*'); //acesso a pasta com o album e listo as imagens
                    $imagens = implode(', ', str_replace($dirImagens . '/', "", $listaImagens)); //Insiro vírgulas entre os nomes
                    $db->inserirAlbuns(addslashes($_POST['titulo']), $_POST['slug_titulo'], addslashes($_POST['descricao']), $imagens, $_POST['data'], $_POST['autor']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case 'videos':
                    $db->inserirVideos($_POST['categorias_id'], addslashes($_POST['titulo']), $_POST['thumbnail'], addslashes($_POST['descricao']), $_POST['codigo'], $_POST['autor'], $_POST['data']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case 'categorias_videos':
                    $db->inserirCategorias($_POST['categoria'], $_POST['slug_categoria'], $_POST['data']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case "autores":
                    $senha = crypt($_POST['senha'], '$2a$' . $this->custo . '$' . $this->salt . '$');
                    $db->insereUsuarios($_POST['login'], $_POST['nome'], $_POST['apelido'], $_POST['email'], $senha, $_POST['nivel'], $_POST['data'], $_POST['status']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
            }
        }

        $datas['secao'] = $this->getParam(2);

        /*         * *
         * Colocando aqui não sobrepõe $db->_tabela que
         * estava apontando para autores qdo chamava artigos
         */
//Listando as categorias
        $cat_art = $this->db;
        $cat_art->_tabela = "categorias_artigos";
        $categorias_art = $cat_art->listaDados();

        $cat_vid = $this->db;
        $cat_vid->_tabela = "categorias_videos";
        $categorias_vid = $cat_vid->listaDados();

//Listando os autores
        $user = $this->db;
        $user->_tabela = "autores";
        $autores = $user->listaDados();

        $datas['categorias_art'] = $categorias_art;
        $datas['categorias_vid'] = $categorias_vid;
        $datas['autores'] = $autores;

        $s = explode('_', $secao); //Para formar a lógica abaixo com categorias_artigos -> artigos/categorias, p.ex.
        $this->showPages((isset($s[1]) ? $s[1] . '/' . $s[0] : $s[0]) . '/cadastrar', $datas);
    }

    public function editar() {
        $redirect = new redirectorHelper();
        $secao = $this->getParam(2);
        $id = $this->getParam(3);
        $db = $this->db;

        switch ($secao) {
            case 'artigos':
                $db->_tabela = $secao;
                $sql = $db->mostrarArtigosId($id);
                break;
            case 'albuns':
                $db->_tabela = $secao;
                $sql = $db->mostrarImagensPorAlbum($id);
                break;
            case 'videos':
                $db->_tabela = $secao;
                $sql = $db->mostrarVideosId($id);
                break;
            default:
                $db->_tabela = $secao;
                $sql = $db->dadosAtuais("id='$id'");
                break;
        }

        if ($this->getParam(4) == "do") {
            if (count($_FILES) > 0) {
                $upload = new uploadHelper();
                $upload->setFile($_FILES['imagem'])
                        ->setPath('/web_files/imagens/artigos/')
                        ->upload();
            }
            switch ($secao) {

                case "artigos":
                    $imagem = (!isset($_FILES['imagem']['name']) || $_FILES['imagem']['name'] == NULL) ? $_POST['imagem'] : $_FILES['imagem']['name'];
                    $db->alterarArtigo($id, addslashes($_POST['titulo']), addslashes($_POST['artigo']), $imagem, $_POST['data'], $_POST['categorias_id'], $_POST['autor']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case "categorias_artigos":
                    $db->alterarCategorias($id, $_POST['categoria'], $_POST['slug_categoria'], $_POST['data']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case 'albuns':
                    $dirImagens = "web_files/imagens/albuns/" . $_POST['slug_titulo'];
                    $listaImagens = glob($dirImagens . '/*'); //acesso a pasta com o album e listo as imagens
                    $imagens = implode(', ', str_replace($dirImagens . '/', "", $listaImagens)); //Insiro vírgulas entre os nomes
                    $db->alterarAlbuns($id, addslashes($_POST['titulo']), $_POST['slug_titulo'], addslashes($_POST['descricao']), $imagens, $_POST['data'], $_POST['autor']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case 'videos':
                    $db->alterarVideo($id, $_POST['categorias_id'], addslashes($_POST['titulo']), $_POST['thumbnail'], addslashes($_POST['descricao']), $_POST['codigo'], $_POST['autor'], $_POST['data']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case "categorias_videos":
                    $db->alterarCategorias($id, $_POST['categoria'], $_POST['slug_categoria'], $_POST['data']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
                case "autores":
                    $senha = crypt($_POST['senha'], '$2a$' . $this->custo . '$' . $this->salt . '$');
                    $db->alteraUsuarios($id, $_POST['login'], $_POST['nome'], $_POST['apelido'], $_POST['email'], $senha, $_POST['nivel'], $_POST['data'], $_POST['status']);
                    $redirect->goToUrl('/admin/gerenciar/' . $secao);
                    break;
            }
        }

        $datas['secao'] = $secao;
        $datas['id'] = $id;
        $datas['dados'] = $sql[0];

//Listando as categorias de artigos
        $cat = $this->db;
        $cat->_tabela = "categorias_artigos";
        $categorias = $cat->listaDados();

        //Listando as categorias de videos
        $catv = $this->db;
        $catv->_tabela = "categorias_videos";
        $categoriasv = $catv->listaDados();

//Listando os autores
        $user = $this->db;
        $user->_tabela = "autores";
        $autores = $user->listaDados();

        $datas['categorias_artigos'] = $categorias;
        $datas['categorias_videos'] = $categoriasv;
        $datas['autores'] = $autores;

        $s = explode('_', $secao); //Para formar a lógica abaixo com categorias_artigos -> artigos/categorias, p.ex.
        $this->showPages((isset($s[1]) ? $s[1] . '/' . $s[0] : $s[0]) . '/editar', $datas);

    }

    public function aprovar() {
        $secao = $this->getParam(2);
        $id = $this->getParam(3);
        $valor = $this->getParam(4);
        $redirect = new redirectorHelper();

        $db = $this->db;
        $db->_tabela = $secao;

        if ($valor == "Não") {
            $db->aprovar($id, "Sim");
        } else {
            $db->aprovar($id, "Não");
        }
        $redirect->goToUrl('/admin/gerenciar/' . $secao);
    }

    public function deletar() {
        $id = $this->getParam(3);
        $secao = $this->getParam(2);

        $db = $this->db;
        $db->_tabela = $secao;

        $db->deletarDado($id);

        $redirector = new redirectorHelper();
        $redirector->goToUrl('/admin/gerenciar/' . $secao);
    }

}
