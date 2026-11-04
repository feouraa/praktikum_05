<?php
declare(strict_types=1);
// Buka: http://localhost/PBO05_CRUD_Mahasiswa/uji.php  — menguji kasus 01–09 (tanpa session).
require_once __DIR__ . '/DataMahasiswa.php';

function mk(string $nim = '23001', string $nama = 'Siti', int $smt = 4, string $agama = 'Islam'): Mahasiswa {
    return new Mahasiswa($nim, $nama, 'FST', 'Informatika', 'SMAN 1', $smt, 'Membaca', $agama);
}
function harusGagal(callable $fn): array {
    try { $fn(); return [false, 'Tidak ada error (SEHARUSNYA ditolak)']; }
    catch (Throwable $e) { return [true, $e->getMessage()]; }
}
function harusBerhasil(callable $fn): array {
    try { $fn(); return [true, 'OK']; }
    catch (Throwable $e) { return [false, $e->getMessage()]; }
}
$repo = new DataMahasiswa();

$kasus = [
 ['01','Mahasiswa valid, semester 4',  fn() => harusBerhasil(function () use ($repo) {
        if (!$repo->tambah(mk())) throw new Exception('Gagal tersimpan'); })],
 ['02','NIM kosong',                   fn() => harusGagal(fn() => mk('  '))],
 ['03','Semester -1',                  fn() => harusGagal(fn() => mk('1', 'Budi', -1))],
 ['04','Semester 15',                  fn() => harusGagal(fn() => mk('1', 'Budi', 15))],
 ['05','Nama kosong/spasi',            fn() => harusGagal(fn() => mk('1', '   '))],
 ['06','Akses langsung $m->semester',  fn() => harusGagal(function () { $m = mk(); echo $m->semester; })],
 ['07','Edit nama valid',              fn() => harusBerhasil(function () use ($repo) {
        $c = clone $repo->cari('23001'); $c->setNama('Siti Aminah'); $repo->ubah($c);
        if ($repo->cari('23001')->getNama() !== 'Siti Aminah') throw new Exception('Nama tidak berubah'); })],
 ['08','NIM duplikat pada tambah',     fn() => harusGagal(function () use ($repo) {
        if (!$repo->tambah(mk('23001', 'Lain'))) throw new InvalidArgumentException('NIM sudah terdaftar (ditolak repository)'); })],
 ['09','Hapus mahasiswa',              fn() => harusBerhasil(function () use ($repo) {
        $repo->tambah(mk('23002', 'Andi')); $repo->hapus('23002');
        if ($repo->cari('23002') !== null || $repo->cari('23001') === null) throw new Exception('Hapus salah sasaran'); })],
 ['—', 'Agama di luar daftar',         fn() => harusGagal(fn() => mk('5', 'Dewi', 2, 'Lainnya'))],
 ['—', 'Mencoba $m->nim = "X" (NIM tetap)', fn() => harusGagal(function () { $m = mk(); $m->nim = 'X'; })],
];
?>
<!DOCTYPE html><meta charset="UTF-8"><title>Uji Enkapsulasi</title>
<h3>Tabel Hasil Uji (otomatis)</h3>
<table border="1" cellpadding="6" style="border-collapse:collapse;font-family:sans-serif">
<tr><th>Kasus</th><th>Skenario</th><th>Status</th><th>Pesan sistem</th></tr>
<?php foreach ($kasus as [$no, $nama, $fn]): [$lulus, $pesan] = $fn(); ?>
<tr><td><?= $no ?></td><td><?= htmlspecialchars($nama) ?></td>
<td><?= $lulus ? '✅ LULUS' : '❌ GAGAL' ?></td><td><?= htmlspecialchars($pesan) ?></td></tr>
<?php endforeach; ?>
</table>
<p>Kasus 10 (refresh browser) diuji manual di <a href="index.php">index.php</a>: tambah data lalu tekan F5; data tetap tampil selama Session aktif.</p>
