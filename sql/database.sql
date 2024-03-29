-- MySQL Script generated by MySQL Workbench
-- Wed 13 Jun 2018 06:08:23 PM CEST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema multiversum
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `multiversum` ;

-- -----------------------------------------------------
-- Schema multiversum
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `multiversum` DEFAULT CHARACTER SET utf8 ;
USE `multiversum` ;

-- -----------------------------------------------------
-- Table `multiversum`.`product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`product` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`product` (
  `EAN` CHAR(13) NOT NULL,
  `naam` VARCHAR(255) NOT NULL,
  `prijs` DECIMAL(9,2) NOT NULL,
  `beschrijving` TEXT NOT NULL,
  `merk` VARCHAR(255) NOT NULL,
  `resolutie` VARCHAR(100) NULL,
  `refresh rate` INT NULL,
  `gezichtsveld` INT(3) NULL,
  `aansluitingen` TEXT NULL,
  `accessoires` TEXT NULL,
  `accelerometer` TINYINT(1) NULL,
  `camera` TINYINT(1) NULL,
  `gyroscoop` TINYINT(1) NULL,
  `verstelbare lenzen` TINYINT(1) NULL,
  `magnetometer` TINYINT(1) NULL,
  `koptelefoon` TINYINT(1) NULL,
  `microfoon` TINYINT(1) NULL,
  `kleur` VARCHAR(45) NULL,
  `platform` VARCHAR(255) NULL,
  `korting` DECIMAL(9,2) NULL,
  PRIMARY KEY (`EAN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`image` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(255) NOT NULL,
  `product_EAN` VARCHAR(13) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_image_product_idx` (`product_EAN` ASC),
  CONSTRAINT `fk_image_product`
    FOREIGN KEY (`product_EAN`)
    REFERENCES `multiversum`.`product` (`EAN`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`adres`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`adres` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`adres` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `straat` VARCHAR(255) NOT NULL,
  `huisnummer` INT NOT NULL,
  `toevoeging` VARCHAR(10) NULL,
  `postcode` VARCHAR(6) NOT NULL,
  `land` VARCHAR(255) NULL,
  `stad` VARCHAR(255) NOT NULL,
  `voornaam` VARCHAR(255) NOT NULL,
  `tussenvoegsel` VARCHAR(255) NULL,
  `achternaam` VARCHAR(255) NOT NULL,
  `geslacht` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`order` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`order` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prijs` DECIMAL(9,2) NOT NULL,
  `telefoonnummer` VARCHAR(45) NULL,
  `email` VARCHAR(254) NULL,
  `betaaladres_id` INT NOT NULL,
  `bezorgadres_id` INT NULL,
  `payment_id` CHAR(13) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_order_adres1_idx` (`betaaladres_id` ASC),
  INDEX `fk_order_adres2_idx` (`bezorgadres_id` ASC),
  CONSTRAINT `fk_order_adres1`
    FOREIGN KEY (`betaaladres_id`)
    REFERENCES `multiversum`.`adres` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_adres2`
    FOREIGN KEY (`bezorgadres_id`)
    REFERENCES `multiversum`.`adres` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`order_has_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`order_has_product` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`order_has_product` (
  `order_id` INT NOT NULL,
  `product_EAN` VARCHAR(13) NOT NULL,
  `aantal` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`order_id`, `product_EAN`),
  INDEX `fk_order_has_product_product1_idx` (`product_EAN` ASC),
  INDEX `fk_order_has_product_order1_idx` (`order_id` ASC),
  CONSTRAINT `fk_order_has_product_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `multiversum`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_has_product_product1`
    FOREIGN KEY (`product_EAN`)
    REFERENCES `multiversum`.`product` (`EAN`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
