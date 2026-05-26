DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `session` VARCHAR(255) NULL DEFAULT NULL,
    `role` INT DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `email` (`email`) USING BTREE
);

DROP TABLE IF EXISTS reportes;

CREATE TABLE reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,


    reportero_nombre VARCHAR(50) NOT NULL,
    fecha_inspeccion DATE NOT NULL,
    tipo_prioridad VARCHAR(50) NOT NULL,
    tipo_ubicacion VARCHAR(50) NOT NULL,
    edificio VARCHAR(30) NOT NULL,
    aula_seccion VARCHAR(80) NOT NULL,


    limpieza INT NOT NULL ,
    seguridad INT NOT NULL,
    iluminacion_funcional BOOLEAN NOT NULL DEFAULT FALSE,
    equipo_operativo BOOLEAN NOT NULL DEFAULT FALSE,


    comentarios TEXT,


    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',

    status_asignado TINYINT(1) NOT NULL DEFAULT 0,
    id_user_asignado INT NULL,
    fecha_asignado DATETIME NULL,
    comentarios_asignado TEXT,
    fecha_atendido DATETIME NULL,


    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);