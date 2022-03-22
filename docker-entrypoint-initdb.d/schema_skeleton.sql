CREATE DATABASE IF NOT EXISTS `parkings`;
USE parkings;

CREATE TABLE IF NOT EXISTS `garage`
(
    `garage_id`    INT          NOT NULL AUTO_INCREMENT,
    `owner_id`     int(10)  unsigned NOT NULL COMMENT 'OWNER ID',
    `name`         varchar(255) NOT NULL,
    `point`        varchar(255) NOT NULL,
    `hourly_price` varchar(255) NOT NULL,
    PRIMARY KEY (`garage_id`)
);

CREATE TABLE IF NOT EXISTS `owner`
(
    `owner_id`     int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'OWNER ID',
    `country_id`   int(10) NOT NULL COMMENT 'Country ID',
    `garage_owner` varchar(255) DEFAULT NULL COMMENT 'Garage Owner',
    `contact_email`        varchar(255) DEFAULT NULL COMMENT 'Email',
    PRIMARY KEY (`owner_id`)
);

CREATE TABLE IF NOT EXISTS `country`
(
    `country_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Country ID',
    `country`       varchar(255) DEFAULT NULL COMMENT 'Country Name',
    `currency`   TEXT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'Currency',
    PRIMARY KEY (`country_id`)
);

ALTER TABLE `garage` ADD CONSTRAINT `garage_fk0` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`);

ALTER TABLE `owner` ADD CONSTRAINT `owner_fk0` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`);



