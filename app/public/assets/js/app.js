const app = {
  routes: {
    getReservas: "/Reservas/getReservas",
    createReserva: "/Reservas/create",
    updateReserva: "/Reservas/update",
    deleteReserva: "/Reservas/delete",
    getUsuarios: "/Reservas/getUsuarios",
    getMesas: "/Reservas/getMesasDisponibles"
  },
  
  $tablaReservas: $("#tabla-reservas"),
  
  // Inicializar la aplicación
  init: function() {
    this.mostrarReservas();
    this.cargarUsuarios();
    this.cargarMesasDisponibles();
    this.setupEventListeners();
  },
  
  // Configurar event listeners
  setupEventListeners: function() {
    // Filtros
    $("#filtro-estado, #filtro-fecha, #filtro-usuario").on("change keyup", this.filtrarReservas.bind(this));
    
    // Botón agregar reserva
    $("#btnAgregarReserva").on("click", () => {
      $("#modalAgregarReserva").modal("show");
    });
    
    // Formulario agregar reserva
    $("#formAgregarReserva").on("submit", this.agregarReserva.bind(this));
    
    // Formulario editar reserva
    $("#formEditarReserva").on("submit", this.editarReserva.bind(this));
    
    // Botón confirmar eliminación
    $("#btn-confirmar-eliminar").on("click", this.eliminarReservaConfirmada.bind(this));
  },

   // Añade estas funciones:
  cargarUsuarios: async function() {
    try {
      const response = await $.getJSON(this.routes.getUsuarios);
      let options = '<option value="">Seleccione un usuario</option>';
      
      response.forEach(usuario => {
        options += `<option value="${usuario.id}">${usuario.nombre}</option>`;
      });
      
      $("#agregar-usuario, #editar-usuario").html(options);
    } catch (err) {
      console.error("Error al cargar usuarios:", err);
      showAlert("Error al cargar la lista de usuarios", "danger");
    }
  },
  
  cargarMesasDisponibles: async function() {
    try {
      const response = await $.getJSON(this.routes.getMesas);
      let options = '<option value="">Seleccione una mesa</option>';
      
      response.forEach(mesa => {
        options += `<option value="${mesa.id}" data-capacidad="${mesa.capacidad}">
                     Mesa ${mesa.numero} (Capacidad: ${mesa.capacidad})
                   </option>`;
      });
      
      $("#agregar-mesa, #editar-mesa").html(options);
      
      // Actualizar capacidad máxima cuando se selecciona una mesa
      $("#agregar-mesa, #editar-mesa").on("change", function() {
        const capacidad = $(this).find("option:selected").data("capacidad");
        $("#agregar-personas, #editar-personas").attr("max", capacidad);
      });
    } catch (err) {
      console.error("Error al cargar mesas:", err);
      showAlert("Error al cargar la lista de mesas", "danger");
    }
  },
  
  // Mostrar reservas en la tabla
  mostrarReservas: async function(reservas = null) {
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

      if (!reservas) {
        reservas = await $.getJSON(this.routes.getReservas);
      }

      if (!reservas || reservas.length === 0) {
        html += `<tr><td colspan="7"><b>No hay reservas registradas</b></td></tr>`;
      } else {
        for (let r of reservas) {
          const estado = r.estado || "";
          const nombreUsuario = r.nombre_usuario || "Desconocido";
          const numeroMesa = r.numero_mesa || "N/A";

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
              <td>${numeroMesa}</td>
              <td>${r.fecha_hora_reserva}</td>
              <td>${r.cantidad_personas} ${r.cantidad_personas == 1 ? "persona" : "personas"}</td>
              <td>${estadoBadge}</td>
              <td>
                <button 
                  class="btn btn-sm btn-outline-primary editar-reserva" 
                  data-bs-toggle="modal" 
                  data-bs-target="#modalEditarReserva"
                  data-id="${r.reserva_id}"
                  data-usuario="${r.usuario_id}"
                  data-mesa="${r.mesa_id}"
                  data-fecha="${r.fecha_hora_reserva}" 
                  data-personas="${r.cantidad_personas}" 
                  data-estado="${r.estado}"
                  title="Editar">
                  <i class="mdi mdi-pencil"></i>
                </button>
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
      
      // Configurar eventos para los botones de edición y eliminación
      $(document).on("click", ".editar-reserva", this.cargarDatosEdicion.bind(this));
      $(document).on("click", ".eliminar-reserva", this.mostrarConfirmacionEliminar.bind(this));
      
    } catch (err) {
      console.error("Error al obtener reservas:", err);
      this.$tablaReservas.html(
        `<tbody><tr><td colspan="7">Error al cargar las reservas</td></tr></tbody>`
      );
    }
  },
  
  // Filtrar reservas
  filtrarReservas: function() {
    const estado = $("#filtro-estado").val();
    const fecha = $("#filtro-fecha").val();
    const usuario = $("#filtro-usuario").val();
    
    const params = new URLSearchParams();
    if (estado) params.append('estado', estado);
    if (fecha) params.append('fecha', fecha);
    if (usuario) params.append('usuario', usuario);
    
    const url = `${this.routes.getReservas}?${params.toString()}`;
    
    $.getJSON(url)
      .done(data => {
        this.mostrarReservas(data);
      })
      .fail(err => {
        console.error("Error al filtrar reservas:", err);
        showAlert("Error al aplicar filtros", "danger");
      });
  },
  
  // Cargar datos para edición
  cargarDatosEdicion: function(e) {
    const button = $(e.currentTarget);
    const fechaFormateada = button.data("fecha").replace(" ", "T");
    
    $("#editar-id").val(button.data("id"));
    $("#editar-usuario").val(button.data("usuario"));
    $("#editar-mesa").val(button.data("mesa"));
    $("#editar-fecha").val(fechaFormateada);
    $("#editar-personas").val(button.data("personas"));
    $("#editar-estado").val(button.data("estado"));
  },
  
  // Mostrar confirmación para eliminar
  mostrarConfirmacionEliminar: function(e) {
    const reservaId = $(e.currentTarget).data("id");
    $("#reserva-id-eliminar").val(reservaId);
    $("#modalConfirmarEliminar").modal("show");
  },
  
  // Eliminar reserva confirmada
  eliminarReservaConfirmada: function() {
    const reservaId = $("#reserva-id-eliminar").val();
    
    $.ajax({
      url: `${this.routes.deleteReserva}/${reservaId}`,
      type: "DELETE",
      dataType: "json"
    })
    .done(response => {
      if (response.success) {
        $("#modalConfirmarEliminar").modal("hide");
        this.mostrarReservas();
        showAlert(response.message || "Reserva eliminada correctamente", "success");
      } else {
        showAlert(response.error || "Error al eliminar reserva", "danger");
      }
    })
    .fail(xhr => {
      console.error("Error:", xhr.responseText);
      showAlert("Error al eliminar la reserva", "danger");
    });
  },
  
  // Agregar nueva reserva
  agregarReserva: function(e) {
    e.preventDefault();
    
    const fechaFormateada = $("#agregar-fecha").val().replace("T", " ");
    
    const formData = {
      usuario: $("#agregar-usuario").val(),
      mesa: $("#agregar-mesa").val(),
      fecha: fechaFormateada,
      personas: $("#agregar-personas").val(),
      estado: $("#agregar-estado").val()
    };

    $.ajax({
      url: this.routes.createReserva,
      type: "POST",
      data: formData,
      dataType: "json"
    })
    .done(response => {
      if (response.success) {
        $("#modalAgregarReserva").modal("hide");
        $("#formAgregarReserva")[0].reset();
        this.mostrarReservas();
        showAlert(response.message || "Reserva creada correctamente", "success");
      } else {
        showAlert(response.error || "Error al crear reserva", "danger");
      }
    })
    .fail(xhr => {
      console.error("Error:", xhr.responseText);
      let errorMsg = "Error en la solicitud";
      try {
        const response = JSON.parse(xhr.responseText);
        errorMsg = response.error || errorMsg;
        if (response.details) errorMsg += `: ${response.details}`;
      } catch (e) {}
      showAlert(errorMsg, "danger");
    });
  },
  
  // Editar reserva existente
  editarReserva: function(e) {
    e.preventDefault();
    
    const fechaFormateada = $("#editar-fecha").val().replace("T", " ");
    
    const formData = {
      id: $("#editar-id").val(),
      usuario: $("#editar-usuario").val(),
      mesa: $("#editar-mesa").val(),
      fecha: fechaFormateada,
      personas: $("#editar-personas").val(),
      estado: $("#editar-estado").val()
    };

    $.ajax({
      url: this.routes.updateReserva,
      type: "POST",
      data: formData,
      dataType: "json"
    })
    .done(response => {
      if (response.success) {
        $("#modalEditarReserva").modal("hide");
        this.mostrarReservas();
        showAlert(response.message || "Reserva actualizada correctamente", "success");
      } else {
        showAlert(response.error || "Error al actualizar reserva", "danger");
      }
    })
    .fail(xhr => {
      console.error("Error:", xhr.responseText);
      let errorMsg = "Error en la solicitud";
      try {
        const response = JSON.parse(xhr.responseText);
        errorMsg = response.error || errorMsg;
        if (response.details) errorMsg += `: ${response.details}`;
      } catch (e) {}
      showAlert(errorMsg, "danger");
    });
  }
};

// Función para mostrar alertas
function showAlert(message, type = "info") {
  const alertPlaceholder = $("#alert-placeholder");
  const wrapper = document.createElement("div");
  wrapper.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>`;
  
  alertPlaceholder.append(wrapper);
  
  // Eliminar la alerta después de 5 segundos
  setTimeout(() => {
    wrapper.remove();
  }, 5000);
}

// Inicializar la aplicación cuando el documento esté listo
$(document).ready(function() {
  app.init();
});