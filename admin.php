<?php 
include 'db_config.php';
// Proteksi Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') { 
    header("Location: login.php"); exit(); 
}
// Letakkan di bagian atas file admin.php bersama query statistik lainnya
$aduan_masuk = $conn->query("SELECT COUNT(*) as total FROM aduan WHERE status='Masuk'")->fetch_assoc()['total'];
// Ambil data statistik sederhana
$total_dokumen = $conn->query("SELECT COUNT(*) as total FROM dokumen")->fetch_assoc()['total'];
$pending = $conn->query("SELECT COUNT(*) as total FROM dokumen WHERE status='Menunggu'")->fetch_assoc()['total'];
$user_count = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='member'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminHub | DLH Kediri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .sidebar-item:hover { background: rgba(22, 163, 74, 0.1); color: #16a34a; }
        .active-link { background: #16a34a; color: white !important; box-shadow: 0 10px 15px -3px rgba(22, 163, 74, 0.4); }
    </style>
</head>
<body class="bg-[#f8fafc] flex">

    <aside class="w-72 bg-white h-screen sticky top-0 border-r border-slate-100 flex flex-col p-6 hidden lg:flex">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-green-200">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1 class="font-black text-xl tracking-tighter text-slate-800">ADMIN<span class="text-green-600">HUB</span></h1>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 px-2">Menu Utama</p>
            <a href="admin.php" class="sidebar-item active-link flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all group">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="tambah_anggota.php" class="sidebar-item text-slate-500 flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all">
                <i class="fas fa-file-invoice"></i> manajemen anggota
            </a>
            <a href="arsip.php" class="sidebar-item text-slate-500 flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all">
                <i class="fas fa-file-invoice"></i> Arsip Dokumen
            </a>
            
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-8 mb-4 px-2">Konten Web</p>
            <a href="kelola_home.php" class="sidebar-item text-slate-500 flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all">
                <i class="fas fa-globe"></i> Berita & Beranda
            </a>
            <a href="kelola_galeri.php" class="sidebar-item text-slate-500 flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all">
                <i class="fas fa-images"></i> Galeri Media
            </a>
            <a href="kelola_agenda.php" class="sidebar-item text-slate-500 flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all">
                <i class="fas fa-calendar-alt"></i> Update Agenda/Layanan
            </a>
            <a href="kelola_aduan.php" class="sidebar-item text-slate-500 flex items-center gap-4 p-4 rounded-2xl font-bold text-sm transition-all">
            <i class="fas fa-exclamation-circle"></i> Aduan Masyarakat
            </a>
        </nav>

        <a href="logout.php" class="mt-auto flex items-center gap-4 p-4 text-red-500 font-bold text-sm hover:bg-red-50 rounded-2xl transition">
            <i class="fas fa-sign-out-alt"></i> Keluar Sistem
        </a>
    </aside>

    <main class="flex-1 p-4 lg:p-10">
        
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Selamat Datang, <?= $_SESSION['username'] ?>! 👋</h2>
                <p class="text-sm text-slate-500 font-medium">Ini adalah ringkasan kinerja sistem hari ini.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="profile.php" class="flex items-center gap-3 bg-white p-2 pr-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                    <img src="uploads/default_avatar.jpg" class="w-10 h-10 rounded-xl object-cover">
                    <div class="text-left">
                        <p class="text-xs font-black text-slate-800 leading-none">Administrator</p>
                        <p class="text-[10px] text-green-600 font-bold mt-1">Online</p>
                    </div>
                </a>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-6">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Dokumen</p>
                    <h3 class="text-2xl font-black text-slate-800"><?= $total_dokumen ?></h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-6">
                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Antrean Baru</p>
                    <h3 class="text-2xl font-black text-slate-800"><?= $pending ?></h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-6">
                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Anggota Aktif</p>
                    <h3 class="text-2xl font-black text-slate-800"><?= $user_count ?></h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-6">
    <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
        <i class="fas fa-bullhorn"></i>
    </div>
    <div>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Aduan Masuk</p>
        <h3 class="text-2xl font-black text-slate-800"><?= $aduan_masuk ?></h3>
    </div>
</div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
            
            <div class="xl:col-span-2 bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-xs uppercase tracking-[0.2em]">Antrean Dokumen Perlu Proses</h3>
                    <a href="arsip.php" class="text-[10px] font-black text-green-600 uppercase tracking-widest hover:underline">Lihat Semua Arsip</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                            <tr>
                                <th class="p-6">Pengirim</th>
                                <th class="p-6">Nama File</th>
                                <th class="p-6">Status</th>
                                <th class="p-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php 
                            $docs = $conn->query("SELECT * FROM dokumen WHERE status='Menunggu' ORDER BY id DESC LIMIT 5");
                            if($docs->num_rows > 0):
                                while($d = $docs->fetch_assoc()):
                            ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-6 font-bold text-slate-700 text-sm italic"><?= $d['pengirim'] ?></td>
                                <td class="p-6">
                                    <p class="text-sm font-black text-slate-800"><?= $d['nama_file'] ?></p>
                                    <p class="text-[10px] text-slate-400 font-medium">Diunggah: <?= $d['tgl_upload'] ?></p>
                                </td>
                                <td class="p-6">
                                    <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Pending</span>
                                </td>
                                <td class="p-6 text-right">
                                    <a href="proses_verif.php?id=<?= $d['id'] ?>" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-green-600 transition shadow-lg shadow-slate-200">Verifikasi</a>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="4" class="p-10 text-center text-slate-400 italic text-sm font-medium">Tidak ada antrean dokumen saat ini. ✨</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-green-600 p-8 rounded-[2.5rem] shadow-2xl shadow-green-100 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-xl font-black mb-2 uppercase tracking-tight">Update Cepat</h3>
                        <p class="text-green-100 text-xs font-medium mb-6">Tambahkan agenda atau berita dinas terbaru sekarang.</p>
                        <a href="kelola_agenda.php" class="block w-full bg-white text-green-700 p-4 rounded-2xl text-center font-black text-xs uppercase shadow-xl hover:bg-slate-50 transition">
                            <i class="fas fa-plus mr-2"></i> Tambah Agenda
                        </a>
                    </div>
                    <i class="fas fa-calendar-check absolute -right-4 -bottom-4 text-8xl text-green-500/20"></i>
                </div>
                           
<div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">Waktu & Pelapor</th>
                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Status</th>
                <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php 
            $res = $conn->query("SELECT * FROM aduan ORDER BY tgl_aduan DESC");
            while($row = $res->fetch_assoc()): 
                $status_color = ($row['status'] == 'Selesai') ? 'bg-green-100 text-green-600' : (($row['status'] == 'Diproses') ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600');
            ?>
            <tr class="hover:bg-slate-50 transition">
                <td class="p-6">
                    <p class="font-black text-slate-800 text-sm uppercase"><?= $row['nama_pelapor'] ?></p>
                    <p class="text-[9px] text-slate-400 italic"><?= date('d M Y, H:i', strtotime($row['tgl_aduan'])) ?></p>
                </td>
                <td class="p-6 text-center">
                    <span class="px-3 py-1 <?= $status_color ?> rounded-lg text-[9px] font-black uppercase tracking-widest">
                        <?= $row['status'] ?>
                    </span>
                </td>
                <td class="p-6 text-right">
                    <button onclick='openModal(<?= json_encode($row) ?>)' class="bg-slate-100 hover:bg-green-600 hover:text-white text-slate-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all">
                        <i class="fas fa-eye mr-1"></i> Detail
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div id="modalAduan" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal()"></div>
    
    <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-black text-slate-800 text-xs uppercase tracking-[0.2em]">Detail Aduan Masuk</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-red-500 transition text-xl">
                <i class="fas fa-times-circle"></i>
            </button>
        </div>
        
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Pelapor</p>
                    <p id="m_nama" class="font-bold text-slate-800 text-sm uppercase"></p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor WhatsApp</p>
                    <a id="m_wa_link" target="_blank" class="text-green-600 font-bold text-sm flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i> <span id="m_wa"></span>
                    </a>
                </div>
            </div>

            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Isi Laporan / Aduan</p>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p id="m_isi" class="text-xs text-slate-600 leading-relaxed italic"></p>
                </div>
            </div>

            <form method="POST" class="pt-4 border-t border-slate-50 flex items-center justify-between gap-4">
                <input type="hidden" name="id_aduan" id="m_id">
                <div class="flex-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Update Status</p>
                    <select name="status" id="m_status" class="w-full p-3 bg-slate-50 border rounded-xl text-[10px] font-black uppercase outline-none focus:ring-2 focus:ring-green-500">
                        <option value="Masuk">Masuk</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <button name="update_status" class="mt-5 bg-green-600 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-green-100 hover:bg-green-700 transition">Simpan</button>
            </form>
        </div>
    </div>
    </div>

    <script>
    function openModal(data) {
    document.getElementById('modalAduan').classList.remove('hidden');
    document.getElementById('m_id').value = data.id;
    document.getElementById('m_nama').innerText = data.nama_pelapor;
    document.getElementById('m_wa').innerText = data.no_wa;
    document.getElementById('m_isi').innerText = data.isi_aduan;
    document.getElementById('m_status').value = data.status;
    document.getElementById('m_wa_link').href = "https://wa.me/" + data.no_wa.replace(/\D/g,'');
    }

    function closeModal() {
    document.getElementById('modalAduan').classList.add('hidden');
    }
    </script>
            </div>

        </div>
    </main>
    

</body>
</html>