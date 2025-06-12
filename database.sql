CREATE DATABASE IF NOT EXISTS patisserie_academie;
USE patisserie_academie;

CREATE TABLE utilisateur (
    utilisateur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    numéro_de_téléphone VARCHAR(20),
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    progression INT DEFAULT 0,
    certificat_date DATE
);

CREATE TABLE formation (
    formation_id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    niveau VARCHAR(50)
);

CREATE TABLE leçon (
    leçon_id INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT,
    ordre INT DEFAULT 1,
    titre VARCHAR(255) NOT NULL,
    image_url VARCHAR(255),
    vidéo_url VARCHAR(255),
    FOREIGN KEY (formation_id) REFERENCES formation(formation_id) ON DELETE CASCADE
);


CREATE TABLE question (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT,
    question_texte TEXT NOT NULL,
    FOREIGN KEY (formation_id) REFERENCES formation(formation_id) ON DELETE CASCADE
);

CREATE TABLE choix (
    choix_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    choix_texte VARCHAR(255) NOT NULL,
    est_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE
);

CREATE TABLE test (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    score INT,
    formation_id INT,
    tentative INT,
    date_passée DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id) ON DELETE CASCADE
);

-- Formation 1 : Bases de la Pâtisserie (Débutant)
INSERT INTO leçon (formation_id, titre, image_url, vidéo_url, ordre) VALUES
(1, 'Préparation de la génoise', 'genoise.jpg', 'https://youtu.be/3kARr7x_svU?si=P10nWPykKDIozGz5', 1),
(1, 'Crèmes de base', 'creme.jpg', 'https://youtu.be/2BFZe4nid28?si=Gw1-_PF5d0lhtpYz', 2);

-- Formation 2 : Techniques Modernes (Intermédiaire)
INSERT INTO leçon (formation_id, titre, image_url, vidéo_url, ordre) VALUES
(2, 'Glaçage miroir', 'glacage.jpg', 'https://youtu.be/8JG3A88S-2Y?si=f-0IqSiGgjOXDyZU', 1),
(2, 'Inserts', 'insert.jpg', 'https://youtu.be/WlR-J6PHmhA?si=QGS7juiyp_vlwxIN', 2),
(2, 'Mousses', 'mousses.jpg', 'https://youtu.be/wOhwX4UVFQk?si=bPhAKazneL69cSar', 3);

-- Formation 3 : Création & Perfectionnement (Avancé)
INSERT INTO leçon (formation_id, titre, image_url, vidéo_url, ordre) VALUES
(3, 'Décoration en chocolat', 'chocolat.jpg', 'https://youtu.be/uhOyjqINWLU?si=4xM85fEwfAOaD3g-', 1),
(3, 'Décoration des tartes', 'tarte.jpg', 'https://youtu.be/HcCzmFTqAqU?si=emX5iLyq_T0X13_s', 2);

INSERT INTO formation (titre, description, niveau) VALUES
('Bases de la Pâtisserie', 'Apprentissage des recettes classiques : tartes, génoises, crèmes de base', 'Débutant'),
('Techniques Modernes', 'Travail des entremets, mousses, inserts, glaçages, et équilibre des saveurs.', 'Intermédiaire'),
('Création & Perfectionnement', 'Techniques poussées, chocolat, design et créations signature.', 'Avancé');

-- أسئلة (تغيير formation_id حسب الحاجة)
INSERT INTO question (formation_id, question_texte) VALUES
(2, 'Qu''est-ce que le glaçage miroir en pâtisserie?'),
(2, 'Quelle est la fonction principale d''un insert dans un entremets?'),
(2, 'Quel ingrédient est essentiel pour stabiliser une mousse?'),
(2, 'À quelle température doit-on verser un glaçage miroir?'),
(2, 'Comment doit être la texture d''une mousse réussie?');

-- اختيارات السؤال 1
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(1, 'Un glaçage brillant et lisse', TRUE),
(1, 'Une pâte pour biscuits', FALSE),
(1, 'Un glaçage mat', FALSE),
(1, 'Un biscuit croustillant', FALSE);

