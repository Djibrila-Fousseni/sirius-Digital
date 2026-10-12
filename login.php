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

    <style>
        body { font-family: Arial, sans-serif; }
    </style>
</head>

<body class="bg-gris-clair min-h-screen flex items-center justify-center p-5">

    <div class="w-full max-w-[350px] bg-white p-8 rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.1)]">

        <h1 class="text-center text-bleu-fonce text-2xl font-bold mb-6">Administration</h1>

        <?php if ($erreur != "") { ?>
            <p class="text-red-600 text-center text-sm mb-4"><?php echo $erreur; ?></p>
        <?php } ?>

        <form method="POST" class="flex flex-col gap-4">

            <input
                type="text"
                name="nom_utilisateur"
                placeholder="Nom d'utilisateur"
                required
                class="w-full px-4 py-3 border border-[#ddd] rounded-lg text-[15px] outline-none transition duration-300 focus:border-bleu focus:shadow-[0_0_0_3px_rgba(5,74,203,0.1)]"
            >

            <input
                type="password"
                name="mot_de_passe"
                placeholder="Mot de passe"
                required
                class="w-full px-4 py-3 border border-[#ddd] rounded-lg text-[15px] outline-none transition duration-300 focus:border-bleu focus:shadow-[0_0_0_3px_rgba(5,74,203,0.1)]"
            >

            <button type="submit"
                    class="w-full px-4 py-3 bg-bleu text-white font-bold rounded-lg cursor-pointer transition duration-300 hover:bg-bleu-fonce">
                Se connecter
            </button>

        </form>

    </div>

</body>
</html>