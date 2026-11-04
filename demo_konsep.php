<?php
declare(strict_types=1);
require_once __DIR__ . '/Mahasiswa.php';

define('DEMO_LIFECYCLE', true);
header('Content-Type: text/plain; charset=utf-8');

echo "1. Menjalankan KONSTRUKTOR (object valid sejak awal)\n";
$m = new Mahasiswa('123', 'Alya', 'Teknik', 'Informatika', 'SMA 1', 3, 'Membaca', 'Islam');
echo $m->ringkasan() . "\n";
try {
    new Mahasiswa('124', 'Budi', 'Teknik', 'Informatika', 'SMA 1', 15, '', 'Islam');
} catch (InvalidArgumentException $e) {
    echo "Ditolak constructor: " . $e->getMessage() . "\n";
}

echo "\n2. ENKAPSULASI: akses langsung vs getter/setter\n";
try {
    echo $m->semester;
} catch (Error $e) {
    echo "Baca langsung \$m->semester  -> " . $e->getMessage() . "\n";
}
try {
    $m->semester = -7;
} catch (Error $e) {
    echo "Tulis langsung \$m->semester -> " . $e->getMessage() . "\n";
}
$m->setSemester(5);
echo "Lewat setSemester(5)   -> getSemester() = " . $m->getSemester() . "\n";
try {
    $m->setSemester(-7);
} catch (InvalidArgumentException $e) {
    echo "Lewat setSemester(-7)  -> ditolak: " . $e->getMessage() . "\n";
}
echo "Semester tetap: " . $m->getSemester() . "\n";

echo "\n3. Menjalankan OVERLOADING METHOD\n";
echo $m->profilSingkat() . "\n"; // __call()

echo "\n4. Menjalankan DESTRUCTOR\n";
echo "Lihat log error PHP setelah unset referensi terakhir.\n";
unset($m); // destructor menulis error_log, bukan menghapus record CRUD
