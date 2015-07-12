CREATE TABLE IF NOT EXISTS `php-wars`.`ranking` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
 `points` int(11) NOT NULL,
 `date` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
