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
    die("Erreur de connexion : " . $connexion->connect_error);
}

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    $sql = "DELETE FROM messages WHERE id = ?";

    $requete = $connexion->prepare($sql);
    $requete->bind_param("i", $id);

    if ($requete->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Erreur lors de la suppression.";
    }

    $requete->close();
}

$connexion->close();

?>