<?php 
include 'db_config.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    header("Location: home.php"); exit(); 
}

// Proses Update Status Aduan
if (isset($_POST['update_status'])) {
    $id = $_POST['id_aduan'];
    $status_baru = $_POST['status'];
    $conn->query("UPDATE aduan SET status='$status_baru' WHERE id=$id");
    header("Location: kelola_aduan.php");
}

// Proses Hapus Aduan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM aduan WHERE id=$id");
    header("Location: kelola_aduan.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Aduan | AdminHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto py-12 px-6">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tighter text-slate-800">Panel <span class="text-green-600">Aduan Masyarakat</span></h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pantau dan tindak lanjuti laporan warga</p>
            </div>
            <a href="admin.php" class="bg-white border px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">Dashboard</a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b">
                    <tr>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">Waktu & Pelapor</th>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest">Isi Aduan</th>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Status</th>
                        <th class="p-6 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php 
                    $res = $conn->query("SELECT * FROM aduan ORDER BY tgl_aduan DESC");
                    while($row = $res->fetch_assoc()): 
                        // Warna Badge Status
                        $color = "bg-slate-100 text-slate-500";
                        if($row['status'] == 'Diproses') $color = "bg-blue-100 text-blue-600";
                        if($row['status'] == 'Selesai') $color = "bg-green-100 text-green-600";
                        if($row['status'] == 'Masuk') $color = "bg-orange-100 text-orange-600";
                    ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6">
                            <p class="font-black text-slate-800 text-sm uppercase"><?= $row['nama_pelapor'] ?></p>
                            <p class="text-[10px] text-green-600 font-bold mt-1"><i class="fab fa-whatsapp mr-1"></i> <?= $row['no_wa'] ?></p>
                            <p class="text-[9px] text-slate-400 mt-2 italic"><?= date('d/m/Y H:i', strtotime($row['tgl_aduan'])) ?></p>
                        </td>
                        <td class="p-6 max-w-xs">
                            <p class="text-xs text-slate-600 leading-relaxed"><?= nl2br($row['isi_aduan']) ?></p>
                        </td>
                        <td class="p-6 text-center">
                            <span class="px-3 py-1 <?= $color ?> rounded-lg text-[9px] font-black uppercase tracking-widest italic">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end gap-2">
                                <form method="POST" class="inline-flex gap-1">
                                    <input type="hidden" name="id_aduan" value="<?= $row['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="text-[9px] font-black uppercase border rounded-lg p-1 outline-none bg-slate-50 cursor-pointer">
                                        <option value="Masuk" <?= $row['status'] == 'Masuk' ? 'selected' : '' ?>>Masuk</option>
                                        <option value="Diproses" <?= $row['status'] == 'Diproses' ? 'selected' : '' ?>>Proses</option>
                                        <option value="Selesai" <?= $row['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <input type="hidden" name="update_status">
                                </form>
                                <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus aduan ini?')" class="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>