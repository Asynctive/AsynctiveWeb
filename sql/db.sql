-- -------------------------------------
-- Asynctive Website Database Schema
-- Author: Andy Deveaux
-- -------------------------------------

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- -------------------------------------
-- User related
-- -------------------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `label` VARCHAR(60) NOT NULL UNIQUE,
    `key_name` VARCHAR(50) NOT NULL COMMENT 'Associated array key name in Roles library',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `user_role_associations`;
CREATE TABLE `user_role_associations`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `role_id` INT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `role_type_id_idx` (`role_id` ASC),
    INDEX `role_user_id_idx` (`user_id` ASC),
    UNIQUE KEY `idx_user_roles`(`role_id`, `user_id`),
    CONSTRAINT `fk_role_assoc_role_id` FOREIGN KEY(`role_id`) REFERENCES `roles`(`id`)
    ON DELETE CASCADE,
    CONSTRAINT `fk_role_assoc_user_id` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(200) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(200),
    `last_name` VARCHAR(200),
    `email` VARCHAR(256) NOT NULL UNIQUE,
    `email_verified` BOOL NOT NULL DEFAULT 0 COMMENT 'Easy way to check without using another query',
    `created` INT(11) UNSIGNED NOT NULL,
    `updated` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`(
	`id` VARCHAR(40) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `timestamp` INT(10) UNSIGNED DEFAULT 0 NOT NULL,
    `data` BLOB NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `ci_sessions_timestamp`(`timestamp`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `pending_email_verifications`;
CREATE TABLE `pending_email_verifications`(
	`id` CHAR(36) NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `code` CHAR(8) NOT NULL COMMENT 'Extra random generated data',
    `created` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `pending_email_user_id_idx` (`user_id` ASC),
    CONSTRAINT `fk_pending_email_user_id` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)
	ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `pw_resets`;
CREATE TABLE `pw_resets`(
	`id` CHAR(36) NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `code` CHAR(8) NOT NULL COMMENT 'Extra random generated data',
    `remote_ip` VARCHAR(45) NOT NULL COMMENT 'Address of what sent the request',
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
    `name` VARCHAR(150) NOT NULL UNIQUE,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    PRIMARY KEY(`id`),
    INDEX `news_categories_slug_idx` (`slug` ASC)
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
-- Software related
-- -------------------------------------
DROP TABLE IF EXISTS `software_categories`;
CREATE TABLE `software_categories`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL UNIQUE,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `software`;
CREATE TABLE `software`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200) NOT NULL UNIQUE,
    `desc` TEXT,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `software_category_associations`;
CREATE TABLE `software_category_associations`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `software_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    INDEX `software_cat_assoc_product_id_idx` (`software_id` ASC),
    INDEX `software_cat_assoc_category_id_idx` (`category_id` ASC),
    CONSTRAINT `fk_software_cat_assoc_product_id` FOREIGN KEY (`software_id`) REFERENCES `software`(`id`)
    ON DELETE CASCADE,
    CONSTRAINT `fk_software_cat_assoc_category_id` FOREIGN KEY (`category_id`) REFERENCES `software_categories`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `commercial_software`;
CREATE TABLE `commercial_software`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `software_id` INT UNSIGNED NOT NULL UNIQUE,
    `price` DECIMAL(10,2) NOT NULL COMMENT 'CAD',
    PRIMARY KEY(`id`),
    INDEX `commercial_software_software_id_idx` (`software_id` ASC),
    CONSTRAINT `fk_commercial_software_software_id` FOREIGN KEY (`software_id`) REFERENCES `software`(`id`)
    ON DELETE CASCADE,
    CHECK (`price`>0.00)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `open_source_software`;
CREATE TABLE `open_source_software`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `software_id` INT UNSIGNED NOT NULL UNIQUE,
    `license` VARCHAR(100),
    `repository_url` VARCHAR(300),
    PRIMARY KEY(`id`),
    INDEX `open_source_software_software_id_idx` (`software_id` ASC),
    CONSTRAINT `fk_open_source_software_software_id` FOREIGN KEY (`software_id`) REFERENCES `software`(`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB;


SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
