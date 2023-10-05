<?php


require_once "CargoModel.php";

class FuncionarioModel{

    private $id;
    private $nome;
    private $sobrenome;
    private $dataNascimento;
    private $salario;
    private $codCargo;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function setSalario($salario)
    {
        $this->salario = $salario;
    }

    public function getSalario()
    {
        return $this->salario;
    }

    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
    }

    public function getCodCargo()
    {
        return $this->codCargo;
    }
}