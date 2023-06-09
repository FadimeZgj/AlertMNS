<?php
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';
$siteUrl = 'http://localhost:82';

/**
 * Permet d'uploader une image
 *
 * @param string $inputFileName
 * @return void
 */
function uploadImageFile(string $inputFileName)
{
    $urlImage = NULL;

    if(!empty($_FILES[$inputFileName]) && $_FILES[$inputFileName]['error'] == 0)
    {
        // On vérifie le poid de l'image
        if($_FILES[$inputFileName]['size'] < 1000000)
        {
            // On vérifie que le fichier est bien une image
            $authorizedTypes = ["image/png","image/jpg","image/gif","image/jpeg"];
            $fileType = mime_content_type($_FILES[$inputFileName]['tmp_name']);

            if(in_array($fileType, $authorizedTypes))
            {

                $fileName = str_replace(' ','-', basename($_FILES[$inputFileName]['name']));
                $tmpFile = $_FILES[$inputFileName]['tmp_name'];

                if(move_uploaded_file($tmpFile, "../assets/uploads/profile-pictures/" . $fileName))
                {
                    $urlImage = "../assets/uploads/profile-pictures/" . $fileName;
                }
                else
                {
                    echo "Impossible de télécharger l'image"; die;
                }

            }
            else
            {
                echo "Fichier non autorisé !"; die;
            }

        }
    }

    return $urlImage;
}

function get_image_url($fileName)
{
    return '../assets/uploads/profile-pictures/' . $fileName;
}

/**
 * Supprime un fichier image du système de fichiers.
 *
 * @param string $imageURL
 * @return bool
 */
function deleteImageInFile($imageURL)
{
    // Supprimer le fichier image du système de fichiers
    if (file_exists($imageURL)) {
        return unlink($imageURL);
    }

    return false;
}
