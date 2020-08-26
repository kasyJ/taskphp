-- Таблица users --
-- имена таблиц и полей в бэквотак или без них, ни каких кавычек!
CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255) NOT NULL UNIQUE,
	`pass` VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
)

CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO `users` (username, pass)
	VALUES ('admin', '$2y$10$fc0w8rBPxzu9zcIFX7zcz.cbd9to/CiZ1Dxlrqt47V4gdjVIjbSNW');
