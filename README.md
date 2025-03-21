# Menéame 🗳️

Repositorio Dockerizado de Menéame, un agregador social de noticias de código abierto. Este proyecto incluye la infraestructura necesaria para levantar todo el sistema de forma automática y consistente mediante Docker y Docker Compose.

---

## 📦 Estructura del Proyecto

```
📁 meneame_project/
│
├── www/                  # Código fuente principal de Menéame
├── docker/               # Archivos de configuración de Docker
├── sql/                  # Dump inicial de la base de datos
├── scripts/              # Scripts adicionales (migraciones, backups, etc.)
├── vendor/               # Dependencias de Composer (ya incluidas)
├── docker-compose.yml    # Orquestación de contenedores
├── composer.json         # Dependencias PHP
├── php.ini               # Configuración de PHP
├── xdebug.ini            # Configuración de Xdebug
├── nginx.conf            # Configuración de Nginx
├── meneame_ER.pdf        # Diagrama Entidad-Relación de la base de datos
└── README.md             # Este documento
```

---

## ⚙️ Servicios Incluidos

| Servicio     | Descripción                                     |
|--------------|--------------------------------------------------|
| Nginx        | Servidor web reverse proxy para PHP              |
| PHP-FPM 8.3  | Ejecutor de código PHP con Xdebug y extensiones  |
| MySQL 8.0    | Base de datos relacional con carga automática    |
| phpMyAdmin   | Interfaz web para gestión de la base de datos    |
| Portainer    | Dashboard opcional para administrar contenedores |

---

## 🎨 Diseño y Colores Base

El diseño se basa en una interfaz oscura con acentos cálidos.  
Consulta el bloque de diseño de colores incluido en este mismo archivo si deseas personalizar el tema visual.

---

## 📥 Instalación del Proyecto

### 1. 🔧 Requisitos

- Ubuntu 20.04+ (o equivalente con soporte para systemd)
- Git
- Docker
- Docker Compose

---

### 2. 🐳 Instalar Docker y Docker Compose

```bash
apt update && apt upgrade -y
apt install -y docker.io

systemctl start docker
systemctl enable docker

curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Verificar instalación
docker --version
docker-compose --version
```

---

### 3. 📦 Clonar el repositorio

```bash
git clone https://github.com/helloprocess/gogo
cd gogo
```

---

### 4. 🚀 Levantar la aplicación

```bash
docker-compose up -d --build
```

Esto:
- Construye la imagen de PHP con las extensiones necesarias (incluido Xdebug, exif, etc).
- Inicializa MySQL y carga `meneame.sql`.
- Sirve la aplicación desde `http://localhost/` o la IP de tu servidor.

---

## 🧪 Comprobaciones útiles

- 🌐 Accede a la web: `http://localhost` o `http://<tu_droplet_ip>`
- 🧠 phpMyAdmin: `http://localhost:8080` (usuario `root`, contraseña `root`)
- ⚙️ Portainer: `https://localhost:9443` (interfaz de gestión opcional)
- 🔍 Verifica logs:
  ```bash
  docker logs meneame_php
  docker logs meneame_nginx
  ```

---

## 📁 Archivos importantes

- `docker/nginx.conf` – configuración optimizada de Nginx (PATH_INFO incluido).
- `docker/php.ini` – configuraciones de desarrollo y límites de carga ajustados.
- `docker/xdebug.ini` – configuración activa para debugging con VS Code.
- `sql/meneame.sql` – script que importa la base de datos inicial.
- `meneame_ER.pdf` – **Diagrama E-R** para entender la estructura de la base de datos.

---

## 🧠 Consideraciones técnicas

- `PATH_INFO` ha sido activado correctamente para `dispatcher.php`.
- Las cookies y recursos estáticos están resueltos con rutas relativas para evitar problemas con `localhost`.
- El contenedor PHP se ejecuta como root pero PHP-FPM como `www-data`, y se automatizan permisos de volúmenes con `entrypoint.sh`.
- Nginx acepta cualquier `server_name` gracias a `server_name _;`.

---

## 🔐 Seguridad

⚠️ Este entorno está preparado para desarrollo.  
**No lo utilices en producción tal cual** sin:
- HTTPS
- Restricción de puertos públicos (Xdebug, phpMyAdmin, Portainer)
- Contraseñas seguras y acceso limitado por firewall

---

## 📚 Créditos

Proyecto original: [meneame/meneame](https://github.com/meneame/meneame)  
Adaptación Dockerizada: [helloprocess/gogo](https://github.com/helloprocess/gogo)

---

## 📄 Licencia

Distribuido bajo la [Licencia Apache 2.0](http://www.apache.org/licenses/LICENSE-2.0)

---

## 💡 ¿Preguntas o sugerencias?

Crea un *issue* en el repositorio o abre un PR. ¡Gracias por contribuir!