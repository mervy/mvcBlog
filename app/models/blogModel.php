<?php

class blogModel extends Model
{
    public function mostrarTudo()
    {
        return $this->read();
    }

    public function mostrarArtigosIndex($qtd)
    {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        return $this->read(
                        'A.*, C.categoria, C.slug_categoria, U.apelido as autor', 'A', 'INNER JOIN categorias_artigos C ON (A.categorias_id = C.id)
                 INNER JOIN autores U ON (A.autor = U.id)', "A.aprovar = 'Sim'", 'A.data DESC', $qtd);
    }

    public function mostrarArtigos($offset = null)
    {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        //BUG: Não é possível usar offset sem limit, daí definir 'limit 10000000'
        return $this->read(
                        'A.*, C.categoria, C.slug_categoria, U.apelido as autor', 'A', 'INNER JOIN categorias_artigos C ON (A.categorias_id = C.id)
                 INNER JOIN autores U ON (A.autor = U.id)', "A.aprovar = 'Sim'", 'A.data DESC', 100000000, $offset);
    }

    public function mostrarArtigosId($id)
    {
        return $this->read(
                        'A.*, C.categoria,C.slug_categoria, U.apelido as autor', 'A', "INNER JOIN categorias_artigos C ON (A.id = $id AND A.categorias_id=C.id)
                    INNER JOIN autores U ON (A.autor = U.id)
                ");
    }

    public function mostrarArtigosCategoria($cat)
    {
        return $this->read('A.*, C.categoria, C.slug_categoria, U.apelido as autor', 'A', 'INNER JOIN categorias_artigos C ON (A.categorias_id = C.id)
                 INNER JOIN autores U ON (A.autor = U.id)', "A.aprovar = 'Sim' AND C.slug_categoria = '$cat'", 'A.data DESC');
    }
}
