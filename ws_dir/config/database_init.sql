DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS consumer;
DROP TABLE IF EXISTS bookloan;


-- Création des tables
CREATE TABLE book (
    book_id int auto_increment,

    title varchar(255) NOT NULL,
    author varchar(255) NOT NULL,
    editor varchar(255) NOT NULL,
    publication_year year NOT NULL,
    category varchar(255) NOT NULL,
    stock int NOT NULL,

    CONSTRAINT PK_book PRIMARY KEY (book_id)
);

CREATE TABLE consumer (
    consumer_id int auto_increment,

    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    birthdate date,
    mail varchar(255),
    password varchar(255) NOT NULL,
    
    CONSTRAINT PK_consumer PRIMARY KEY (consumer_id)
);

CREATE TABLE bookloan (
    book_id int NOT NULL,
    consumer_id int NOT NULL,
    date_start date NOT NULL,
    date_end date NOT NULL,

    CONSTRAINT FK_bookloan_to_book
    FOREIGN KEY (book_id)
    REFERENCES book(book_id),

    CONSTRAINT FK_bookloan_to_consumer
    FOREIGN KEY (consumer_id)
    REFERENCES consumer(consumer_id)
);


-- Remplissage avec des valeurs de tests

-- Livres
INSERT INTO book
(book_id, title, author, editor, publication_year, category, stock)
VALUES
(NULL, "Super titre", "Moi", "Padéditeur", 1975, "Roman", 2);

-- Utilisateurs
INSERT INTO consumer
(consumer_id, firstname, lastname, birthdate, mail, password)
VALUES
(NULL, "Michel", "Samba", "1946-01-31", "michel.samba@gmiel.com", "$2y$10$pSNKCsO.PpTjJhot.f7Yd.Gpl0ZDNpvfcnoVAt0RcEBcwU9CbJ4dq");

-- Emprunts
INSERT INTO bookloan
(book_id, consumer_id, date_start, date_end)
VALUES
(1, 1, "2024-04-14", "2024-04-30");
