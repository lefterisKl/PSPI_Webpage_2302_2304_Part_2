
CREATE DATABASE SiteComments;
USE DATABASE SiteComments;

CREATE TABLE Comments(
	ID int AUTO_INCREMENT,
	body varchar(500),
   	email varchar(100),
	PRIMARY KEY (ID)
);

CREATE USER 'php'@'localhost' IDENTIFIED BY 'phpPassWord';
GRANT ALL PRIVILEGES ON SiteComments.* TO 'php'@'localhost';
