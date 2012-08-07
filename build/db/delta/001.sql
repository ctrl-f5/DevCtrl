INSERT INTO `item` (`id`, `project_id`, `title`, `description`, `itemType_id`, `itemState_id`) VALUES
(1, NULL, 'First Bug reported!', 'Something went wrong...', 1, 1);

INSERT INTO `itemstate` (`id`, `label`, `color`, `nativeState`, `order`, `itemStateList_id`) VALUES
(1, 'open', '', 'open', 1, 1),
(2, 'blocked', '', 'blocked', 3, 1),
(3, 'closed', '', 'closed', 2, 1);

INSERT INTO `itemstatelist` (`id`, `name`) VALUES
(1, 'minimal');

INSERT INTO `itemtype` (`id`, `name`, `description`, `supportsTiming`, `itemStateList_id`) VALUES
(1, 'Bug', 'software bug', 0, 1);

INSERT INTO `itemtype_property` (`id`, `property_id`, `required`, `defaultProvider`, `defaultProviderConfig`, `order`, `itemType_id`) VALUES
(1, 3, 1, 'Last', NULL, 0, 1);

INSERT INTO `item_type_property_value` (`id`, `item_id`, `nativeValue_id`, `itemType_property_id`) VALUES
(1, 1, 4, 1);

INSERT INTO `nativevalue` (`id`, `nativeType`) VALUES
(1, 'string'),
(2, 'string'),
(3, 'string'),
(4, 'string');

INSERT INTO `nativevalue_string` (`id`, `value`) VALUES
(1, 'normal'),
(2, 'high'),
(3, 'blocking'),
(4, '2');

INSERT INTO `projects` (`id`, `name`, `description`) VALUES
(1, 'New Project', 'This is A new example project');

INSERT INTO `project_backlog` (`project_id`, `item_id`) VALUES
(1, 1);

INSERT INTO `property` (`id`, `name`, `description`, `valuesProvider`, `valuesProviderConfig`, `propertyType`) VALUES
(3, 'priority', 'how important is it?', 'CustomList', '1', 'select');

INSERT INTO `propertyvaluelist` (`id`, `name`, `nativeType`) VALUES
(1, 'priority', 'string');

INSERT INTO `propertyvaluelist_nativevalue` (`id`, `order`, `nativeValue_id`, `propertyValueList_id`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1);