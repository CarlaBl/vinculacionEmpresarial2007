<?php
require_once 'session.php';
?>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT reportes.*,users.email FROM reportes LEFT join users on reportes.id_user_asignado = users.id WHERE reportes.id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontró el reporte con ID: $id";
    }
    // Obtener usuarios
    $sql = "SELECT id, email FROM users";
    $result = mysqli_query($conn, $sql);
    $usuarios = [];

    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            $usuarios[] = $user;
        }
    } else {
        echo "No hay usuarios";
    }
} else {
    echo "Error: No se recibió el parámetro 'id'";
}
$areas = [
    "classrooms" => "Aulas",
    "bathrooms" => "Baños",
    "laboratories" => "Laboratorios",
    "administrative_buildings" => "Edificios Administrativos",
    "common_areas" => "Áreas Comunes"
];
$prioridad = [
    "low" => "Baja",
    "medium" => "Media",
    "high" => "Alta"
];
$ratings = [
    1 => '<span class="text-red-500 flex items-center gap-1 text-sm font-bold">
          <span class="material-symbols-outlined text-sm">cancel</span> Deficiente
        </span>',

    2 => '<span class="text-red-400 flex items-center gap-1 text-sm font-bold">
          <span class="material-symbols-outlined text-sm">cancel</span> Muy malo
        </span>',

    3 => '<span class="text-amber-500 flex items-center gap-1 text-sm font-bold">
          <span class="material-symbols-outlined text-sm">error</span> Regular
        </span>',

    4 => '<span class="text-primary flex items-center gap-1 text-sm font-bold">
          <span class="material-symbols-outlined text-sm">check_circle</span> Bueno
        </span>',

    5 => '<span class="text-green-600 flex items-center gap-1 text-sm font-bold">
          <span class="material-symbols-outlined text-sm">verified</span> Excelente
        </span>'
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Detalle del Reporte - Mantenimiento de Instalaciones</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
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
                        "background-light": "#f8fafc", // Slate 50
                        "background-dark": "#0f172a", // Slate 900
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
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <nav class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-4">
                    <a class="p-2 text-slate-400 hover:text-primary transition-colors" href="<?php echo "http://localhost:8082/?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode']; ?>">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    <h1 class="text-xl font-semibold flex items-center gap-2">
                        Reporte <span class="text-slate-400 font-normal">#R-<?= $row['id'] ?></span>
                    </h1>
                </div>
                <div class="flex items-center gap-3">

                    <a class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        href="?mode=<?php echo (isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') ? 'light&id='.$row['id'] : 'dark&id='.$row['id']; ?>">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </a>
                    <button
                        class="hidden flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-sm">edit</span>
                        Editar Reporte
                    </button>
                    <?php if ($row['status_asignado'] == 1 && $row['estado'] != 'atendido' && $row['id_user_asignado'] == $_SESSION['id']) { ?>
                        <a
                            class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold shadow-sm hover:opacity-90 transition-opacity"
                            href="<?php echo "http://localhost:8084/atenderTarea.php?session=" . $_SESSION['session'] . "&mode=" . $_SESSION['mode'] . "&id=" . $row['id']; ?>"

                            >
                            
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            Marcar como Atendido
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?= $row['estado'] === 'atendido'
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                    : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' ?>">
                                Acción <?= $row['estado'] ?>
                            </span>
                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">history</span>
                                Creado el
                                <?= date('d M Y \a \l\a\s h:i A', strtotime($row['created_at'])) ?>
                            </span>
                        </div>
                        <h2 class="text-lg font-bold">Detalles de la Solicitud de Mantenimiento</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Nombre del
                                    Reportero</label>
                                <p class="mt-1 text-base font-medium"><?= $row['reportero_nombre'] ?></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Fecha del Reporte</label>
                                <p class="mt-1 text-base font-medium">
                                    <?= date('j \d\e F, Y', strtotime($row['created_at'])) ?>
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Prioridad</label>
                                <p class="mt-1 text-base font-medium"><?= $prioridad [$row['tipo_prioridad']] ?></p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Tipo de
                                    Ubicación</label>
                                <p class="mt-1 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">school</span>
                                    <span class="text-base font-medium"><?= $areas[$row['tipo_ubicacion']] ?></span>
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Edificio /
                                    Aula</label>
                                <p class="mt-1 text-base font-medium"><?= $row['edificio'] ?>, <?= $row['aula_seccion'] ?></p>
                            </div>
                        </div>
                        <div class="mt-8">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider block mb-3">Lista
                                de Evaluación</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div
                                    class="flex items-center justify-between p-3 rounded-lg border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                                    <span class="text-sm font-medium">Limpieza del Suelo</span>
                                    <?= $ratings[$row['limpieza']] ?>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 rounded-lg border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                                    <span class="text-sm font-medium">Seguridad y Cumplimiento</span>
                                    <?= $ratings[$row['seguridad']] ?>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 rounded-lg border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                                    <span class="text-sm font-medium">Iluminación Funcional</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input class="sr-only peer" type="checkbox" <?= ($row['iluminacion_funcional'] == 1) ? 'checked' : '' ?> />
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 rounded-lg border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                                    <span class="text-sm font-medium">Equipo Operativo</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input class="sr-only peer" type="checkbox" <?= ($row['equipo_operativo'] == 1) ? 'checked' : '' ?> />
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider">Comentarios del
                                Reportero</label>
                            <div
                                class="mt-2 p-4 bg-slate-50 dark:bg-slate-900 rounded-lg text-sm leading-relaxed border-l-4 border-primary italic">
                                "<?= $row['comentarios'] ?>"
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($row['status_asignado'] == 0 && $_SESSION['role'] == 2) : ?>
                <div class="space-y-6">
                    <form action="asignarTarea.php" method="POST"
                        class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="font-bold flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">assignment_turned_in</span>
                                Estado de Atención
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="p-4 rounded-lg bg-primary/5 border border-primary/10 text-center">
                                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Este reporte aún no ha sido
                                    marcado como atendido.</p>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="user_asig">Usuario Asignado</label>
                                    <select
                                        class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all appearance-none"
                                        id="user_asig" name="user_asig" required="">
                                        <option value="">Seleccione Usuario</option>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <option value="<?= $usuario['id'] ?>"><?= $usuario['email'] ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="comments">Notas
                                        Detalladas</label>
                                    <textarea
                                        class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:text-white outline-none transition-all resize-none"
                                        id="comments" name="comments"
                                        placeholder="Describa cualquier detalle al solucionar el reporte..."
                                        rows="5"></textarea>
                                </div>
                                <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                            </div>
                            <button
                                class="w-full py-2.5 bg-primary text-white font-semibold rounded-lg shadow-sm hover:opacity-90 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">handyman</span>
                                Asignar Tarea
                            </button>
                        </div>
                </div>
                </form>
        </div>
    <?php endif; ?>
    <?php if ($row['status_asignado'] == 1): ?>
        <div class="space-y-6">
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">assignment_turned_in</span>
                        Estado de Atención
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="pt-4 border-slate-100 dark:border-slate-700">
                        <label
                            class="block text-xs font-semibold text-slate-500 uppercase mb-3 tracking-widest">Registros
                            de Atención</label>
                        <div class="space-y-4 opacity-40 select-none grayscale">
                            <div class="flex gap-3">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden border border-slate-300 dark:border-slate-600">
                                        <img alt="Avatar de usuario" class="w-full h-full object-cover"
                                            src="https://upload.wikimedia.org/wikipedia/commons/c/ca/Escudo-UNAM-escalable.svg" />
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-bold"><?= $row['email'] ?></p>
                                    <p class="text-xs text-slate-500">Fecha: <?= date("d/m/Y", strtotime($row['fecha_asignado'])) ?></p>
                                </div>
                            </div>
                            <div
                                class="text-xs bg-slate-50 dark:bg-slate-900 p-3 rounded border border-slate-100 dark:border-slate-700 italic">
                                <?= $row['comentarios_asignado'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($row['status_asignado'] == 0 && $_SESSION['role'] == 1): ?>
        <div class="space-y-6">
            <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">assignment_turned_in</span>
                            Estado de Atención 
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="p-4 rounded-lg bg-primary/5 border border-primary/10 text-center">
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Este reporte aún no ha sido
                                marcado como atendido.</p>
                            
                        </div>
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                            <label
                                class="block text-xs font-semibold text-slate-500 uppercase mb-3 tracking-widest">Registros
                                de Atención</label>
                            <div class="space-y-4 opacity-40 select-none grayscale">
                                <div class="flex gap-3">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xs">person</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">---</p>
                                        <p class="text-xs text-slate-500">Fecha: --/--/----</p>
                                    </div>
                                </div>
                                <div
                                    class="text-xs bg-slate-50 dark:bg-slate-900 p-3 rounded border border-slate-100 dark:border-slate-700 italic">
                                    Sin notas proporcionadas...
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
        </div>
    <?php endif; ?>
    </div>
    </main>


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