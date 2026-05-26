<?php
require_once 'session.php';
?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Formulario de Nuevo Reporte</title>
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
    <nav class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-6 py-4">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-primary p-1.5 rounded-lg">
                    <span class="material-symbols-outlined text-white">fact_check</span>
                </div>
                <span class="font-bold text-xl tracking-tight">SGAMI</span></span>
            </div>
            <div class="flex items-center gap-4">
                <a class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    href="?mode=<?php echo (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') ? 'light' : 'dark'; ?>">
                    <span class="material-symbols-outlined">dark_mode</span>
                </a>
                <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">person</span>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-4xl mx-auto py-10 px-6">
        <div class="mb-8">
            <nav aria-label="Breadcrumb" class="flex mb-4 text-sm text-slate-500 dark:text-slate-400">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li>Panel de Control</li>
                    <li><span class="mx-2 text-primary font-medium">/ Nuevo Reporte de Inspección</span></li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold tracking-tight">Nuevo Reporte de Inspección</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Por favor, complete los detalles a continuación para
                registrar una nueva inspección de las instalaciones.</p>
        </div>
        <form method="POST" action="reportes.php"
            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-xl overflow-hidden">
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-full pb-2 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">person_outline</span>
                            Información General
                        </h2>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="reporter_name">Nombre
                            del Reportero</label>
                        <input
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all"
                            id="reporter_name" maxlength="50" name="reporter_name"
                            placeholder="Ingrese su nombre completo" required="" type="text" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="report_date">Fecha de
                            Inspección</label>
                        <input
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all"
                            id="report_date" name="report_date" required="" type="date" />
                    </div>
                    <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="priority_type">Prioridad</label>
                            <select
                                class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all appearance-none"
                                id="priority_type" name="priority_type" required="">
                                <option value="">Seleccione Prioridad</option>
                                <option value="low">Baja</option>
                                <option value="medium">Media</option>
                                <option value="high">Alta</option>
                            </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="col-span-full pb-2 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            Detalles de Ubicación
                        </h2>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="location_type">Tipo
                            de Ubicación</label>
                        <select
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all appearance-none"
                            id="location_type" name="location_type" required="">
                            <option value="">Seleccione Tipo</option>
                            <option value="classrooms">Aulas</option>
                            <option value="bathrooms">Baños</option>
                            <option value="laboratories">Laboratorios</option>
                            <option value="administrative_buildings">Edificios Administrativos</option>
                            <option value="common_areas">Áreas Comunes</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300"
                            for="building">Edificio</label>
                        <input
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all"
                            id="building" maxlength="30" name="building" placeholder="ej. Ala de Ciencias" required=""
                            type="text" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="room">Aula /
                            Sección</label>
                        <input
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all"
                            id="room" maxlength="80" name="room" placeholder="ej. Aula 402B" required="" type="text" />
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="pb-2 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">grade</span>
                            Evaluaciones
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div class="flex items-center justify-between group">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Limpieza</span>
                            <div class="flex gap-1">
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="cleanliness" type="radio" value="1" checked/>
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="cleanliness" type="radio" value="2" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="cleanliness" type="radio" value="3" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="cleanliness" type="radio" value="4" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="cleanliness" type="radio" value="5" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Seguridad y
                                Cumplimiento</span>
                            <div class="flex gap-1">
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="safety" type="radio" value="1" checked/>
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="safety" type="radio" value="2" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="safety" type="radio" value="3" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="safety" type="radio" value="4" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input class="hidden peer" name="safety" type="radio" value="5" />
                                    <span
                                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 peer-checked:text-yellow-400 peer-checked:fill-1">star</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Iluminación
                                Funcional</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" type="checkbox" name="lighting"/>
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                                </div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Equipo Operativo</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" type="checkbox" name="equipment"/>
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="pb-2 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">description</span>
                            Comentarios y Observaciones
                        </h2>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="comments">Notas
                            Detalladas</label>
                        <textarea
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all resize-none"
                            id="comments" name="comments"
                            placeholder="Describa cualquier problema, reparaciones necesarias o estado general..."
                            rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div
                class="bg-slate-50 dark:bg-slate-800/50 p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-200 dark:border-slate-800">
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-[30%]">
                    <span class="font-medium">Nota de Privacidad:</span> Los reportes se registran para la auditoría de
                    gestión de instalaciones y seguimiento histórico.
                </p>
                <div class="flex items-center w-full sm:w-auto">
                    <a
                        class="flex-1 sm:flex-none px-6 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-colors"
                        href="<?php echo "http://localhost:8082/?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode']; ?>"
                            
                        >
                        Cancelar
                    </a>
                    <button
                        class="flex-1 sm:flex-none px-8 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-emerald-700 rounded-lg shadow-sm shadow-emerald-200 dark:shadow-none transition-all flex items-center justify-center gap-2"
                        type="submit">
                        <span class="material-symbols-outlined text-lg">send</span>
                        Enviar Reporte
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        window.onload = function () {
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.getElementById('report_date');
            if (dateInput) {
                dateInput.value = today;
            }
        };
    </script>
    <script>
        <?php
        if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') {
            echo "document.documentElement.classList.add('dark');";
        }
        ?>

        function cerrarSesion() {
            window.location.replace('http://localhost:8082/logout.php');
        }
    </script>

</body>

</html>