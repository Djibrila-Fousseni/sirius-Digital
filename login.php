<?php

session_start();

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];

    if ($nom_utilisateur === "admin" && $mot_de_passe === "1234") {

        $_SESSION["admin"] = true;

        header("Location: admin.php");
        exit;

    } else {

        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";

    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion - Sirius Digital</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #03035A;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #054ACB;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .erreur {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h1>Administration</h1>

    <?php if ($erreur != "") { ?>
        <p class="erreur"><?php echo $erreur; ?></p>
    <?php } ?>

    <form method="POST">

        <input
            type="text"
            name="nom_utilisateur"
            placeholder="Nom d'utilisateur"
            required
        >

        <input
            type="password"
            name="mot_de_passe"
            placeholder="Mot de passe"
            required
        >

        <button type="submit">
            Se connecter
        </button>

    </form>

</div>

</body>
</html>