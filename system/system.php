<?php

class system
{
    private $_url;
    private $_explode;
    public $_controller;
    public $_action;
    public $_params;

    public function __construct()
    {
        $this->setUrl();
        $this->setExplode();
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

    private function setUrl()
    {
        $_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : 'index/index_action');
        $this->_url = $_GET['url'].'/';
        echo(!filter_var($this->_url, FILTER_VALIDATE_URL)) ? '' : 'URL tem caracteres não permitidos';
    }

    private function setExplode()
    {
        $this->_explode = explode('/', $this->_url);
    }

    private function setController()
    {
        $this->_controller = $this->_explode[0];
    }

    private function setAction()
    {
        $ac = (!isset($this->_explode[1]) || $this->_explode[1] == null || $this->_explode[1] == 'index' ? 'index_action' : $this->_explode[1]);
        $this->_action = $ac;
    }

    public function setParams()
    {
        $this->_url = (isset($_GET['url'])) ? explode('/', $_GET['url']) : array('');
    }

    public function getParam($key)
    {
        if (array_key_exists($key, $this->_url)) {
            return $this->_url[$key];
        } else {
            return false;
        }
    }

    public function run()
    {
        $controller_path = CONTROLLERS.$this->_controller.DIRECTORY_SEPARATOR.$this->_controller.'Controller.php';

        if (!file_exists($controller_path)) {
            die('Houve um erro. O controller nao existe.');
        }

        require_once $controller_path;
        $app = new $this->_controller();

        if (!method_exists($app, $this->_action)) {
            die('Esta action nao existe.');
        }

        $action = $this->_action;
        $app->init();
        $app->$action();
    }
}
