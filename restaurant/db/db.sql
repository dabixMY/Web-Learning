CREATE DATABASE cafe_data CHARACTER
SET
    utf8 COLLATE utf8_general_ci;
	
USE cafe_data;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE dishes (
    dish_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(6,2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(50)
);

CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    dish_id INT NOT NULL,
    quantity INT DEFAULT 1,

    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (dish_id) REFERENCES dishes(dish_id)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(8,2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(30) DEFAULT 'Pending',

    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_details (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    dish_id INT NOT NULL,
    quantity INT NOT NULL,

    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (dish_id) REFERENCES dishes(dish_id)
);

CREATE TABLE contact (
        contact_id INT AUTO_INCREMENT PRIMARY KEY,
        salutation VARCHAR(10) NOT NULL,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        enquiry_type VARCHAR(30) NOT NULL,
        feedback_category VARCHAR(30),
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
	
CREATE TABLE admin (
    adm_id INT AUTO_INCREMENT PRIMARY KEY,
    adm_username VARCHAR(50) NOT NULL UNIQUE,
    adm_email VARCHAR(100) NOT NULL UNIQUE,
    adm_password VARCHAR(255) NOT NULL,
    adm_phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin (adm_username, adm_email, adm_password, adm_phone)
VALUES (
    'MWJ',
    'mwj@plateco.com',
    '$2y$10$mLsaLYbhSWZWomGS3xWEdOQTusz82UnR19nPTFXZL//K6Te5C9/1W',
    '0179879517'
)
ON DUPLICATE KEY UPDATE
    adm_email = VALUES(adm_email),
    adm_password = VALUES(adm_password),
    adm_phone = VALUES(adm_phone);