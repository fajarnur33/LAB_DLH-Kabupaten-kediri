<?php 
include 'db_config.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    header("Location: login.php"); exit(); 
}

// --- LOGIKA AGENDA ---
if (isset($_POST['simpan_agenda'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul_agenda']);
    $tgl = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    
    $gambar = "default_agenda.jpg";
    if ($_FILES['gambar_agenda']['name'] != "") {
        $gambar = time() . "_" . $_FILES['gambar_agenda']['name'];
        move_uploaded_file($_FILES['gambar_agenda']['tmp_name'], "uploads/" . $gambar);
    }

    $conn->query("INSERT INTO agenda (judul, tanggal, jam, lokasi, gambar_agenda) VALUES ('$judul', '$tgl', '$jam', '$lokasi', '$gambar')");
    header("Location: kelola_konten.php?tab=agenda");
}

// --- LOGIKA LAYANAN ---
if (isset($_POST['simpan_layanan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul_layanan']);
    $desc = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    $ikon = "default_service.png";
    if ($_FILES['gambar_layanan']['name'] != "") {
        $ikon = time() . "_" . $_FILES['gambar_layanan']['name'];
        move_uploaded_file($_FILES['gambar_layanan']['tmp_name'], "uploads/" . $ikon);
    }

    $conn->query("INSERT INTO layanan (judul, deskripsi, gambar) VALUES ('$judul', '$desc', '$ikon')");
    header("Location: kelola_konten.php?tab=layanan");
}

// Logika Hapus Universal
if (isset($_GET['hapus_agenda'])) {
    $conn->query("DELETE FROM agenda WHERE id=".$_GET['hapus_agenda']);
    header("Location: kelola_konten.php?tab=agenda");
}
if (isset($_GET['hapus_layanan'])) {
    $conn->query("DELETE FROM layanan WHERE id=".$_GET['hapus_layanan']);
    header("Location: kelola_konten.php?tab=layanan");
}

$tab_aktif = isset($_GET['tab']) ? $_GET['tab'] : 'agenda';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konten Manager | AdminHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#f8fafc] min-h-screen pb-20">

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tighter text-slate-800">Manajemen <span class="text-green-600">Konten Publik</span></h1>
                <div class="flex gap-4 mt-4">
                    <a href="?tab=agenda" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all <?= $tab_aktif == 'agenda' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-slate-400 border' ?>">
                        <i class="fas fa-calendar-alt mr-2"></i> Agenda Kegiatan
                    </a>
                    <a href="?tab=layanan" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all <?= $tab_aktif == 'layanan' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-slate-400 border' ?>">
                        <i class="fas fa-concierge-bell mr-2"></i> Layanan Digital
                    </a>
                </div>
            </div>
            <a href="admin.php" class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-green-600 transition shadow-xl">Kembali ke Dashboard</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-4">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100">
                    <?php if($tab_aktif == 'agenda'): ?>
                        <form method="POST" enctype="multipart/form-data" class="space-y-4">
                            <h3 class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-4">Input Agenda Baru</h3>
                            <input type="text" name="judul_agenda" placeholder="Nama Kegiatan" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-bold outline-none" required>
                            <input type="date" name="tanggal" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-bold outline-none" required>
                            <input type="text" name="jam" placeholder="Jam (Contoh: 09:00)" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-bold outline-none" required>
                            <input type="text" name="lokasi" placeholder="Lokasi Tempat" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-bold outline-none" required>
                            <input type="file" name="gambar_agenda" class="text-[10px]">
                            <button name="simpan_agenda" class="w-full bg-green-600 text-white py-4 rounded-2xl font-black uppercase text-xs shadow-lg mt-4">Terbitkan Agenda</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" enctype="multipart/form-data" class="space-y-4">
                            <h3 class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-4">Input Layanan Baru</h3>
                            <input type="text" name="judul_layanan" placeholder="Nama Layanan" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-bold outline-none" required>
                            <textarea name="deskripsi" placeholder="Deskripsi Singkat" class="w-full p-4 bg-slate-50 border rounded-2xl text-sm font-medium h-32 outline-none" required></textarea>
                            <label class="text-[9px] font-black text-slate-400 ml-1">UNGGAH IKON LAYANAN</label>
                            <input type="file" name="gambar_layanan" class="text-[10px]">
                            <button name="simpan_layanan" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black uppercase text-xs shadow-lg mt-4">Simpan Layanan</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Informasi</th>
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Preview</th>
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php 
                            $table = ($tab_aktif == 'agenda') ? 'agenda' : 'layanan';
                            $res = $conn->query("SELECT * FROM $table ORDER BY id DESC");
                            while($row = $res->fetch_assoc()):
                            ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-6">
                                    <p class="font-black text-slate-800 text-sm uppercase"><?= $row['judul'] ?></p>
                                    <p class="text-[10px] text-slate-400 mt-1">
                                        <?= ($tab_aktif == 'agenda') ? $row['tanggal']." • ".$row['lokasi'] : substr($row['deskripsi'],0,50)."..." ?>
                                    </p>
                                </td>
                                <td class="p-6">
                                    <img src="uploads/<?= ($tab_aktif == 'agenda') ? $row['gambar_agenda'] : $row['gambar'] ?>" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                </td>
                                <td class="p-6 text-center">
                                    <a href="?tab=<?= $tab_aktif ?>&hapus_<?= $tab_aktif ?>=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="w-10 h-10 bg-red-50 text-red-500 rounded-xl inline-flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>