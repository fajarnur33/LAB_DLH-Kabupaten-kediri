<?php 
include 'db_config.php'; 
if (isset($_POST['register'])) {
    $user = $_POST['username']; $pass = $_POST['password'];
    $check = $conn->query("SELECT * FROM users WHERE username='$user'");
    if ($check->num_rows > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $conn->query("INSERT INTO users (username, password, role) VALUES ('$user', '$pass', 'member')");
        echo "<script>alert('Akun Berhasil Dibuat!'); window.location='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar | DLH Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[url('https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center min-h-screen flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white/90 p-8 rounded-[2rem] shadow-2xl w-full max-w-md border border-white/20">
        <div class="text-center mb-10">
            <div class="inline-flex bg-green-600 p-4 rounded-2xl mb-4 shadow-lg"><i class="fas fa-leaf text-2xl text-white"></i></div>
            <h2 class="text-3xl font-black text-gray-800">DAFTAR AKUN</h2>
        </div>
        <?php if(isset($error)) echo "<p class='text-red-500 text-center mb-4 text-sm font-bold'>$error</p>"; ?>
        <form method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest ml-1">Username</label>
                <input type="text" name="username" class="w-full p-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none" required>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest ml-1">Password</label>
                <input type="password" name="password" class="w-full p-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-500 outline-none" required>
            </div>
            <button name="register" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-4 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs">DAFTAR SEKARANG</button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-500 underline"><a href="login.php">Kembali ke Login</a></p>
    </div>
</body>
</html>