CREATE TABLE `room` (
 `rm_id` int(11) NOT NULL AUTO_INCREMENT,
 `rm_name` varchar(120) NOT NULL,
 `posi` int(11) NOT NULL,
 `chk_flg` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`rm_id`)
);
INSERT INTO `room` (`rm_id`, `rm_name`, `posi`, `chk_flg`) VALUES
(1, 'Favorite', 1, 1),
(2, 'Room manager', 2, 0)