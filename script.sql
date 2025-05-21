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

-- Tabla de reservas con campo unificado para fecha y hora
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ID único de la reserva',
    usuario_id INT COMMENT 'ID del usuario que registró la reserva',
    mesa_id INT COMMENT 'ID de la mesa reservada',
    fecha_hora_reserva DATETIME NOT NULL COMMENT 'Fecha y hora completa para la reserva',
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
    INDEX idx_fecha_hora_reserva (fecha_hora_reserva),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT = 'Reservas hechas en el restaurante';

-- Insertar roles
INSERT INTO roles (nombre_rol) VALUES
('Administrador'),
('Recepcionista'),
('Mesero'),
('Cliente'),
('Gerente');

-- Insertar usuarios
INSERT INTO usuarios (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email, telefono, fecha_ingreso)
VALUES
('Annelise', 'Najara', 'Cabrales', 'López', 'annelise.cabrales@example.com', '5544332211', '2023-10-01'),
('Luis', 'Antonio', 'Mendoza', 'Gómez', 'luis.mendoza@example.com', '5511223344', '2024-01-12'),
('María', NULL, 'Fernández', 'Luna', 'maria.fernandez@example.com', '5522334455', '2024-02-05'),
('Carlos', 'Eduardo', 'Ramírez', 'Santos', 'carlos.ramirez@example.com', '5533445566', '2023-12-10'),
('Sofía', 'Beatriz', 'Morales', 'Ortiz', 'sofia.morales@example.com', '5544556677', '2024-03-20');

-- Asignación de roles a usuarios
INSERT INTO usuario_roles (usuario_id, rol_id) VALUES
(1, 1),  -- Annelise: Administradora
(2, 4),  -- Luis: Cliente
(3, 4),  -- María: Cliente
(4, 2),  -- Carlos: Recepcionista
(5, 3);  -- Sofía: Mesera

-- Credenciales de login
INSERT INTO credenciales_login (usuario_id, contraseña) VALUES
(1, SHA2('admin123', 256)),
(2, SHA2('cliente456', 256)),
(3, SHA2('cliente789', 256)),
(4, SHA2('recepcion123', 256)),
(5, SHA2('mesera321', 256));

-- Mesas disponibles
INSERT INTO mesas (numero_mesa, capacidad, ubicacion, tipo) VALUES
(1, 4, 'Interior', 'normal'),
(2, 6, 'Terraza', 'vip'),
(3, 2, 'Ventana', 'normal'),
(4, 8, 'Salón privado', 'reservada'),
(5, 4, 'Exterior', 'exterior');

-- Reservas realizadas
INSERT INTO reservas (usuario_id, mesa_id, fecha_hora_reserva, cantidad_personas, estado)
VALUES 
(1, 1, '2025-05-22 13:00:00', 2, 'Confirmada'),
(2, 2, '2025-05-23 19:30:00', 4, 'Pendiente'),
(3, 3, '2025-05-24 14:15:00', 3, 'Cancelada'),
(4, 4, '2025-05-25 20:00:00', 5, 'Confirmada'),
(5, 5, '2025-05-26 18:00:00', 2, 'En lista de espera');
