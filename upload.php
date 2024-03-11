<?php
// FTP credentials
$ftp_server = "s2.serv00.com";
$ftp_username = "f5761_karens49";
$ftp_password = "2L4$v%xEfv0jqwr!L@sf";

// File upload handling
$target_dir = "/usr/home/karens49/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
$allowed_formats = array("txt", "pdf", "doc", "docx");
if (!in_array($imageFileType, $allowed_formats)) {
    echo "Sorry, only TXT, PDF, DOC, and DOCX files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Connect to FTP server
        $conn_id = ftp_connect($ftp_server);
        $login_result = ftp_login($conn_id, $ftp_username, $ftp_password);

        // Upload file to FTP server
        if (ftp_put($conn_id, $target_file, $target_file, FTP_BINARY)) {
            echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        // Close FTP connection
        ftp_close($conn_id);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
