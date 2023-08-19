<?php

require_once '../vendor/autoload.php';

//use Kunnu;
use Kunnu\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use kunnu\Dropbox\Http;
use Kunnu\Dropbox\Http\Clients;
use Kunnu\Dropbox\Models;
use Kunnu\Dropbox\Models\FileMetadata;
use Kunnu\Dropbox\Security;
use Kunnu\Dropbox\Store;
use Kunnu\Dropbox\Exceptions\DropboxClientException;

// these are for the keys we need to access the folder and files in the dropbox
$appkey = '	o4ieswzrk70v7gk';
$secretKey = "lt1a4on2d9t0brm";
$accessToken = 'sl.BjwbdQSIDsvoM1fzWiYsxwukvaF42iQKqqVrZTZ_ekmBuHu5kE0yHLhEaSZBVz-0-7H9grh2Bp4_7b9GSOADXU0zZhWDkWqHkhTVeflmGV4QE8iDB0kmaBSPwosAoJU7wHAYrpYHMCIph5CAJon2';

if (isset($_FILES["file_name"]) && $_FILES["file_name"]["error"] === UPLOAD_ERR_OK)
{
    // Get the uploaded file details
    $file = $_FILES["file_name"];


    // Specify the destination path in Dropbox
    $destinationPath = '/BusRouteProject/' . $file['name'];
//    var_dump($destinationPath);
    // Create a Dropbox app instance
    $app = new DropboxApp($appkey, $secretKey, $accessToken);

    try {
        // Create a Dropbox object
        $dropbox = new Dropbox\Dropbox($app);

        // Create a DropboxFile object from the uploaded file
        $dropboxFile = new \Kunnu\Dropbox\DropboxFile($file['tmp_name']);

        // Upload the file to Dropbox
        $fileMetadata = $dropbox->upload($dropboxFile, $destinationPath);

        // Get the temporary link for the uploaded file
        $temporaryLink = $dropbox->getTemporaryLink($destinationPath);

        $temporaryLinkUrl = $temporaryLink->getLink();

        echo json_encode(['status' => 'success', 'url' => $temporaryLinkUrl]);
    } catch (DropboxClientException $e) {
        // Handle any errors that occurred during the upload
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
