<?php include 'db_config.php';
// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: login.php"); exit(); }

// Logika Simpan dan Hapus tetap sama seperti sebelumnya...
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul']; $isi = $_POST['isi']; $kat = $_POST['kategori'];
    $foto = "news_default.jpg";
    if ($_FILES['gambar']['name'] != "") {
        $foto = time() . "_" . $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/" . $foto);
    }
    $conn->query("INSERT INTO konten (judul, isi, kategori, gambar) VALUES ('$judul', '$isi', '$kat', '$foto')");
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM konten WHERE id=$id");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengelola Konten | Admin DLH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans">

    <header class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="admin.php" class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-200 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="font-black text-slate-800 text-lg leading-tight uppercase tracking-tighter">Pusat Editor</h1>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manajemen Konten Halaman Utama</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="index.php" target="_blank" class="bg-blue-50 text-blue-600 px-5 py-2.5 rounded-2xl text-xs font-black flex items-center gap-2 hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100">
                    <i class="fas fa-external-link-alt"></i> LIHAT SITUS
                </a>
                
                <div class="h-8 w-[1px] bg-slate-100 mx-2"></div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest hidden md:block">Mode: Administrator</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <?php if(isset($_POST['simpan'])): ?>
            <div class="mb-8 bg-green-50 border border-green-100 p-4 rounded-2xl flex items-center justify-between">
                <p class="text-green-700 text-xs font-bold"><i class="fas fa-check-circle mr-2"></i> Konten berhasil diterbitkan!</p>
                <a href="index.php" target="_blank" class="text-green-700 text-xs font-black underline">Cek Hasil Sekarang &rarr;</a>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white sticky top-28">
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                        <span class="w-2 h-6 bg-green-500 rounded-full"></span> Buat Postingan
                    </h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Judul Utama</label>
                            <input type="text" name="judul" placeholder="Contoh: Kerja Bakti DLH..." class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-green-500 outline-none transition" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Isi Berita/Pengumuman</label>
                            <textarea name="isi" rows="6" placeholder="Tuliskan detail informasi di sini..." class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs font-medium focus:ring-2 focus:ring-green-500 outline-none transition" required></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                                <select name="kategori" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl text-[10px] font-black uppercase outline-none">
                                    <option value="berita">Berita</option>
                                    <option value="pengumuman">Pengumuman</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Gambar</label>
                                <input type="file" name="gambar" class="text-[9px] mt-2">
                            </div>
                        </div>

                        <button name="simpan" class="w-full bg-slate-800 hover:bg-green-600 text-white font-black py-4 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs mt-4">
                            Publikasikan Konten
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 ml-2">Konten Aktif Saat Ini</h3>
                <?php 
                $res = $conn->query("SELECT * FROM konten ORDER BY tanggal DESC");
                while($k = $res->fetch_assoc()): ?>
                <div class="bg-white p-5 rounded-3xl flex justify-between items-center border border-slate-100 shadow-sm hover:border-green-200 transition">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 flex-shrink-0">
                            <img src="uploads/<?= $k['gambar'] ?>" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-md <?= $k['kategori'] == 'berita' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600' ?>">
                                    <?= $k['kategori'] ?>
                                </span>
                                <span class="text-[9px] text-slate-400 font-bold"><?= date('d M Y', strtotime($k['tanggal'])) ?></span>
                            </div>
                            <h5 class="font-black text-slate-800 text-sm tracking-tight"><?= $k['judul'] ?></h5>
                        </div>
                    </div>
                    <a href="?hapus=<?= $k['id'] ?>" onclick="return confirm('Hapus konten ini selamanya?')" class="w-10 h-10 bg-red-50 text-red-400 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
</body>
</html>