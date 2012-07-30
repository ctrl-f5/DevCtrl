SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dev_ctrl`
--

--
-- Dumping data for table `auth_users`
--

INSERT INTO `auth_users` (`id`, `username`, `password`) VALUES
(1, 'test1', 'tester1'),
(2, 'test2', 'tester2'),
(3, 'test3', 'tester3'),
(4, 'test4', 'tester4'),
(5, 'test5', 'tester5');

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `project_id`, `item_type_id`, `title`, `description`, `created_by_user_id`, `state`) VALUES
(1, 1, 1, 'first item', 'THis is the first item ever!', 1, '1');

--
-- Dumping data for table `item_item_properties`
--

INSERT INTO `item_item_properties` (`id`, `item_type_id`, `item_property_id`, `required`) VALUES
(1, 1, 3, 0),
(2, 1, 4, 0);

--
-- Dumping data for table `item_properties`
--

INSERT INTO `item_properties` (`id`, `type`, `name`, `description`) VALUES
(3, 1, 'software version', 'the version of the software the bug was found in'),
(4, 1, 'URL', 'the URL of the page the bug was encountered');

--
-- Dumping data for table `item_property_values`
--

INSERT INTO `item_property_values` (`id`, `item_property_id`, `item_id`, `value`) VALUES
(1, 3, 1, 'testvalue'),
(2, 4, 1, 'testvalue');

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`id`, `name`, `description`) VALUES
(1, 'bug', 'A bug relates to a problem in the project'),
(2, 'feature', 'a feature is something new that could be integrated into the project');

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `parent_id`, `created_by`, `state`, `date_created`, `date_due`) VALUES
(1, 'testproject', NULL, 1, 'closed', '2012-07-22 00:00:00', '2012-07-22 00:00:00');

--
-- Dumping data for table `project_users`
--

INSERT INTO `project_users` (`id`, `project_id`, `user_id`, `level`) VALUES
(1, 1, 1, 'developer'),
(3, 1, 4, 'viewer');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `auth_user_id`, `firstname`, `lastname`) VALUES
(1, 1, 'test', 'tester'),
(2, 2, 'test', 'tester'),
(3, 3, 'test', 'tester'),
(4, 4, 'test', 'tester'),
(5, 5, 'test', 'tester');
