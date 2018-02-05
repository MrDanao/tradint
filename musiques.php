<?php
session_start();
require("checklogin.php");
if (!Auth::isLogged()) {
    header('Location:login.php');
}
// Connexion à mysql en local (localhost est équivalent à 127.0.0.1)
$select_db = mysqli_connect('localhost', 'dantran', 'MOT DE PASSE', 'www');
// Selectionner la base MyTestDB
//mysql_select_db('www') or die("Erreur de connexion à la base de données www");

// Récupération du dernier ID
$query = "SELECT * FROM `musiques` ORDER BY id DESC LIMIT 1;";
$result = mysqli_query($select_db, $query);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$newId = $id + 1; // nombre utiliser pour id - cover - audio de la nouvelle track
// Fin de récupération du dernier ID

if (isset($_POST['up-button'])) {
    if (isset($_FILES['files']) && isset($_POST['artiste']) && isset($_POST['titre']) && isset($_POST['label']) && isset($_POST['date']) && isset($_POST['album'])) {

        // tags
        $artiste = $_POST['artiste'];
        $titre = $_POST['titre'];
        $album = $_POST['album'];
        $label = $_POST['label'];
        $date = $_POST['date'];

        for ($i = 0; $i < 2; $i++) {
            $tmpPathFile = $_FILES['files']['tmp_name'][$i];
            $tmpMimeFile = $_FILES['files']['type'][$i];
            switch ($tmpMimeFile) {
                case 'image/jpeg':
                    $file_destination = '../img/musiques/artwork/' . $newId . '.jpg';
                    if (move_uploaded_file($tmpPathFile, $file_destination)) {
                        $logCover = "<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Cover <br>";
                    } else {
                        $logCover = "<i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> Cover <br>";
                    }
                    break;
                case 'audio/x-m4a':
                    $file_destination = '../src/musiques/sound/' . $newId . '.m4a';
                    $audiofile = $newId . '.m4a';
                    if (move_uploaded_file($tmpPathFile, $file_destination)) {
                        $logAudio = "<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Audio <br>";
                        $querym4a = "INSERT INTO `musiques` (`id`, `artiste`, `titre`, `album`, `date`, `label`, `audio`) VALUES ('".$newId."', '".$artiste."', '".$titre."', '".$album."', '".$date."', '".$label."', '".$audiofile."');";
			$queryInsert = mysqli_query($select_db, $querym4a);
                        if ($queryInsert) {
                            $logSQL = "<i class=\"fa fa-check\" aria-hidden=\"true\"></i> SQL <br>";
                        } else {
                            $logSQL = "<i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> SQL <br>";
                        }
                    } else {
                        $logAudio = "<i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> Audio <br>";
                    }
                    break;
                case 'audio/mp3':
                    $file_destination = '../src/musiques/sound/' . $newId . '.mp3';
                    $audiofile = $newId . '.mp3';
                    if (move_uploaded_file($tmpPathFile, $file_destination)) {
                        $logAudio = "<i class=\"fa fa-check\" aria-hidden=\"true\"></i> Audio <br>";
                        $querymp3 = "INSERT INTO `musiques` (`id`, `artiste`, `titre`, `album`, `date`, `label`, `audio`) VALUES ('".$newId."', '".$artiste."', '".$titre."', '".$album."', '".$date."', '".$label."', '".$audiofile."');";
			$queryInsert = mysqli_query($select_db, $querymp3);
                        if ($queryInsert) {
                            $logSQL = "<i class=\"fa fa-check\" aria-hidden=\"true\"> SQL <br>";
                        } else {
                            $logSQL = "<i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> SQL <br>";
                        }
                    } else {
                        $logAudio = "<i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> Audio <br>";
                    }
                    break;
            }
        }
    } else {
        $logForm = "<i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> Remplir tous les champs <br>";
    }
mysqli_close($select_db);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <link rel="icon" type="image/png" href="../img/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="../style/upload.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Musiques</title>
</head>
<body>
    <div id="main">
        <form action="musiques.php" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr>
                    <th colspan="2"><input type="file" name="files[]" multiple/></th>
                </tr>
                <tr>
                    <th><input type="text" name="artiste" placeholder="Artiste"/></th>
                </tr>
                <tr>
                    <th><input type="text" name="titre" placeholder="Titre"/></th>
                </tr>
                <tr>
                    <th><input type="text" name="album" placeholder="Album"/></th>
                </tr>
                <tr>
                    <th><input type="text" name="date" placeholder="Date"/></th>
                </tr>
                <tr>
                    <th colspan="2"><input type="text" name="label" placeholder="Label"/></th>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" name="up-button" value="Uploader"/></th>
                </tr>
                <?php
                if (isset($logForm) || isset($logAudio) || isset($logCover) || isset($logSQL)) {
                    echo "<tr>";
                    echo "<th colspan=\"2\">";
                    echo "$logForm $logAudio $logCover $logSQL";
                    echo "</th>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <th colspan="2"><input type="button" onclick="location.href='logout.php'"; value="Se déconnecter"/></th>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
