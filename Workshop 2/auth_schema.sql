CREATE DATABASE IF NOT EXISTS isw613_workshop2
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE isw613_workshop2;

CREATE TABLE IF NOT EXISTS provinces (
    id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_provinces_name (name)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO provinces (id, name) VALUES
    (1, 'Alajuela'), (2, 'Cartago'), (3, 'Guanacaste'), (4, 'Heredia'),
    (5, 'Limón'), (6, 'Puntarenas'), (7, 'San José');

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(120) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    province_id TINYINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_username (username),
    UNIQUE KEY uq_users_email (email),
    CONSTRAINT fk_users_province FOREIGN KEY (province_id) REFERENCES provinces(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE=utf8mb4_unicode_ci;
