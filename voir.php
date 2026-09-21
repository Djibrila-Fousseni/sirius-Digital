<?php

session_start();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: login.php");
    exit;
}

$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "sirius_digital";

$connexion = new mysqli(
    $serveur,
    $utilisateur,
    $mot_de_passe,
    $base_de_donnees
);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

if (!isset($_GET["id"])) {
    die("Message introuvable.");
}

$id = intval($_GET["id"]);

$sql = "SELECT * FROM messages WHERE id = ?";
$requete = $connexion->prepare($sql);
$requete->bind_param("i", $id);
$requete->execute();

$resultat = $requete->get_result();

if ($resultat->num_rows === 0) {
    die("Message introuvable.");
}

$message = $resultat->fetch_assoc();

$requete->close();
$connexion->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Voir le message - Sirius Digital</title>

    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fc;
            padding: 40px;
            color: #28292F;
        }

        .message-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        h1 {
            color: #03035A;
            margin-bottom: 25px;
        }

        .information {
            margin-bottom: 20px;
        }

        .information strong {
            color: #03035A;
        }

        .message {
            background: #f4f7fc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 10px;
            white-space: pre-wrap;
        }

        .btn-retour {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            padding: 12px 20px;
            background: #054ACB;
            color: white;
            text-decoration: none;
            border-radius: 8px;
           transition: 0.3s;
        }

        .btn-retour:hover {
           background: #03035A;
           transform: translateY(-2px);
        }

        .logo {
           display: block;
           width: 180px;
           margin: 0 auto 25px;
        }

        .information {
            padding: 15px;
            margin-bottom: 12px;
            background: #f8f9fc;
            border-radius: 8px;
            border-left: 4px solid #054ACB;
        }

        .information strong {
            display: inline-block;
            min-width: 120px;
            color: #03035A;
        }

        .information i {
            margin-right: 8px;
            color: #054ACB;
        }

        .message {
            margin-top: 12px;
            line-height: 1.6;
            background: white;
            border: 1px solid #e5e5e5;
        }

        .btn-imprimer {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            margin-left: 10px;
            padding: 12px 20px;
            background: #03035A;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-imprimer:hover {
            background: #054ACB;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

<div class="message-container">

<img src="logo.jpg" alt="Sirius Digital" class="logo">
    <h1>Détail du message</h1>

    <div class="information">
       <strong><i class="fa-solid fa-user"></i> Nom :</strong>
        <?php echo htmlspecialchars($message["nom"]); ?>
    </div>

    <div class="information">
       <strong><i class="fa-solid fa-envelope"></i> Email :</strong>
        <?php echo htmlspecialchars($message["email"]); ?>
    </div>

    <div class="information">
       <strong><i class="fa-solid fa-phone"></i> Téléphone :</strong>
        <?php echo htmlspecialchars($message["telephone"]); ?>
    </div>

    <div class="information">
        <strong><i class="fa-solid fa-tag"></i> Sujet :</strong>
        <?php echo htmlspecialchars($message["sujet"]); ?>
    </div>

    <div class="information">
       <strong><i class="fa-solid fa-calendar"></i> Date :</strong>
        <?php echo htmlspecialchars($message["date_creation"]); ?>
    </div>

    <div class="information">
        <strong><i class="fa-solid fa-circle-check"></i> Statut :</strong>
        <?php echo htmlspecialchars($message["statut"]); ?>
    </div>

    <div class="information">
        <strong><i class="fa-solid fa-message"></i> Message :</strong>

        <div class="message">
            <?php echo htmlspecialchars($message["message"]); ?>
        </div>
    </div>

    <a href="admin.php" class="btn-retour">
       <i class="fa-solid fa-arrow-left"></i>
       Retour à l'administration
    </a>

    <button onclick="window.print()" class="btn-imprimer">
       <i class="fa-solid fa-print"></i>
       Imprimer
    </button>

</div>

</body>
</html>