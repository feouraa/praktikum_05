<?php
declare(strict_types=1);

class Buku
{
    private string $kodeBuku;
    private string $judul;
    private int $stok;

    public function __construct(string $kodeBuku, string $judul, int $stok = 0)
    {
        $kodeBuku = trim($kodeBuku);
        if ($kodeBuku === "") {
            throw new InvalidArgumentException("Kode buku wajib diisi");
        }
        $this->kodeBuku = $kodeBuku;      // read-only: tidak ada setKodeBuku()
        $this->setJudul($judul);
        if ($stok < 0) {
            throw new InvalidArgumentException("Stok awal tidak boleh negatif");
        }
        $this->stok = $stok;
    }

    public function getKodeBuku(): string { return $this->kodeBuku; }
    public function getJudul(): string    { return $this->judul; }
    public function getStok(): int        { return $this->stok; }

    public function setJudul(string $judul): void
    {
        $judul = trim($judul);
        if ($judul === "") {
            throw new InvalidArgumentException("Judul wajib diisi");
        }
        $this->judul = $judul;
    }

    public function tambahStok(int $jumlah): void
    {
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah tambah stok harus positif");
        }
        $this->stok += $jumlah;
    }

    public function kurangiStok(int $jumlah): void
    {
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah pengurangan harus positif");
        }
        if ($jumlah > $this->stok) {
            throw new InvalidArgumentException("Stok tidak mencukupi (tersedia {$this->stok})");
        }
        $this->stok -= $jumlah;
    }
}

// ---------- Pengujian ----------
function coba(string $label, callable $fn): void
{
    try {
        $hasil = $fn();
        echo "<tr><td>$label</td><td>VALID</td><td>" . htmlspecialchars((string)$hasil) . "</td></tr>";
    } catch (Throwable $e) {
        echo "<tr><td>$label</td><td>DITOLAK</td><td>" . htmlspecialchars($e->getMessage()) . "</td></tr>";
    }
}

$b = new Buku("BK-001", "Pemrograman Berorientasi Objek", 10);

echo "<h3>Tugas 2 – Pengujian class Buku</h3>";
echo "<table border='1' cellpadding='6'><tr><th>Input</th><th>Jenis</th><th>Hasil</th></tr>";
coba('tambahStok(5) → stok 10+5',        function () use ($b) { $b->tambahStok(5); return "stok = " . $b->getStok(); });
coba('kurangiStok(3) → stok 15-3',       function () use ($b) { $b->kurangiStok(3); return "stok = " . $b->getStok(); });
coba('setJudul("")',                     function () use ($b) { $b->setJudul("   "); return "ok"; });
coba('kurangiStok(100) (melebihi stok)', function () use ($b) { $b->kurangiStok(100); return "ok"; });
coba('tambahStok(-5)',                   function () use ($b) { $b->tambahStok(-5); return "ok"; });
coba('new Buku("BK-2","X",-1)',          fn() => new Buku("BK-2", "X", -1) ? "ok" : "");
coba('Akses langsung $b->stok = -9',     function () use ($b) { $b->stok = -9; return "ok"; });
echo "</table>";
