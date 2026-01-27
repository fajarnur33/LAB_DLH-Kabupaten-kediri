<?php include 'db_config.php';
// Proteksi: Harus login sebagai member
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'member') { 
    header("Location: login.php"); exit(); 
}

$user_sekarang = $_SESSION['username'];

// Ambil data profil terbaru dari database
$query_user = $conn->query("SELECT * FROM users WHERE username='$user_sekarang'");
$user_data = $query_user->fetch_assoc();

// Logika Upload Dokumen
if (isset($_POST['upload'])) {
    $nama = $_FILES['file']['name'];
    $nama_baru = time() . "_" . $nama;
    move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $nama_baru);
    $conn->query("INSERT INTO dokumen (nama_file, pemilik) VALUES ('$nama_baru', '$user_sekarang')");
    echo "<script>alert('Dokumen Berhasil Terkirim!'); window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Anggota | DLH Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#f0f4f0] min-h-screen font-sans">

    <nav class="bg-white/80 backdrop-blur-md border-b border-green-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-green-600 p-2 rounded-xl text-white shadow-lg shadow-green-200">
                    <i class="fas fa-leaf"></i>
                </div>
                <span class="font-black text-xl tracking-tighter text-slate-800">DLH<span class="text-green-600">PROFIL</span></span>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="logout.php" class="text-xs font-bold text-red-500 hover:text-red-700 transition uppercase tracking-widest">Keluar</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-green-900/5 overflow-hidden border border-white">
                    <div class="bg-gradient-to-br from-green-500 to-green-700 h-24"></div>
                    <div class="px-6 pb-8 text-center">
                        <div class="relative -top-12 mb-[-3rem]">
                            <?php 
                            $foto_path = ($user_data['foto'] == 'default_avatar.jpg' || empty($user_data['foto'])) 
                                ? 'https://ui-avatars.com/api/?name='.$user_sekarang.'&background=16a34a&color=fff' 
                                : 'uploads/'.$user_data['foto'];
                            ?>
                            <img src="<?= $foto_path ?>" class="w-24 h-24 rounded-3xl mx-auto border-4 border-white shadow-md object-cover">
                        </div>
                        <h2 class="text-xl font-black text-slate-800 mt-14"><?= $user_sekarang ?></h2>
                        <p class="text-[10px] font-bold text-green-600 uppercase tracking-[0.2em] mb-6">Anggota Dinas</p>
                        
                        <div class="flex flex-col gap-2">
                            <a href="profile.php" class="bg-slate-50 hover:bg-green-50 text-slate-600 hover:text-green-700 py-3 rounded-2xl text-xs font-bold transition flex items-center justify-center gap-2">
                                <i class="fas fa-user-edit"></i> Edit Profil
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-[2rem] p-6 text-white relative overflow-hidden shadow-lg">
                    <i class="fas fa-question-circle absolute -right-4 -bottom-4 text-6xl text-white/10 rotate-12"></i>
                    <h4 class="font-bold text-sm mb-2">Butuh Bantuan?</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed">Hubungi admin jika dokumen Anda belum diverifikasi dalam 24 jam.</p>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-white flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <h1 class="text-2xl font-black text-slate-800">Selamat Datang di Portal Digital</h1>
                        <p class="text-sm text-slate-500">Silakan unggah dokumen lingkungan Anda untuk diproses oleh Admin.</p>
                    </div>
                    <form method="POST" enctype="multipart/form-data" class="flex gap-2 w-full md:w-auto">
                        <label class="flex-1 md:flex-none">
                            <input type="file" name="file" required class="hidden" id="mainUpload">
                            <div onclick="document.getElementById('mainUpload').click()" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3 rounded-2xl text-xs font-bold cursor-pointer transition flex items-center gap-2">
                                <i class="fas fa-folder-open"></i> PILIH FILE
                            </div>
                        </label>
                        <button name="upload" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-2xl text-xs font-bold shadow-lg shadow-green-100 transition">KIRIM</button>
                    </form>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-green-900/5 overflow-hidden border border-white">
                    <div class="p-8 border-b border-slate-50">
                        <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Arsip Dokumen Terkini</h3>
                    </div>
            <div class="flex justify-between items-center mb-4 px-2">
                <p class="text-xs font-bold text-slate-400 italic">* Menampilkan dokumen yang perlu diproses</p>
                <a href="arsip.php" class="text-xs font-black text-green-600 hover:text-green-800 flex items-center gap-2 underline tracking-widest">
                    <i class="fas fa-archive"></i> LIHAT SEMUA ARSIP
                 </a>
            </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                                <tr>
                                    <th class="p-6 text-left">Nama Dokumen</th>
                                    <th class="p-6 text-left">Pemilik</th>
                                    <th class="p-6 text-center">Status</th>
                                    <th class="p-6 text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php 
                                $res = $conn->query("SELECT * FROM dokumen WHERE status='Menunggu' ORDER BY tgl_upload DESC");
                                while($d = $res->fetch_assoc()): 
                                    $isMe = ($d['pemilik'] == $user_sekarang);
                                ?>
                                <tr class="<?= $isMe ? 'bg-green-50/40' : '' ?> hover:bg-slate-50 transition duration-300">
                                    <td class="p-6">
                                        <div class="font-bold text-slate-700"><?= $d['nama_file'] ?></div>
                                        <div class="text-[10px] text-slate-400 mt-1"><?= date('d/m/Y H:i', strtotime($d['tgl_upload'])) ?></div>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-xs font-medium <?= $isMe ? 'text-green-700 font-bold' : 'text-slate-500' ?>">
                                            <?= $d['pemilik'] ?> <?= $isMe ? ' (Anda)' : '' ?>
                                        </span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-tighter <?= $d['status'] == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                            <?= $d['status'] ?>
                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="uploads/<?= $d['nama_file'] ?>" class="w-9 h-9 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-200 transition" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if($d['file_revisi']): ?>
                                                <a href="uploads/<?= $d['file_revisi'] ?>" class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-green-100 hover:bg-green-700 transition" title="Unduh Hasil">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>