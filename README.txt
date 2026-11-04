PBO PERTEMUAN 5 — ENKAPSULASI — PHP 8+ / XAMPP
1. Ekstrak folder PBO05_CRUD_Mahasiswa ke C:\xampp\htdocs\
2. Jalankan Apache dari XAMPP Control Panel.
3. Buka http://localhost/PBO05_CRUD_Mahasiswa/index.php  (CRUD)
4. Buka .../demo_konsep.php  (constructor, enkapsulasi, overloading method, destructor)
5. Buka .../uji.php          (tabel uji otomatis kasus 01–09)
6. Buka .../tugas1.php dan .../tugas2.php  (Tugas 1 dan 2)

PERUBAHAN DARI PERTEMUAN 4
Mahasiswa.php      = semua property private; getter; setter bervalidasi; TANPA setNim();
                     __get/__set/__isset/__unset dihapus (lihat catatan di berkas).
DataMahasiswa.php  = memakai getNim(); tambah() menolak NIM duplikat;
                     ubah(Mahasiswa $m) tanpa $nimLama karena NIM tidak berubah.
index.php          = memakai getter lewat helper nilai(); NIM readonly saat Edit;
                     edit memakai clone + setter; kunci session 'mahasiswa_p5'.
demo_konsep.php    = demo property overloading diganti demo enkapsulasi.

CATATAN:
- require_once class HARUS sebelum session_start().
- Kunci session diganti agar object public lama dari Pertemuan 4 tidak ikut terbaca.
  Bila perlu, tutup semua tab/browser untuk mengosongkan session lama.
- Destructor tidak menghapus data CRUD. Demo menulis ke error log.
- Data di Session hanya untuk pembelajaran, bukan penyimpanan permanen.
