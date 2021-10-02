CREATE TABLE IF NOT EXISTS `USER` (
	`user_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`Name` varchar(50) NOT NULL,
	`Email` varchar(50) NOT NULL,
	`Phone` varchar(50) NOT NULL,
	`Password` varchar(50) NOT NULL,
	`User_type` varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `USER_AVAILABILTY` (
	`user_id` int(10) NOT NULL,
	`time_to` varchar(50) NOT NULL,
	`time_from` varchar(50) NOT NULL,
	`user_day` varchar(50) NOT NULL,
	`user_month` varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `RESERVATION` (
	`red_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`user_id` varchar(50) NOT NULL,
	`name` varchar(50) NOT NULL,
	`comments` varchar(50) NOT NULL,
	`res_day` varchar(50) NOT NULL,
	`res_month` varchar(50) NOT NULL,
	`time_to` varchar(50) NOT NULL,
	`time_from` varchar(50) NOT NULL,
	`occupy` varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

