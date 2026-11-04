<?php
declare(strict_types=1);
require_once __DIR__ . '/Mahasiswa.php';

class DataMahasiswa {
    /** @var array<string, Mahasiswa> key = NIM */
    private array $data = [];

    public function __construct(array $dataAwal = []) {
        foreach ($dataAwal as $item) {
            if ($item instanceof Mahasiswa) {
                $this->data[$item->getNim()] = $item;   // SEBELUM: $item->nim
            }
        }
    }
    public function tambah(Mahasiswa $m): bool {
        if (isset($this->data[$m->getNim()])) return false;   // NIM harus unik
        $this->data[$m->getNim()] = $m;
        return true;
    }
    /** @return array<string, Mahasiswa> */
    public function semua(): array { return $this->data; }
    public function cari(string $nim): ?Mahasiswa {
        return $this->data[$nim] ?? null;
    }
    /**
     * NIM tetap, jadi key tidak pernah berubah: cukup mengganti object
     * pada key yang sama. (Parameter $nimLama dari Pertemuan 4 tidak diperlukan lagi.)
     */
    public function ubah(Mahasiswa $m): bool {
        if (!isset($this->data[$m->getNim()])) return false;
        $this->data[$m->getNim()] = $m;
        return true;
    }
    public function hapus(string $nim): bool {
        if (!isset($this->data[$nim])) return false;
        unset($this->data[$nim]);
        return true;
    }
}
