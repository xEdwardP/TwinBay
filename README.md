## 🔥 TwinBay Parking 🔥

Sistema modular y escalable desarrollado en Laravel 12, diseñado para gestionar entradas, salidas y espacios de parqueo con precisión y eficiencia. TwinBay combina arquitectura limpia, componentes reutilizables y una interfaz intuitiva basada en Bootstrap 4.6 y AdminLTE3, ofreciendo una experiencia fluida tanto para usuarios como administradores.

---

## 🧰 Requisitos del Sistema

### 💻 Hardware:

- Procesador: Intel Core i3 / AMD Ryzen 3 o superior
- Memoria RAM: 4 GB mínimo
- Almacenamiento: 1 GB libre para proyecto y base de datos
- Conectividad: Acceso a internet para dependencias y envío de correos
- Resolución de pantalla: 1280x720 o superior

### 🧪 Software

- PHP 8.2 o superior
- Composer 2.x
- Node.js 18.x
- NPM 9.x
- MySQL 8.x o MariaDB compatible
- Apache o Nginx como servidor web
- Laravel 12
- Livewire 3
- Navegador moderno (Chrome, Firefox, Edge)

---

## 🛠 Instalación

### Clona el repositorio:

```bash
  https://github.com/xEdwardP/TwinBay.git
  cd TwinBay
```

### Instala dependencias:

```bash
  composer install
  npm install
```

### Configura tu archivo .env:

```bash
  cp .env.example .env
  php artisan key:generate
```

> [!IMPORTANT]
> Antes de ejecutar las migraciones con php artisan migrate, asegúrate de que la base de datos esté creada y accesible en tu servidor local o remoto.
> Luego, verifica que los datos de conexión estén correctamente configurados en tu archivo .env
> 

### Ejecuta migraciones y seeders:

```bash
  php artisan migrate --seed
```

### Ejecuta migraciones y seeders:

```bash
  php artisan serve
```

---

## ⚙ Variables de Entorno

Para ejecutar correctamente este proyecto, asegúrate de definir las siguientes variables en tu archivo .env:

- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=nombre_de_tu_bd`
- `DB_USERNAME=tu_usuario`
- `DB_PASSWORD=tu_contraseña`

- `API_KEY=tu_api_key_aqui`

Para habilitar el envio de correos electrónicos, configura tus credenciales SMTP en .env:

- `MAIL_MAILER=smtp`
- `MAIL_HOST=smtp.example.com`
- `MAIL_PORT=2525`
- `MAIL_USERNAME=tu_usuario`
- `MAIL_PASSWORD=tu_contraseña`
- `MAIL_FROM_ADDRESS="hello@example.com"`
- `MAIL_FROM_NAME="${APP_NAME}"`

---

## 🧱 Tecnologías utilizadas

- Laravel 12.x
- Livewire ^3.x
- Bootstrap 4.6x
- AdminLTE 3.x
- FontAwesome 5.x
- SweetAlert 2.x

---

## 🧠 Autor

- [@xedwardp](https://github.com/xEdwardP)

---

## 📄 Licencia

Este proyecto está bajo la licencia de [MIT](https://opensource.org/licenses/MIT).