-- اختيارات السؤال 2
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(2, 'Créer un cœur caché dans un gâteau', TRUE),
(2, 'Décorer le dessus du gâteau', FALSE),
(2, 'Faire croustiller une couche', FALSE),
(2, 'Donner une couleur au gâteau', FALSE);

-- اختيارات السؤال 3
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(3, 'La gélatine', TRUE),
(3, 'Le sucre glace', FALSE),
(3, 'La farine', FALSE),
(3, 'Le beurre', FALSE);

-- اختيارات السؤال 4
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(4, 'Entre 30°C et 35°C', TRUE),
(4, 'À température ambiante', FALSE),
(4, 'Directement sortie du congélateur', FALSE),
(4, 'À plus de 50°C', FALSE);

-- اختيارات السؤال 5
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(5, 'Légère et aérienne', TRUE),
(5, 'Dense et compacte', FALSE),
(5, 'Liquide', FALSE),
(5, 'Granuleuse', FALSE);


-- Génoise
INSERT INTO question (formation_id, question_texte) VALUES
(1, 'Quelle est la température idéale pour cuire une génoise ?'),
(1, 'Est-ce qu’on utilise de la levure chimique dans une génoise classique ?'),
(1, 'Quel est l’état des œufs et du sucre avant d’ajouter la farine dans une génoise ?');

-- Crèmes de base
INSERT INTO question (formation_id, question_texte) VALUES
(1, 'Quelle crème est utilisée pour garnir les tartes et les éclairs ?'),
(1, 'Quels sont les ingrédients principaux d’une crème pâtissière ?');

-- Question 1
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(1, '160°C', FALSE),
(1, '180°C', TRUE),
(1, '200°C', FALSE),
(1, '220°C', FALSE);

-- Question 2
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(2, 'Oui', TRUE),
(2, 'Non', FALSE),
(2, 'Seulement avec du chocolat', FALSE),
(2, 'Ça dépend du four', FALSE);

-- Question 3
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(3, 'Les œufs doivent être froids', FALSE),
(3, 'Le sucre doit être fondu', FALSE),
(3, 'Le mélange œufs-sucre doit être bien monté', TRUE),
(3, 'Les œufs doivent être séparés', FALSE);

-- Question 4
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(4, 'Crème chantilly', FALSE),
(4, 'Crème anglaise', FALSE),
(4, 'Crème pâtissière', TRUE),
(4, 'Crème au beurre', FALSE);

-- Question 5
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(5, 'Lait, œufs, sucre, farine ou maïzena', TRUE),
(5, 'Crème liquide, sucre, chocolat', FALSE),
(5, 'Farine, huile, eau', FALSE),
(5, 'Juste du lait', FALSE);






-- Insert Questions de la formation 3
INSERT INTO question (formation_id, question_texte) VALUES
(3, 'Quel est le bon tempérage du chocolat noir pour une décoration brillante?');
SET @q1 = LAST_INSERT_ID();

INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q1, 'Entre 31°C et 32°C', TRUE),
(@q1, 'Entre 40°C et 45°C', FALSE),
(@q1, 'À température ambiante', FALSE),
(@q1, 'Directement sortie du frigo', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(3, 'Quelle est la meilleure technique pour coller une décoration en chocolat sur un entremets?');
SET @q2 = LAST_INSERT_ID();

INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q2, 'Avec un peu de chocolat fondu comme colle', TRUE),
(@q2, 'Avec du sucre glace', FALSE),
(@q2, 'Avec de la farine', FALSE),
(@q2, 'Avec de l''eau', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(3, 'Quel fruit est souvent utilisé pour décorer les tartes classiques?');
SET @q3 = LAST_INSERT_ID();

INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q3, 'Fraises', TRUE),
(@q3, 'Pommes de terre', FALSE),
(@q3, 'Lentilles', FALSE),
(@q3, 'Oignons', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(3, 'Quel ustensile est idéal pour créer des motifs en chocolat?');
SET @q4 = LAST_INSERT_ID();

INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q4, 'Cornet en papier ou poche à douille', TRUE),
(@q4, 'Fouet', FALSE),
(@q4, 'Couteau à pain', FALSE),
(@q4, 'Maryse', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(3, 'Pourquoi utilise-t-on un nappage sur une tarte aux fruits?');
SET @q5 = LAST_INSERT_ID();

INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q5, 'Pour donner de la brillance et protéger les fruits', TRUE),
(@q5, 'Pour épaissir la pâte', FALSE),
(@q5, 'Pour sucrer la crème', FALSE),
(@q5, 'Pour décorer le plat', FALSE);




