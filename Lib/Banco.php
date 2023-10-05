<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

abstract class Banco{
	//host
	private $host = 'localhost';
	//usuario
	private $usuario = 'root';
	//senha
	private $senha = 'root';
	//banco de dados
	private $database = 'Funcionariosdb';

	public function conecta_mysql()
	{
		//criar a conexao
		try {
			$link = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
		} catch (mysqli_sql_exception $e) {
			if ($e->getCode() === 1045) {
				$menssagem = "Erro ao conectar o banco de dados, o usuario ou senha não conferem, contate o administrador do sistema";
				Application::redirect("ErroPage.php?menssagem=" . $menssagem);
				die();
			} elseif ($e->getCode() === 1045) {
				$menssagem = "Erro ao conectar o banco de dados, base de dados desconhecida, contate o administrador do sistema";
				Application::redirect("ErroPage.php?menssagem=" . $menssagem);
				die();
			} elseif ($e->getCode() === 2002) {
				$menssagem = "Erro ao conectar o banco de dados,Nenhuma a máquina de destino as recusou ativamente., contate o administrador do sistema";
				Application::redirect("ErroPage.php?menssagem=" . $menssagem);
				die();
			} else {
				$menssagem = "Erro ao conectar o banco de dados, contate o administrador do sistema";
				Application::redirect("ErroPage.php?menssagem=" . $menssagem);
				die();
			}
		}

		//ajusta o charset de comunicação entre a aplicação e o banco de dados
		mysqli_set_charset($link, 'utf8');

		return $link;
	}
}
