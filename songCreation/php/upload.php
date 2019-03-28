<!--
 @file
 @brief Contains the function to aid with uploading a file to the server.
-->
<?php
function upload() {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        unlink($target_file);
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $message = "Sorry, file is too large";
    }

    //check other errors
    $message = 'Error uploading file';
    switch ($_FILES['fileToUpload']['error']) {
        case UPLOAD_ERR_OK:
            $message = false;;
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $message .= ' - file too large.';
            break;
        case UPLOAD_ERR_PARTIAL:
            $message .= ' - file upload was not completed.';
            break;
        case UPLOAD_ERR_NO_FILE:
            $message .= ' - zero-length file uploaded.';
            break;
        default:
            $message .= ' - internal error #' . $_FILES['fileToUpload']['error'];
            break;
    }

    if (!$message) {
        if (!is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
            $message = 'Error uploading file- unknown error.';
        } else {
            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $message = 'Error uploading file- could not save upload';
                echo $target_dir;
                echo $_FILES['fileToUpload']["name"];
            }
        }
    }

    if ($message != '') {
        echo $message;
    }
}
?>
