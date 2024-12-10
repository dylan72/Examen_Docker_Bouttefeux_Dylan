<?php
$resultsFile = 'results.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $inputText = $_POST['inputText']; // Récupérer le texte à crypter
    $hashMethod = $_POST['hashMethod']; // Récupérer la méthode de cryptage

    // Crypter le texte
    switch ($hashMethod) {
        case 'sha256':
            $hash = hash('sha256', $inputText);
            break;
        case 'md5':
            $hash = hash('md5', $inputText);
            break;
        case 'sha1':
            $hash = hash('sha1', $inputText);
            break;
        case 'sha512':
            $hash = hash('sha512', $inputText);
            break;
        case 'crc32':
            $hash = hash('crc32', $inputText);
            break;
        default:
            $hash = 'Méthode inconnue';
    }

    // Créer une nouvelle entrée
    $newEntry = [
        'method' => $hashMethod,
        'text' => $inputText,
        'hash' => $hash
    ];

    // Sauvegarder la nouvelle entrée
    $data = [];
    if (file_exists($resultsFile)) { // Vérifier si le fichier existe
        $data = json_decode(file_get_contents($resultsFile), true); // Lire le contenu du fichier
    }
    $data[] = $newEntry; // Ajouter la nouvelle entrée
    file_put_contents($resultsFile, json_encode($data)); // Sauvegarder les données

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Traitement de la suppression d'une entrée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $index = (int)$_POST['index']; // Récupérer l'index de l'entrée à supprimer
    if (file_exists($resultsFile)) { // Vérifier si le fichier existe
        $data = json_decode(file_get_contents($resultsFile), true); // Lire le contenu du fichier
        if (isset($data[$index])) { // Vérifier si l'entrée existe
            unset($data[$index]); // Supprimer l'entrée
            $data = array_values($data); // Réindexer le tableau
            file_put_contents($resultsFile, json_encode($data)); // Sauvegarder les modifications
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cryptage PHP</title>
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/monstyle.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Examen - Bouttefeux Dylan</h1>
</div>
<div class="container mt-5">
    <h1 class="text-center">Convertisseur de Hash</h1>
    <form method="POST" class="mt-4">
        <input type="hidden" name="action" value="add">
        <div class="mb-3">
            <label for="inputText" class="form-label" style="font-weight: bold">Texte à crypter :</label>
            <input type="text" class="form-control" id="inputText" name="inputText" required>
        </div>
        <div class="mb-3">
            <label for="hashMethod" class="form-label" style="font-weight: bold">Méthode de cryptage :</label>
            <select class="form-select" id="hashMethod" name="hashMethod" required>
                <option value="sha256">SHA256</option>
                <option value="md5">MD5</option>
                <option value="sha1">SHA1</option>
                <option value="sha512">SHA512</option>
                <option value="crc32">CRC32</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Crypter</button>
    </form>

    <hr>
    <h2 class="text-center">Historique</h2>
    <div id="history">
        <?php
        if (file_exists($resultsFile)) {
            $data = json_decode(file_get_contents($resultsFile), true);
            if (!empty($data)) {
                echo '<table class="table table-striped table-bordered">';
                echo '<thead class="table-dark">';
                echo '<tr>';
                echo '<th scope="col">Méthode</th>';
                echo '<th scope="col">Texte</th>';
                echo '<th scope="col">Hash</th>';
                echo '<th scope="col">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($data as $index => $entry) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($entry['method']) . '</td>';
                    echo '<td>' . htmlspecialchars($entry['text']) . '</td>';
                    echo '<td>' . htmlspecialchars($entry['hash']) . '</td>';
                    echo '<td>';
                    echo '<form method="POST" style="display: inline;">';
                    echo '<input type="hidden" name="action" value="delete">';
                    echo '<input type="hidden" name="index" value="' . $index . '">';
                    echo '<button type="submit" class="btn btn-danger btn-sm">Supprimer</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p class="text-muted text-center">Aucun historique disponible.</p>';
            }
        } else {
            echo '<p class="text-muted text-center">Aucun historique disponible.</p>';
        }
        ?>
    </div>
</div>
</body>
</html>
