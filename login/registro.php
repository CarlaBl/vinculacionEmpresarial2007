<?php
require_once 'api/mode.php';
?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Registro</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#6B21A8",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .star-rating label {
            cursor: pointer;
        }
        .star-rating input:checked ~ label .material-symbols-outlined {
            font-variation-settings: 'FILL' 1;
            color: #fbbf24;
        }
    </style>
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-primary">Registro de Usuario</h2>
  </div>
  <div class="flex items-center justify-center gap-4" >
    <a class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
            href="?mode=<?php echo (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') ? 'light' : 'dark'; ?>" id="theme-toggle">
        <span class="material-symbols-outlined">dark_mode</span>
    </a>
</div>
  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="./api/registroBackend.php" method="POST" class="space-y-6">
      <div>
        <label for="email" class="block text-sm/6 font-medium text-primary">Correo electrónico</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-primary">Contraseña</label>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password2" class="block text-sm/6 font-medium text-primary">Confirmar contraseña</label>
        </div>
        <div class="mt-2">
          <input id="password2" type="password" name="password2" required autocomplete="current-password2" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>
      <div class="space-y-2">
        <label  for="role_type" class="block text-sm/6 font-medium text-primary">Rol</label>
        <select
            class=" text-sm/6 font-medium w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all appearance-none"
            id="role_type" name="role_type" required="">
            <option value="">Seleccione Rol</option>
            <option value="1">Usuario</option>
            <option value="2">Admin</option>
        </select>
      </div>
      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-primary px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Registrar</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-400">
        ¿Ya tienes una cuenta?
      <a href="http://localhost:8081/" class="font-semibold text-primary hover:text-indigo-300">Iniciar sesión</a>
    </p>
  </div>
</div>
<script>
<?php
if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') {
    echo "document.documentElement.classList.add('dark');";
}
?>
</script>
</body>

</html>