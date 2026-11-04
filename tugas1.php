<?php
declare(strict_types=1);

class Produk
{
    public string $nama;
    protected string $kategori;
    private int $harga;

    public function __construct(string $nama, string $kategori, int $harga)
    {
        $this->nama = $nama;
        $this->kategori = $kategori;
        $this->harga = $harga;
    }

    public function getHarga(): int { return $this->harga; }
}

class ProdukDigital extends Produk
{
    public function bacaKategori(): string
    {
        return $this->kategori;          // protected: BOLEH dari class turunan
    }

    public function bacaHargaLangsung(): mixed
    {
        return $this->harga;             // private milik Produk: TIDAK terlihat
    }
}

// Ubah warning/error menjadi exception agar mudah dicatat
set_error_handler(function (int $no, string $msg) {
    throw new ErrorException($msg, 0, $no);
});

function uji(string $label, callable $fn): void
{
    try {
        $hasil = $fn();
        echo "<tr><td>$label</td><td>BERHASIL</td><td>" . htmlspecialchars((string)$hasil) . "</td></tr>";
    } catch (Throwable $e) {
        echo "<tr><td>$label</td><td>DITOLAK</td><td>" . htmlspecialchars($e->getMessage()) . "</td></tr>";
    }
}

$p = new Produk("Laptop", "Elektronik", 7500000);
$d = new ProdukDigital("E-Book PBO", "Digital", 50000);

echo "<h3>Tugas 1 – Hasil uji access modifier</h3>";
echo "<table border='1' cellpadding='6'><tr><th>Uji</th><th>Hasil</th><th>Keterangan</th></tr>";
uji('Luar class: $p->nama (public)',            fn() => $p->nama);
uji('Luar class: $p->kategori (protected)',     fn() => $p->kategori);
uji('Luar class: $p->harga (private)',          fn() => $p->harga);
uji('Luar class: $p->getHarga() (public method)', fn() => $p->getHarga());
uji('Subclass: $this->kategori (protected)',    fn() => $d->bacaKategori());
uji('Subclass: $this->harga (private induk)',   fn() => $d->bacaHargaLangsung());
echo "</table>";
