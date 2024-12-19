<?php
// install.php



    $artisanPath = __DIR__ . '/../../artisan'; // Adjust the path based on your directory structure


    exec("php $artisanPath artisan optimize:clear", $output, $returnVar);
    exec("php $artisanPath artisan config:clear", $output, $returnVar);





    exec("php $artisanPath migrate", $output, $returnVar);

    if ($returnVar !== 0) {
        echo 'Error running migrations and seeders: ' . implode("\n", $output);
        exit;
    }

    echo 'DB Schema updated successfully!';


?>;

