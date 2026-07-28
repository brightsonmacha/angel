CREATE TABLE IF NOT EXISTS `cars` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `make` VARCHAR(100) NOT NULL,
    `model` VARCHAR(100) NOT NULL,
    `year` INT NOT NULL,
    `plate_number` VARCHAR(20) NOT NULL UNIQUE,
    `daily_rate` DECIMAL(10,2) NOT NULL,
    `status` ENUM('available','rented') NOT NULL DEFAULT 'available',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
