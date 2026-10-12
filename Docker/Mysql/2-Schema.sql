CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first` varchar(30) NOT NULL DEFAULT '',
  `last` varchar(30) NOT NULL DEFAULT '',
  `user_id` varchar(30) NOT NULL DEFAULT '',
  `password_hash` longtext NOT NULL,
  `email` varchar(60) NOT NULL DEFAULT '',
  `balance` varchar(30) NOT NULL DEFAULT '',
  `last_update` datetime DEFAULT NULL,
  `question` varchar(100) NOT NULL DEFAULT '',
  `answer` varchar(100) NOT NULL DEFAULT '',
  `notice` mediumtext NOT NULL,
  `gm` longtext NOT NULL,
  `level` varchar(30) NOT NULL DEFAULT '',
  `locked` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
