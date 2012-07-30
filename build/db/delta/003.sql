CREATE TABLE `item_timing` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`item_id` INT UNSIGNED NOT NULL ,
`estimated` INT UNSIGNED NOT NULL DEFAULT  '0',
`delivered` INT UNSIGNED NOT NULL DEFAULT  '0'
) ENGINE = INNODB;

ALTER TABLE  `item_types` ADD  `has_state` TINYINT NOT NULL DEFAULT  '0';

ALTER TABLE  `items` CHANGE  `state`  `state_id` INT UNSIGNED NULL;

ALTER TABLE  `item_states` ADD  `order` INT UNSIGNED NOT NULL;

-- //@UNDO