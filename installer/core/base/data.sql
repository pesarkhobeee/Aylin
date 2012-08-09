--
-- Dumping data for table `meta_data`
--

INSERT INTO `meta_data` (`id`, `name`, `value`, `group`) VALUES
(1, 'welcome', 'root', 'acl'),
(2, 'welcome', 'user', 'acl'),
(3, 'users', 'root', 'acl'),
(4, 'domain', 'user', 'acl'),
(5, 'menu', 'root', 'acl'),
(6, 'aylin', 'root', 'acl');


--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_url`, `menu_section`, `parent`) VALUES
(1, 'تنظیمات', '#', 'admin', NULL),
(2, 'عمومی', 'aylin/config', 'admin', 1),
(3, 'کاربران', 'users/show_users', 'admin', 1),
(4, 'منوها', 'menu/index', 'admin', 1),
(5, 'محتوا', '#', 'admin', NULL),
(6, 'آپلود', 'aylin/upload', 'admin', 5);

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_title`, `content_text`, `content_tag`, `content_modify_date`) VALUE
(1, 'Home', '<center><b><h3>Welcome To Aylin</h3></b></center>','home,aylin', '2012-04-09');



--
-- Dumping data for table `users`
--


INSERT INTO `users` (`id`, `username`, `password`, `user_group`) VALUES
(7, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'root');
