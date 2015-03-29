<?php

/**
 * Inserir em controller_post (tipo blog_post.phtml, videos_post.phtml, etc
 * o seguinte código:.
 */
class contadorHelper extends System
{
    public $acessos;

    public function contarLinks($controller)
    {
        $urls = file('app/views/contador_'.$controller.'.php');
        $this->acessos = array_count_values($urls);
        arsort($this->acessos); //ordena decrescente pelos valores do array
        return $this->acessos;
    }
}
