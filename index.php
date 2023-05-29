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
        <h1> Je suis la page d'accueil </h1>
    </main>
    <footer>
        <p> Je suis le footer</p>
    </footer>
</body>

</html>