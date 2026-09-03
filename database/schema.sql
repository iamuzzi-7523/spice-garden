CREATE DATABASE IF NOT EXISTS spicegarden_db;

USE spicegarden_db;

-- Users
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Reservations
CREATE TABLE IF NOT EXISTS reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    people_count INT NOT NULL,
    reservation_time DATETIME NOT NULL,
    notes TEXT
);

-- Items included in each reservation
CREATE TABLE IF NOT EXISTS reservation_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    dish_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_reservation_items_reservation
        FOREIGN KEY (reservation_id)
        REFERENCES reservations(reservation_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);