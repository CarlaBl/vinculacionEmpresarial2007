<?php
require_once 'session.php';
?>
<?php
require_once "conexion.php";

$sql = "SELECT id, reportero_nombre as reportero, fecha_inspeccion as fecha, 
               tipo_ubicacion, edificio, aula_seccion, limpieza, seguridad, 
               iluminacion_funcional, equipo_operativo, comentarios, estado, 
               created_at, updated_at 
        FROM reportes 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$totalReportes = $conn->query("SELECT COUNT(*) AS total FROM reportes")
                     ->fetch_assoc()["total"];

$reportesMesActual = $conn->query("
    SELECT COUNT(*) AS total 
    FROM reportes 
    WHERE MONTH(created_at) = MONTH(NOW()) 
      AND YEAR(created_at) = YEAR(NOW())
")->fetch_assoc()["total"];

$reportesMesAnterior = $conn->query("
    SELECT COUNT(*) AS total 
    FROM reportes 
    WHERE MONTH(created_at) = MONTH(NOW() - INTERVAL 1 MONTH) 
      AND YEAR(created_at) = YEAR(NOW() - INTERVAL 1 MONTH)
")->fetch_assoc()["total"];

$porcentaje = 0;

if ($reportesMesAnterior > 0) {
    $porcentaje = (($reportesMesActual - $reportesMesAnterior) / $reportesMesAnterior) * 100;
}

$pendientes = $conn->query("SELECT COUNT(*) AS total FROM reportes WHERE estado = 'pendiente'")
                   ->fetch_assoc()["total"];
                   
$atendidos = $conn->query("
    SELECT COUNT(*) AS total 
    FROM reportes 
    WHERE estado = 'atendido'
      AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
")->fetch_assoc()["total"];

$areas = [
    "classrooms" => "Aulas",
    "bathrooms" => "Baños",
    "common_areas" => "Áreas Comunes"
];

?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Panel de Control de Reportes</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#6B21A8", // Violet 800
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
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        <aside
            class="w-64 flex-shrink-0 hidden lg:flex flex-col border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-primary p-2 rounded-lg">
                    <span class="material-symbols-outlined text-white">domain</span>
                </div>
                <h1 class="font-bold text-xl tracking-tight text-slate-800 dark:text-white">SGAMI</h1>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1">
                <a class="flex items-center gap-3 px-3 py-2 text-primary bg-emerald-50 dark:bg-emerald-950/30 rounded-lg font-medium"
                    href="#">
                    <span class="material-symbols-outlined">dashboard</span>
                    Panel Principal
                </a>

            </nav>
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                <button
                    class="flex items-center gap-3 w-full px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors"

                    onclick="cerrarSesion()">
                    <span class="material-symbols-outlined">logout</span>
                    Cerrar sesión
                </button>
            </div>
        </aside>
        <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark">
            <header
                class="sticky top-0 z-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-8 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Panel de Control de Reportes</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Sistema de Gestión Administrativa de Mantenimiento Institucional</p>
                </div>
                <div class="flex items-center gap-4">
                    <a class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        href="?mode=<?php echo (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') ? 'light' : 'dark'; ?>" id="theme-toggle">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </a>

                    <div
                        class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden border border-slate-300 dark:border-slate-600">
                        <img alt="Avatar de usuario" class="w-full h-full object-cover"
                            src="https://upload.wikimedia.org/wikipedia/commons/c/ca/Escudo-UNAM-escalable.svg" />
                    </div>
                </div>
            </header>
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total de Reportes</p>
                                <h3 class="text-3xl font-bold mt-1">    <?= number_format($totalReportes) ?></h3>
                            </div>
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg">
                                <span class="material-symbols-outlined">assignment</span>
                            </div>
                            
                        </div>
                        <div class="mt-4 flex items-center text-xs font-medium text-emerald-600">
                            <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span>
                            <span><?= round($porcentaje, 1) ?>% respecto al mes pasado</span>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Acciones Pendientes
                                </p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($pendientes) ?></h3>
                            </div>
                            <div
                                class="p-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-lg">
                                <span class="material-symbols-outlined">pending_actions</span>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs font-medium text-amber-600">
                            <span class="material-symbols-outlined text-[14px] mr-1">priority_high</span>
                            <span>Requiere atención</span>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Atendidos
                                    Recientemente</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($atendidos) ?></h3>
                            </div>
                            <div
                                class="p-3 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                <span class="material-symbols-outlined">task_alt</span>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs font-medium text-slate-400">
                            <span>Últimos 7 días</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div
                        class="p-6 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-3">

                        </div>
                        <a
                            class="bg-primary hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-2 transition-colors"
                            href="<?php echo "http://localhost:8083/?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode']; ?>">

                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Nuevo Reporte
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Fecha</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Reportero</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Tipo de Ubicación</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Edificio y Aula</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Estado</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                                
                                <?php foreach ($data as $row): ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <?= date("d M, Y", strtotime($row["fecha"])) ?>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold">
                                                    <?= strtoupper(substr($row["reportero"], 0, 2)) ?>
                                                </div>
                                                <span class="text-sm font-medium">
                                                    <?= htmlspecialchars($row["reportero"]) ?>
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                                <?= htmlspecialchars($areas[$row["tipo_ubicacion"]]) ?>
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm"><?= htmlspecialchars($row["edificio"]) ?> - <?= htmlspecialchars($row["aula_seccion"]) ?></div>
                                        </td>

                                        <?php if ($row["estado"] === "atendido"): ?>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></span>
                                                    <?= htmlspecialchars($row["estado"]) ?>
                                                </span>
                                            </td>
                                        <?php else: ?>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="flex items-center gap-1.5 text-xs font-medium text-amber-600 dark:text-amber-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 dark:bg-amber-400"></span>
                                                    <?= htmlspecialchars($row["estado"]) ?>
                                                </span>
                                            </td>
                                        <?php endif; ?>

                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a
                                                class="text-slate-400 hover:text-primary transition-colors"
                                                href="<?php echo "http://localhost:8084/?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode'] . "&id=" . $row['id']; ?>"
                                                >
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Mostrando <?= number_format($totalReportes) ?> reportes</p>

                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        <?php
        if (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') {
            echo "document.documentElement.classList.add('dark');";
        }
        ?>

        async function cerrarSesion() {

            const requests = [];

            for (let port = 8081; port <= 8084; port++) {

                requests.push(
                    fetch(`http://localhost:${port}/logout.php`, {
                        method: 'GET',
                        credentials: 'include'
                    }).catch(() => {})
                );
            }

            await Promise.all(requests);

            window.location.replace(
                `http://localhost:8081/?mode=<?php echo $_SESSION['mode'] ?? 'light'; ?>`
            );
        }
    </script>




</body>

</html>