--
-- Dumping data for table `meta_data`
--

INSERT INTO `meta_data` (`id`, `name`, `value`, `group`) VALUES
(1, 'welcome', '*', 'acl'),
(2, 'users_root', 'root', 'acl'),
(3, 'users', '*', 'acl'),
(4, 'domain', 'user', 'acl'),
(5, 'menu', 'root', 'acl'),
(6, 'aylin', 'root', 'acl');


--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_url`, `menu_section`, `parent`) VALUES
(1, 'تنظیمات', '#', 'root', NULL),
(2, 'عمومی', 'aylin/config', 'root', 1),
(3, 'کاربران', 'users/show_users', 'root', 1),
(4, 'ACL', 'users/acl', 'root', 1),
(5, 'منوها', 'menu/index', 'root', 1),
(6, 'محتوا', '#', 'root', NULL),
(7, 'آپلود', 'aylin/upload', 'root', 6);

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_title`, `content_text`, `content_tag`, `content_modify_date`) VALUE
(1, 'Home', '<center><b><h3>Welcome To Aylin</h3></b></center>','home,aylin', '2012-04-09');



--
-- Dumping data for table `users`
--


INSERT INTO `users` VALUES (7, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'root',1);


--
-- Dumping data for table `users_groups`
--
INSERT INTO `users_groups` VALUES (0,'root');
INSERT INTO `users_groups` VALUES (0,'public');
