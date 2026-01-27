<?php include 'db_config.php';
if (isset($_POST['login'])) {
    $user = $_POST['username']; $pass = $_POST['password'];
    $res = $conn->query("SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if ($res->num_rows > 0) {
        $u = $res->fetch_assoc();
        $_SESSION['username'] = $u['username']; $_SESSION['role'] = $u['role'];
        header($u['role'] == 'admin' ? "Location: admin.php" : "Location: index.php");
    } else { echo "<script>alert('Akses Ditolak: Periksa kembali kredensial Anda');</script>"; }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Dinas Lingkungan Hidup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center h-screen flex items-center justify-center">
    <div class="absolute inset-0 bg-green-900/40 backdrop-blur-sm"></div>
    <div class="relative bg-white/90 p-10 rounded-3xl shadow-2xl w-full max-w-md border border-white/20">
        <div class="text-center mb-8">
            <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-leaf text-3xl text-green-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-wider">E-Koreksi DLH</h2>
            <p class="text-gray-500 text-sm">Sistem Manajemen Dokumen Lingkungan</p>
        </div>
        <div class="mb-6">
    <a href="index.php" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 hover:text-green-600 uppercase tracking-[0.2em] transition-all group">
        <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i> 
        Kembali ke Beranda
    </a>
</div>
        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Username</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-3.5 text-gray-400"></i>
                    <input type="text" name="username" placeholder="Masukkan ID" class="w-full pl-10 p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3.5 text-gray-400"></i>
                    <input type="password" name="password" placeholder="••••••••" class="w-full pl-10 p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 outline-none transition" required>
                </div>
            </div>
            <button name="login" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-200 transition-all transform hover:scale-[1.02]">
                MASUK KE SISTEM
            </button>
        </form>
        
    </div>
</body>
</html>