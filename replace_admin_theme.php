<?php

$dir = __DIR__ . '/resources/views/admin';

$replacements = [
    'bg-[#111]' => 'bg-primary',
    'text-[#111]' => 'text-primary',
    'hover:bg-black' => 'hover:bg-opacity-90',
    'hover:text-black' => 'hover:text-opacity-90',
    'border-[#111]' => 'border-primary',
    'ring-[#111]' => 'ring-primary',
    'bg-secondary' => 'bg-primary', // Dark teal sidebar
];

function processDirectory($dir, $replacements) {
    if (!is_dir($dir)) return;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
            if ($newContent !== $content) {
                file_put_contents($file->getPathname(), $newContent);
                echo "Updated: " . $file->getPathname() . "\n";
            }
        }
    }
}

processDirectory($dir, $replacements);

// Also update layouts/admin.blade.php
$adminLayoutPath = __DIR__ . '/resources/views/layouts/admin.blade.php';
if (file_exists($adminLayoutPath)) {
    $content = file_get_contents($adminLayoutPath);
    $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
    if ($newContent !== $content) {
        file_put_contents($adminLayoutPath, $newContent);
        echo "Updated: " . $adminLayoutPath . "\n";
    }
}

echo "Admin clinical theme rebranding complete.\n";
