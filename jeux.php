<?php
$bdd_fichier = 'cluedo.db';	
$sqlite = new SQLite3($bdd_fichier);
$sql = 'SELECT id_personnage, nom_personnage, couleur ';
	$sql .= 'FROM personnages';
    $requete = $sqlite -> prepare($sql);
    //echo $sql;
    //:echo $sqlite ->lastErrorMsg();
    $result = $requete -> execute();
    while($adj = $result -> fetchArray(SQLITE3_ASSOC)) {
		echo '<li>'.$adj['nom_personnage']." (id : {$adj['id_personnage']})</li>";
	}
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insérer une image</title>
</head>
<body>
    <h1>voici les lieux du crimes</h1>
    <img src="cluedoscreen.png" alt="voici les lieux du crime">
        <li><a href="cluedo.php">retour a l'acceuil</a></li>
</body>
</html>