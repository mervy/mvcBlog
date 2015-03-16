<?php

class Sobre extends Controller {

    public $config;

    public function init() {
        $this->config = new configHelper();
    }

    public function Index_action() {
        $this->showPages('sobre');
    }

}
