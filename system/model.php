<?php

class model
{
    protected $_db;
    protected $_dados;
    protected $_conn;
    public $_tabela;

    public function __construct()
    {
        $this->_dados = parse_ini_file('conexao.ini', true);
        $this->_conn = (filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING) !== '127.0.0.1') ? 'remoto' : 'local';
        try {
            $this->_db = new PDO('mysql:host='.$this->_dados[$this->_conn]['DB_HOST'].';dbname='.$this->_dados[$this->_conn]['DB_NAME'].'', $this->_dados[$this->_conn]['DB_USER'], $this->_dados[$this->_conn]['DB_PASS'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (PDOException $e) {
            echo 'Erro na conexão: '.$e->getMessage();
            die();
        }
    }

    public function insert(Array $dados)
    {
        $campos = implode(', ', array_keys($dados));
        $valores = "'".implode("','", array_values($dados))."'";

        return $this->_db->query(" INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores}) ");
    }

    public function read($fields = null, $nick = null, $sql = null, $where = null, $orderby = null, $limit = null, $offset = null)
    {
        $fields = ($fields != null ? $fields : '*');
        $nick = ($nick != null ? $nick : '');
        $sql = ($sql != null ? $sql : '');
        $where = ($where != null ? "WHERE {$where}" : '');
        $orderby = ($orderby != null ? "ORDER BY {$orderby}" : '');
        $limit = ($limit != null ? "LIMIT {$limit}" : '');
        $offset = ($offset != null ? "OFFSET {$offset}" : '');
        $q = $this->_db->query(" SELECT {$fields} FROM `{$this->_tabela}` {$nick} {$sql} {$where} {$orderby} {$limit} {$offset} ");
        $q->setFetchMode(PDO::FETCH_ASSOC);

        return $q->fetchAll();
    }

    public function update(Array $dados, $where)
    {
        foreach ($dados as $ind => $val) {
            $campos[] = "{$ind} = '{$val}'";
        }
        $campos = implode(', ', $campos);

        return $this->_db->query(" UPDATE `{$this->_tabela}` SET {$campos} WHERE {$where} ");
    }

    public function delete($where)
    {
        return $this->_db->query(" DELETE FROM `{$this->_tabela}` WHERE {$where} ");
    }
}
