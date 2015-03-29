<?php

class adminModel extends Model
{
    public function listaDados()
    {
        return $this->read(null, null, null, null, 'id desc');
    }

    public function dadosAtuais($where)
    {
        return $this->read(null, null, null, $where, 'id desc');
    }

    public function mostrarArtigos()
    {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        return $this->read('A.*, C.categoria, U.apelido', 'A', 'INNER JOIN categorias_artigos C ON A.categorias_id = C.id
INNER JOIN autores U ON A.autor = U.id', null, 'A.id ASC'
        );
    }

    public function mostrarArtigosId($id)
    {
        return $this->read('A.*, C.categoria, U.*', 'A', "INNER JOIN categorias_artigos C ON (A.id = $id AND A.categorias_id=C.id)
                    INNER JOIN autores U ON (A.autor = U.id)
                ");
    }

    public function inserirCategorias($categoria, $slug, $data)
    {
        return $this->insert(array(
                    'id' => null,
                    'categoria' => $categoria,
                    'slug_categoria' => $slug,
                    'data' => $data,
        ));
    }

    public function alterarCategorias($id, $categoria, $slug, $data)
    {
        $this->update(array(
            'id' => $id,
            'categoria' => $categoria,
            'slug_categoria' => $slug,
            'data' => $data,
                ), 'id='.$id);
    }

    public function inserirArtigos($titulo, $artigo, $imagem, $data, $categorias_id, $autor)
    {
        return $this->insert(array(
                    'id' => null,
                    'titulo' => $titulo,
                    'artigo' => $artigo,
                    'imagem' => $imagem,
                    'data' => $data,
                    'aprovar' => 'Não',
                    'categorias_id' => $categorias_id,
                    'autor' => $autor,
        ));
    }

    public function alterarArtigo($id, $titulo, $artigo, $imagem, $data, $categorias_id, $autor)
    {
        return $this->update(array(
                    'id' => $id,
                    'titulo' => $titulo,
                    'artigo' => $artigo,
                    'imagem' => $imagem,
                    'data' => $data,
                    'aprovar' => 'Não',
                    'categorias_id' => $categorias_id,
                    'autor' => $autor,
                        ), 'id='.$id);
    }

    public function insereUsuarios($login, $nome, $apelido, $email, $senha, $nivel, $data, $status)
    {
        return $this->insert(array(
                    'id' => null,
                    'login' => $login,
                    'nome' => $nome,
                    'apelido' => $apelido,
                    'email' => $email,
                    'senha' => $senha,
                    'nivel' => $nivel,
                    'data' => $data,
                    'status' => $status,
        ));
    }

    public function alteraUsuarios($id, $login, $nome, $apelido, $email, $senha, $nivel, $data, $status)
    {
        return $this->update(array(
                    'id' => $id,
                    'login' => $login,
                    'nome' => $nome,
                    'apelido' => $apelido,
                    'email' => $email,
                    'senha' => $senha,
                    'nivel' => $nivel,
                    'data' => $data,
                    'status' => $status,
                        ), 'id='.$id);
    }

    /**
     * Regra para os álbuns.
     *
     * @param type $id
     *
     * @return type
     */
    public function mostrarImagensPorAlbum($id)
    {
        //select g.*, u.apelido as autor from galeria g inner join autores u on (g.autor = u.id) where g.id =1
        return $this->read('G.*, U.*', 'G', "INNER JOIN autores U ON (G.autor = U.id) WHERE G.id = $id");
    }

    public function inserirAlbuns($titulo, $slug_titulo, $descricao, $imagens, $data, $autor)
    {
        return $this->insert(array(
                    'id' => null,
                    'titulo' => $titulo,
                    'slug_titulo' => $slug_titulo,
                    'descricao' => $descricao,
                    'imagens' => $imagens,
                    'data' => $data,
                    'aprovar' => 'Não',
                    'autor' => $autor,
        ));
    }

    public function alterarAlbuns($id, $titulo, $slug_titulo, $descricao, $imagens, $data, $autor)
    {
        return $this->update(array(
                    'id' => $id,
                    'titulo' => $titulo,
                    'slug_titulo' => $slug_titulo,
                    'descricao' => $descricao,
                    'imagens' => $imagens,
                    'data' => $data,
                    'aprovar' => 'Não',
                    'autor' => $autor,
                        ), 'id='.$id);
    }

    /**
     * Regras para os vídeos.
     */
    public function mostrarVideos()
    {
        //$this->read($fields, $nick, $sql, $where, $orderby, $limit, $offset)
        return $this->read('V.*, C.categoria, U.apelido', 'V', 'INNER JOIN categorias_videos C ON V.categorias_id = C.id
INNER JOIN autores U ON V.autor = U.id', null, 'V.id ASC'
        );
    }

    public function mostrarVideosId($id)
    {
        return $this->read('V.*, C.categoria, U.apelido, U.id as id_autor', 'V', "INNER JOIN categorias_videos C ON (V.id = $id AND V.categorias_id=C.id)
                    INNER JOIN autores U ON (V.autor = U.id)
                ");
    }

    public function inserirVideos($categoria, $titulo, $thumbnail, $descricao, $codigo, $autor, $data)
    {
        return $this->insert(array(
                    'id' => null,
                    'categorias_id' => $categoria,
                    'titulo' => $titulo,
                    'thumbnail' => $thumbnail,
                    'descricao' => $descricao,
                    'codigo' => $codigo,
                    'autor' => $autor,
                    'data' => $data,
                    'aprovar' => 'Não',
        ));
    }

    public function alterarVideo($id, $categoria, $titulo, $thumbnail, $descricao, $codigo, $autor, $data)
    {
        return $this->update(array(
                    'id' => $id,
                    'categorias_id' => $categoria,
                    'titulo' => $titulo,
                    'thumbnail' => $thumbnail,
                    'descricao' => $descricao,
                    'codigo' => $codigo,
                    'autor' => $autor,
                    'data' => $data,
                    'aprovar' => 'Não',
                        ), 'id='.$id);
    }

    /**
     * Regras para todos os controllers.
     *
     * @param type $id
     * @param type $dado
     *
     * @return type
     */
    public function aprovar($id, $dado)
    {
        return $this->update(array(
                    'aprovar' => $dado,
                        ), 'id='.$id);
    }

    public function deletarDado($id)
    {
        return $this->delete('id='.$id);
    }
}
