<?php


class Autoloader
{
    public static function load($class)
    {
        if (file_exists('Lib/' . $class . '.php'))
            require_once 'Lib/' . $class . '.php';
    }
}

spl_autoload_register(['Autoloader', 'load']);


class Application
{
    protected $controller;
    protected $action;

    private function loadRoute()
    {
        $this->controller = $_REQUEST['controle'];
        $this->action = $_REQUEST['acao'];
    }

    public function dispatch()
    {
        $this->loadRoute();

        //verificando se o arquivo de controle existe
        $controller_file = 'Controllers/' . $this->controller . 'Controller.php';
        if (file_exists($controller_file))
            require_once $controller_file;
        else {
            $menssagem = "O Arquivo " . $this->controller .
                "Controller.php não foi encontrado";
            $this->redirect("ErroPage.php?menssagem=" . $menssagem);
            die();
        }
        //verificando se a classe existe
        $class = $this->controller . 'Controller';
        if (class_exists($class))
            $o_class = new $class;
        else {
            $menssagem = "A classe '$class' não existe no arquivo '$controller_file'";
            $this->redirect("ErroPage.php?menssagem=" . $menssagem);
            die();
        }

        //verificando se o metodo existe
        $method = $this->action . 'Action';
        if (method_exists($o_class, $method))
            $o_class->$method();
        else {
            $menssagem = "Metodo '$method' nao existe na classe $class'";
            $this->redirect("ErroPage.php?menssagem=" . $menssagem);
            die();
        }
    }

    static function redirect($uri)
    {
        header("Location: $uri");
    }
}
