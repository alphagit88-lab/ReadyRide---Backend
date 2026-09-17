<?php

$target = realpath(__DIR__ . '/../storage/app/public');
$link = __DIR__ . '/storage';

echo "Target: " . ($target ?: 'NOT FOUND') . "<br>";
echo "Link: " . $link . "<br><br>";

if (!$target) {
    die("❌ Target folder does not exist.");
}

if (is_link($link)) {
    unlink($link);
}

if (file_exists($link)) {
    die("❌ public/storage already exists. Delete/rename it from File Manager first.");
}

if (symlink($target, $link)) {
    echo "✅ Storage link created successfully.";
} else {
    echo "❌ Failed to create symlink.";
}