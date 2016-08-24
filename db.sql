-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sitebuilder
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sitebuilder
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sitebuilder` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `sitebuilder` ;

-- -----------------------------------------------------
-- Table `sitebuilder`.`typeuser`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`typeuser` (
  `id_typeuser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id_typeuser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `login` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `numlogin` INT NULL DEFAULT 0,
  `date` TIMESTAMP NULL,
  `id_typeuser` INT NOT NULL,
  `lastlogin` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` ENUM('ACTIVE', 'INACTIVE') NULL,
  `path` VARCHAR(145) NULL,
  PRIMARY KEY (`id_user`),
  INDEX `fk_user_typeuser1_idx` (`id_typeuser` ASC),
  CONSTRAINT `fk_user_typeuser1`
    FOREIGN KEY (`id_typeuser`)
    REFERENCES `sitebuilder`.`typeuser` (`id_typeuser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`newsletter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`newsletter` (
  `id_newsletter` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(120) NULL,
  `data` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_newsletter`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`post` (
  `id_post` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  `summary` VARCHAR(250) NULL,
  `content` TEXT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `views` INT NULL DEFAULT 0,
  `status` ENUM('DRAFT', 'PUBLISHED') NULL,
  `id_user` INT NOT NULL,
  `path` VARCHAR(85) NULL,
  `mainpicture` VARCHAR(300) NULL COMMENT 'Guarda a imagem principal do post',
  `type` ENUM('post', 'page', 'product') NULL,
  `slug` VARCHAR(145) NULL,
  PRIMARY KEY (`id_post`),
  INDEX `fk_post_user2_idx` (`id_user` ASC),
  CONSTRAINT `fk_post_user2`
    FOREIGN KEY (`id_user`)
    REFERENCES `sitebuilder`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`comment` (
  `id_comment` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(200) NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` INT NOT NULL,
  `id_post` INT NOT NULL,
  PRIMARY KEY (`id_comment`),
  INDEX `fk_comment_user1_idx` (`id_user` ASC),
  INDEX `fk_comment_post1_idx` (`id_post` ASC),
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `sitebuilder`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_post1`
    FOREIGN KEY (`id_post`)
    REFERENCES `sitebuilder`.`post` (`id_post`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`typecategory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`typecategory` (
  `id_typecategory` INT NOT NULL COMMENT '  ',
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id_typecategory`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`category` (
  `id_category` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `id_typecategory` INT NOT NULL,
  PRIMARY KEY (`id_category`),
  INDEX `fk_category_typecategory1_idx` (`id_typecategory` ASC),
  CONSTRAINT `fk_category_typecategory1`
    FOREIGN KEY (`id_typecategory`)
    REFERENCES `sitebuilder`.`typecategory` (`id_typecategory`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`post_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`post_category` (
  `id_post` INT NOT NULL,
  `id_category` INT NOT NULL,
  PRIMARY KEY (`id_post`, `id_category`),
  INDEX `fk_post_has_category_category1_idx` (`id_category` ASC),
  INDEX `fk_post_has_category_post1_idx` (`id_post` ASC),
  CONSTRAINT `fk_post_has_category_post1`
    FOREIGN KEY (`id_post`)
    REFERENCES `sitebuilder`.`post` (`id_post`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_has_category_category1`
    FOREIGN KEY (`id_category`)
    REFERENCES `sitebuilder`.`category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`permission` (
  `id_permission` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id_permission`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`datalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`datalog` (
  `id_datalog` INT NOT NULL AUTO_INCREMENT,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` INT NOT NULL,
  `id_post` INT NULL,
  `ip` VARCHAR(45) NULL,
  PRIMARY KEY (`id_datalog`),
  INDEX `fk_datalog_user1_idx` (`id_user` ASC),
  INDEX `fk_datalog_post1_idx` (`id_post` ASC),
  CONSTRAINT `fk_datalog_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `sitebuilder`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datalog_post1`
    FOREIGN KEY (`id_post`)
    REFERENCES `sitebuilder`.`post` (`id_post`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`like`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`like` (
  `id_like` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `placing` INT NULL COMMENT 'Nota de 1 a 5 para o projeto.',
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `id_post` INT NOT NULL,
  PRIMARY KEY (`id_like`),
  INDEX `fk_like_user1_idx` (`id_user` ASC),
  INDEX `fk_like_post1_idx` (`id_post` ASC),
  CONSTRAINT `fk_like_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `sitebuilder`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_like_post1`
    FOREIGN KEY (`id_post`)
    REFERENCES `sitebuilder`.`post` (`id_post`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`typeuser_permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`typeuser_permission` (
  `id_typeuser` INT NOT NULL,
  `id_permission` INT NOT NULL,
  PRIMARY KEY (`id_typeuser`, `id_permission`),
  INDEX `fk_typeuser_has_permission_permission1_idx` (`id_permission` ASC),
  INDEX `fk_typeuser_has_permission_typeuser1_idx` (`id_typeuser` ASC),
  CONSTRAINT `fk_typeuser_has_permission_typeuser1`
    FOREIGN KEY (`id_typeuser`)
    REFERENCES `sitebuilder`.`typeuser` (`id_typeuser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_typeuser_has_permission_permission1`
    FOREIGN KEY (`id_permission`)
    REFERENCES `sitebuilder`.`permission` (`id_permission`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`event` (
  `id_event` INT NOT NULL COMMENT ' ',
  `title` VARCHAR(145) NULL,
  `date` TIMESTAMP NULL,
  `content` TEXT NULL,
  `path` VARCHAR(45) NULL,
  `id_user` INT NOT NULL,
  PRIMARY KEY (`id_event`),
  INDEX `fk_event_user1_idx` (`id_user` ASC),
  CONSTRAINT `fk_event_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `sitebuilder`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`product` (
  `id_product` INT NOT NULL,
  `name` VARCHAR(145) NULL,
  `data` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` INT NOT NULL,
  `status` ENUM('ACTIVE', 'INACTIVE') NULL,
  `path` VARCHAR(145) NULL,
  `mainpicture` VARCHAR(145) NULL,
  `slug` VARCHAR(145) NULL,
  PRIMARY KEY (`id_product`),
  INDEX `fk_product_user1_idx` (`id_user` ASC),
  CONSTRAINT `fk_product_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `sitebuilder`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sitebuilder`.`product_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sitebuilder`.`product_category` (
  `id_product` INT NOT NULL,
  `id_category` INT NOT NULL,
  PRIMARY KEY (`id_product`, `id_category`),
  INDEX `fk_product_has_category_category1_idx` (`id_category` ASC),
  INDEX `fk_product_has_category_product1_idx` (`id_product` ASC),
  CONSTRAINT `fk_product_has_category_product1`
    FOREIGN KEY (`id_product`)
    REFERENCES `sitebuilder`.`product` (`id_product`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_category_category1`
    FOREIGN KEY (`id_category`)
    REFERENCES `sitebuilder`.`category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sitebuilder`.`typeuser`
-- -----------------------------------------------------
START TRANSACTION;
USE `sitebuilder`;
INSERT INTO `sitebuilder`.`typeuser` (`id_typeuser`, `name`) VALUES (1, 'Membro');
INSERT INTO `sitebuilder`.`typeuser` (`id_typeuser`, `name`) VALUES (2, 'Moderador');
INSERT INTO `sitebuilder`.`typeuser` (`id_typeuser`, `name`) VALUES (3, 'Administrador');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sitebuilder`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `sitebuilder`;
INSERT INTO `sitebuilder`.`user` (`id_user`, `name`, `login`, `password`, `email`, `numlogin`, `date`, `id_typeuser`, `lastlogin`, `status`, `path`) VALUES (1, 'Filipe Rodrigues', 'filiperdo', '0871', 'frodrigues@anacom.com.br', NULL, '2016-06-01', 1, NULL, 'ACTIVE', NULL);

COMMIT;

