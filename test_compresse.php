<?php
function addFolderToZip($dir, $zipArchive, $zipdir = ''){
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {

            // Ajout du dossier courant au zip
            if(!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);

            while (($file = readdir($dh)) !== false) {

                // Si fichier, l'ajouter directement. Si dossier, utiliser la récursivité.
                if(!is_file($dir . $file)){
                    // dossier : récursivité
                    if( ($file !== ".") && ($file !== "..")){
                        addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                    }
                }else{
                    // fichier
                    $zipArchive->addFile($dir . $file, $zipdir . $file);
                }
            }
        }
        closedir($dh);
    }
}

// Chemin du dossier à compresser
$folderPath = 'files/';

// Nom du fichier ZIP de sortie (peut être modifié selon votre besoin)
$zipFileName = 'output.zip';

// Création de l'objet ZipArchive
$zip = new ZipArchive;

if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
    // Ajout du dossier au zip
    addFolderToZip($folderPath, $zip);

    // Fermeture de l'archive
    $zip->close();
    echo 'Dossier compressé avec succès';
} else {
    echo 'Impossible de créer le fichier ZIP';
}
?>
<?php
// $zip = new ZipArchive;
// $zipFileName = 'output.zip'; // Chemin vers le fichier ZIP
// $extractPath = 'extract/'; // Chemin où extraire les fichiers

// if ($zip->open($zipFileName) === TRUE) {
//     // Extraction des fichiers dans le dossier spécifié
//     $zip->extractTo($extractPath);
//     $zip->close();
//     echo 'Extraction réussie.';
// } else {
//     echo 'Erreur lors de l\'ouverture du fichier ZIP.';
// }
?>
<?php
$url = 'https://chahid.info/pse/receive.php'; // URL de l'API cible
$filePath = 'output.zip'; // Chemin du fichier compressé

// Initialisation de cURL
$ch = curl_init();

// Paramètres de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new CURLFile($filePath)]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Exécution de la requête
$response = curl_exec($ch);

// Fermeture de la session cURL
curl_close($ch);

// Afficher la réponse
echo $response;

session_start();

    $_SESSION['envoie_reussi'] = true;
    header("Location:admin/mise_a_jour.php");
?>
