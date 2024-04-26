-- 
-- Script d'initialisation de la base de donnée
-- 

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Supprime les tables si elles existents déjà

DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS consumer;
DROP TABLE IF EXISTS bookloan;
DROP TABLE IF EXISTS cartitem;

-- (re) Création des tables
CREATE TABLE book (
    book_id int auto_increment,

    title varchar(255) NOT NULL,
    author varchar(255) NOT NULL,
    editor varchar(255) NOT NULL,
    publication_year int NOT NULL,
    category varchar(255) NOT NULL,
    stock int NOT NULL,

    CONSTRAINT PK_book PRIMARY KEY (book_id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE consumer (
    consumer_id int auto_increment,

    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    birthdate date,
    mail varchar(255),
    password varchar(255) NOT NULL,
    
    CONSTRAINT PK_consumer PRIMARY KEY (consumer_id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE cartitem (
    book_id int NOT NULL,
    consumer_id int NOT NULL,

    CONSTRAINT FK_cartitem_to_book
    FOREIGN KEY (book_id)
    REFERENCES book(book_id),

    CONSTRAINT FK_cartitem_to_consumer
    FOREIGN KEY (consumer_id)
    REFERENCES consumer(consumer_id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Remplissage avec des valeurs de tests

-- Livres  ; valeures générées via ChatGPT
INSERT INTO book
(book_id, title, author, editor, publication_year, category, stock)
VALUES
(NULL, "Super titre", "Moi", "Padéditeur", "1975", "Roman", 2),
(NULL, "Les Misérables", "Victor Hugo", "Gallimard", "1862", "Roman classique", 3),
(NULL, "1984", "George Orwell", "Secker & Warburg", "1949", "Science-fiction", 5),
(NULL, "Le Seigneur des Anneaux", "J.R.R. Tolkien", "Allen & Unwin", "1954", "Fantasy", 3),
(NULL, "Le Petit Prince", "Antoine de Saint-Exupéry", "Reynal & Hitchcock", "1943", "Conte philosophique", 4),
(NULL, "Harry Potter à l'école des sorciers", "J.K. Rowling", "Bloomsbury", "1997", "Jeunesse", 5),
(NULL, "Crime et Châtiment", "Fiodor Dostoïevski", "The Russian Messenger", "1866", "Roman psychologique", 3),
(NULL, "Orgueil et Préjugés", "Jane Austen", "T. Egerton, Whitehall", "1813", "Roman romantique", 4),
(NULL, "L'Étranger", "Albert Camus", "Gallimard", "1942", "Roman philosophique", 5),
(NULL, "Guerre et Paix", "Léon Tolstoï", "The Russian Messenger", "1869", "Roman historique", 2),
(NULL, "Le Parfum", "Patrick Süskind", "Diogenes Verlag", "1985", "Roman noir", 3),
(NULL, "Les Trois Mousquetaires", "Alexandre Dumas", "Baudry", "1844", "Roman d'aventure", 3),
(NULL, "Anna Karénine", "Léon Tolstoï", "The Russian Messenger", "1877", "Roman réaliste", 2),
(NULL, "Le Comte de Monte-Cristo", "Alexandre Dumas", "Pétion", "1844", "Roman d'aventure", 3),
(NULL, "Fahrenheit 451", "Ray Bradbury", "Ballantine Books", "1953", "Science-fiction", 5),
(NULL, "Don Quichotte", "Miguel de Cervantes", "Francisco de Robles", "1605", "Roman de chevalerie", 2),
(NULL, "Les Hauts de Hurlevent", "Emily Brontë", "Thomas Cautley Newby", "1847", "Roman gothique", 4),
(NULL, "Le Portrait de Dorian Gray", "Oscar Wilde", "Ward, Lock and Company", "1890", "Roman fantastique", 5),
(NULL, "Le Vieil Homme et la Mer", "Ernest Hemingway", "Charles Scribner's Sons", "1952", "Roman philosophique", 5),
(NULL, "Les Raisins de la colère", "John Steinbeck", "The Viking Press", "1939", "Roman réaliste", 1),
(NULL, "Voyage au bout de la nuit", "Louis-Ferdinand Céline", "Éditions Denoël", "1932", "Roman noir", 3),
(NULL, "Les Frères Karamazov", "Fiodor Dostoïevski", "The Russian Messenger", "1880", "Roman philosophique", 4),
(NULL, "Vingt mille lieues sous les mers", "Jules Verne", "Pierre-Jules Hetzel", "1870", "Roman d'aventure", 5),
(NULL, "Le Tour du monde en quatre-vingts jours", "Jules Verne", "Pierre-Jules Hetzel", "1873", "Roman d'aventure", 5),
(NULL, "Les Quatre Filles du docteur March", "Louisa May Alcott", "Roberts Brothers", "1868", "Roman jeunesse", 3),
(NULL, "Le Nom de la rose", "Umberto Eco", "Bompiani", "1980", "Roman historique", 4),
(NULL, "Moby Dick", "Herman Melville", "Richard Bentley", "1851", "Roman d'aventure", 4),
(NULL, "Autant en emporte le vent", "Margaret Mitchell", "Macmillan Publishers", "1936", "Roman historique", 3),
(NULL, "Les Piliers de la Terre", "Ken Follett", "William Morrow and Company", "1989", "Roman historique", 4),
(NULL, "Le Journal d'Anne Frank", "Anne Frank", "Contact Publishing", "1947", "Journal intime", 2),
(NULL, "Matilda", "Roald Dahl", "Jonathan Cape", "1988", "Jeunesse", 5),
(NULL, "Les Aventures de Tom Sawyer", "Mark Twain", "Charles L. Webster And Company", "1876", "Roman jeunesse", 4),
(NULL, "Les Aventures d'Alice au pays des merveilles", "Lewis Carroll", "Macmillan", "1865", "Roman jeunesse", 4),
(NULL, "Les Enfants du capitaine Grant", "Jules Verne", "Pierre-Jules Hetzel", "1868", "Roman d'aventure", 4),
(NULL, "La Guerre et la Paix", "Léon Tolstoï", "The Russian Messenger", "1869", "Roman historique", 2);

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


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
