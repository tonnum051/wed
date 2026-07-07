
CREATE DATABASE IF NOT EXISTS `library_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `library_db`;

CREATE TABLE IF NOT EXISTS `library_bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` VARCHAR(20) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  `resource_type` ENUM('Single Seat', 'PC Station', 'Group Study Room') NOT NULL,
  `booking_date` DATE NOT NULL,
  `time_slot` VARCHAR(20) NOT NULL,
  `status` ENUM('Pending', 'Checked-in', 'No-show', 'Cancelled') DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_booking_check (`booking_date`, `resource_type`, `time_slot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;