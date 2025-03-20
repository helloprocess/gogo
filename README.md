Menéame
=======

Source code for the social aggregator https://www.meneame.net (central repository) 
/etc/php/8.1/cli/php.ini

📁 meneame_project/        # Directorio raíz del proyecto
│
├── 📁 www/               # Código fuente de la aplicación (document root)
│   ├── 📁 api/  
│   ├── 📁 backend/
│   ├── 📁 css/
│   ├── 📁 fonts/
│   ├── 📁 img/
│   ├── 📁 js/
│   ├── 📁 libs/
│   ├── 📁 submit/
│   ├── 📁 templates/
│   ├── 📁 user/
│   ├── 📜 .htaccess
│   ├── 📜 index.php
│   ├── 📜 config.php
│   ├── 📜 dispatcher.php
│   ├── 📜 router.php
│   ├── 📜 login.php
│   ├── 📜 register.php
│   ├── 📜 search.php
│   ├── 📜 values.php
│   ├── 📜 story.php
│   ├── 📜 rss2.php
│   ├── 📜 topstories.php
│   ├── 📜 sitemap.php
│   └── 📜 etc...
│
├── 📁 docker/             # Configuración de Docker
│   ├── 📜 Dockerfile      # Archivo Docker para PHP
│   ├── 📜 php.ini         # Configuración de PHP
│   ├── 📜 xdebug.ini      # Configuración de Xdebug
│   ├── 📜 nginx.conf      # Configuración de Nginx
│   └── 📜 .env            # Variables de entorno opcionales
│
├── 📁 sql/                # Base de datos
│   ├── 📜 meneame.sql     # Archivo con la estructura de la base de datos
│
├── 📁 scripts/            # Scripts útiles (migraciones, backups, cron jobs, etc.)
│
├── 📁 vendor/             # Dependencias de Composer
│
├── 📜 docker-compose.yml  # Definición de servicios de Docker
├── 📜 README.md           # Documentación del proyecto
├── 📜 composer.json       # Definición de paquetes PHP
├── 📜 composer.lock       # Estado actual de las dependencias
└── 📜 .gitignore          # Ignorar archivos innecesarios en el repo

Colores Base

Fondo oscuro principal: #121212

Texto claro: #ddd

Texto secundario/deshabilitado: #aaa, #ccc

Blanco puro: #fff

Acentos Principales

Naranja primario: #e35614

Naranja hover/botones: #ff8c40

Naranja alternativo: #ff9400

Rojo/alertas: #c91223

Grises y Fondos Secundarios

Gris muy oscuro: #101010

Gris oscuro (inputs/paneles): #1e1e1e

Gris medio (bordes/menús): #2a2a2a, #444

Gris deshabilitado: #333

Gris paneles: #3c3c3c

Enlaces y Elementos Interactivos

Enlaces normales: #66aaff (azul claro)

Enlaces visitados: #9a80d4 (lavanda)

Botones sociales:

Facebook: #3b5998

Twitter: #55acee

WhatsApp: #4dc247

Email: #7b6663

Elementos Especiales

Destacados/comentarios: #adcedf (azul pastel)

Advertencias: #FEFBEA (amarillo claro)

Promocionados: #8AAED9 (azul claro)

Sombras/números: #FFB600 (dorado)

Degradados y Variantes

Botón "Menealo":

Base: #e35614

Degradado: linear-gradient(-180deg, #F5720E 0%, #FE4A00 100%)

Base Oscura:
- #121212 (fondo principal)
- #1e1e1e (paneles/inputs)
- #2a2a2a (barras de menú)

Acentos Cálidos:
- #e35614 🟧 (principal)
- #ff8c40 🟠 (hover)
- #c91223 🔴 (alertas)

Textos:
- #ddd ⚪ (principal)
- #ccc ⚪ (secundario)
- #aaa ⚪ (terciario)

Enlaces:
- #66aaff 🔵 (normal)
- #9a80d4 🟣 (visitado)

Elementos UI:
- #444 🩶 (bordes)
- #333 🩶 (deshabilitado)
- #3c3c3c 🩶 (fondos)