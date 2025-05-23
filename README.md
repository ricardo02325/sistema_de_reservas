# Sistema de reservas

![Logo](app/public/assets/imgs/logo.jpeg)

**Sitema de reservas** es una aplicación web para consultar, eliminar, modificar, añadir reservas.

## Características principales
- Consultar las reservas
- Consultar las mesas del restaurante
- Eliminar reservas
- Modificar las reservas
- Añadir las reservas

## Instalación

### 1. Clona el repositorio
```bash
git clone https://github.com/elizaldi14/HydroByte.git
```

<!-- ## Estructura del proyecto
```
HydroByte/
├── app/
│   ├── main_window.py
│   ├── widgets/
│   │   ├── sensor_card.py
│   │   ├── chart_widget.py
│   │   ├── sidebar.py
│   │   └── ...
│   └── ...
├── utils/
│   └── img/
│       ├── logo_pi.png
│       └── logo_pi.ico
├── main.py
├── requirements.txt
└── README.md
``` -->

<!-- ## Documentación rápida
- **main.py:** Punto de entrada de la app.
- **app/main_window.py:** Lógica principal y gestión de temas.
- **app/widgets/**: Componentes visuales reutilizables (cards, sidebar, charts, etc).
- **utils/img/**: Recursos gráficos (íconos y logos). -->

<!-- ## Personalización
- Cambia el logo en `utils/img/logo_pi.png` y/o `logo_pi.ico`.
- Modifica los temas en `theme_manager.py`. -->


# Documentación Técnica

## Estructura de la Interfaz
- **Sidebar:** Barra lateral con navegación y submenús para gráficas.
- **SensorCard:** Tarjetas para mostrar datos de sensores, rango óptimo y estado (Activo/Inactivo).
- **ChartWidget:** Gráficas interactivas para cada sensor.
- **Alertas:** Cards y tabla con alertas recientes.