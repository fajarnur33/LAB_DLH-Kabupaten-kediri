<?php 
include 'db_config.php';

if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

$user_sekarang = $_SESSION['username'];

// Proses Update Data
if (isset($_POST['update_profile'])) {
    $nama = $_POST['nama_lengkap'];
    $divisi = $_POST['divisi'];
    $email = $_POST['email'];
    
    // Logika Upload Foto
    $foto_baru = $_POST['foto_lama']; // Default pakai foto lama
    if ($_FILES['foto']['name'] != "") {
        $foto_baru = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_baru);
        
        // Hapus foto lama jika bukan default agar server tidak penuh
        if ($_POST['foto_lama'] != 'default_avatar.jpg' && file_exists("uploads/".$_POST['foto_lama'])) {
            unlink("uploads/".$_POST['foto_lama']);
        }
    }
    
    $sql = "UPDATE users SET nama_lengkap='$nama', divisi='$divisi', email='$email', foto='$foto_baru' WHERE username='$user_sekarang'";
    
    if ($conn->query($sql)) {
        echo "<script>alert('Profil & Foto berhasil diperbarui!'); window.location='profile.php';</script>";
    }
}

$data = $conn->query("SELECT * FROM users WHERE username='$user_sekarang'")->fetch_assoc();
$foto_tampil = (!empty($data['foto'])) ? $data['foto'] : 'default_avatar.jpg';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya | DLH Kediri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen pb-20">

    <nav class="bg-white border-b h-20 flex items-center shadow-sm">
        <div class="max-w-4xl mx-auto w-full px-6 flex justify-between items-center">
            <a href="admin.php" class="text-slate-800 font-black text-xs uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto mt-12 px-6">
        <form method="POST" enctype="multipart/form-data" class="space-y-8">
            <input type="hidden" name="foto_lama" value="<?= $foto_tampil ?>">

            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-slate-100 text-center">
                <div class="relative w-32 h-32 mx-auto mb-6">
                    <img id="previewFoto" src="uploads/<?= $foto_tampil ?>" class="w-full h-full object-cover rounded-[2rem] shadow-lg border-4 border-white ring-1 ring-slate-100">
                    <label class="absolute -bottom-2 -right-2 bg-green-600 w-10 h-10 rounded-xl flex items-center justify-center text-white cursor-pointer hover:bg-slate-900 transition shadow-lg">
                        <i class="fas fa-camera text-sm"></i>
                        <input type="file" name="foto" id="inputFoto" class="hidden" accept="image/*" onchange="previewImage()">
                    </label>
                </div>
                <h3 class="font-black text-slate-800 uppercase tracking-tight"><?= $data['username'] ?></h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1"><?= $data['role'] ?> • DLH KEDIRI</p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-slate-100 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none transition font-bold" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Divisi</label>
                        <select name="divisi" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none transition font-bold">
                            <option value="Sekretariat" <?= ($data['divisi'] == 'Sekretariat') ? 'selected' : '' ?>>Sekretariat</option>
                            <option value="Tata Lingkungan" <?= ($data['divisi'] == 'Tata Lingkungan') ? 'selected' : '' ?>>Tata Lingkungan</option>
                            <option value="Pengelolaan Sampah" <?= ($data['divisi'] == 'Pengelolaan Sampah') ? 'selected' : '' ?>>Pengelolaan Sampah</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email</label>
                    <input type="email" name="email" value="<?= $data['email'] ?>" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none transition font-bold" required>
                </div>

                <button name="update_profile" class="w-full bg-slate-900 hover:bg-green-600 text-white font-black py-4 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs">
                    Perbarui Profil & Foto
                </button>
            </div>
        </form>
    </main>

    <script>
        function previewImage() {
            const input = document.getElementById('inputFoto');
            const preview = document.getElementById('previewFoto');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

    <footer class="bg-[#16a34a] text-white py-8 mt-20">
        <div class="text-center text-[10px] font-bold uppercase tracking-[0.3em]">
            © 2021 DINAS LINGKUNGAN HIDUP KEDIRI
        </div>
    </footer>
</body>
</html>