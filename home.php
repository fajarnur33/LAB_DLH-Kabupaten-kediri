<?php include 'db_config.php';
if (isset($_POST['kirim_aduan'])) {
    // Sanitasi input untuk mencegah SQL Injection
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pelapor']);
    $wa   = mysqli_real_escape_string($conn, $_POST['no_wa']);
    $isi  = mysqli_real_escape_string($conn, $_POST['isi_aduan']);
    $status = "Masuk";

    // Validasi sederhana (hanya angka untuk WhatsApp)
    if (!preg_match('/^[0-9]*$/', $wa)) {
        echo "<script>alert('Nomor WhatsApp hanya boleh berisi angka!');</script>";
    } else {
        $sql = "INSERT INTO aduan (nama_pelapor, no_wa, isi_aduan, status) VALUES ('$nama', '$wa', '$isi', '$status')";
        
        if ($conn->query($sql)) {
            echo "<script>
                alert('Terima kasih! Laporan Anda telah kami terima dan akan segera ditindaklanjuti.');
                window.location='home.php#aduan';
            </script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
 ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Resmi DLH Kabupaten Kediri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-nav { @apply bg-white/80 backdrop-blur-md border-b border-slate-100; }
        .hero-gradient { background: linear-gradient(135deg, #16a34a 0%, #065f46 100%); }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="logo-dlh.png" class="h-12 w-auto object-contain">
                <div class="hidden md:block">
                    <h1 class="font-black text-lg leading-none">DLH<span class="text-green-600">KEDIRI</span></h1>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kabupaten Kediri</p>
                </div>
            </div>
            
            <div class="hidden lg:flex items-center gap-8">
                <a href="#layanan" class="text-xs font-bold uppercase tracking-widest hover:text-green-600">Layanan</a>
                <a href="#poster&pamflet" class="text-xs font-bold uppercase tracking-widest hover:text-green-600">poster&pamflet</a>
                <a href="#berita" class="text-xs font-bold uppercase tracking-widest hover:text-green-600">Berita</a>
                <a href="#agenda" class="text-xs font-bold uppercase tracking-widest hover:text-green-600">Agenda</a>
                <a href="galeri.php" class="text-xs font-bold uppercase tracking-widest hover:text-green-600">Galeri</a>
                <a href="#kontak" class="text-xs font-bold uppercase tracking-widest hover:text-green-600">Kontak</a>
                <a href="login.php" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-xs font-black hover:bg-green-600 transition shadow-lg shadow-slate-200 uppercase tracking-widest">Login</a>
            </div>
        </div>
    </nav>

    <header class="pt-32 pb-20 px-6 hero-gradient relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-12 relative z-10">
            <div class="flex-1 text-center lg:text-left">
                <span class="bg-white/20 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em]">Selamat Datang di Portal Resmi</span>
                <h1 class="text-4xl md:text-6xl font-black text-white mt-6 leading-[1.1]">Mewujudkan Kediri <br><span class="text-green-300 underline decoration-4 underline-offset-8">Bersih & Hijau</span></h1>
                <p class="text-green-50/80 mt-8 text-lg leading-relaxed max-w-xl">Akses layanan publik, informasi lingkungan hidup, dan pengaduan masyarakat dalam satu pintu.</p>
                <div class="mt-10 flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="#aduan" class="bg-white text-green-700 px-8 py-4 rounded-2xl font-black uppercase text-xs shadow-xl hover:scale-105 transition">Buat Aduan</a>
                    <a href="#layanan" class="bg-green-800/40 text-white border border-green-400/30 px-8 py-4 rounded-2xl font-black uppercase text-xs hover:bg-green-800 transition">Lihat Layanan</a>
                </div>
            </div>
            <div class="flex-1 hidden lg:block">
               
            </div>
        </div>
    </header>

    <section id="layanan" class="py-24 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">Layanan <span class="text-green-600">Digital</span></h2>
        <div class="h-1.5 w-20 bg-green-600 mx-auto mt-4 rounded-full"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php 
        $query_layanan = $conn->query("SELECT * FROM layanan ORDER BY id ASC");
        while($lay = $query_layanan->fetch_assoc()): ?>
        <a href="<?= $lay['link_tujuan'] ?>" target="_blank" class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:shadow-2xl transition group block">
            <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition overflow-hidden">
                <img src="uploads/<?= $lay['gambar'] ?>" class="w-full h-full object-cover">
            </div>
            <h3 class="font-black text-xl mb-3 uppercase tracking-tight group-hover:text-green-600 transition"><?= $lay['judul'] ?></h3>
            <p class="text-slate-500 text-sm leading-relaxed"><?= $lay['deskripsi'] ?></p>
        </a>
        <?php endwhile; ?>
    </div>
</section>
<section id="poster&pamflet" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center mb-12">
        <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">Poster <span class="text-green-600">& Informasi</span></h2>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        $posters = $conn->query("SELECT * FROM poster ORDER BY id DESC");
        while($p = $posters->fetch_assoc()): ?>
        <div class="rounded-[2.5rem] overflow-hidden shadow-xl border border-slate-100 group">
            <div class="aspect-[3/4] overflow-hidden">
                <img src="uploads/<?= $p['gambar'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-6 bg-white">
                <h4 class="font-black text-slate-800 uppercase tracking-tight"><?= $p['judul'] ?></h4>
                <a href="uploads/<?= $p['gambar'] ?>" target="_blank" class="text-[10px] font-black text-green-600 uppercase tracking-widest mt-4 inline-block hover:underline">Lihat Full Size</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>
    <section id="berita" class="py-24 bg-white px-6">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-16">
            <div class="lg:w-2/3">
                <div class="flex justify-between items-end mb-10">
                    <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">Berita <span class="text-green-600">Terbaru</span></h2>
                    <a href="#" class="text-[10px] font-black uppercase text-green-600 tracking-widest">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php 
                    $berita = $conn->query("SELECT * FROM konten LIMIT 2");
                    while($b = $berita->fetch_assoc()): ?>
                    <div class="group cursor-pointer">
                        <div class="rounded-[2rem] overflow-hidden h-64 mb-6 shadow-lg">
                            <img src="uploads/<?= $b['gambar'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <span class="text-[10px] font-black text-green-600 uppercase tracking-widest"><?= date('d M Y', strtotime($b['tanggal'])) ?></span>
                        <h3 class="font-black text-xl text-slate-800 mt-2 mb-4 group-hover:text-green-600 transition leading-tight"><?= $b['judul'] ?></h3>
                        <a href="detail.php?id=<?= $b['id'] ?>" class="text-[10px] font-black uppercase tracking-widest pb-1 border-b-2 border-slate-100 group-hover:border-green-600 transition">Baca Lengkap</a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div id="agenda" class="lg:w-1/3 bg-slate-50 p-10 rounded-[3rem] border border-slate-100">
    <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mb-8">
        <i class="far fa-calendar-alt text-green-600 mr-2"></i> Agenda
    </h2>
    <div class="space-y-6">
        <?php 
        // Ambil data dari tabel agenda
        $query_agenda = $conn->query("SELECT * FROM agenda ORDER BY tanggal ASC LIMIT 3");
        
        // Cek apakah ada data agenda
        if ($query_agenda->num_rows > 0) {
            while($a = $query_agenda->fetch_assoc()): 
        ?>
            <a href="detail_agenda.php?id=<?= $a['id'] ?>" class="flex gap-4 items-start group">
                <div class="bg-green-600 text-white p-3 rounded-2xl text-center min-w-[60px]">
                    <span class="block text-lg font-black leading-none"><?= date('d', strtotime($a['tanggal'])) ?></span>
                    <span class="text-[9px] font-bold uppercase tracking-widest opacity-80"><?= date('M', strtotime($a['tanggal'])) ?></span>
                </div>
                <div>
                    <h4 class="font-black text-slate-800 text-sm leading-tight uppercase group-hover:text-green-600 transition"><?= $a['judul'] ?></h4>
                    <p class="text-xs text-slate-400 mt-1 font-bold italic uppercase tracking-widest"><?= $a['jam'] ?> - <?= $a['lokasi'] ?></p>
                </div>
            </a>
        <?php 
            endwhile; 
        } else {
            echo "<p class='text-xs text-slate-400 italic font-bold uppercase tracking-widest'>Belum ada agenda terdekat.</p>";
        }
        ?>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="aduan" class="py-24 px-6 relative overflow-hidden bg-slate-50">
    <div class="absolute top-0 left-0 w-64 h-64 bg-green-100 rounded-full blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-50 translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div>
                <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                    Layanan Pengaduan
                </span>
                <h2 class="text-4xl font-black text-slate-800 uppercase tracking-tighter mt-6 leading-tight">
                    Suara Anda <br><span class="text-green-600">Membangun Kediri</span>
                </h2>
                <p class="text-slate-500 mt-6 leading-relaxed font-medium">
                    Laporkan kendala lingkungan, saran, atau keluhan Anda langsung kepada kami. Kami berkomitmen untuk merespons setiap aduan dengan cepat dan transparan.
                </p>

                <div class="mt-10 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white shadow-sm border border-slate-100 rounded-2xl flex items-center justify-center text-green-600">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">WhatsApp Center</p>
                            <p class="font-bold text-slate-800">+62 812-3456-7890</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white shadow-sm border border-slate-100 rounded-2xl flex items-center justify-center text-blue-600">
                            <i class="far fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Resmi</p>
                            <p class="font-bold text-slate-800">dlh@kedirikab.go.id</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-[3rem] shadow-2xl shadow-slate-200 border border-white relative">
                <form action="" method="POST" class="space-y-5">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Nama Lengkap</label>
                        <input type="text" name="nama_pelapor" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-green-500 outline-none transition-all"
                            placeholder="Masukkan nama Anda">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Nomor WhatsApp (Aktif)</label>
                        <input type="tel" name="no_wa" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-green-500 outline-none transition-all"
                            placeholder="Contoh: 08123456789">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Isi Aduan / Laporan</label>
                        <textarea name="isi_aduan" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-medium h-32 focus:ring-2 focus:ring-green-500 outline-none transition-all"
                            placeholder="Tuliskan laporan Anda secara detail..."></textarea>
                    </div>

                    <button type="submit" name="kirim_aduan"
                        class="w-full bg-slate-900 text-white py-5 rounded-[1.5rem] font-black uppercase text-xs tracking-[0.2em] shadow-xl hover:bg-green-600 hover:-translate-y-1 transition-all duration-300">
                        Kirim Laporan Sekarang <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
                
                <div class="absolute -top-4 -right-4 bg-yellow-400 text-slate-900 px-4 py-2 rounded-2xl text-[9px] font-black uppercase tracking-tighter shadow-lg -rotate-12">
                    Respon 24/7
                </div>
            </div>

        </div>
    </div>
</section>

    <section id="kontak" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row border border-slate-100">
            <div class="lg:w-1/2 p-12 lg:p-20">
                <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter mb-10">Hubungi <span class="text-green-600">Kami</span></h2>
                <div class="space-y-8">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 shadow-sm"><i class="fas fa-map-marker-alt"></i></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat Kantor</p><p class="text-sm font-bold text-slate-700">Jl. Pamenang No.39, Katang, Kediri</p></div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 shadow-sm"><i class="fas fa-phone-alt"></i></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Telepon / Fax</p><p class="text-sm font-bold text-slate-700">(0354) 689101</p></div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 shadow-sm"><i class="fab fa-instagram"></i></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Instagram Official</p><p class="text-sm font-bold text-slate-700">@dlhkabupatenkediri</p></div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 h-[400px] lg:h-auto bg-slate-200">
                <iframe class="w-full h-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.8839077427284!2d112.04018041477755!3d-7.802111894378179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785764c207d58f%3A0xc47b9ec9c0e0c800!2sKantor%20Dinas%20Lingkungan%20Hidup%20Kabupaten%20Kediri!5e0!3m2!1sid!2sid!4v1650000000000" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <footer class="bg-[#16a34a] text-white py-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <img src="logo-dlh.png" class="h-16 mx-auto mb-6 drop-shadow-lg">
            <h2 class="text-sm md:text-base font-bold uppercase tracking-[0.2em] mb-4">Portal Resmi Dinas Lingkungan Hidup Kabupaten Kediri</h2>
            <div class="flex justify-center gap-6 mb-10 opacity-60">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="pt-10 border-t border-white/20">
                <p class="text-[10px] font-black tracking-[0.5em] uppercase opacity-80">© 2026 DINAS LINGKUNGAN HIDUP KEDIRI</p>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('py-4', 'shadow-xl');
                nav.classList.remove('py-6');
            } else {
                nav.classList.remove('py-4', 'shadow-xl');
                nav.classList.add('py-6');
            }
        });
    </script>
</body>
</html>