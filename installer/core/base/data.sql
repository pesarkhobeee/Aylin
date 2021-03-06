--
-- Dumping data for table `meta_data`
--

INSERT INTO `meta_data` (`id`, `name`, `value`, `group`) VALUES
(1, 'welcome', '*', 'acl'),
(2, 'users_root', 'root', 'acl'),
(3, 'users', '*', 'acl'),
(4, 'domain', 'user', 'acl'),
(5, 'menu', 'root', 'acl'),
(6, 'aylin_base', 'root', 'acl');


--
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_url`, `menu_section`, `parent`) VALUES
(1, 'تنظیمات', '#', 'root', NULL),
(2, 'عمومی', 'aylin_base/config', 'root', 1),
(3, 'کاربران', 'users/show_users', 'root', 1),
(4, 'ACL', 'users/acl', 'root', 1),
(5, 'منوها', 'menu/index', 'root', 1),
(6, 'محتوا', '#', 'root', NULL),
(7, 'آپلود', 'aylin_base/upload', 'root', 6),
(0, 'پشتیبان گیری', 'aylin_base/backup_dl', 'root', 6);

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_title`, `content_text`, `content_tag`, `content_modify_date`) VALUE
(1, 'Home', '<center><b><h3>Welcome To Aylin</h3></b></center>','home,aylin', '2012-04-09');




--
-- Dumping data for table `users_groups`
--
INSERT INTO `users_groups` VALUES (0,'root');
INSERT INTO `users_groups` VALUES (0,'users');
INSERT INTO `users_groups` VALUES (0,'public');
