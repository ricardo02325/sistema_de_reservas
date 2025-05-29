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
                  <th>Acciones 
                  <button onclick="mostrarModal()" 
                          class="btn btn-primary btn-sm rounded-circle"
                          title="Añadir nueva reserva"> + 
                  </button></th>
              </tr>
          </thead>
          <tbody>`;

      const reservas = await $.getJSON(this.routes.getReservas);
      console.log("🔍 Datos recibidos:", reservas);

      if (!reservas || reservas.length === 0) {
        html += `<tr><td colspan="7"><b>No hay reservas registradas</b></td></tr>`;
      } else {
        for (let r of reservas) {
          console.log(r); // ✅ Aquí sí

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
                      <td>${nombreUsuario}</td>
                      <td>${r.numero_mesa}</td>
                      <td>${r.fecha_hora_reserva}</td>
                      <td>${r.cantidad_personas} ${
            r.cantidad_personas == 1 ? "persona" : "personas"
          }</td>
                      <td>${estadoBadge}</td>
                      <td>
                        <button 
                          class="btn btn-sm btn-outline-primary editar-reserva" 
                          data-bs-toggle="modal" 
                          data-bs-target="#modalEditarReserva"
                          data-id="${r.reserva_id}"
                          data-fecha="${r.fecha_hora_reserva}" 
                          data-personas="${r.cantidad_personas}" 
                          data-estado="${r.estado}"
                          title="Editar">
                          <i class="mdi mdi-pencil"></i>
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