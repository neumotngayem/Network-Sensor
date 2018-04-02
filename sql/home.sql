CREATE TABLE `home` (
 `device_id` varchar(120) NOT NULL,
 `fav` int(11) NOT NULL DEFAULT '0',
 `type` varchar(120) NOT NULL,
 `temp` varchar(11) DEFAULT NULL,
 `humi` varchar(11) DEFAULT NULL,
 `water` int(11) DEFAULT NULL,
 `sec` int(11) NOT NULL,
 `loca_id` int(11) NOT NULL DEFAULT '0',
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`device_id`)
)