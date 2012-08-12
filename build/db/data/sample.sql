SET foreign_key_checks = 0;

INSERT INTO `item` (`id`, `project_id`, `title`, `description`, `dateCreated`, `dateUpdate`, `versionReported_id`, `versionFixed_id`, `createdByUser_id`, `itemType_id`, `itemState_id`) VALUES
(1, 1, 'First Bug reported!', 'I found something that does not work as expected', '2012-08-13 08:23:54', '2012-08-12 01:25:52', 1, 2, 1, 1, 3),
(2, 1, 'error on page x', 'I got an error when loading the page', '2012-08-19 16:45:27', '0000-00-00 00:00:00', NULL, NULL, 3, 1, 1);

INSERT INTO `itemstate` (`id`, `label`, `color`, `nativeState`, `order`, `itemStateList_id`) VALUES
(1, 'open', '', 'open', 1, 1),
(2, 'blocked', '', 'blocked', 3, 1),
(3, 'closed', '', 'closed', 2, 1);

INSERT INTO `itemstatelist` (`id`, `name`) VALUES
(1, 'minimal');

INSERT INTO `itemtiming` (`id`, `item_id`, `estimated`, `executed`) VALUES
(1, 1, 40, 48),
(2, 2, 80, 32);

INSERT INTO `itemtype` (`id`, `name`, `description`, `supportsTiming`, `supportsVersions`, `itemStateList_id`) VALUES
(1, 'Bug', 'software bug', 1, 1, 1);

INSERT INTO `itemtype_property` (`id`, `property_id`, `required`, `defaultProvider`, `defaultProviderConfig`, `order`, `itemType_id`) VALUES
(1, 3, 1, 'Last', NULL, 0, 1);

INSERT INTO `item_type_property_value` (`id`, `item_id`, `nativeValue_id`, `itemType_property_id`) VALUES
(1, 1, 4, 1),
(2, 2, 5, 1);

INSERT INTO `item_user` (`item_id`, `user_id`) VALUES
(2, 1);

INSERT INTO `nativevalue` (`id`, `nativeType`) VALUES
(1, 'string'),
(2, 'string'),
(3, 'string'),
(4, 'string'),
(5, 'string');

INSERT INTO `nativevalue_string` (`id`, `value`) VALUES
(1, 'normal'),
(2, 'high'),
(3, 'blocking'),
(4, '2'),
(5, '3');

INSERT INTO `project` (`id`, `version_id`, `name`, `description`) VALUES
(1, 1, 'New Project', 'This is a new example project');

INSERT INTO `projectversion` (`id`, `project_id`, `version`, `name`, `description`, `released`, `order`) VALUES
(1, 1, '0.0.0', 'current', NULL, 0, 1),
(2, 1, '0.0.1', 'preview1', 'first preview release', 0, 2);

INSERT INTO `project_backlog` (`project_id`, `item_id`) VALUES
(1, 1),
(1, 2);

INSERT INTO `dev_ctrl`.`projectmilestone` (`id`, `project_id`, `version_id`, `name`, `description`) VALUES (NULL, '1', '2', 'Setup Entity CRUD', 'First phase of the project, set up all entities as analyzed and add CRUD UI.');

INSERT INTO `property` (`id`, `name`, `description`, `valuesProvider`, `valuesProviderConfig`, `propertyType`) VALUES
(3, 'priority', 'how important is it?', 'CustomList', '1', 'select');

INSERT INTO `propertyvaluelist` (`id`, `name`, `nativeType`) VALUES
(1, 'priority', 'string');

INSERT INTO `propertyvaluelist_nativevalue` (`id`, `order`, `nativeValue_id`, `propertyValueList_id`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1);

INSERT INTO `user` (`id`, `username`, `firstName`, `lastName`, `email`) VALUES
(1, 'johnd', 'john', 'doe', 'john.doe@example.com'),
(2, 'ronny', 'ron', 'swanson', 'ron.swanson@meatlovers.com'),
(3, 'geargk', 'george', 'kastanza', 'george.kastanza@nyc.com');

SET foreign_key_checks = 1;