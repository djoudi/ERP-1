SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `pessoas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pessoas` ;

CREATE  TABLE IF NOT EXISTS `pessoas` (
  `pessoa_id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(230) NULL ,
  `endereco` VARCHAR(255) NULL ,
  PRIMARY KEY (`pessoa_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `clientes` ;

CREATE  TABLE IF NOT EXISTS `clientes` (
  `cliente_id` INT NOT NULL AUTO_INCREMENT ,
  `responsavel` INT NOT NULL ,
  `cnpj` VARCHAR(15) NOT NULL ,
  `razaoSocial` VARCHAR(140) NOT NULL ,
  `endereco` VARCHAR(255) NOT NULL ,
  `senhaAtendimento` VARCHAR(4) NULL ,
  `numeroCliente` VARCHAR(45) NULL ,
  `usuarioGestor` VARCHAR(45) NULL ,
  `senhaGestor` VARCHAR(45) NULL ,
  PRIMARY KEY (`cliente_id`) ,
  UNIQUE INDEX `cnpj_UNIQUE` (`cnpj` ASC) ,
  INDEX `fk_empresas_pessoas1_idx` (`responsavel` ASC) ,
  CONSTRAINT `fk_empresas_pessoas1`
    FOREIGN KEY (`responsavel` )
    REFERENCES `pessoas` (`pessoa_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuarios` ;

CREATE  TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT ,
  `pessoa` INT NOT NULL ,
  `senha` VARCHAR(15) NOT NULL ,
  `permissao` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`usuario_id`) ,
  INDEX `fk_usuario_pessoa_idx` (`pessoa` ASC) ,
  UNIQUE INDEX `pessoa_id_UNIQUE` (`pessoa` ASC) ,
  CONSTRAINT `fk_usuario_pessoa`
    FOREIGN KEY (`pessoa` )
    REFERENCES `pessoas` (`pessoa_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sessoes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sessoes` ;

CREATE  TABLE IF NOT EXISTS `sessoes` (
  `hash` VARCHAR(255) NOT NULL ,
  `usuario` INT NOT NULL ,
  `data_criacao` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`hash`) ,
  INDEX `fk_sessao_usuario1_idx` (`usuario` ASC) ,
  UNIQUE INDEX `hash_UNIQUE` (`hash` ASC) ,
  CONSTRAINT `fk_sessao_usuario1`
    FOREIGN KEY (`usuario` )
    REFERENCES `usuarios` (`usuario_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `registros` ;

CREATE  TABLE IF NOT EXISTS `registros` (
  `registro_id` INT NOT NULL AUTO_INCREMENT ,
  `empresa` INT NOT NULL ,
  `autor` INT NOT NULL ,
  `titulo` VARCHAR(140) NULL ,
  `descricao` TEXT NULL ,
  `data_criacao` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`registro_id`) ,
  INDEX `fk_registros_empresas1_idx` (`empresa` ASC) ,
  INDEX `fk_registros_usuarios1_idx` (`autor` ASC) ,
  CONSTRAINT `fk_registros_empresas1`
    FOREIGN KEY (`empresa` )
    REFERENCES `clientes` (`cliente_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registros_usuarios1`
    FOREIGN KEY (`autor` )
    REFERENCES `usuarios` (`usuario_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
