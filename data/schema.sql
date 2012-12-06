CREATE TABLE users
(
    user_id       INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username      VARCHAR(255) DEFAULT NULL UNIQUE,
    firstname     VARCHAR(255) DEFAULT NULL,
    lastname      VARCHAR(255) DEFAULT NULL,
    email         VARCHAR(255) DEFAULT NULL UNIQUE,
    display_name  VARCHAR(50) DEFAULT NULL,
    password      VARCHAR(128) NOT NULL,
    state         SMALLINT
) ENGINE=InnoDB;
