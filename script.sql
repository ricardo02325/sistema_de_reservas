CREATE DATABASE IF NOT EXISTS sistema_reservas;
USE sistema_reservas;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador único de usuario',
    primer_nombre VARCHAR(30) NOT NULL COMMENT 'Primer nombre del usuario',
    segundo_nombre VARCHAR(30) DEFAULT NULL COMMENT 'Segundo nombre (opcional)',
    primer_apellido VARCHAR(30) NOT NULL COMMENT 'Primer apellido del usuario',
    segundo_apellido VARCHAR(30) NOT NULL COMMENT 'Segundo apellido (opcional)',
    email VARCHAR(50) UNIQUE COMMENT 'Correo electrónico',
    telefono VARCHAR(10) COMMENT 'Teléfono de contacto',
    fecha_ingreso DATE COMMENT 'Fecha de ingreso al restaurante',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de registro',
    INDEX idx_nombre_completo (primer_nombre, primer_apellido),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Usuarios registrados en el restaurante';

-- Tabla de roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador único del rol',
    nombre_rol VARCHAR(30) NOT NULL UNIQUE COMMENT 'Nombre del rol',
    INDEX idx_nombre_rol (nombre_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Roles del sistema';

-- Tabla intermedia usuario_roles
CREATE TABLE usuario_roles (
    usuario_id INT COMMENT 'ID del usuario',
    rol_id INT COMMENT 'ID del rol asignado',
    PRIMARY KEY (usuario_id, rol_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_usuario (usuario_id),
    INDEX idx_rol (rol_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Asignación de roles a usuarios';

-- Tabla de credenciales
CREATE TABLE credenciales_login (
    usuario_id INT PRIMARY KEY COMMENT 'ID del usuario autorizado para login',
    contraseña VARCHAR(128) NOT NULL COMMENT 'Contraseña hasheada',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Credenciales de acceso';

-- Tabla de mesas
CREATE TABLE mesas (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ID único de la mesa',
    numero_mesa INT NOT NULL UNIQUE COMMENT 'Número identificador de la mesa',
    capacidad TINYINT UNSIGNED NOT NULL COMMENT 'Capacidad máxima de personas (máximo 10)',
    ubicacion VARCHAR(30) COMMENT 'Ubicación de la mesa',
    tipo ENUM('normal', 'vip', 'exterior', 'reservada') NOT NULL DEFAULT 'normal' COMMENT 'Tipo de mesa',
    INDEX idx_numero_mesa (numero_mesa),
    INDEX idx_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Mesas disponibles en el restaurante';

-- Tabla de reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ID único de la reserva',
    usuario_id INT COMMENT 'ID del usuario que registró la reserva',
    mesa_id INT COMMENT 'ID de la mesa reservada',
    fecha_reserva DATE NOT NULL COMMENT 'Fecha para la reserva',
    hora_reserva TIME NOT NULL COMMENT 'Hora para la reserva',
    cantidad_personas TINYINT UNSIGNED NOT NULL COMMENT 'Número de personas para la reserva (máximo 10)',
    estado ENUM(
        'Pendiente',
        'Confirmada',
        'Cancelada',
        'Cumplida',
        'No show',
        'En lista de espera',
        'Reprogramada'
    ) DEFAULT 'Pendiente' COMMENT 'Estado actual de la reserva',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (mesa_id) REFERENCES mesas(id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_usuario_reserva (usuario_id),
    INDEX idx_mesa_reserva (mesa_id),
    INDEX idx_fecha_reserva (fecha_reserva),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Reservas hechas en el restaurante';

-- Insertar roles
INSERT INTO roles (nombre_rol) VALUES 
('mesero'),
('administrador'),
('recepcionista');

-- Insertar usuarios
INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, email, telefono, fecha_ingreso)
VALUES
('Annelise Najara', 'Cabrales', 'López', 'annelise.cabrales@example.com', '5567890123', '2023-05-01'),
('Carlos', 'Ramírez', 'Méndez', 'carlos.ramirez@example.com', '5512345678', '2022-10-12'),
('Fernanda', 'Soto', 'Lozano', 'fernanda.soto@example.com', '5523456789', '2023-01-15'),
('Jorge', 'Martínez', NULL, 'jorge.mtz@example.com', '5598765432', '2023-03-20'),
('Lucía', 'Gómez', 'Pérez', 'lucia.gomez@example.com', '5543219876', '2023-06-01');

-- Relacionar usuarios con roles
INSERT INTO usuario_roles (usuario_id, rol_id) VALUES
(1, 1), -- Annelise - mesero
(2, 2), -- Carlos - administrador
(3, 1), -- Fernanda - mesero
(4, 3), -- Jorge - recepcionista
(5, 1); -- Lucía - mesero

-- Credenciales (solo para meseros y admin)
INSERT INTO credenciales_login (usuario_id, contraseña) VALUES
(1, 'hash_annelise123'),
(2, 'hash_carlos456'),
(3, 'hash_fernanda789'),
(5, 'hash_lucia321');

-- Insertar mesas
INSERT INTO mesas (numero_mesa, capacidad, ubicacion, tipo) VALUES
(1, 4, 'Interior', 'normal'),
(2, 6, 'Terraza', 'exterior'),
(3, 2, 'VIP Room', 'vip'),
(4, 4, 'Interior', 'reservada'),
(5, 8, 'Exterior', 'normal');

-- Insertar reservas
INSERT INTO reservas (usuario_id, mesa_id, fecha_reserva, hora_reserva, cantidad_personas, estado)
VALUES
(1, 1, '2025-05-16', '19:00:00', 2, 'Confirmada'), -- Annelise
(3, 2, '2025-05-17', '20:30:00', 4, 'Pendiente'),
(5, 3, '2025-05-17', '18:45:00', 2, 'En lista de espera'),
(4, 4, '2025-05-18', '21:00:00', 3, 'Cancelada'),
(2, 5, '2025-05-19', '19:15:00', 6, 'Reprogramada');
