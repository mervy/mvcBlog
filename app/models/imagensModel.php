<?php

class imagensModel extends Model {

    public function mostrarTudo() {
        return $this->read();
    }

    public function mostrarAlbunsIndex($qtd) {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        return $this->read(
                        'G.*, U.apelido as autor', 'G', 'INNER JOIN autores U ON (G.autor = U.id)', "G.aprovar = 'Sim'", 'G.data DESC', $qtd);
    }

    public function mostrarAlbuns($offset = null) {
        return $this->read('G.*, U.apelido as autor', 'G', 'INNER JOIN autores U ON (G.autor = U.id)', "G.aprovar = 'Sim'", 'G.data DESC', 100000000, $offset);
    }

    public function mostrarImagensPorAlbum($id) {
        //select g.*, u.apelido as autor from imagens g inner join autores u on (g.autor = u.id) where g.id =1
        return $this->read('G.*, U.apelido as autor', 'G', "INNER JOIN autores U ON (G.autor = U.id) WHERE G.id = $id");
    }

}
