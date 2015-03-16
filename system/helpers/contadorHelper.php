<?php
/**
 * Inserir em controller_post (tipo blog_post.phtml, videos_post.phtml, etc
 * o seguinte código:
 * 
 <?php
    if ($this->getParam(4) != null) {//se existe a id            
        $actual =  $view_res['categoria'].','.$view_res['titulo'].','.$view_res['id'];
        $fp = fopen("app/views/contador.php", "a+");
        fwrite($fp, $actual . "\n"); // grava a string no arquivo. Se o arquivo não existir ele será criado
        fclose($fp);
    }
?>
 */

class ContadorHelper extends System {

    public $acessos;

    public function contarLinks($controller) {
        $urls = file("app/views/contador_".$controller.".php");
        $this->acessos = array_count_values($urls);
        arsort($this->acessos); //ordena decrescente pelos valores do array
        return $this->acessos;
    }

}
