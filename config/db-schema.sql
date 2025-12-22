-- ===========================================================
-- DATABASE: tauheed_academy_database (UPDATED)
-- ===========================================================

CREATE DATABASE IF NOT EXISTS tauheed_academy_database;
USE tauheed_academy_database;

-- ===========================================================
-- 1. ADMINS TABLE
-- ===========================================================
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255) NULL,
    reset_expires DATETIME NULL,
    type ENUM('admin', 'superAdmin') DEFAULT 'admin',
    staff_no VARCHAR(50) UNIQUE,
    address VARCHAR(255),
    qualification VARCHAR(255),
    experience VARCHAR(255),
    gender ENUM('male', 'female') DEFAULT 'male',
    department VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    phone VARCHAR(20),
    picture_path VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 2. SCHOOLS TABLE
-- ===========================================================
CREATE TABLE schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    motto VARCHAR(255),
    address VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100),
    about_message TEXT,
    welcome_message TEXT,
    whatsapp_number VARCHAR(20),
    facebook VARCHAR(255),
    twitter VARCHAR(255),
    instagram VARCHAR(255),
    admission_number_format VARCHAR(255),
    admission_number_format_description VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 3. TEACHERS TABLE
-- (created before sections)
-- ===========================================================
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    qualification VARCHAR(255),
    experience VARCHAR(255),
    gender ENUM('male', 'female') DEFAULT 'male',
    staff_no VARCHAR(50) UNIQUE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    picture_path VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255) NULL,
    reset_expires DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 4.1 SECTIONS TABLE
