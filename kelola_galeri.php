<?php 
include 'db_config.php';

// Proteksi: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    header("Location: login.php"); exit(); 
}

// Proses Simpan Data
if (isset($_POST['simpan_galeri'])) {
    $judul = $_POST['judul'];
    $tipe = $_POST['tipe'];
    
    if ($tipe == 'foto') {
        $file_nama = time() . "_" . $_FILES['foto']['name'];
        if (move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $file_nama)) {
            $conn->query("INSERT INTO galeri (judul, tipe, file_nama) VALUES ('$judul', 'foto', '$file_nama')");
        }
    } else {
        // Ambil ID Video dari Link YouTube (Contoh: dQw4w9WgXcQ)
        $url = $_POST['video_url'];
        parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
        $video_id = $my_array_of_vars['v'] ?? $url; 
        
        $conn->query("INSERT INTO galeri (judul, tipe, video_url) VALUES ('$judul', 'video', '$video_id')");
    }
    header("Location: kelola_galeri.php");
    
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM galeri WHERE id=$id");
    header("Location: kelola_galeri.php");
}
// Proses Simpan Poster
if (isset($_POST['simpan_poster'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul_poster']);
    
    // Folder tujuan upload
    $target_dir = "uploads/";
    $file_name = time() . "_" . basename($_FILES["gambar_poster"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["gambar_poster"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO poster (judul, gambar) VALUES ('$judul', '$file_name')");
        echo "<script>alert('Poster berhasil diunggah!'); window.location='kelola_galeri.php?tab=poster';</script>";
    } else {
        echo "<script>alert('Gagal mengunggah gambar.');</script>";
    }
}

// Proses Hapus Poster
if (isset($_GET['hapus_poster'])) {
    $id = $_GET['hapus_poster'];
    $conn->query("DELETE FROM poster WHERE id=$id");
    header("Location: kelola_galeri.php?tab=poster");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Galeri | Admin DLH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-slate-800">Tambah <span class="text-green-600">Dokumentasi</span></h1>
            <a href="admin.php" class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-800">Kembali</a>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100 mb-10">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Judul Kegiatan</label>
                    <input type="text" name="judul" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-green-500 font-bold" required>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Tipe Media</label>
                        <select name="tipe" id="tipeSelect" onchange="toggleInput()" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none font-bold">
                            <option value="foto">Foto (Upload)</option>
                            <option value="video">Video (YouTube ID)</option>
                        </select>
                    </div>
                    
                    <div id="inputFoto">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Pilih File Foto</label>
                        <input type="file" name="foto" class="text-xs mt-2">
                    </div>

                    <div id="inputVideo" class="hidden">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">ID Video / Link YouTube</label>
                        <input type="text" name="video_url" placeholder="Contoh: dQw4w9WgXcQ" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none text-xs">
                    </div>
                </div>

                <button name="simpan_galeri" class="w-full bg-green-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-green-100 hover:bg-green-700 transition">Simpan ke Galeri</button>
            </form>
        </div>

        <div class="space-y-4">
            <h2 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.3em] ml-2">Konten Galeri</h2>
            <?php 
            $res = $conn->query("SELECT * FROM galeri ORDER BY tgl_upload DESC");
            while($g = $res->fetch_assoc()): ?>
            <div class="bg-white p-4 rounded-2xl flex justify-between items-center border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                        <i class="fas <?= $g['tipe'] == 'foto' ? 'fa-image' : 'fa-video' ?>"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm"><?= $g['judul'] ?></p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?= $g['tipe'] ?> • <?= date('d/m/Y', strtotime($g['tgl_upload'])) ?></p>
                    </div>
                </div>
                <a href="?hapus=<?= $g['id'] ?>" onclick="return confirm('Hapus media ini?')" class="text-red-400 hover:text-red-600 p-2 transition">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function toggleInput() {
            let tipe = document.getElementById('tipeSelect').value;
            document.getElementById('inputFoto').classList.toggle('hidden', tipe !== 'foto');
            document.getElementById('inputVideo').classList.toggle('hidden', tipe !== 'video');
        }
    </script>
    
<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <div class="lg:col-span-4">
        <form method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 space-y-4">
            <h3 class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-4">Unggah Pamflet Baru</h3>
            <input type="text" name="judul_poster" placeholder="Judul Poster" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-bold outline-none" required>
            <input type="file" name="gambar_poster" class="text-[10px]" required>
            <button name="simpan_poster" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black uppercase text-xs shadow-lg mt-4 hover:bg-green-600 transition">Terbitkan Poster</button>
        </form>
    </div>

    <div class="lg:col-span-8">
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400">Judul</th>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400">Preview</th>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php 
                    $res = $conn->query("SELECT * FROM poster ORDER BY id DESC");
                    while($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td class="p-6 text-sm font-bold text-slate-800 uppercase"><?= $row['judul'] ?></td>
                        <td class="p-6">
                            <img src="uploads/<?= $row['gambar'] ?>" class="w-16 h-20 object-cover rounded-lg shadow-sm">
                        </td>
                        <td class="p-6 text-center">
                            <a href="?tab=poster&hapus_poster=<?= $row['id'] ?>" onclick="return confirm('Hapus poster ini?')" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>