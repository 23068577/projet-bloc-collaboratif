CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(100),
    role ENUM('etudiant', 'administrateur') DEFAULT 'etudiant'
);
CREATE TABLE Article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    contenu TEXT,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id)
);

CREATE TABLE Commentaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    utilisateur_id INT,
    article_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id),
    FOREIGN KEY (article_id) REFERENCES Article(id)
);

-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table des articles
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

-- Table des commentaires
CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT NOT NULL,
    article_id INT,
    utilisateur_id INT,
    FOREIGN KEY (article_id) REFERENCES articles(id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255)
);

-- Table des articles
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    contenu TEXT,
    utilisateur_id INT,
    created_at DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    utilisateur_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);
