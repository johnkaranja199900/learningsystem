CREATE TABLE `payments` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED,
    `transaction_id` VARCHAR(255) UNIQUE,
    `amount` VARCHAR(255),
    `phone` VARCHAR(255),
    `account_reference` VARCHAR(255),
    `transaction_desc` VARCHAR(255),
    `status` VARCHAR(255),
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `User`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `Payments`;
