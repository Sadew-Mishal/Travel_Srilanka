CREATE DATABASE IF NOT EXISTS travel_srilanka;
USE travel_srilanka;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    customer_name VARCHAR(100) NOT NULL,
    whatsapp_number VARCHAR(30) NULL,
    selected_cities TEXT NOT NULL,
    vehicle_name VARCHAR(50) NOT NULL,
    vehicle_price DECIMAL(10,2) NOT NULL,
    travel_days INT NOT NULL,
    guide_added TINYINT(1) NOT NULL DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    receipt_file_name VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_bookings_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
);
