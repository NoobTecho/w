<?php
// Folder utama yang berisi semua direktori WordPress
$main_dir = "/home/cursosba";

// Ekstensi file sampah
$junk_extensions = ['log', 'tmp', 'bak', 'old', 'zip', 'tar', 'gz'];

// Nama file sampah umum
$junk_filenames = ['error_log', 'debug.log'];

// Fungsi hapus file sampah
function delete_junk($dir, $exts, $names) {
    $count = 0;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $full = $dir . DIRECTORY_SEPARATOR . $file;

        if (is_dir($full)) {
            $count += delete_junk($full, $exts, $names);
        } else {
            $path_info = pathinfo($full);
            $ext = strtolower($path_info['extension'] ?? '');
            $base = strtolower($path_info['basename']);

            if (in_array($ext, $exts) || in_array($base, $names)) {
                if (@unlink($full)) {
                    echo "Deleted: $full\n";
                    $count++;
                }
            }
        }
    }
    return $count;
}

// Loop semua subfolder di dalam domain utama
$subdirs = scandir($main_dir);
foreach ($subdirs as $folder) {
    $full_path = $main_dir . DIRECTORY_SEPARATOR . $folder;
    if ($folder === '.' || $folder === '..') continue;
    if (is_dir($full_path)) {
        echo "Membersihkan folder: $full_path\n";
        $deleted = delete_junk($full_path, $junk_extensions, $junk_filenames);
        echo "Total file dihapus dari $folder: $deleted\n\n";
    }
}
?>
