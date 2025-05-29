# Sistema de reservas

![Logo](app/public/assets/imgs/logo.jpeg)

**Sistema de reservas** es una aplicación web para consultar, eliminar, modificar y añadir reservas en un restaurante. Este sistema busca reemplazar procesos manuales (libretas, hojas de cálculo) con una plataforma web sencilla y eficiente.

---

## Características principales

- Consultar las reservas existentes
- Consultar las mesas disponibles
- Eliminar reservas
- Modificar reservas
- Añadir nuevas reservas

---

## Instalación

### 1. Clona el repositorio
```bash
git clone https://github.com/ricardo02325/sistema_de_reservas.git
```

### 2. Configura un host virtual en XAMPP (Windows)

#### 🧰 Paso 1: Mueve el proyecto a `htdocs`
Coloca la carpeta clonada (`sistema_de_reservas`) dentro de:
```
C:\xampp\htdocs
```

#### 🧰 Paso 2: Edita `httpd-vhosts.conf`
Ubicación:
```
C:\xampp\apache\conf\extra\httpd-vhosts.conf
```

Agrega al final:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/sistema_de_reservas"
    ServerName reservas.local
    <Directory "C:/xampp/htdocs/sistema_de_reservas">
        Options Indexes FollowSymLinks Includes ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### 🧰 Paso 3: Activa `httpd-vhosts.conf`
Archivo:
```
C:\xampp\apache\conf\httpd.conf
```

Busca la línea:
```apache
#Include conf/extra/httpd-vhosts.conf
```

Y descoméntala:
```apache
Include conf/extra/httpd-vhosts.conf
```

#### 🧰 Paso 4: Edita el archivo `hosts` de Windows
Ubicación:
```
C:\Windows\System32\drivers\etc\hosts
```

Abre el archivo con Bloc de notas como administrador y agrega esta línea:
```
127.0.0.1    reservas.local
```

#### 🧰 Paso 5: Reinicia Apache desde XAMPP
Desde el Panel de Control de XAMPP, reinicia Apache (Stop y luego Start).

#### 🧰 Paso 6: Accede al sistema
Abre tu navegador y visita:
```
http://reservas.local
```

---

### 3. Configura la base de datos

#### 📦 Paso 1: Abre **phpMyAdmin**
Accede desde:
```
http://localhost/phpmyadmin
```

#### 📂 Paso 2: Crea una base de datos
- Nombre sugerido: `sistema_reservas`

#### 🧾 Paso 3: Importa el archivo `.sql`
1. En phpMyAdmin, selecciona la base de datos `sistema_reservas`.
2. Haz clic en la pestaña **Importar**.
3. Selecciona el archivo SQL incluido en el proyecto (por ejemplo: `database/reservas.sql`).
4. Haz clic en **Continuar**.

---

## Documentación Técnica

### Estructura del Proyecto
```
Sistema_de_reservas/
├── app/                             # Contiene la lógica principal de la aplicación
│   ├── classes/                     # Clases generales y utilitarias del sistema
│   │   ├── Autoloader.php          # Carga automática de clases (autoload)
│   │   ├── DB.php                  # Clase para conexión y gestión de base de datos
│   │   ├── Router.php              # Gestión de rutas y controladores
│   │   └── View.php                # Renderizado de vistas
│   ├── controllers/                # Controladores que manejan la lógica entre vistas y modelos
│   │   ├── auth/                   # Controladores de autenticación
│   │   │   └── SessionController.php  # Controla el inicio, cierre y validación de sesiones
│   │   ├── Controller.php          # Clase base para otros controladores
│   │   ├── ErrorController.php     # Controlador para gestionar errores
│   │   ├── HomeController.php      # Controlador de la vista principal (inicio)
│   │   ├── PostsController.php     # Controlador de publicaciones o posts
│   │   └── ReservasController.php  # Controlador para el módulo de reservas
│   ├── models/                     # Modelos de la base de datos
│   │   ├── comments.php            # Modelo para comentarios
│   │   ├── interactions.php        # Modelo para interacciones entre usuarios
│   │   ├── Model.php               # Clase base para los modelos
│   │   ├── posts.php               # Modelo de publicaciones
│   │   ├── reservas.php            # Modelo para las reservas
│   │   └── user.php                # Modelo de usuarios
│   ├── views/                      # Vistas de la aplicación (interfaz de usuario)
│   │   ├── auth/                   # Vistas relacionadas con autenticación
│   │   │   └── inisession.view.php # Vista de inicio de sesión
│   │   ├── home.view.php           # Vista principal después de iniciar sesión
│   │   ├── app.php                 # Vista general de la aplicación
│   │   └── config.php              # Vista o configuración general de vistas
│   ├── layouts/                    # Plantillas reutilizables
│   │   ├── main_foot.php           # Pie de página común
│   │   └── main_head.php           # Encabezado común con HTML y CSS
│   ├── resources/                  # Funciones auxiliares o librerías adicionales
│   │   └── functions/
│   │       └── main_functions.php  # Funciones reutilizables en toda la app
│   └── public/                     # Archivos públicos accesibles desde el navegador
│       ├── assets/                 # Archivos estáticos como CSS, JS, imágenes
│       │   ├── css/
│       │   │   ├── bootstrap.css   # Estilos de Bootstrap
│       │   │   └── styles.css      # Estilos personalizados
│       │   ├── imgs/
│       │   │   └── logo.jpeg       # Logo del sistema
│       │   └── js/
│       │       ├── app.js          # Scripts generales de la app
│       │       ├── bootstrap.js    # Scripts de Bootstrap
│       │       ├── jquery.js       # Biblioteca jQuery
│       │       ├── sidebar.js      # Script para barra lateral
│       │       └── sweetalert2.js  # Script de alertas estilizadas
│       ├── .htaccess               # Configuración de Apache para URLs amigables
│       └── index.php               # Punto de entrada de la aplicación
├── database/
│   └── reservas.sql                # Script de creación y datos de la base de datos
├── .htaccess                       # Configuración raíz para redirecciones y seguridad
└── README.md                       # Documentación del proyecto
```