-- ===========================================================
CREATE TABLE sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    head_teacher_id INT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (head_teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ===========================================================
-- 4.2 ISLAMIYYA_SECTIONS TABLE
-- ===========================================================
CREATE TABLE islamiyya_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,          -- e.g. Primary Islamiyya, Junior Islamiyya, Senior Islamiyya
    description TEXT,
    head_teacher_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (head_teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ===========================================================
-- 5.1 CLASS_ARMS TABLE
-- ===========================================================
CREATE TABLE class_arms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 5.2 ISLAMIYYA_CLASS_ARMS TABLE
-- ===========================================================
CREATE TABLE islamiyya_class_arms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,          -- e.g. Islamiyya Primary 1A, Islamiyya Primary 1B
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ===========================================================
-- 6.1.1 CLASSES TABLE (unchanged except clearer naming comment)
-- ===========================================================
    CREATE TABLE classes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        section_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        level INT UNIQUE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    

        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;
-- ===========================================================
-- 6.1.2 ISLAMIYYA_CLASSES TABLE
-- ===========================================================
CREATE TABLE islamiyya_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,             -- links to islamiyya_sections
    name VARCHAR(100) NOT NULL,          -- e.g. Qur’an Level 1, Tajweed Level 2
    level INT UNIQUE NOT NULL,           -- used for promotion logic
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (section_id) REFERENCES islamiyya_sections(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===========================================================
-- 6.2.1 CLASS_CLASS_ARMS TABLE (pivot for many-to-many)
-- ===========================================================
CREATE TABLE class_class_arms (
    class_id INT NOT NULL,
    arm_id INT NOT NULL,
    teacher_id INT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (class_id, arm_id),
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (arm_id) REFERENCES class_arms(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ===========================================================
-- 6.2.2 ISLAMIYYA_CLASS_CLASS_ARMS TABLE (pivot for many-to-many)
-- ===========================================================
CREATE TABLE islamiyya_class_class_arms (
    class_id INT NOT NULL,
    arm_id INT NOT NULL,
    teacher_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (class_id, arm_id),
    FOREIGN KEY (class_id) REFERENCES islamiyya_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (arm_id) REFERENCES islamiyya_class_arms(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ===========================================================
-- 7. TEACHER_SECTION TABLE
-- ===========================================================
CREATE TABLE teacher_section (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    section_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===========================================================
-- 8.1.1 SUBJECTS TABLE
-- ===========================================================
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 8.1.2 CLASS_SUBJECTS TABLE
-- ===========================================================
CREATE TABLE class_subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    subject_id INT NOT NULL,
    teacher_id INT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    UNIQUE (class_id, subject_id, teacher_id)
) ENGINE=InnoDB;


-- ===========================================================
-- 8.2.1 ISLAMIYYA_SUBJECTS TABLE
-- ===========================================================
CREATE TABLE islamiyya_subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,          -- e.g. Qur’an, Tajweed, Fiqh, Hadith
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 8.2.2 ISLAMIYYA_CLASS_SUBJECTS TABLE
-- ===========================================================
CREATE TABLE islamiyya_class_subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,               -- links to islamiyya_classes
    subject_id INT NOT NULL,             -- links to islamiyya_subjects
    teacher_id INT NULL,                 -- teacher responsible for subject
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES islamiyya_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES islamiyya_subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    UNIQUE (class_id, subject_id, teacher_id)
) ENGINE=InnoDB;


-- ===========================================================
-- 9. GUARDIANS TABLE
-- ===========================================================
CREATE TABLE guardians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    picture_path VARCHAR(255),
    relationship VARCHAR(255),
    gender ENUM('male', 'female') DEFAULT 'male',
    occupation VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
       reset_token VARCHAR(255) NULL,
    reset_expires DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 10 SESSIONS TABLE
-- ===========================================================
CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL, -- e.g., '2023/2024'
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================================
-- 10.1 TERMS TABLE
-- ===========================================================
CREATE TABLE terms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL, -- e.g., 'First Term'
    session_id INT NOT NULL,
    start_date DATE,
    end_date DATE,
    status ENUM('pending', 'ongoing', 'finished') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE
) ENGINE=InnoDB;


-- ===========================================================
-- 10.2 STUDENTS TABLE (UPDATED for hybrid structure)
-- ===========================================================
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    admission_number VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NULL,
    phone VARCHAR(20) NULL,
    guardian_id INT,
    dob DATE,

    picture_path VARCHAR(255),

    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255) NULL,
    reset_expires DATETIME NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    gender ENUM('male', 'female') DEFAULT 'male',
    
    -- Academic track
    class_id INT NULL,
    arm_id INT NULL,
    term_id INT NULL,

    -- Islamiyya track
    islamiyya_class_id INT NULL,
    islamiyya_arm_id INT NULL,

    -- Registration session (first session student was registered)
    registration_session_id INT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (guardian_id) REFERENCES guardians(id) ON DELETE SET NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (arm_id) REFERENCES class_arms(id) ON DELETE SET NULL,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE SET NULL,
    FOREIGN KEY (islamiyya_class_id) REFERENCES islamiyya_classes(id) ON DELETE SET NULL,
    FOREIGN KEY (islamiyya_arm_id) REFERENCES islamiyya_class_arms(id) ON DELETE SET NULL,
    FOREIGN KEY (registration_session_id) REFERENCES sessions(id) ON DELETE SET NULL
) ENGINE=InnoDB;


-- ===========================================================
-- 10.3.1 STUDENT_CLASS_RECORDS TABLE (UPDATED hybrid)
-- ===========================================================

CREATE TABLE student_class_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    session_id INT NOT NULL,
    class_id INT NOT NULL,
    arm_id INT NOT NULL,

    overall_total DECIMAL(8,2) DEFAULT 0,
    overall_average DECIMAL(5,2) DEFAULT 0,
    overall_position INT DEFAULT NULL,
    promotion_status ENUM('promoted', 'repeat', 'pending') DEFAULT 'pending',

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (arm_id) REFERENCES class_arms(id) ON DELETE CASCADE,

    UNIQUE (student_id, session_id)
) ENGINE=InnoDB;

-- ===========================================================
-- 10.3.2 ISLAMIYYA_STUDENT_CLASS_RECORDS TABLE
-- ===========================================================
CREATE TABLE islamiyya_student_class_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    session_id INT NOT NULL,
    class_id INT NOT NULL,
    arm_id INT NOT NULL,

    overall_total DECIMAL(8,2) DEFAULT 0,
    overall_average DECIMAL(5,2) DEFAULT 0,
    overall_position INT DEFAULT NULL,
    promotion_status ENUM('promoted', 'repeat', 'pending') DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES islamiyya_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (arm_id) REFERENCES islamiyya_class_arms(id) ON DELETE CASCADE,

    UNIQUE (student_id, session_id)
) ENGINE=InnoDB;

-- ===========================================================
-- 10.4.1 STUDENT_TERM_RECORDS TABLE (UPDATED hybrid)
-- ===========================================================
CREATE TABLE student_term_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_class_record_id INT NOT NULL,
    term_id INT NOT NULL,

    total_marks DECIMAL(8,2) DEFAULT 0,
    average_marks DECIMAL(5,2) DEFAULT 0,
    position_in_class INT DEFAULT NULL,
    class_size INT DEFAULT NULL,
    overall_grade VARCHAR(5) NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (student_class_record_id) REFERENCES student_class_records(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,

    UNIQUE (student_class_record_id, term_id)
) ENGINE=InnoDB;


-- ===========================================================
-- 10.4.2 ISLAMIYYA_STUDENT_TERM_RECORDS TABLE
-- ===========================================================
CREATE TABLE islamiyya_student_term_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_class_record_id INT NOT NULL,
    term_id INT NOT NULL,

    total_marks DECIMAL(8,2) DEFAULT 0,
    average_marks DECIMAL(5,2) DEFAULT 0,
    position_in_class INT DEFAULT NULL,
    class_size INT DEFAULT NULL,
    overall_grade VARCHAR(5) NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (student_class_record_id) REFERENCES islamiyya_student_class_records(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,

    UNIQUE (student_class_record_id, term_id)
) ENGINE=InnoDB;

-- ===========================================================
-- 11.1 RESULTS TABLE
-- ===========================================================
CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_term_record_id INT NOT NULL,
    subject_id INT NOT NULL,

    ca DECIMAL(5,2) DEFAULT 0.00,
    exam DECIMAL(5,2) DEFAULT 0.00,
    total DECIMAL(6,2) GENERATED ALWAYS AS (ca + exam) STORED,
    grade VARCHAR(2),
    remark VARCHAR(50),

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (student_term_record_id) REFERENCES student_term_records(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,

    UNIQUE (student_term_record_id, subject_id)
) ENGINE=InnoDB;


-- ===========================================================
-- 11.2 ISLAMIYYA_RESULTS TABLE
-- ===========================================================
CREATE TABLE islamiyya_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_term_record_id INT NOT NULL,
    subject_id INT NOT NULL,

    ca DECIMAL(5,2) DEFAULT 0.00,   -- Continuous Assessment
    exam DECIMAL(5,2) DEFAULT 0.00, -- Exam score
    total DECIMAL(6,2) GENERATED ALWAYS AS (ca + exam) STORED,
    grade VARCHAR(2),
    remark VARCHAR(50),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (student_term_record_id) REFERENCES islamiyya_student_term_records(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES islamiyya_subjects(id) ON DELETE CASCADE,

    UNIQUE (student_term_record_id, subject_id)
) ENGINE=InnoDB;

-- ===========================================================
-- 12. NEWS TABLE
-- ===========================================================
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    category ENUM('announcement', 'event', 'achievement', 'update') DEFAULT 'announcement',
    content TEXT,
    picture_path VARCHAR(255),
    publication_date TIMESTAMP,
    status ENUM('draft', 'published') DEFAULT 'draft',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ===========================================================
-- 13.1 FEES TABLE
-- ===========================================================
CREATE TABLE fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    first_term DECIMAL(10,2),
    second_term DECIMAL(10,2),
    third_term DECIMAL(10,2),
    uniform DECIMAL(10,2),
    transport DECIMAL(10,2),
    materials DECIMAL(10,2),
    registration DECIMAL(10,2),
    pta DECIMAL(10,2),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_fees_class
        FOREIGN KEY (class_id) REFERENCES classes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ===========================================================
-- 13.2 ISLAMIYYA FEES TABLE
-- ===========================================================
CREATE TABLE islamiyya_fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    islamiyya_class_id INT NOT NULL,
    first_term DECIMAL(10,2),
    second_term DECIMAL(10,2),
    third_term DECIMAL(10,2),
    materials DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_islamiyya_fees_class FOREIGN KEY (islamiyya_class_id) REFERENCES islamiyya_classes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;


-- ===========================================================
-- 14. BANK ACCOUNTS TABLE
-- ===========================================================
CREATE TABLE bank_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_name VARCHAR(255),
    account_name VARCHAR(255),
    account_number VARCHAR(34),
    purpose VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
) ENGINE=InnoDB;
