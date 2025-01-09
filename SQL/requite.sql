create database project_management;

use project_management;

Admin Password: admin123
CTO Password: ctoPass2025
Member Password: memberPass2025

CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE CTO (
    cto_id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status ENUM("active", "deactivate") default 'active'

);



CREATE TABLE projet (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(5000),
    cto_id INT,
    status ENUM('ACTIVE','TERMINER',) default 'ACTIVE',
    visibility ENUM('private', 'public'),
    status ENUM('ACTIVE','TERMINER', 'DEACTIVE') default 'ACTIVE',
    FOREIGN KEY (cto_id) REFERENCES CTO(cto_id)
) ENGINE=InnoDB;

CREATE TABLE member (
    member_id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    cto_id int,
    image LONGBLOB NOT NULL,
    status ENUM("active", "deactivate") default 'active',
    FOREIGN KEY (cto_id) REFERENCES CTO(cto_id)
) ENGINE=InnoDB;


CREATE TABLE category (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
    cto_id int,
    FOREIGN KEY (cto_id) REFERENCES CTO(cto_id)

) ENGINE=InnoDB;


CREATE TABLE tache (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(5000) NOT NULL,
    date DATE NOT NULL,
    status ENUM('A_FAIRE', 'EN_COURS', 'TERMINER') NOT NULL,
    tag ENUM('BASIQUE', 'BUG', 'FONCTIONNALITE') NOT NULL,
    member_id INT,
    category_id INT,
    projet_id INT,
    deleted ENUM('active', 'deactive') default 'active',
    FOREIGN KEY (member_id) REFERENCES member(member_id),
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
