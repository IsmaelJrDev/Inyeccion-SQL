<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login - SQL Injection Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <!-- Card Principal -->
        <div class="bg-slate-800 rounded-2xl shadow-2xl border border-slate-700 overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-12 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white p-4 rounded-full">
                        <i class="fas fa-shield-alt text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">SecureAuth</h1>
                <p class="text-blue-100 text-sm">Portal de Acceso Seguro</p>
            </div>

            <!-- Formulario -->
            <div class="px-8 py-10">
                <form id="loginForm" class="space-y-5">
                    
                    <!-- Campo Usuario -->
                    <div class="space-y-2">
                        <label for="username" class="block text-sm font-semibold text-slate-200">
                            <i class="fas fa-user text-blue-500 mr-2"></i>Usuario
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Ingresa tu usuario"
                            class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition"
                            required
                        >
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-200">
                            <i class="fas fa-lock text-blue-500 mr-2"></i>Contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Ingresa tu contraseña"
                                class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition"
                                required
                            >
                            <button 
                                type="button" 
                                id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-blue-400 transition"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Alerta de Mensaje -->
                    <div id="messageBox" class="hidden p-4 rounded-lg text-sm font-medium flex items-center gap-3">
                        <i class="fas fa-info-circle"></i>
                        <span id="messageText"></span>
                    </div>

                    <!-- Botón Login -->
                    <button 
                        type="submit" 
                        id="loginBtn"
                        class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold hover:from-blue-700 hover:to-blue-800 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800 flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="btnText">Iniciar Sesión</span>
                    </button>

                </form>
            </div>

            <!-- Footer -->
            <div class="bg-slate-700 bg-opacity-50 px-8 py-4 text-center text-slate-400 text-xs">
                <p>Ismael Jr Dev  -  Practica Inyección SQL  -  2026</p>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>
</html>
