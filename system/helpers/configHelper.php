<?php

class configHelper
{
    public $web_root = 'http://www.mvcblog.com.br';
    public $titulo = 'mvc Blog - Base para Outros Sites';
    public $descricao = 'Site usado para base para criação de novos sites';
    public $palavras_chaves = 'base, php, mvc, site base, esqueleto, pontapé inicial, iniciando o site';

    public function getWeb_root()
    {
        return $this->web_root;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getPalavras_chaves()
    {
        return $this->palavras_chaves;
    }
}
