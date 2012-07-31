ALTER TABLE  `item_property_possible_values`
CHANGE  `id`  `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT,
CHANGE  `value`  `value` VARCHAR( 255 ) NOT NULL;

ALTER TABLE  `item_properties`
ADD  `default_value_provider` VARCHAR( 255 ) NOT NULL DEFAULT  'Empty' AFTER  `type` ,
ADD  `possible_values_provider` VARCHAR( 255 ) NOT NULL DEFAULT  'Empty' AFTER  `default_value_provider`,
ADD  `static_default` VARCHAR( 255 ) NULL,
CHANGE  `type`  `type` VARCHAR( 255 ) NOT NULL;

ALTER TABLE  `item_property_possible_values`
ADD  `order` INT UNSIGNED NOT NULL,
ADD  `item_property_id` INT UNSIGNED NOT NULL AFTER  `id`;

-- //@UNDO