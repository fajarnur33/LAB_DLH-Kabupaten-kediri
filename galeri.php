<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Galeri Kegiatan | DLH Kediri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50">
    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-green-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="logo-dlh.png" class="h-10">
                <span class="font-black text-xl tracking-tighter text-slate-800 uppercase">DLH<span class="text-green-600">GALLERY</span></span>
            </div>
            <div class="flex items-center gap-6">
                <a href="index.php" class="text-xs font-bold text-slate-500 hover:text-green-600 uppercase tracking-widest">Kembali ke Berita</a>
            </div>
        </div>
    </nav>

    <header class="bg-green-700 text-white py-16 px-6 text-center">
        <h1 class="text-3xl font-black uppercase tracking-tight">Galeri Dokumentasi</h1>
        <p class="text-green-100 text-sm mt-2">Dokumentasi kegiatan lapangan dan sosialisasi Dinas Lingkungan Hidup Kabupaten Kediri.</p>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            $res = $conn->query("SELECT * FROM galeri ORDER BY tgl_upload DESC");
            while($g = $res->fetch_assoc()): 
            ?>
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-100">
                <?php if($g['tipe'] == 'foto'): ?>
                    <div class="h-64 overflow-hidden">
                        <img src="uploads/<?= $g['file_nama'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                <?php else: ?>
                    <div class="h-64">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/<?= $g['video_url'] ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
                
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-md <?= $g['tipe'] == 'foto' ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600' ?>">
                            <?= $g['tipe'] ?>
                        </span>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm"><?= $g['judul'] ?></h4>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
    

    <footer class="bg-[#16a34a] text-white py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-sm font-bold uppercase tracking-wider mb-2">PORTAL RESMI DINAS LINGKUNGAN HIDUP KEDIRI</h2>
            <p class="text-[10px] opacity-80 uppercase tracking-[0.3em]">© 2026 DINAS LINGKUNGAN HIDUP KEDIRI</p>
        </div>
    </footer>
</body>
</html>