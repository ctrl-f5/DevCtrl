CREATE TABLE `itemstate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemStateList_id` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `nativeState` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `itemstatelist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `itemtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `supportsTiming` tinyint(3) unsigned NOT NULL,
  `itemStateList_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `itemtype_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemType_id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned NOT NULL,
  `required` tinyint(3) unsigned NOT NULL,
  `defaultProvider` varchar(255) DEFAULT NULL,
  `defaultProviderConfig` varchar(255) DEFAULT NULL,
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `nativevalue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nativeType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `nativevalue_int` (
  `id` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `nativevalue_string` (
  `id` int(10) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `nativevalue_text` (
  `id` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valuesProvider` varchar(255) DEFAULT NULL,
  `valuesProviderConfig` varchar(255) DEFAULT NULL,
  `propertyType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `propertyvaluelist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nativeType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `propertyvaluelist_nativevalue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `propertyValueList_id` int(10) unsigned NOT NULL,
  `nativeValue_id` int(10) unsigned NOT NULL,
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;