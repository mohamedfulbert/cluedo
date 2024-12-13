<?php

	//Documentation php pour sqlite : https://www.php.net/manual/en/book.sqlite3.php
	

	/* Paramètres */
	$bdd_fichier = 'cluedo.db';		//Fichier de la base de données
	$piece = 'Salle de billard';				//Pièce à utiliser
	

	$sqlite = new SQLite3($bdd_fichier);		//On ouvre le fichier de la base de données
	
	/* Instruction SQL pour récupérer la liste des pieces adjacentes à la pièce paramétrée */
	$sql = 'SELECT adj.id_piece, adj.nom_piece ';
	$sql .= 'FROM pieces INNER JOIN portes ON portes.id_piece1=pieces.id_piece OR portes.id_piece2=pieces.id_piece ';
	$sql .= 'INNER JOIN pieces AS adj ON portes.id_piece1=adj.id_piece OR portes.id_piece2=adj.id_piece ';
	$sql .= 'WHERE adj.id_piece!=pieces.id_piece AND pieces.nom_piece LIKE :piece';
	
	
	/* Préparation de la requete et de ses paramètres */
	$requete = $sqlite -> prepare($sql);
	$requete -> bindValue(':piece', $piece, SQLITE3_TEXT);
	
	$result = $requete -> execute();	//Execution de la requête et récupération du résultat


	/* On génère et on affiche notre page HTML avec la liste de nos films */
	echo "<!DOCTYPE html>\n";		//On demande un saut de ligne avec \n, seulement avec " et pas '
	echo "<html lang=\"fr\"><head><meta charset=\"UTF-8\">\n";	//Avec " on est obligé d'échapper les " a afficher avec \
	echo "<title>Pièces adjacentes à $piece</title>\n";
	echo "</head>\n";
	
	echo "<body>\n";
	echo "<h1>Pièces adjacentes à $piece</h1>\n";
	echo "<ul>";
	
	while($adj = $result -> fetchArray(SQLITE3_ASSOC)) {
		echo '<li>'.$adj['nom_piece']." (id : {$adj['id_piece']})</li>";
	}

	echo "</ul>";
	echo "</body>\n";
	echo "</html>\n";
	
	
	$sqlite -> close();			//On ferme bien le fichier de la base de données avant de terminer!
	
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cluedo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ff0000;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        main {
            padding: 20px;
        }

        .game-description {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .game-rules {
            font-size: 1em;
            line-height: 1.6;
        }

        footer {
            background-color: #ff0000;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Cluedo</h1>
    </header>
    <main>
        <section class="game-description">
            <p>Bienvenue dans le jeu de société Cluedo, le célèbre jeu de déduction où les joueurs doivent résoudre un meurtre en déterminant qui est le coupable, avec quelle arme, et dans quelle pièce.</p>
        </section>

        <section class="game-rules">
            <h2>Règles du jeu</h2>
            <ul>
                <li>Le Cluedo est un jeu de déduction dans lequel les joueurs doivent découvrir qui a commis un
                    meurtre, avec quelle arme, et dans quelle pièce du manoir. Le but est de parcourir les
                    différentes pièces, émettre des hypothèses sur l'identité du meurtrier, l'arme utilisée, et
                    l'endroit où le crime a été commis. À chaque tour, le joueur formule des hypothèses et reçoit
                    des indices pour affiner ses suppositions. Le joueur remporte la partie s’il devine correctement
                    la combinaison (personnage, arme, pièce).</li>
                    <li><a href="jeux.php">commencer</a></li>
                
            </ul>
        </section>
    </main>

</body>