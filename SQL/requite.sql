create database project_management;

use project_management;

Admin Password: admin123
CTO Password: ctoPass2025
Member Password: memberPass2025

CREATE TABLE user (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    image LONGBLOB NOT NULL,
    status ENUM("active", "deactivate") default 'active',
)


CREATE TABLE  role_member(
    role_id int,
    user_id int,
    foreign key (role_id) REFERENCES ROLE(role_id),
    foreign key (user_id) REFERENCES user(user_id)
    
) ENGINE=InnoDB;


CREATE TABLE projet (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(5000),
    user_id INT,
    status ENUM('ACTIVE','TERMINER',) default 'ACTIVE',
    visibility ENUM('private', 'public'),
    status ENUM('ACTIVE','TERMINER', 'DEACTIVE') default 'ACTIVE',
    FOREIGN KEY (user_id) REFERENCES user(user_id)
) ENGINE=InnoDB;


CREATE TABLE category (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
    user_id int,
    FOREIGN KEY (user_id) REFERENCES user(user_id)

) ENGINE=InnoDB;


CREATE TABLE tache (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(5000) NOT NULL,
    date DATE NOT NULL,
    status ENUM('A_FAIRE', 'EN_COURS', 'TERMINER') NOT NULL,
    tag ENUM('BASIQUE', 'BUG', 'FONCTIONNALITE') NOT NULL,
    user_id INT,
    category_id INT,
    projet_id INT,
    deleted ENUM('active', 'deactive') default 'active',
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (category_id) REFERENCES category(category_id),
    FOREIGN KEY (projet_id) REFERENCES projet(id)
) ENGINE=InnoDB;



CREATE TABLE ROLE (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name varchar(255) not null
) ENGINE=InnoDB;

responsable_de_creation , 1
responsable_de_supression , 2

CREATE TABLE  role_permission(
    role_id int,
    permession_id int,
    foreign key (role_id) REFERENCES ROLE(role_id),
    foreign key (permession_id) REFERENCES permission(permession_id)
    
) ENGINE=InnoDB;

CREATE TABLE  permission(
    permession_id INT PRIMARY KEY AUTO_INCREMENT,
    permission_name varchar(255) not null
    
) ENGINE=InnoDB;

1, creation 
2, supression

INSERT INTO admin (fullname, email, password) VALUES
('Super Admin', 'admin@projectmanagement.com', '$2y$10$abcdefghijklmnopqrstuuQPXMqOCGMB.xkZxhLlCl3X4TjX9Xjm');
-- Original password: admin123


-- Members (50 entries)
INSERT INTO member (fullname, email, password, cto_id, image) VALUES
('Emma Davis', 'emma.davis@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 1, ''),
('Liam Wilson', 'liam.wilson@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 1, ''),
('Olivia Brown', 'olivia.brown@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 1, ''),
('Noah Taylor', 'noah.taylor@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 1, ''),
('Ava Martinez', 'ava.martinez@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 1, ''),
('Ethan Johnson', 'ethan.johnson@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 2, ''),
('Sophia Anderson', 'sophia.anderson@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 2, ''),
('Mason Thompson', 'mason.thompson@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 2, ''),
('Isabella Clark', 'isabella.clark@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 2, ''),
('William Rodriguez', 'william.rodriguez@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 2, ''),
('Charlotte Lee', 'charlotte.lee@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 3, ''),
('James Walker', 'james.walker@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 3, ''),
('Amelia Hall', 'amelia.hall@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 3, ''),
('Benjamin Young', 'benjamin.young@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 3, ''),
('Mia King', 'mia.king@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 3, ''),
('Elijah Wright', 'elijah.wright@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 4, ''),
('Evelyn Lopez', 'evelyn.lopez@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 4, ''),
('Alexander Scott', 'alexander.scott@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 4, ''),
('Harper Green', 'harper.green@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 4, ''),
('Daniel Adams', 'daniel.adams@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 4, ''),
('Sofia Baker', 'sofia.baker@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 5, ''),
('Joseph Nelson', 'joseph.nelson@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 5, ''),
('Scarlett Carter', 'scarlett.carter@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 5, ''),
('Samuel Mitchell', 'samuel.mitchell@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 5, ''),
('Aria Perez', 'aria.perez@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 5, ''),
('David Roberts', 'david.roberts@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 6, ''),
('Chloe Turner', 'chloe.turner@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 6, ''),
('John Phillips', 'john.phillips@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 6, ''),
('Grace Campbell', 'grace.campbell@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 6, ''),
('Andrew Parker', 'andrew.parker@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 6, ''),
('Zoe Evans', 'zoe.evans@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 7, ''),
('Christopher Edwards', 'christopher.edwards@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 7, ''),
('Penelope Collins', 'penelope.collins@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 7, ''),
('Matthew Stewart', 'matthew.stewart@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 7, ''),
('Layla Sanchez', 'layla.sanchez@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 7, ''),
('Luke Morris', 'luke.morris@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 8, ''),
('Victoria Rogers', 'victoria.rogers@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 8, ''),
('Gabriel Reed', 'gabriel.reed@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 8, ''),
('Audrey Cook', 'audrey.cook@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 8, ''),
('Isaac Morgan', 'isaac.morgan@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 8, ''),
('Nora Bell', 'nora.bell@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 9, ''),
('Owen Murphy', 'owen.murphy@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 9, ''),
('Lily Bailey', 'lily.bailey@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 9, ''),
('Ryan Rivera', 'ryan.rivera@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 9, ''),
('Hannah Cooper', 'hannah.cooper@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 9, ''),
('Wyatt Richardson', 'wyatt.richardson@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 10, ''),
('Addison Cox', 'addison.cox@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 10, ''),
('Julian Howard', 'julian.howard@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 10, ''),
('Leah Ward', 'leah.ward@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 10, ''),
('Jack Torres', 'jack.torres@example.com', '$2y$10$qqipnLd6vMovQycmkSZ5luIXY/NMZWHtxSGYHMe01s6djeukSeVQO', 10, '');
-- Original password for all members: memberPass2025 CTOpass2025
