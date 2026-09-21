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

   <link rel="stylesheet" href="admin.css">
   <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <div class="admin-container">

        <div class="admin-title">
            <h1>Messages reçus</h1>
            <p>Administration — Sirius Digital</p>
        </div>

        <div class="statistiques">

            <div class="statistique">
                <i class="fa-solid fa-envelope"></i>
                <h2><?php echo $nombre_nouveaux; ?></h2>
                <p>Nouveaux</p>
            </div>

            <div class="statistique">
                <i class="fa-solid fa-eye"></i>
                <h2><?php echo $nombre_lus; ?></h2>
                <p>Lus</p>
            </div>

            <div class="statistique">
                <i class="fa-solid fa-check"></i>
                <h2><?php echo $nombre_traites; ?></h2>
                <p>Traités</p>
            </div>

            <div class="statistique">
                <h2><?php echo $nombre_messages; ?></h2>
                <p>Messages reçus</p>
            </div>

        </div>

        <div class="actions-admin">
            <a href="index.html" class="btn-retour">
                ← Retour au site
            </a>
            <a href="logout.php" class="btn-deconnexion">
                Se déconnecter
            </a>
        </div>

         <div class="recherche">
              <input type="text" id="recherche" placeholder="Rechercher un message...">
            </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>statut</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($message = $resultat->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $message["id"]; ?></td>
                            <td><?php echo htmlspecialchars($message["nom"]); ?></td>
                            <td><?php echo htmlspecialchars($message["email"]); ?></td>
                            <td><?php echo htmlspecialchars($message["telephone"]); ?></td>
                            <td><?php echo htmlspecialchars($message["sujet"]); ?></td>
                            <td><?php echo htmlspecialchars($message["message"]); ?></td>
                            <td><?php echo $message["date_creation"]; ?></td>
                            <td>
                                <form action="statut.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $message["id"]; ?>">

                                    <select name="statut" onchange="this.form.submit()">
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
                            <td>
                               <a href="voir.php?id=<?php echo $message['id']; ?>"
                                  class="btn-voir">
                                  <i class="fa-solid fa-eye"></i> 
                               </a>

                                <a href="supprimer.php?id=<?php echo $message['id']; ?>"
                                   class="btn-supprimer"
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