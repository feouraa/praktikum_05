<?php
declare(strict_types=1);

class Mahasiswa {
    public const AGAMA_VALID = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'];

    // Pertemuan 5: semua state PRIVATE. Perubahan hanya lewat setter bervalidasi.
    private string $nim;
    private string $nama;
    private string $fakultas;
    private string $prodi;
    private string $asalSekolah;
    private int $semester;
    private string $hobi;
    private string $agama;

    // Constructor: membentuk object yang valid sejak awal (memakai setter yang sama).
    public function __construct(
        string $nim, string $nama, string $fakultas, string $prodi,
        string $asalSekolah, int $semester, string $hobi, string $agama
    ) {
        $nim = trim($nim);
        if ($nim === '') throw new InvalidArgumentException('NIM wajib diisi.');
        $this->nim = $nim; // identitas tetap: sengaja TIDAK ada setNim()

        $this->setNama($nama);
        $this->setFakultas($fakultas);
        $this->setProdi($prodi);
        $this->setAsalSekolah($asalSekolah);
        $this->setSemester($semester);
        $this->setHobi($hobi);
        $this->setAgama($agama);
    }

    // ===== Getter =====
    public function getNim(): string         { return $this->nim; }
    public function getNama(): string        { return $this->nama; }
    public function getFakultas(): string    { return $this->fakultas; }
    public function getProdi(): string       { return $this->prodi; }
    public function getAsalSekolah(): string { return $this->asalSekolah; }
    public function getSemester(): int       { return $this->semester; }
    public function getHobi(): string        { return $this->hobi; }
    public function getAgama(): string       { return $this->agama; }

    // ===== Setter + validasi (tidak ada setNim) =====
    public function setNama(string $nama): void {
        $this->nama = $this->wajibIsi($nama, 'Nama');
    }
    public function setFakultas(string $fakultas): void {
        $this->fakultas = $this->wajibIsi($fakultas, 'Fakultas');
    }
    public function setProdi(string $prodi): void {
        $this->prodi = $this->wajibIsi($prodi, 'Program Studi');
    }
    public function setAsalSekolah(string $asal): void {
        $this->asalSekolah = $this->wajibIsi($asal, 'Asal Sekolah');
    }
    public function setSemester(int $semester): void {
        if ($semester < 1 || $semester > 14) {
            throw new InvalidArgumentException('Semester harus 1–14.');
        }
        $this->semester = $semester;
    }
    public function setHobi(string $hobi): void {
        $this->hobi = trim($hobi); // hobi boleh kosong
    }
    public function setAgama(string $agama): void {
        $agama = trim($agama);
        if (!in_array($agama, self::AGAMA_VALID, true)) {
            throw new InvalidArgumentException('Pilihan agama tidak valid.');
        }
        $this->agama = $agama;
    }

    private function wajibIsi(string $nilai, string $label): string {
        $nilai = trim($nilai);
        if ($nilai === '') throw new InvalidArgumentException($label . ' wajib diisi.');
        return $nilai;
    }

    public function ringkasan(): string {
        return $this->nim . ' - ' . $this->nama;
    }

    // Overloading method (Pertemuan 4) tetap dipertahankan.
    public function __call(string $nama, array $argumen): mixed {
        if ($nama === 'profilSingkat' && count($argumen) === 0) {
            return $this->ringkasan();
        }
        throw new BadMethodCallException('Method tidak tersedia: ' . $nama);
    }

    public function __destruct() {
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) {
            error_log('Destructor Mahasiswa: ' . $this->nim);
        }
    }

    /*
     * CATATAN: __set/__get/__isset/__unset dari Pertemuan 4 DIHAPUS.
     * Jika dipertahankan, `$m->semester = -7` dari luar class akan "diam-diam"
     * dialihkan ke __set() (karena property private dianggap tidak terlihat),
     * sehingga error akses private tidak muncul dan enkapsulasi bocor.
     */
}
