CREATE TABLE IF NOT EXISTS `shopping-api`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(8,2) NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shopping-api`.`buyers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shopping-api`.`carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `buyer_id` INT NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_buyer_idx` (`buyer_id` ASC),
  CONSTRAINT `fk_buyer`
    FOREIGN KEY (`buyer_id`)
    REFERENCES `shopping-api`.`buyers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shopping-api`.`cart_products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cart_idx` (`cart_id` ASC),
  INDEX `fk_product_idx` (`product_id` ASC),
  CONSTRAINT `fk_cart`
    FOREIGN KEY (`cart_id`)
    REFERENCES `shopping-api`.`carts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product`
    FOREIGN KEY (`product_id`)
    REFERENCES `shopping-api`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `shopping-api`.`products` (`id`, `name`, `price`) VALUES ('1', 'Sun glasses', '49.50');
INSERT INTO `shopping-api`.`products` (`id`, `name`, `price`) VALUES ('2', 'T-shirt', '24.00');
INSERT INTO `shopping-api`.`products` (`id`, `name`, `price`) VALUES ('3', 'Sport Shoes', '69.00');

INSERT INTO `shopping-api`.`buyers` (`id`, `name`) VALUES ('1', 'Buyer1');

INSERT INTO `shopping-api`.`carts` (`id`, `buyer_id`, `status`) VALUES ('1', '1', 'complete');

INSERT INTO `shopping-api`.`cart_products` (`id`, `cart_id`, `product_id`, `quantity`) VALUES ('1', '1', '1', '3');
INSERT INTO `shopping-api`.`cart_products` (`id`, `cart_id`, `product_id`, `quantity`) VALUES ('2', '1', '2', '1');
