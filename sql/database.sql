-- MySQL Script generated by MySQL Workbench
-- Mon 28 May 2018 08:03:19 PM CEST
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
  `EAN` INT(13) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(9,2) NOT NULL,
  `description` TEXT NOT NULL,
  `brand` VARCHAR(255) NOT NULL,
  `resolution` VARCHAR(100) NULL,
  `refresh_rate` INT NULL,
  `fov` INT(3) NULL,
  `inputs` TEXT NULL,
  `accessories` TEXT NULL,
  `accelerometer` TINYINT(1) NULL,
  `camera` TINYINT(1) NULL,
  `gyroscope` TINYINT(1) NULL,
  `adjustable_lenses` TINYINT(1) NULL,
  `color` VARCHAR(45) NULL,
  `platform` VARCHAR(255) NULL,
  `discount` DECIMAL(9,2) NULL,
  PRIMARY KEY (`EAN`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`image` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(255) NOT NULL,
  `product_EAN` INT(13) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_image_product_idx` (`product_EAN` ASC),
  CONSTRAINT `fk_image_product`
    FOREIGN KEY (`product_EAN`)
    REFERENCES `multiversum`.`product` (`EAN`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`order` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`order` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` DECIMAL(9,2) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `insertion` VARCHAR(45) NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(45) NULL,
  `iban` VARCHAR(34) NOT NULL,
  `gender` TINYINT(1) NULL,
  `email` VARCHAR(254) NULL,
  `street` VARCHAR(255) NOT NULL,
  `house_number` INT NOT NULL,
  `addition` VARCHAR(10) NULL,
  `postal_code` VARCHAR(6) NOT NULL,
  `country` VARCHAR(255) NULL,
  `city` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`order_has_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`order_has_product` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`order_has_product` (
  `order_id` INT NOT NULL,
  `product_EAN` INT(13) NOT NULL,
  `amount` INT NOT NULL DEFAULT 1,
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
