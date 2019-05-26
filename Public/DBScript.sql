  /*
  @MikhailRzhevsky
  
  Define your database or create new one in line YOUR_DATABASE_NAME;
  
  */
   
use YOUR_DATABASE_NAME;

CREATE TABLE IF NOT EXISTS users (
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50) NOT NULL ,
     password VARCHAR(50) NOT NULL,
     INDEX idx_username (username)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;



CREATE TABLE IF NOT EXISTS tasks (
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50) NOT NULL,
     email VARCHAR(50) NOT NULL,
     description text NOT NULL,
     picture VARCHAR(255),
     status INT(1) NOT NULL DEFAULT '0',
     created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     INDEX idx_username (username),
     INDEX idx_email (email),
     INDEX idx_status (status)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
	
	
