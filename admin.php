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

$sql_compteur = "SELECT COUNT(*) AS total FROM messages";
$compteur = $connexion->query($sql_compteur);
$nombre_messages = $compteur->fetch_assoc()["total"];

$nouveaux = $connexion->query(
    "SELECT COUNT(*) AS total FROM messages WHERE statut = 'Nouveau'"
);
$nombre_nouveaux = $nouveaux->fetch_assoc()["total"];

$lus = $connexion->query(
    "SELECT COUNT(*) AS total FROM messages WHERE statut = 'Lu'"
);
$nombre_lus = $lus->fetch_assoc()["total"];

$traites = $connexion->query(
    "SELECT COUNT(*) AS total FROM messages WHERE statut = 'Traité'"
);
$nombre_traites = $traites->fetch_assoc()["total"];

$sql = "SELECT * FROM messages ORDER BY id DESC";
$resultat = $connexion->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administration - Sirius Digital</title>

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

    <div class="max-w-[1200px] mx-auto">

        <!-- Titre -->
        <div class="text-center mb-8">
            <h1 class="text-bleu-fonce text-[28px] md:text-[36px] font-bold mb-2">Messages reçus</h1>
            <p class="text-gris">Administration — Sirius Digital</p>
        </div>

        <!-- Statistiques -->
        <div class="flex flex-wrap justify-center gap-6 mb-8">

            <div class="w-[220px] p-6 text-center bg-white rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.08)]">
                <i class="fa-solid fa-envelope text-[30px] text-bleu mb-2.5"></i>
                <h2 class="text-bleu-fonce text-[40px] font-bold mb-1"><?php echo $nombre_nouveaux; ?></h2>
                <p class="text-gris">Nouveaux</p>
            </div>

            <div class="w-[220px] p-6 text-center bg-white rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.08)]">
                <i class="fa-solid fa-eye text-[30px] text-bleu mb-2.5"></i>
                <h2 class="text-bleu-fonce text-[40px] font-bold mb-1"><?php echo $nombre_lus; ?></h2>
                <p class="text-gris">Lus</p>
            </div>

            <div class="w-[220px] p-6 text-center bg-white rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.08)]">
                <i class="fa-solid fa-check text-[30px] text-bleu mb-2.5"></i>
                <h2 class="text-bleu-fonce text-[40px] font-bold mb-1"><?php echo $nombre_traites; ?></h2>
                <p class="text-gris">Traités</p>
            </div>

            <div class="w-[220px] p-6 text-center bg-white rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.08)]">
                <h2 class="text-bleu-fonce text-[40px] font-bold mb-1"><?php echo $nombre_messages; ?></h2>
                <p class="text-gris">Messages reçus</p>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex flex-wrap items-center gap-3 mb-5">

            <a href="sirius.html"
               class="inline-block px-5 py-3 bg-bleu text-white rounded-lg transition duration-300 hover:bg-bleu-fonce">
                ← Retour au site
            </a>

            <a href="logout.php"
               class="group inline-flex items-center gap-3 rounded-xl bg-bleu-fonce px-6 py-3 font-semibold text-white shadow-md transition-all duration-300 hover:-translate-y-1 hover:bg-bleu hover:shadow-lg">

                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 transition group-hover:bg-white/20">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </span>

                <span>Quitter l'administration</span>

            </a>

        </div>

        <!-- Recherche -->
        <div class="mb-5">
            <input type="text" id="recherche" placeholder="Rechercher un message..."
                   class="w-full p-3.5 border border-[#ddd] rounded-lg text-base outline-none transition duration-300 focus:border-bleu">
        </div>

        <!-- Tableau -->
        <div class="bg-white p-2.5 md:p-5 rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.08)] overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-bleu-fonce text-white">
                    <tr>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">ID</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Nom</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Email</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Téléphone</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Sujet</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Message</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Date</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Statut</th>
                        <th class="p-2.5 md:p-4 text-left text-sm md:text-base font-bold border-b border-[#eee]">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($message = $resultat->fetch_assoc()) { ?>
                        <tr class="transition hover:bg-gris-clair">
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]"><?php echo $message["id"]; ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]"><?php echo htmlspecialchars($message["nom"]); ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]"><?php echo htmlspecialchars($message["email"]); ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]"><?php echo htmlspecialchars($message["telephone"]); ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]"><?php echo htmlspecialchars($message["sujet"]); ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]"><?php echo htmlspecialchars($message["message"]); ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee] whitespace-nowrap"><?php echo $message["date_creation"]; ?></td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee]">
                                <form action="statut.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $message["id"]; ?>">

                                    <select name="statut" onchange="this.form.submit()"
                                            class="px-2 py-1.5 border border-[#ddd] rounded-md text-sm outline-none cursor-pointer focus:border-bleu">
                                        <option value="Nouveau"
                                            <?php if ($message["statut"] == "Nouveau") echo "selected"; ?>>
                                            Nouveau
                                        </option>

                                        <option value="Lu"
                                            <?php if ($message["statut"] == "Lu") echo "selected"; ?>>
                                            Lu
                                        </option>

                                        <option value="Traité"
                                            <?php if ($message["statut"] == "Traité") echo "selected"; ?>>
                                            Traité
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-2.5 md:p-4 text-sm md:text-base border-b border-[#eee] whitespace-nowrap">
                                <a href="voir.php?id=<?php echo $message['id']; ?>"
                                   class="inline-block px-3.5 py-2 bg-bleu text-white text-sm rounded-md transition duration-300 hover:bg-bleu-fonce">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="supprimer.php?id=<?php echo $message['id']; ?>"
                                   class="inline-block px-3.5 py-2 bg-[#dc3545] text-white text-sm rounded-md transition duration-300 hover:bg-[#b02a37]"
                                   onclick="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const recherche = document.getElementById("recherche");

        recherche.addEventListener("keyup", function () {
            const texte = this.value.toLowerCase();
            const lignes = document.querySelectorAll("tbody tr");

            lignes.forEach(function (ligne) {
                ligne.style.display = ligne.textContent.toLowerCase().includes(texte)
                    ? ""
                    : "none";
            });
        });
    </script>

</body>

</html>

<?php
$connexion->close();
?>