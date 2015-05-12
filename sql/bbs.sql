CREATE TABLE `bbs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`email` varchar(64) DEFAULT NULL,
	`subject` varchar(128) DEFAULT NULL,
	`body` text,
	`password` varchar(32) DEFAULT NULL,
	`ip_address` varchar(39) DEFAULT NULL,
	`datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `captcha` (
	`captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
	`captcha_time` int(10) unsigned NOT NULL,
	`word` varchar(20) NOT NULL,
	PRIMARY KEY (`captcha_id`),
	KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
