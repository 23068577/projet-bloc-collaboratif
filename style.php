<?php
$host = 'localhost';      // Adresse de votre serveur MySQL
$dbname = 'blog';         // Nom de la base de données
$username = 'root';       // Nom d'utilisateur MySQL
$password = '';           // Mot de passe MySQL

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichage de l'erreur en cas de problème
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
?>
<?php
include('db.php'); // Inclure la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

    // Hash du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Insertion des données dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe_hash
    ]);

    echo "Inscription réussie!";
}
?>

<!-- Formulaire d'inscription -->
<form action="inscription.php" method="POST">
    <label for="nom">Nom :</label><br>
    <input type="text" name="nom" required><br><br>
    <label for="email">Email :</label><br>
    <input type="email" name="email" required><br><br>
    <label for="mot_de_passe">Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>
    <button type="submit">S'inscrire</button>
</form>
<?php
include('db.php'); // Inclure la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

    // Recherche de l'utilisateur dans la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        // L'utilisateur est authentifié avec succès
        echo "Bienvenue, " . $utilisateur['nom'] . "!";
    } else {
        // L'authentification a échoué
        echo "Email ou mot de passe incorrect.";
    }
}
?>

<!-- Formulaire de connexion -->
<form action="connexion.php" method="POST">
    <label for="email">Email :</label><br>
    <input type="email" name="email" required><br><br>
    <label for="mot_de_passe">Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>
    <button type="submit">Se connecter</button>
</form>
<?php
include('db.php'); // Inclure la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = htmlspecialchars($_POST['contenu']);
    $utilisateur_id = 1; // ID de l'utilisateur qui publie l'article (à ajuster selon le système d'authentification)

    // Insertion de l'article dans la base de données
    $sql = "INSERT INTO articles (titre, contenu, utilisateur_id) VALUES (:titre, :contenu, :utilisateur_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':contenu' => $contenu,
        ':utilisateur_id' => $utilisateur_id
    ]);

    echo "Article publié avec succès!";
}
?>

<!-- Formulaire de publication d'article -->
<form action="publier_article.php" method="POST">
    <label for="titre">Titre de l'article :</label><br>
    <input type="text" name="titre" required><br><br>
    <label for="contenu">Contenu de l'article :</label><br>
    <textarea name="contenu" rows="5" required></textarea><br><br>
    <button type="submit">Publier l'article</button>
</form>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>


<?php
$host = 'localhost';      // Adresse de votre serveur MySQL
$dbname = 'blog';         // Nom de la base de données
$username = 'root';       // Nom d'utilisateur MySQL
$password = '';           // Mot de passe MySQL

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichage de l'erreur en cas de problème
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
?>
<?php include('includes/header.php'); ?>

<main>
    <h1>Bienvenue sur le Blog des Étudiants Développeurs</h1>
    
    <div class="articles">
        <h2>Articles Récents</h2>
        <?php
        include('db.php');

        $sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT 5";
        $stmt = $pdo->query($sql);
        
        while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='article'>";
            echo "<h3>" . htmlspecialchars($article['titre']) . "</h3>";
            echo "<p>" . substr(htmlspecialchars($article['contenu']), 0, 150) . "...</p>";
            echo "<a href='article.php?id=" . $article['id'] . "'>Lire plus</a>";
            echo "</div>";
        }
        ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = htmlspecialchars($_POST['contenu']);
    $utilisateur_id = 1; // ID de l'utilisateur (à implémenter)

    $sql = "INSERT INTO articles (titre, contenu, utilisateur_id, created_at) VALUES (:titre, :contenu, :utilisateur_id, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':contenu' => $contenu,
        ':utilisateur_id' => $utilisateur_id
    ]);

    echo "Article publié avec succès!";
}
?>

<?php include('includes/header.php'); ?>

<main>
    <h1>Publier un Article</h1>
    
    <form action="publier_article.php" method="POST">
        <label for="titre">Titre :</label><br>
        <input type="text" name="titre" required><br><br>

        <label for="contenu">Contenu :</label><br>
        <textarea name="contenu" rows="5" required></textarea><br><br>

        <button type="submit">Publier l'article</button>
    </form>
</main>

<?php include('includes/footer.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Collaboratif</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="publier_article.php">Publier un article</a></li>
            </ul>
        </nav>
    </header>
    <footer>
        <p>&copy; 2024 Blog des Étudiants Développeurs</p>
    </footer>
</body>
</html>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<?php
$host = 'localhost';
$dbname = 'blog'; // Assurez-vous que la base de données existe
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie!";
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}
?>
echo "Connexion à la base de données réussie!";
$sql = "SELECT * FROM articles";
$stmt = $pdo->query($sql);
echo "Requête exécutée!";

<?php include('includes/header.php'); ?>

<main>
    <h1>Bienvenue sur le Blog des Étudiants Développeurs</h1>
    
    <div class="articles">
        <h2>Articles Récents</h2>
        <?php
        include('db.php');

        $sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT 5";
        $stmt = $pdo->query($sql);
        
        while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='article'>";
            echo "<h3>" . htmlspecialchars($article['titre']) . "</h3>";
            echo "<p>" . substr(htmlspecialchars($article['contenu']), 0, 150) . "...</p>";
            echo "<a href='article.php?id=" . $article['id'] . "'>Lire plus</a>";
            echo "</div>";
        }
        ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Collaboratif</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="publier_article.php">Publier un article</a></li>
            </ul>
        </nav>
    </header>
    <footer>
        <p>&copy; 2024 Blog des Étudiants Développeurs</p>
    </footer>
</body>
</html>
<?php
$host = 'localhost';      // Adresse de votre serveur MySQL
$dbname = 'blog';         // Nom de la base de données
$username = 'root';       // Nom d'utilisateur MySQL
$password = '';           // Mot de passe MySQL

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichage de l'erreur en cas de problème
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
?>
