-- -------------------------------------
-- Asynctive Website Database Schema
-- Author: Andy Deveaux
-- -------------------------------------

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- -------------------------------------
-- User related
-- -------------------------------------
DROP TABLE IF EXISTS `privileges`;
CREATE TABLE `privileges`(
	`id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    PRIMARY KEY(`id`),
    UNIQUE(`name`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(200) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(256) NOT NULL,
    `created` INT(11) UNSIGNED NOT NULL,
    `updated` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `uc_user_id` UNIQUE(`username`, `email`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `privilege_associations`;
CREATE TABLE `privilege_associations`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `privilege_id` INT NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `privilege_user_id_idx` (`user_id` ASC),
    INDEX `privilege_type_id_idx` (`privilege_id` ASC),
    CONSTRAINT `fk_privilege_assoc_user_id` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE,
    CONSTRAINT `fk_privilege_assoc_privilege_id` FOREIGN KEY(`privilege_id`) REFERENCES `privileges`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `pw_resets`;
CREATE TABLE `pw_resets`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `data` VARCHAR(255) NOT NULL,
    `created` INT(11) UNSIGNED NOT NULL,
    `expires` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `pw_reset_user_id_idx` (`user_id` ASC),
    CONSTRAINT `fk_pw_reset_user_id` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


-- -------------------------------------
-- News related
-- -------------------------------------
DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `uc_news_category_id` UNIQUE(`name`, `slug`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `news_articles`;
CREATE TABLE `news_articles`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(250) NOT NULL,
    `content` TEXT,
    `created` INT(11) UNSIGNED NOT NULL,
    `updated` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `news_article_user_id_idx` (`user_id` ASC),
    INDEX `news_article_category_id_dx` (`category_id` ASC),
    CONSTRAINT `fk_news_article_user_id` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE,
    CONSTRAINT `fk_news_article_category_id` FOREIGN KEY(`category_id`) REFERENCES `news_categories`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `news_categories_slug_idx` (`slug` ASC),
    CONSTRAINT `uc_news_category_id` UNIQUE(`name`, `slug`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `news_articles`;
CREATE TABLE `news_articles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(250) NOT NULL,
    `content` TEXT,
    `created` INT(11) UNSIGNED NOT NULL,
    `updated` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `news_article_user_id_idx` (`user_id` ASC),
    INDEX `news_article_category_id_dx` (`category_id` ASC),
    CONSTRAINT `fk_news_article_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE
)  ENGINE=INNODB;


DROP TABLE IF EXISTS `news_category_associations`;
CREATE TABLE `news_category_associations`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `article_id` BIGINT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `news_cat_assoc_article_id_idx` (`article_id` ASC),
    INDEX `news_cat_assoc_category_id_idx` (`category_id` ASC),
    CONSTRAINT `fk_news_cat_assoc_article_id` FOREIGN KEY (`article_id`) REFERENCES `news_articles`(`id`)
	ON DELETE CASCADE,
    CONSTRAINT `fk_news_cat_assoc_category_id` FOREIGN KEY (`category_id`) REFERENCES `news_categories`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


-- -------------------------------------
-- Product related
-- -------------------------------------
DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL UNIQUE,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200) NOT NULL UNIQUE,
    `desc` TEXT,
    `price` DECIMAL(9,2) NOT NULL DEFAULT '0.00' COMMENT 'CAD',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `product_category_associations`;
CREATE TABLE `product_category_associations`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `product_cat_assoc_product_id_idx` (`product_id` ASC),
    INDEX `product_cat_assoc_category_id_idx` (`category_id` ASC),
    CONSTRAINT `fk_product_cat_assoc_product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
    ON DELETE CASCADE,
    CONSTRAINT `fk_product_cat_assoc_category_id` FOREIGN KEY (`category_id`) REFERENCES `product_categories`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
