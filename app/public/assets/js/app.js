const app = {
  routes: {
    getReservas: "/Reservas/getReservas",
  },
  user: {
    sv: false,
    id: "",
    username: "",
    tipo: "",
  },
  $pp: $("#prev-posts"),
  $lp: $("#content"),
  $tablaReservas: $("#tabla-reservas"),

  mostrarReservas: async function () {
    try {
      let html = `
            <thead class="table-dark">
                <tr>
                    <th>N° Reserva</th>
                    <th>Usuario</th>
                    <th>N° Mesa</th>
                    <th>Fecha</th>
                    <th>Personas</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>`;

      const reservas = await $.getJSON(this.routes.getReservas);
      console.log("🔍 Datos recibidos:", reservas);

      if (!reservas || reservas.length === 0) {
        html += `<tr><td colspan="7"><b>No hay reservas registradas</b></td></tr>`;
      } else {
        for (let r of reservas) {
          const estado = r.estado || "";
          const nombreUsuario = r.nombre_usuario || "Desconocido";

          let estadoBadge = "";
          switch (estado.toLowerCase()) {
            case "confirmada":
              estadoBadge = `<span class="badge bg-success">Confirmada</span>`;
              break;
            case "pendiente":
              estadoBadge = `<span class="badge bg-warning text-dark">Pendiente</span>`;
              break;
            case "cancelada":
              estadoBadge = `<span class="badge bg-danger">Cancelada</span>`;
              break;
            case "cumplida":
              estadoBadge = `<span class="badge bg-primary">Cumplida</span>`;
              break;
            case "no show":
              estadoBadge = `<span class="badge bg-dark">No show</span>`;
              break;
            case "en lista de espera":
              estadoBadge = `<span class="badge bg-info text-dark">En lista de espera</span>`;
              break;
            case "reprogramada":
              estadoBadge = `<span class="badge bg-secondary">Reprogramada</span>`;
              break;
            default:
              estadoBadge = `<span class="badge bg-light text-dark">${estado}</span>`;
              break;
          }

          html += `
                    <tr>
                        <td>${r.reserva_id}</td>
                        <td>${r.nombre_usuario}</td>
                        <td>${r.numero_mesa}</td>
                        <td>${r.fecha_hora_reserva}</td>
                        <td>${r.cantidad_personas}</td>
                        <td>${estadoBadge}</td>
                        <td>
                        <!-- Botón Editar -->
                        <button 
                            class="btn btn-sm btn-outline-primary editar-reserva" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalEditarReserva"
                            data-id="${r.reserva_id}" 
                            title="Editar">
                            <i class="mdi mdi-pencil"></i>
                        </button>

                        <!-- Botón Eliminar -->
                        <button 
                            class="btn btn-sm btn-outline-danger eliminar-reserva" 
                            data-id="${r.reserva_id}" 
                            title="Eliminar">
                            <i class="mdi mdi-delete"></i>
                        </button>

                        </td>
                    </tr>`;
        }
      }

      html += `</tbody>`;
      this.$tablaReservas.html(html);
    } catch (err) {
      console.error("Error al obtener reservas:", err);
      this.$tablaReservas.html(
        `<tbody><tr><td colspan="7">Error al cargar las reservas</td></tr></tbody>`
      );
    }
  },
};

$(document).ready(function () {
  app.mostrarReservas();
});
