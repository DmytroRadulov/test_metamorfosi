 CREATE TABLE blogs
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(255),
    content    TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    author_id  INT,
    deleted    BOOLEAN   DEFAULT false,
    INDEX author_id_index (author_id),
    INDEX deleted_index (deleted)
);

CREATE TABLE categories
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted    BOOLEAN   DEFAULT false,
    INDEX deleted_index (deleted)
);

CREATE TABLE users
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255),
    lastname  VARCHAR(255),
    email     VARCHAR(255),
    password  VARCHAR(255),
    deleted   BOOLEAN DEFAULT false,
    INDEX deleted_index (deleted)
);

CREATE TABLE blog_category
(
    blog_id     INT,
    category_id INT,
    FOREIGN KEY (blog_id) REFERENCES blogs (id),
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE blog_user
(
    blog_id INT,
    user_id INT,
    FOREIGN KEY (blog_id) REFERENCES blogs (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

INSERT INTO blogs (title, content, author_id)
VALUES ('Barselona', 'Content blog barselona', 1),
       ('Premiere', 'iron Man', 2),
       ('The best place for fishing', 'City Odessa', 1);

INSERT INTO categories (title)
VALUES ('Football'),
       ('Movies'),
       ('Fishing');

INSERT INTO users (firstname, lastname, email, password)
VALUES ('leonel', 'Messi', 'messi@example.com', 'password1'),
       ('Robert', 'Dauni', 'dauni@example.com', 'password2');

INSERT INTO blog_category (blog_id, category_id)
VALUES (1, 1),
       (1, 2),
       (2, 2),
       (3, 3);

INSERT INTO blog_user (blog_id, user_id)
VALUES (1, 1),
       (2, 1),
       (3, 2);