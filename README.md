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
sistema_de_reservas/
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── public/
│   │   └── assets/imgs/
│   └── ...
├── database/
│   └── reservas.sql
├── index.php
├── .htaccess
└── README.md
```