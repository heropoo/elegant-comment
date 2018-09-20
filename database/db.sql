DROP TABLE IF EXISTS `cw_account`;
CREATE TABLE `cw_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'E-mail',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 -1禁止',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='账户表';

DROP TABLE IF EXISTS `cw_user`;
CREATE TABLE `cw_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0未知 1男 2女',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'E-mail',
  `website` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码盐',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 -1禁止',
  `account_id` int(11) unsigned NOT NULL COMMENT '账号id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

DROP TABLE IF EXISTS `cw_comment`;
CREATE TABLE `cw_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章id',
  `parent_comment_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '回复评论的id',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `user_nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `user_head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `user_sex` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `account_id` int(11) unsigned NOT NULL COMMENT '账号id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='评论表';