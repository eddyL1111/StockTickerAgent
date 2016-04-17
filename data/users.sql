# create a simple users table for authentication
CREATE TABLE IF NOT EXISTS `users` (
`userid` varchar(10) NOT NULL,
`username` varchar(20) NOT NULL,
`password` varchar(64) NOT NULL,
`role` varchar(20) NOT NULL,
PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO users
VALUES ('GODMODE', 'Omnipotent', 'godlike', 'admin');