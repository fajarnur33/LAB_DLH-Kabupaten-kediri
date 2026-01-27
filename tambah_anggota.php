<?php 
include 'db_config.php';

// Proteksi Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') { 
    header("Location: login.php"); exit(); 
}

// 1. PROSES TAMBAH ANGGOTA
if (isset($_POST['tambah_anggota'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $divisi = $_POST['divisi'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = 'member';

    $sql = "INSERT INTO users (username, password, nama_lengkap, divisi, email, role) 
            VALUES ('$user', '$pass', '$nama', '$divisi', '$email', '$role')";
    
    if ($conn->query($sql)) {
        header("Location: tambah_anggota.php?status=sukses");
    }
}

// 2. PROSES HAPUS ANGGOTA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM users WHERE id=$id AND role='member'");
    header("Location: daftar_anggota.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota | AdminHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#f8fafc] min-h-screen">

    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tighter text-slate-800">Manajemen <span class="text-green-600">Anggota</span></h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola hak akses dan data personil dinas</p>
            </div>
            <a href="admin.php" class="bg-white border px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i> Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-4">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100 sticky top-10">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                        <i class="fas fa-user-plus text-green-600"></i> Tambah Anggota Baru
                    </h2>
                    
                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1">Username</label>
                            <input type="text" name="username" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-green-500 font-bold text-sm" required>
                        </div>

                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1">Password</label>
                            <input type="password" name="password" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-green-500 font-bold text-sm" required>
                        </div>

                        <hr class="border-slate-100 my-4">

                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-green-500 font-bold text-sm" required>
                        </div>

                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1">Divisi / Bidang</label>
                            <select name="divisi" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none font-bold text-sm">
                                <option value="Sekretariat">Sekretariat</option>
                                <option value="Tata Lingkungan">Tata Lingkungan</option>
                                <option value="Pengelolaan Sampah">Pengelolaan Sampah</option>
                                <option value="Pengendalian Pencemaran">Pengendalian Pencemaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1">Email</label>
                            <input type="email" name="email" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none font-bold text-sm" required>
                        </div>

                        <button name="tambah_anggota" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg hover:bg-green-600 transition mt-4">
                            Daftarkan Anggota
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50">
                        <h3 class="font-black text-slate-800 text-xs uppercase tracking-[0.2em]">Daftar Personil Aktif</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Anggota</th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Divisi</th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Kontak</th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php 
                                $res = $conn->query("SELECT * FROM users WHERE role='member' ORDER BY id DESC");
                                while($row = $res->fetch_assoc()): ?>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center font-black text-xs">
                                                <?= strtoupper(substr($row['nama_lengkap'], 0, 2)) ?>
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-800 text-sm uppercase leading-none"><?= $row['nama_lengkap'] ?></p>
                                                <p class="text-[10px] text-slate-400 mt-1 font-bold">@<?= $row['username'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase tracking-widest">
                                            <?= $row['divisi'] ?>
                                        </span>
                                    </td>
                                    <td class="p-6 text-sm font-medium text-slate-500">
                                        <?= $row['email'] ?>
                                    </td>
                                    <td class="p-6 text-center">
                                        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus anggota ini?')" class="w-10 h-10 bg-red-50 text-red-500 rounded-xl inline-flex items-center justify-center hover:bg-red-500 hover:text-white transition">
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
    </div>

</body>
</html>