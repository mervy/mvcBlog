<?php

class noticiasModel extends Model {

    public function mostrarTudo() {
        return $this->read();
    }

    public function mostrarNoticiasIndex($qtd) {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        return $this->read(
                        'N.*, C.categoria, C.slug_categoria, U.apelido as autor', 'N', 'INNER JOIN categorias_noticias C ON (N.categorias_id = C.id) 
                 INNER JOIN autores U ON (N.autor = U.id)', "N.aprovar = 'Sim'", 'N.data DESC', $qtd);
    }

    public function mostrarNoticias($offset = null) {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        //BUG: Não é possível usar offset sem limit, daí definir 'limit 10000000'
        return $this->read(
                        'N.*, C.categoria, C.slug_categoria, U.apelido as autor', 'N', 'INNER JOIN categorias_noticias C ON (N.categorias_id = C.id) 
                 INNER JOIN autores U ON (N.autor = U.id)', "N.aprovar = 'Sim'", 'N.data DESC', 100000000, $offset);
    }

    public function mostrarArtigosId($id) {
        return $this->read(
                        'A.*, C.categoria,C.slug_categoria, U.apelido as autor', 'A', "INNER JOIN categorias_artigos C ON (A.id = $id AND A.categorias_id=C.id)
                    INNER JOIN autores U ON (A.autor = U.id)               
                ");
    }

    public function mostrarArtigosCategoria($cat) {
        return $this->read('A.*, C.categoria, C.slug_categoria, U.apelido as autor', 'A', 'INNER JOIN categorias_artigos C ON (A.categorias_id = C.id) 
                 INNER JOIN autores U ON (A.autor = U.id)', "A.aprovar = 'Sim' AND C.slug_categoria = '$cat'", 'A.data DESC');
    }

}
