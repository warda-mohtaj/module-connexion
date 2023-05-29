<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login </title>
    <link rel="stylesheet" href="le.css">
</head>
<?php
session_start();

function status()
{
    $estConnecte = false;
    if (isset($_SESSION['estConnecte']) && $_SESSION['estConnecte'] === true) {
        $estConnecte = true;
    }

    $estAdmin = false;
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $estAdmin = true;
    }

    return array($estConnecte, $estAdmin);
}

list($estConnecte, $estAdmin) = status();


function connectDB()
{
    $dsn = 'mysql:host=localhost;dbname=moduleconnexion;charset=utf8';
    $username = 'root';
    $password = 'root';

    try {
        $bdd = new PDO($dsn, $username, $password);
        return $bdd;
    } catch (PDOException $e) {
        die("Connexion échouée: " . $e->getMessage());
    }
}


function processLogin()
{
    $bdd = connectDB();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = "SELECT * FROM utilisateurs WHERE (id = 1 AND (login = :login OR prenom = :login OR nom = :login)) OR (login = :login AND password = :password)";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user['id'] == 1) {
                $_SESSION['role'] = 'admin'; 
                header("Location: admin.php");
            } else {
                header("Location: profil.php");
            }
            exit();
        } else {
            echo "Identifiants incorrects.";
        }
    }
}
connectDB();
processLogin();
status();
?>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"> Accueil </a></li>
                <?php if (!$estConnecte) : ?>
                    <li><a href="connection.php"> Se connecter </a></li>
                    <li><a href="inscription"> S'inscrire </a></li>
                <?php endif; ?>

                <?php if ($estConnecte) : ?>
                    <li><a href="profil.php"> Profil </a></li>
                <?php endif; ?>

                <?php if ($estConnecte && $estAdmin) : ?>
                    <li><a href="admin.php"> Espace d'administration </a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>
    <main>
        <h1>je suis la page de connection</h1>
        <hr>
        <h2> Page de connexion </h2>
        <form method="POST" action="">
            <label for="login"> Identifiant : </label>
            <input type="text" id="login" name="login" required><br><br>

            <label for="password"> Mot de passe: </label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Se connecter">
        </form>
    </main>
    <footer>
        <p> Je suis le footer</p>
    </footer>
</body>

</html>