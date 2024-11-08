<?php
session_start();

// Inisialisasi data barang jika belum ada
if (!isset($_SESSION['data_barang'])) {
    $_SESSION['data_barang'] = [
        ['id_barang' => 1, 'nama_barang' => 'buku', 'stok' => 350, 'harga_beli' => 30000, 'harga_jual' => 35000],
        ['id_barang' => 2, 'nama_barang' => 'sepatu', 'stok' => 500, 'harga_beli' => 50000, 'harga_jual' => 70000],
        ['id_barang' => 3, 'nama_barang' => 'seragam', 'stok' => 300, 'harga_beli' => 100000, 'harga_jual' => 150000],
        ['id_barang' => 4, 'nama_barang' => 'pensil', 'stok' => 250, 'harga_beli' => 15000, 'harga_jual' => 20000],
        ['id_barang' => 5, 'nama_barang' => 'pulpen', 'stok' => 300, 'harga_beli' => 17000, 'harga_jual' => 20000],
    ];
}

// Tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $id_barang = count($_SESSION['data_barang']) + 1;
        $nama_barang = $_POST['nama_barang'];
        $stok = $_POST['stok'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];

        $_SESSION['data_barang'][] = [
            'id_barang' => $id_barang,
            'nama_barang' => $nama_barang,
            'stok' => $stok,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
        ];
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id_barang = $_POST['id_barang'];
        $nama_barang = $_POST['nama_barang'];
        $stok = $_POST['stok'];
        $harga_jual = $_POST['harga_jual'];
        $harga_beli = $_POST['harga_beli'];

        foreach ($_SESSION['data_barang'] as &$item) {
            if ($item['id_barang'] == $id_barang) {
                $item['nama_barang'] = $nama_barang;
                $item['stok'] = $stok;
                $item['harga_jual'] = $harga_jual;
                $item['harga_beli'] = $harga_beli;
                break;
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id_barang = $_POST['id_barang'];
        $_SESSION['data_barang'] = array_filter($_SESSION['data_barang'], function ($item) use ($id_barang) {
            return $item['id_barang'] != $id_barang;
        });
    }
}

// Ambil data barang
$data_barang = $_SESSION['data_barang'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Amel Peralatan Sekolah</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #843434;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Data Alat Tulis Kantor</h2>
    <table>
        <tr>
            <th>id_barang</th>
            <th>nama_barang</th>
            <th>stok</th>
            <th>harga_beli</th>
            <th>harga_jual</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data_barang as $item): ?>
        <tr>
            <td><?php echo $item['id_barang']; ?></td>
            <td><?php echo $item['nama_barang']; ?></td>
            <td><?php echo $item['stok']; ?></td>
            <td><?php echo $item['harga_beli']; ?></td>
            <td><?php echo $item['harga_jual']; ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id_barang" value="<?php echo $item['id_barang']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Hapus</button>
                </form>
                <button onclick="editData(<?php echo $item['id_barang']; ?>, '<?php echo $item['nama_barang']; ?>', <?php echo $item['stok']; ?>, <?php echo $item['harga_beli']; ?>, <?php echo $item['harga_jual']; ?>)">Edit</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Tambah Data</h3>
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label>Nama Barang: <input type="text" name="nama_barang" required></label>
        <label>Stok: <input type="number" name="stok" required></label>
        <label>Harga beli: <input type="number" name="harga_beli" required></label>
        <label>Harga jual: <input type="number" name="harga_jual" required></label>
        <button type="submit">Tambah</button>
    </form>

    <script>
        function editData(id, nama, stok, hargaJual, hargaBeli) {
            const form = document.createElement('form');
            form.method = 'post';
            form.innerHTML = `
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_barang" value="${id}">
                <label>Nama Barang: <input type="text" name="nama_barang" value="${nama}" required></label>
                <label>Stok: <input type="number" name="stok" value="${stok}" required></label>
                <label>Harga beli: <input type="number" name="harga_beli" value="${hargabeli}" required></label>
                <label>Harga jual: <input type="number" name="harga_jual" value="${hargajual}" required></label>
                <button type="submit">Simpan</button>
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>