-- Création de la base et utilisation
DROP DATABASE IF EXISTS patisserie_academie;
CREATE DATABASE patisserie_academie;
USE patisserie_academie;

-- Tables
CREATE TABLE utilisateur (
    utilisateur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    numéro_de_téléphone VARCHAR(20),
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    progression INT DEFAULT 0,
    certificat_date DATE
);

CREATE TABLE formation (
    formation_id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    niveau VARCHAR(50)
);

CREATE TABLE leçon (
    leçon_id INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT,
    ordre INT DEFAULT 1,
    titre VARCHAR(255) NOT NULL,
    image_url VARCHAR(255),
    vidéo_url VARCHAR(255),
    FOREIGN KEY (formation_id) REFERENCES formation(formation_id) ON DELETE CASCADE
);

CREATE TABLE question (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT,
    question_texte TEXT NOT NULL,
    FOREIGN KEY (formation_id) REFERENCES formation(formation_id) ON DELETE CASCADE
);

CREATE TABLE choix (
    choix_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    choix_texte VARCHAR(255) NOT NULL,
    est_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE
);

CREATE TABLE test (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    score INT,
    date_passée DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id) ON DELETE CASCADE
);

-- Insert Formation 1
INSERT INTO formation (titre, description, niveau) VALUES
('Bases de la Pâtisserie', 'Apprentissage des recettes classiques : tartes, génoises, crèmes de base', 'Débutant');
SET @f1 = LAST_INSERT_ID();

-- Insert Leçons Formation 1
INSERT INTO leçon (formation_id, ordre, titre, image_url, vidéo_url) VALUES
(@f1, 1, 'Préparation de la génoise', 'genoise.jpg', 'https://youtu.be/3kARr7x_svU?si=P10nWPykKDIozGz5'),
(@f1, 2, 'Crèmes de base', 'creme.jpg', 'https://youtu.be/2BFZe4nid28?si=Gw1-_PF5d0lhtpYz');

-- Insert Questions + Choix Formation 1
INSERT INTO question (formation_id, question_texte) VALUES
(@f1, 'Quelle est la température idéale pour cuire une génoise ?');
SET @q1 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q1, '160°C', FALSE), (@q1, '180°C', TRUE), (@q1, '200°C', FALSE), (@q1, '220°C', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f1, 'Est-ce qu’on utilise de la levure chimique dans une génoise classique ?');
SET @q2 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q2, 'Oui', TRUE), (@q2, 'Non', FALSE), (@q2, 'Seulement avec du chocolat', FALSE), (@q2, 'Ça dépend du four', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f1, 'Quel est l’état des œufs et du sucre avant d’ajouter la farine dans une génoise ?');
SET @q3 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q3, 'Les œufs doivent être froids', FALSE), (@q3, 'Le sucre doit être fondu', FALSE),
(@q3, 'Le mélange œufs-sucre doit être bien monté', TRUE), (@q3, 'Les œufs doivent être séparés', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f1, 'Quelle crème est utilisée pour garnir les tartes et les éclairs ?');
SET @q4 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q4, 'Crème chantilly', FALSE), (@q4, 'Crème anglaise', FALSE), (@q4, 'Crème pâtissière', TRUE), (@q4, 'Crème au beurre', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f1, 'Quels sont les ingrédients principaux d’une crème pâtissière ?');
SET @q5 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q5, 'Lait, œufs, sucre, farine ou maïzena', TRUE), (@q5, 'Crème liquide, sucre, chocolat', FALSE),
(@q5, 'Farine, huile, eau', FALSE), (@q5, 'Juste du lait', FALSE);


