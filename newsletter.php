<?php

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
    die("Erreur de connexion à la base de données.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }

    $requete = $connexion->prepare(
        "INSERT INTO newsletter (email) VALUES (?)"
    );

    $requete->bind_param("s", $email);

    if ($requete->execute()) {

        echo "Inscription réussie ! Merci.";

    } else {

        if ($connexion->errno === 1062) {
            echo "Cette adresse email est déjà inscrite.";
        } else {
            echo "Une erreur est survenue.";
        }
    }

    $requete->close();
}

$connexion->close();

?>