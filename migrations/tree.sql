CREATE TABLE `tree` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL COMMENT 'имя',
  `url` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'путь',
  `tree_id` INTEGER(11) DEFAULT NULL COMMENT 'предок',
  `txt` TEXT COLLATE utf8_general_ci COMMENT 'сообщение',
  PRIMARY KEY USING BTREE (`id`),
  UNIQUE KEY `id` USING BTREE (`id`),
  UNIQUE KEY `name` USING BTREE (`name`),
  UNIQUE KEY `url` USING BTREE (`url`),
  KEY `tree_id` USING BTREE (`tree_id`),
  CONSTRAINT `treee_fk1` FOREIGN KEY (`tree_id`) REFERENCES `tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
AUTO_INCREMENT=18 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;