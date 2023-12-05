<?php

if (isset($_GET['file'])) {
    $filePaths = explode(', ', urldecode($_GET['file']));

    foreach ($filePaths as $filePath) {
        header('Content-Type: application/pdf'); // Ví dụ, đối với định dạng PDF

        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');

        readfile($filePath);
    }
} else {
    echo 'Không tìm thấy file.';
}