-- Insert Formation 2
INSERT INTO formation (titre, description, niveau) VALUES
('Techniques Modernes', 'Travail des entremets, mousses, inserts, glaçages, et équilibre des saveurs.', 'Intermédiaire');
SET @f2 = LAST_INSERT_ID();

-- Insert Leçons Formation 2
INSERT INTO leçon (formation_id, ordre, titre, image_url, vidéo_url) VALUES
(@f2, 1, 'Glaçage miroir', 'glacage.jpg', 'https://youtu.be/8JG3A88S-2Y?si=f-0IqSiGgjOXDyZU'),
(@f2, 2, 'Inserts', 'insert.jpg', 'https://youtu.be/WlR-J6PHmhA?si=QGS7juiyp_vlwxIN'),
(@f2, 3, 'Mousses', 'mousses.jpg', 'https://youtu.be/wOhwX4UVFQk?si=bPhAKazneL69cSar');

-- Insert Questions + Choix Formation 2
INSERT INTO question (formation_id, question_texte) VALUES
(@f2, 'Qu\'est-ce que le glaçage miroir en pâtisserie?');
SET @q6 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q6, 'Un glaçage brillant et lisse', TRUE), (@q6, 'Une pâte pour biscuits', FALSE),
(@q6, 'Un glaçage mat', FALSE), (@q6, 'Un biscuit croustillant', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f2, 'Quelle est la fonction principale d\'un insert dans un entremets?');
SET @q7 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q7, 'Créer un cœur caché dans un gâteau', TRUE), (@q7, 'Décorer le dessus du gâteau', FALSE),
(@q7, 'Faire croustiller une couche', FALSE), (@q7, 'Donner une couleur au gâteau', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f2, 'Quel ingrédient est essentiel pour stabiliser une mousse?');
SET @q8 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q8, 'La gélatine', TRUE), (@q8, 'Le sucre glace', FALSE), (@q8, 'La farine', FALSE), (@q8, 'Le beurre', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f2, 'À quelle température doit-on verser un glaçage miroir?');
SET @q9 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q9, 'Entre 30°C et 35°C', TRUE), (@q9, 'À température ambiante', FALSE),
(@q9, 'Directement sortie du congélateur', FALSE), (@q9, 'À plus de 50°C', FALSE);

INSERT INTO question (formation_id, question_texte) VALUES
(@f2, 'Comment doit être la texture d\'une mousse réussie?');
SET @q10 = LAST_INSERT_ID();
INSERT INTO choix (question_id, choix_texte, est_correct) VALUES
(@q10, 'Légère et aérienne', TRUE), (@q10, 'Dense et compacte', FALSE),
(@q10, 'Liquide', FALSE), (@q10, 'Granuleuse', FALSE);


-- Insert Formation 3
INSERT INTO formation (titre, description, niveau) VALUES
('Création & Perfectionnement', 'Techniques poussées, chocolat, design et créations signature.', 'Avancé');
SET @f3 = LAST_INSERT_ID();

-- Insert Leçons Formation 3
INSERT INTO leçon (formation_id, ordre, titre, image_url, vidéo_url) VALUES
(@f3, 1, 'Décoration en chocolat', 'chocolat.jpg', 'https://youtu.be/uhOyjqINWLU?si=4xM85fEwfAOaD3g-'),
(@f3, 2, 'Décoration des tartes', 'tarte.jpg', 'https://youtu.be/HcCzmFTqAqU?si=emX5iLyq_T0X13_s');

-- (Questions de la formation 3 n'étaient pas fournies, tu peux les rajouter بنفس الطريقة)
