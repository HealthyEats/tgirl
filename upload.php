<?php
if(isset($_POST['submit'])){
    // معلومات الاتصال بالخادم FTP
    $ftpHost = 's2.serv00.com';
    $ftpUsername = 'karens49';
    $ftpPassword = '2L4$v%xEfv0jqwr!L@sf';

    // معلومات الملف المراد رفعه
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $remoteFile = '/usr/home/karens49/' . $fileName; // يمكنك تحديد المسار البعيد حسب احتياجاتك

    // إنشاء اتصال FTP
    $ftpConn = ftp_connect($ftpHost);
    if (!$ftpConn) {
        die('Could not connect to FTP server');
    }

    // تسجيل الدخول إلى حساب FTP
    $login = ftp_login($ftpConn, $ftpUsername, $ftpPassword);
    if (!$login) {
        die('Could not login to FTP server');
    }

    // رفع الملف
    $upload = ftp_put($ftpConn, $remoteFile, $fileTmpName, FTP_BINARY);
    if (!$upload) {
        die('Could not upload file');
    }

    // إغلاق اتصال FTP
    ftp_close($ftpConn);

    echo 'File uploaded successfully';
}
?>
