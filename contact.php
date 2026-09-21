<?php

// Connexion à la base de données
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

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}


// Vérifier si le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $sujet = $_POST["sujet"];
    $message = $_POST["message"];


    // Préparer la requête
    $sql = "INSERT INTO messages
            (nom, email, telephone, sujet, message)
            VALUES (?, ?, ?, ?, ?)";

    $requete = $connexion->prepare($sql);

    $requete->bind_param(
        "sssss",
        $nom,
        $email,
        $telephone,
        $sujet,
        $message
    );


    // Enregistrer le message
    if ($requete->execute()) {

        echo "<h2>Message envoyé avec succès !</h2>";
        echo "<p>Merci $nom. Nous avons bien reçu votre message.</p>";

    } else {

        echo "Erreur lors de l'enregistrement.";

    }


    $requete->close();
}

$connexion->close();

?>