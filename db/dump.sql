/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50522
Source Host           : localhost:3306
Source Database       : moood

Target Server Type    : MYSQL
Target Server Version : 50522
File Encoding         : 65001

Date: 2012-08-31 18:09:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `playlist`
-- ----------------------------
DROP TABLE IF EXISTS `playlist`;
CREATE TABLE `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `keywords` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of playlist
-- ----------------------------

-- ----------------------------
-- Table structure for `playlist_songs`
-- ----------------------------
DROP TABLE IF EXISTS `playlist_songs`;
CREATE TABLE `playlist_songs` (
  `song_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  PRIMARY KEY (`song_id`,`playlist_id`),
  KEY `song_id_idx` (`song_id`),
  KEY `pla;ist_id_idx` (`playlist_id`),
  CONSTRAINT `plalist_id` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `song_id` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of playlist_songs
-- ----------------------------

-- ----------------------------
-- Table structure for `songs`
-- ----------------------------
DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `title` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of songs
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `password` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `last_name` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nick_name` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `is_admin` tinyint(1) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` text CHARACTER SET utf8,
  PRIMARY KEY (`username`,`email`,`nick_name`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nirgeier', 'c75c52a8adf5ed4a0eec891dfe21306ea6d1f906', 'nirgeier@gmail.com', 'Nir', 'Geier', 'jsExpert', '1', '2012-08-23 15:32:17', 'http://www.gravatar.com/avatar/80609fb4e62ba863d998094386bca9f6.png');

-- ----------------------------
-- Table structure for `users_playlist`
-- ----------------------------
DROP TABLE IF EXISTS `users_playlist`;
CREATE TABLE `users_playlist` (
  `user_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`playlist_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `playlist_id_idx` (`playlist_id`),
  CONSTRAINT `playlist_id` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of users_playlist
-- ----------------------------

-- ----------------------------
-- Procedure structure for `add_playlist`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_playlist`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_playlist`(IN userId INT, IN pName VARCHAR(100))
BEGIN
       INSERT INTO playlist (name) VALUES (pName);
			 INSERT INTO users_playlist (user_id,playlist_id) VALUES (userId, LAST_INSERT_ID());
     END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_song`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_song`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_song`(IN `pId` int,IN `videoId` varchar(50),IN `title` varchar(500))
BEGIN
	     INSERT INTO songs (video_id,title) VALUES (videoId, title);
			 INSERT INTO playlist_songs (song_id,playlist_id) VALUES (LAST_INSERT_ID(), pId);
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `delete_playlist`
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_playlist`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_playlist`(IN userId INT, IN pId INT)
BEGIN

DECLARE songId INT;
DECLARE playlistId INT;
DECLARE done INT;

DECLARE cur CURSOR FOR
SELECT
	songs.id as songId,
	users_playlist.playlist_id as playlistId
FROM
	songs
	LEFT JOIN playlist_songs ON songs.id=playlist_songs.song_id
	LEFT JOIN users_playlist ON users_playlist.playlist_id=playlist_songs.playlist_id
	LEFT JOIN playlist ON users_playlist.playlist_id = playlist.id
WHERE 
	users_playlist.user_id=userId
AND playlist.id=pId;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

OPEN cur;
SET done=0;

REPEAT FETCH cur into songId, playlistId;
	DELETE FROM playlist_songs WHERE song_id=songId;
	DELETE FROM songs WHERE id=songId;
UNTIL done END REPEAT;

	DELETE FROM users_playlist WHERE playlist_id=pId;
	DELETE FROM playlist where id=pId;		


  END
;;
DELIMITER ;
