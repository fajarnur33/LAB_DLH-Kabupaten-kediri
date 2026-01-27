<?php include 'db_config.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

$user_sekarang = $_SESSION['username'];
$role_sekarang = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Arsip Dokumen | DLH Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#f8fafc] min-h-screen">
    <nav class="bg-white border-b h-20 flex items-center shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto w-full px-6 flex justify-between items-center">
            <a href="<?= ($role_sekarang == 'admin') ? 'admin.php' : 'index.php' ?>" class="flex items-center gap-2 text-green-600 font-black tracking-widest text-sm">
                <i class="fas fa-arrow-left"></i> KEMBALI
            </a>
            <h1 class="font-black text-slate-800 uppercase tracking-tighter">ARSIP<span class="text-green-600">DIGITAL</span></h1>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-100">
            <div class="p-8 border-b bg-slate-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="font-black text-slate-800 text-lg uppercase tracking-widest">Dokumen Selesai</h3>
                    <p class="text-xs text-slate-400">Daftar seluruh dokumen yang telah melalui proses verifikasi.</p>
                </div>
                <div class="relative w-full md:w-80">
                    <i class="fas fa-search absolute left-4 top-3.5 text-slate-300"></i>
                    <input type="text" id="searchArsip" onkeyup="filterArsip()" placeholder="Cari di arsip..." class="w-full pl-12 p-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none text-sm">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                        <tr>
                            <th class="p-6 text-left">Informasi Dokumen</th>
                            <th class="p-6 text-left">Pemilik</th>
                            <th class="p-6 text-center">Status</th>
                            <th class="p-6 text-right">Unduh Hasil</th>
                        </tr>
                    </thead>
                    <tbody id="tableArsip" class="divide-y divide-slate-50">
                        <?php 
                        // Mengambil hanya yang berstatus 'Selesai'
                        $res = $conn->query("SELECT * FROM dokumen WHERE status='Selesai' ORDER BY tgl_upload DESC");
                        while($d = $res->fetch_assoc()): 
                        ?>
                        <tr class="hover:bg-green-50/30 transition">
                            <td class="p-6">
                                <div class="font-bold text-slate-700"><?= $d['nama_file'] ?></div>
                                <div class="text-[10px] text-slate-400 italic">Diarsipkan pada: <?= date('d M Y', strtotime($d['tgl_upload'])) ?></div>
                            </td>
                            <td class="p-6 text-slate-600 font-medium"><?= $d['pemilik'] ?></td>
                            <td class="p-6 text-center">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase">Selesai</span>
                            </td>
                            <td class="p-6 text-right">
                                <?php if($d['file_revisi']): ?>
                                    <a href="uploads/<?= $d['file_revisi'] ?>" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-700 shadow-lg shadow-green-100 transition">
                                        <i class="fas fa-download"></i> HASIL EDIT
                                    </a>
                                    
                                <?php else: ?>
                                    <a href="uploads/<?= $d['nama_file'] ?>" class="inline-flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-600 transition">
                                        <i class="fas fa-check-circle"></i> FILE ASLI
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function filterArsip() {
            let input = document.getElementById('searchArsip').value.toLowerCase();
            let rows = document.querySelectorAll('#tableArsip tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
            });
        }
    </script>
</body>
</html>