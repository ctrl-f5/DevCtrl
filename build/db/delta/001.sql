CREATE TABLE `property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valuesProvider` varchar(255) DEFAULT NULL,
  `valuesProviderConfig` varchar(255) DEFAULT NULL,
  `propertyType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `itemType` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`supportsTiming` TINYINT UNSIGNED NOT NULL ,
`supportsStates` TINYINT UNSIGNED NOT NULL
) ENGINE = INNODB;

CREATE TABLE `itemType_property` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`itemType_id` INT UNSIGNED NOT NULL ,
`property_id` INT UNSIGNED NOT NULL ,
`required` TINYINT UNSIGNED NOT NULL ,
`defaultProvider` VARCHAR( 255 ) NOT NULL
`defaultProviderConfig` VARCHAR( 255 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE `nativeValue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nativeType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;


CREATE TABLE `nativeValue_int` (
  `id` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `nativeValue_string` (
  `id` int(10) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `nativeValue_text` (
  `id` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `propertyValueList` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`nativeType` VARCHAR( 255 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE  `propertyValueList_nativeValue` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`propertyValueList_id` INT UNSIGNED NOT NULL ,
`nativeValue_id` INT UNSIGNED NOT NULL
) ENGINE = INNODB;

CREATE TABLE `itemState` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`itemStateList_id` INT UNSIGNED NOT NULL,
`label` VARCHAR( 255 ) NOT NULL ,
`nativeState` VARCHAR( 255 ) NOT NULL ,
`color` VARCHAR( 255 ) NULL ,
`order` INT UNSIGNED NOT NULL
) ENGINE = INNODB;

CREATE TABLE `itemStateList` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = INNODB;