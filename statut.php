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

$id = intval($_POST["id"]);
$statut = $_POST["statut"];

$sql = "UPDATE messages SET statut = ? WHERE id = ?";

$requete = $connexion->prepare($sql);
$requete->bind_param("si", $statut, $id);

$requete->execute();

$requete->close();
$connexion->close();

header("Location: admin.php");
exit;

?>