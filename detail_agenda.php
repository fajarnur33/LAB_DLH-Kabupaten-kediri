<?php 
include 'db_config.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Query ambil data agenda
$query = $conn->query("SELECT * FROM agenda WHERE id = '$id'");
$a = $query->fetch_assoc();

// Jika agenda tidak ditemukan
if (!$a) {
    echo "<script>alert('Agenda tidak ditemukan!'); window.location='home.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $a['judul'] ?> | Agenda DLH Kediri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-5xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="home.php" class="flex items-center gap-3 group">
                <img src="logo-dlh.png" class="h-10">
                <span class="font-black text-slate-800 uppercase tracking-tighter">Detail <span class="text-green-600">Agenda</span></span>
            </a>
            <a href="home.php#agenda" class="text-[10px] font-black uppercase text-slate-400 hover:text-green-600 tracking-widest transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-2 rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-100">
                    <img src="uploads/<?= $a['gambar_agenda'] ?>" class="w-full h-[400px] object-cover rounded-[2.3rem]">
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                            <i class="fas fa-calendar-day mr-1"></i> Agenda Dinas
                        </span>
                        <span class="text-slate-300 text-xs">|</span>
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            Diposting: <?= date('d M Y', strtotime($a['tgl_dibuat'])) ?>
                        </span>
                    </div>

                    <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-tight mb-6">
                        <?= $a['judul'] ?>
                    </h1>

                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium">
                        <?= nl2br($a['deskripsi']) ?>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-900 text-white p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-green-400 mb-6">Jadwal Pelaksanaan</h3>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-green-400">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Tanggal</p>
                                    <p class="font-bold text-sm mt-1"><?= date('l, d F Y', strtotime($a['tanggal'])) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-green-400">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Waktu</p>
                                    <p class="font-bold text-sm mt-1"><?= $a['jam'] ?> WIB</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-green-400">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Lokasi</p>
                                    <p class="font-bold text-sm mt-1"><?= $a['lokasi'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-green-500/10 rounded-full blur-3xl"></div>
                </div>

                <div class="bg-white p-4 rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 p-4">Penunjuk Lokasi</h3>
                    <div class="h-64 rounded-[1.8rem] overflow-hidden bg-slate-100">
                        <iframe 
                            src="<?= $a['google_maps_url'] ?>" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                    <div class="p-4">
                        <a href="https://www.google.com/maps/search/<?= urlencode($a['lokasi']) ?>" target="_blank" class="w-full bg-slate-50 hover:bg-green-50 text-slate-600 hover:text-green-700 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition flex items-center justify-center gap-2">
                            <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-[#16a34a] text-white py-12 mt-12">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <img src="logo-dlh.png" class="h-12 mx-auto mb-4">
            <p class="text-[10px] font-black tracking-[0.3em] uppercase opacity-80">© 2026 DINAS LINGKUNGAN HIDUP KEDIRI</p>
        </div>
    </footer>

</body>
</html>