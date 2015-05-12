CREATE TABLE `category` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `category` (`id`, `name`) VALUES
(1, '本'),
(2, 'CD'),
(3, 'DVD');

CREATE TABLE `product` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`category_id` int(11) DEFAULT NULL,
	`name` varchar(64) NOT NULL,
	`detail` text,
	`price` int(11) NOT NULL,
	`img` varchar(64) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
