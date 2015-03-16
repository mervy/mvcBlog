<?php

class Controller extends System {

    protected function view($nome, $vars = null) {
        if (is_array($vars) && count($vars) > 0)
            extract($vars, EXTR_PREFIX_ALL, 'view');

        $file = VIEWS . $this->_controller . DIRECTORY_SEPARATOR . $nome . '.phtml';

        if (!file_exists($file))
            die("Houve um erro. View *$file* nao existe.");

        require_once( $file );
    }

    protected function showPages($page, $dados = null) {
        $this->view('../templates/header');
        $this->view($page, $dados);
        $this->view('../templates/footer');
    }

    public function init() {
        
    }

}
