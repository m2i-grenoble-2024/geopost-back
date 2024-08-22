DROP TABLE IF EXISTS post;

DROP TABLE IF EXISTS category;

CREATE TABLE category (
    id INT PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(255) NOT NULL
);

CREATE TABLE post(
    id INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT NOT NULL,
    posted_at DATETIME NOT NULL,
    latitude DOUBLE NOT NULL,
    longitude DOUBLE NOT NULL,
    author VARCHAR(255),
    picture VARCHAR(255),
    -- si qu'une seule table, on fait pas ces deux lignes suivantes
    category_id INT,
    Foreign Key (category_id) REFERENCES category(id)
);


INSERT INTO category (label) VALUES ('street art'), ('food'), ('social'), ('warnings');

INSERT INTO post (message, posted_at, latitude,longitude,author, category_id) VALUES
('Great art', '2024-08-18', 45.76965135594465, 4.827156535674179, 'Bobby', 1),
('Good food', '2024-08-19', 45.76965135594534, 4.827156535674123, 'Bobby', 2),
('Another great art', '2024-08-19', 45.76965134394465, 4.827154335674179, 'Raya', 1),
('Social gathering', '2024-08-20', 45.7696513559876, 4.827156535674234, 'Ling', 3);