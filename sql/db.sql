-- -------------------------------------
-- Asynctive Website Database Schema
-- Author: Andy Deveaux
-- -------------------------------------

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- -------------------------------------
-- User related
-- -------------------------------------
DROP TABLE IF EXISTS `privilege_types`;
CREATE TABLE `privilege_types`(
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


DROP TABLE IF EXISTS `privileges`;
CREATE TABLE `privileges`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `type_id` INT NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `privilege_user_id_idx` (`user_id` ASC),
    INDEX `privilege_type_id_idx` (`type_id` ASC),
    CONSTRAINT `fk_privileges_user_id` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE,
    CONSTRAINT `fk_privileges_type_id` FOREIGN KEY(`type_id`) REFERENCES `privilege_types`(`id`)
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

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;