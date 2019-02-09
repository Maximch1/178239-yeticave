CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title CHAR(32) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email CHAR(128) NOT NULL UNIQUE,
  name INT NOT NULL UNIQUE,
  password VARCHAR(32) NOT NULL,
  contacts TEXT NOT NULL,
  avatar VARCHAR(255)
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title INT NOT NULL UNIQUE,
  description TEXT NOT NULL,
  image VARCHAR(255) NOT NULL,
  category_id INT NOT NULL,
  price CHAR(7) NOT NULL,
  end_date DATETIME NOT NULL,
  step_rate INT NOT NULL
);

CREATE UNIQUE INDEX category_id ON category(id);
CREATE UNIQUE INDEX users_id ON users(id);
CREATE UNIQUE INDEX lot_id ON lot(id);

CREATE INDEX category_title ON category(title);
CREATE INDEX user_name ON users(name);
CREATE INDEX lot_title ON lot(title);
