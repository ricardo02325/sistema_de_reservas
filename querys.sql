-- Vista de Reservas
CREATE VIEW vista_reservas AS
SELECT 
    r.id AS reserva_id,
    CONCAT(u.primer_nombre, ' ', 
           COALESCE(u.segundo_nombre, ''), ' ', 
           u.primer_apellido, ' ', 
           u.segundo_apellido) AS nombre_usuario,
    m.numero_mesa,
    r.fecha_hora_reserva,
    r.cantidad_personas,
    r.estado,
    r.fecha_creacion
FROM reservas r
INNER JOIN usuarios u ON r.usuario_id = u.id
INNER JOIN mesas m ON r.mesa_id = m.id;