<?php 
include 'db_config.php'; 

// Ambil ID dari URL
if (!isset($_GET['id'])) { header("Location: home.php"); exit(); }
$id = $_GET['id'];

// Ambil data berita berdasarkan ID
$query = $conn->query("SELECT * FROM konten WHERE id = $id");
$d = $query->fetch_assoc();

// Jika data tidak ditemukan
if (!$d) { echo "Berita tidak ditemukan."; exit(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $d['judul'] ?> | DLH Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans text-slate-800">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="home.php" class="text-xs font-black text-green-600 uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <div class="flex items-center gap-2">
                <i class="fas fa-leaf text-green-600"></i>
                <span class="font-black text-lg tracking-tighter">DLH<span class="text-green-600">NEWS</span></span>
            </div>
        </div>
    </nav>

    <article class="max-w-4xl mx-auto px-6 py-12">
        <div class="flex items-center gap-4 mb-6">
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                <?= $d['kategori'] ?>
            </span>
            <span class="text-xs font-bold text-slate-400 italic">
                Diterbitkan pada: <?= date('d F Y', strtotime($d['tanggal'])) ?>
            </span>
        </div>

        <h1 class="text-3xl md:text-5xl font-black text-slate-900 leading-[1.1] mb-10 tracking-tight">
            <?= $d['judul'] ?>
        </h1>

        <div class="rounded-[2.5rem] overflow-hidden shadow-2xl mb-12 border border-slate-100">
            <img src="uploads/<?= $d['gambar'] ?>" class="w-full h-auto object-cover max-h-[500px]" alt="<?= $d['judul'] ?>">
        </div>

        <div class="prose prose-slate prose-lg max-w-none">
            <p class="text-slate-600 leading-relaxed text-lg whitespace-pre-line">
                <?= $d['isi'] ?>
            </p>
        </div>

        <div class="mt-20 pt-10 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium">
    

<div class="flex items-center gap-4 mb-8">
    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Ikuti kami:</span>
    <a href="https://www.instagram.com/dlh_kabkediri?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" 
       class="w-10 h-10 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform duration-300">
        <i class="fab fa-instagram text-xl"></i>
    </a>
</div>
            <a href="home.php" class="bg-slate-900 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-green-600 transition shadow-xl">Baca Berita Lainnya</a>
        </div>
    </article>

    <footer class="bg-slate-50 py-12 mt-20 border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">© 2026 Dinas Lingkungan Hidup Digital</p>
        </div>
    </footer>
</body>
</html>