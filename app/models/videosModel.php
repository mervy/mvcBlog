<?php

class videosModel extends Model {

    public function mostrarTudo() {
        return $this->read();
    }

    public function mostrarVideosIndex($qtd) {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        return $this->read(
                        'V.*, C.categoria, C.slug_categoria, U.apelido as autor', 'V', 'INNER JOIN categorias_videos C ON (V.categorias_id = C.id) 
                 INNER JOIN autores U ON (V.autor = U.id)', "V.aprovar = 'Sim'", 'V.data DESC', $qtd);
    }

    public function mostrarVideos($offset = null) {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        //BUG: Não é possível usar offset sem limit, daí definir 'limit 10000000'
        return $this->read(
                        'V.*, C.categoria, C.slug_categoria, U.apelido as autor', 'V', 'INNER JOIN categorias_videos C ON (V.categorias_id = C.id) 
                 INNER JOIN autores U ON (V.autor = U.id)', "V.aprovar = 'Sim'", 'V.data DESC', 100000000, $offset);
    }

    public function mostrarVideosId($id) {
        return $this->read(
                        'V.*, C.categoria, C.slug_categoria, U.apelido as autor', 'V', "INNER JOIN categorias_videos C ON (V.id = $id AND V.categorias_id=C.id)
                    INNER JOIN autores U ON (V.autor = U.id)               
                ");
    }

    public function mostrarVideosCategoria($cat) {
        return $this->read('V.*, C.categoria, C.slug_categoria, U.apelido as autor', 'V', 'INNER JOIN categorias_videos C ON (V.categorias_id = C.id) 
                 INNER JOIN autores U ON (V.autor = U.id)', "V.aprovar = 'Sim' AND C.slug_categoria = '$cat'", 'V.data DESC');
    }

}
