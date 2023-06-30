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
$accessToken = 'sl.BhQVA5xt-knfKVHo4aiNWE0OypnVxCl0bVN8Quj3C30cR0ZQKBe023S563ndHAyrF7saDuuGX7RV2n3C5qioyZoB_E8vq0XiJd8sZYYZ0-xLYZpH_RCx5xCs2RKcB9cQvFjoWfKabf0';

if (isset($_FILES["file_name"]) && $_FILES["file_name"]["error"] === UPLOAD_ERR_OK) {
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
