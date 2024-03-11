<?php
// مسار مجلد الرفع على الخادم
$uploadDir = '/usr/home/karens49/';

// فحص ما إذا كان المجلد موجوداً وقابل للقراءة
if (is_dir($uploadDir) && $handle = opendir($uploadDir)) {
    echo "<h2>Uploaded Websites:</h2>";
    echo "<ul>";
    // قراءة الملفات في المجلد وعرضها كروابط
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "<li><a href='" . $uploadDir . $entry . "'>" . $entry . "</a></li>";
        }
    }
    echo "</ul>";
    closedir($handle);
} else {
    echo "No uploaded websites found.";
}
?>
