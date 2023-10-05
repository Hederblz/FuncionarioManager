CREATE TABLE IF NOT EXISTS `Funcionariosdb`.`tbCargo` (
  `idTbCargo` INT NOT NULL AUTO_INCREMENT,
  `Descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`idTbCargo`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Funcionariosdb`.`tbFuncionario` (
  `idtbFuncionario` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(45) NOT NULL,
  `Sobrenome` VARCHAR(45) NOT NULL,
  `DataNascimento` DATE NOT NULL,
  `Salario` DECIMAL(10, 2) NOT NULL,
  `CodTbCargo` INT NOT NULL,
  PRIMARY KEY (`idtbFuncionario`),
  CONSTRAINT `fk_tbFuncionarios_tbCargos1`
    FOREIGN KEY (`CodTbCargo`)
    REFERENCES `Funcionariosdb`.`tbCargo` (`idTbCargo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;