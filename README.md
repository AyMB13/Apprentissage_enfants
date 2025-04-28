Veuillez ajouter ce script(ou script similaire) dans phpMyAdmin pour créer la base de données nécessaire au fonctionnement du site.

DROP DATABASE IF EXISTS apprentissage_enfants;
CREATE DATABASE apprentissage_enfants
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE apprentissage_enfants;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE elements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categorie_id INT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    audio_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE administrateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (nom, description) VALUES
('Animaux de la ferme', 'Découvrez les animaux que l''on trouve dans une ferme'),
('Animaux de la jungle', 'Explorez les animaux sauvages de la jungle'),
('Animaux marins', 'Découvrez les créatures fascinantes de l''océan'),
('Animaux domestiques', 'Apprenez à connaître les animaux de compagnie'),
('Oiseaux', 'Découvrez les différentes espèces d''oiseaux');

INSERT INTO elements (categorie_id, nom, description, image_path) VALUES
(1, 'Vache', 'La vache nous donne du lait', 'images/farm/cow.jpg'),
(1, 'Poule', 'La poule pond des œufs', 'images/farm/chicken.jpg'),
(1, 'Cochon', 'Le cochon aime jouer dans la boue', 'images/farm/pig.jpg'),
(2, 'Lion', 'Le roi de la jungle', 'images/jungle/lion.jpg'),
(2, 'Éléphant', 'Le plus grand animal terrestre', 'images/jungle/elephant.jpg'),
(2, 'Girafe', 'L''animal au long cou', 'images/jungle/giraffe.jpg'),
(3, 'Dauphin', 'Un mammifère marin très intelligent', 'images/sea/dolphin.jpg'),
(3, 'Baleine', 'Le plus grand animal du monde', 'images/sea/whale.jpg'),
(4, 'Chat', 'Un animal de compagnie affectueux', 'images/pets/cat.jpg'),
(4, 'Chien', 'Le meilleur ami de l''homme', 'images/pets/dog.jpg'),
(5, 'Perroquet', 'Un oiseau qui peut parler', 'images/birds/parrot.jpg'),
(5, 'Aigle', 'Le roi des oiseaux', 'images/birds/eagle.jpg');

INSERT INTO administrateurs (username, password_hash) VALUES
('admin', '$2y$10$8K1p/bMmqskXnHhxhvMkPOoWf6.jcGk7hQxwD5mOgNzKxV0Q3ZlG.');
