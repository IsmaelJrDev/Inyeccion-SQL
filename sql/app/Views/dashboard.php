<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuarios Registrados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-slate-800 border-b border-slate-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-2 rounded-lg">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <h1 class="text-white text-2xl font-bold">SecureAuth</h1>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-slate-300">
                        <p class="text-sm text-slate-400">Bienvenido</p>
                        <p class="text-lg font-semibold flex items-center gap-2">
                            <i class="fas fa-user-circle text-blue-500"></i>
                            <?php echo htmlspecialchars($currentUser); ?>
                        </p>
                    </div>
                    <a href="index.php?action=logout" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="mb-12">
            <h2 class="text-4xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-database text-blue-500"></i>
                Usuarios Registrados en la Base de Datos
            </h2>
            <p class="text-slate-400">A continuación se muestran todos los usuarios activos en el sistema:</p>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="bg-slate-800 rounded-2xl shadow-2xl border border-slate-700 overflow-hidden">
            
            <!-- Header de la Tabla -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-users text-white text-2xl"></i>
                    <div>
                        <h3 class="text-white text-xl font-bold">Lista de Usuarios</h3>
                        <p class="text-blue-100 text-sm">Total: <?php echo count($users); ?> usuarios</p>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-700 border-b border-slate-600">
                            <th class="px-8 py-4 text-left text-sm font-semibold text-slate-200">
                                <i class="fas fa-hashtag text-blue-500 mr-2"></i>ID
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-slate-200">
                                <i class="fas fa-user text-blue-500 mr-2"></i>Usuario
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-slate-200">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>Email
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-slate-200">
                                <i class="fas fa-calendar text-blue-500 mr-2"></i>Fecha de Registro
                            </th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-slate-200">
                                <i class="fas fa-cog text-blue-500 mr-2"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        <?php foreach ($users as $key => $user): ?>
                        <tr class="hover:bg-slate-700 transition bg-slate-800">
                            <td class="px-8 py-4 text-slate-300">
                                <span class="bg-slate-700 px-3 py-1 rounded-full text-sm font-mono">
                                    #<?php echo $user['id']; ?>
                                </span>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <span class="text-white font-semibold"><?php echo htmlspecialchars($user['username']); ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-slate-300">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-blue-500"></i>
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-slate-400 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-green-500"></i>
                                    <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <button class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-eye"></i>
                                    Ver
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 border-t border-slate-700 mt-16 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-400 text-sm">
            <p>Ismael Jr Dev  -  Practica Inyección SQL  -  2026</p>
        </div>
    </footer>
</body>
</html>
