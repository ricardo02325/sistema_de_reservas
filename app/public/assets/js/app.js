const app = {
    routes: {
        getReservas: '/Reservas/getReservas',
    },
    user: {
        sv: false,
        id: '',
        username: '',
        tipo: ''
    },
    $pp: $("#prev-posts"),
    $lp: $("#content"),

    $tablaReservas: $("#tabla-reservas"),

    mostrarReservas: async function () {
        try {
            let html = `
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>N° Mesa</th>
                        <th>Fecha</th>
                        <th>Personas</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>`;

            const reservas = await $.getJSON(this.routes.getReservas);

            if (!reservas || reservas.length === 0) {
                html += `<tr><td colspan="6"><b>No hay reservas registradas</b></td></tr>`;
            } else {
                for (let r of reservas) {
                    const estado = r.estado || '';

                    let estadoBadge = '';
                    switch (estado.toLowerCase()) {
                        case 'confirmada':
                            estadoBadge = `<span class="badge bg-success">Confirmado</span>`;
                            break;
                        case 'pendiente':
                            estadoBadge = `<span class="badge bg-warning text-dark">Pendiente</span>`;
                            break;
                        case 'cancelada':
                            estadoBadge = `<span class="badge bg-danger">Cancelado</span>`;
                            break;
                        default:
                            estadoBadge = `<span class="badge bg-secondary">${estado}</span>`;
                            break;
                    }

                    html += `
                        <tr>
                            <td>${r.id}</td>
                            <td>${r.mesa_id}</td>
                            <td>${r.fecha_hora_reserva}</td>
                            <td>${r.cantidad_personas}</td>
                            <td>${estadoBadge}</td>
                        </tr>`;
                }
            }

            html += `</tbody>`;
            this.$tablaReservas.html(html);

        } catch (err) {
            console.error('Error al obtener reservas:', err);
            this.$tablaReservas.html(`<tbody><tr><td colspan="6">Error al cargar las reservas</td></tr></tbody>`);
        }
    }
}

// Llamada automática al cargar la página
$(document).ready(function () {
    app.mostrarReservas();
});