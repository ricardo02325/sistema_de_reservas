const app = {
    routes: {
        getReservas: '/Reservas',
    },
    user :{
            sv      : false,
            id      : '',
            username: '',
            tipo    : ''
    },
    $pp : $("#prev-posts"),
    $lp : $("#content"),

    $tablaReservas: $("#tabla-reservas"),

    mostrarReservas: async function () {
        try {
            let html = `
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>N° Mesa</th>
                        <th>Fecha</th>
                        <th>Personas</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>`

            const reservas = await $.getJSON(this.routes.getReservas)

            if (reservas.length === 0) {
                html += `<tr><td colspan="6"><b>No hay reservas registradas</b></td></tr>`
            } else {
                for (let r of reservas) {
                    let estadoBadge = ''
                    switch (r.estado.toLowerCase()) {
                        case 'confirmado':
                            estadoBadge = `<span class="badge bg-success">Confirmado</span>`
                            break
                        case 'pendiente':
                            estadoBadge = `<span class="badge bg-warning text-dark">Pendiente</span>`
                            break
                        case 'cancelado':
                            estadoBadge = `<span class="badge bg-danger">Cancelado</span>`
                            break
                        default:
                            estadoBadge = `<span class="badge bg-secondary">${r.estado}</span>`
                            break
                    }

                    html += `
                        <tr>
                            <td>${r.id}</td>
                            <td>${r.nombre}</td>
                            <td>${r.mesa}</td>
                            <td>${r.fecha}</td>
                            <td>${r.personas}</td>
                            <td>${estadoBadge}</td>
                        </tr>`
                }
            }

            html += `</tbody>`
            this.$tablaReservas.html(html)

        } catch (err) {
            console.error('Error al obtener reservas:', err)
            this.$tablaReservas.html(`<tbody><tr><td colspan="6">Error al cargar las reservas</td></tr></tbody>`)
        }
    }
}

// Llamada automática al cargar la página
$(document).ready(function () {
    app.mostrarReservas()
})