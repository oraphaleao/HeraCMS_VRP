CREATE TABLE `whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `steam` varchar(255) NOT NULL,
  `hits` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `success` enum('0','1') NOT NULL DEFAULT '0',
  `blocked` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;