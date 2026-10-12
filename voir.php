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

    <!-- Tailwind CSS (Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bleu-fonce': '#03035A',
                        'bleu': '#054ACB',
                        'bleu-clair': '#2878E8',
                        'gris': '#666666',
                        'gris-clair': '#f4f7fc',
                    }
                }
            }
        }
    </script>

    <!-- Icônes Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body { font-family: Arial, sans-serif; }
    </style>
</head>

<body class="bg-gris-clair text-[#28292F] p-5 md:p-10">

<div class="max-w-[800px] mx-auto bg-white p-6 md:p-[30px] rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.08)]">

    <img src="logo.jpg" alt="Sirius Digital" class="block w-[180px] mx-auto mb-6">

    <h1 class="text-bleu-fonce text-3xl font-bold mb-6">Détail du message</h1>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-user mr-2 text-bleu"></i> Nom :
        </strong>
        <?php echo htmlspecialchars($message["nom"]); ?>
    </div>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-envelope mr-2 text-bleu"></i> Email :
        </strong>
        <?php echo htmlspecialchars($message["email"]); ?>
    </div>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-phone mr-2 text-bleu"></i> Téléphone :
        </strong>
        <?php echo htmlspecialchars($message["telephone"]); ?>
    </div>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-tag mr-2 text-bleu"></i> Sujet :
        </strong>
        <?php echo htmlspecialchars($message["sujet"]); ?>
    </div>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-calendar mr-2 text-bleu"></i> Date :
        </strong>
        <?php echo htmlspecialchars($message["date_creation"]); ?>
    </div>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-circle-check mr-2 text-bleu"></i> Statut :
        </strong>
        <?php echo htmlspecialchars($message["statut"]); ?>
    </div>

    <div class="p-4 mb-3 bg-[#f8f9fc] rounded-lg border-l-4 border-bleu">
        <strong class="inline-block min-w-[120px] text-bleu-fonce">
            <i class="fa-solid fa-message mr-2 text-bleu"></i> Message :
        </strong>

        <div class="mt-3 p-5 bg-white border border-[#e5e5e5] rounded-lg leading-relaxed whitespace-pre-wrap">
            <?php echo htmlspecialchars($message["message"]); ?>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-2.5 mt-6 print:hidden">

        <a href="admin.php"
           class="inline-flex items-center gap-2 px-5 py-3 bg-bleu text-white rounded-lg transition duration-300 hover:bg-bleu-fonce hover:-translate-y-0.5">
            <i class="fa-solid fa-arrow-left"></i>
            Retour à l'administration
        </a>

        <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-3 bg-bleu-fonce text-white text-base rounded-lg cursor-pointer transition duration-300 hover:bg-bleu hover:-translate-y-0.5">
            <i class="fa-solid fa-print"></i>
            Imprimer
        </button>

    </div>

</div>

</body>
</html>