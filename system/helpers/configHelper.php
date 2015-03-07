<?php

class ConfigHelper {

    public $web_root = 'http://testes.mervy.net';
    public $titulo = 'Site base MVC';
    public $descricao = 'Site usado para base para criação de novos sites';
    public $palavras_chaves = 'base, php, mvc, site base, esqueleto, pontapé inicial, iniciando o site';

    function getWeb_root() {
        return $this->web_root;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getPalavras_chaves() {
        return $this->palavras_chaves;
    }

}
