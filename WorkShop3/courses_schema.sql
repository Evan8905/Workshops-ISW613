CREATE TABLE IF NOT EXISTS courses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    course_code VARCHAR(20) NOT NULL,
    career_id INT UNSIGNED NOT NULL,
    credits INT UNSIGNED NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_courses_course_code (course_code)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
