# Coordinacion Academica - CMS PHP

Sitio institucional para la Coordinacion Academica, dependiente de la Subsecretaria de Educacion Basica de SEPyC Sinaloa.

## Requisitos

- PHP 7.4 o superior
- MySQL o MariaDB
- Servidor Apache con soporte PHP

## Instalacion rapida

1. Crea una base de datos MySQL, por ejemplo `coordinacion_academica`.
2. Importa el archivo `database/coordinacion_academica.sql`.
3. Copia `includes/config.example.php` como `includes/config.php`.
4. Edita `includes/config.php` con tus datos de conexion.
5. Asegura permisos de escritura para la carpeta `uploads/`.
6. Abre el sitio en el navegador.

## Acceso al CMS

URL: `/admin/login.php`

Usuario inicial: `admin`

Contrasena inicial: `admin123`

Cambia la contrasena desde el servidor o crea otro usuario desde la base de datos antes de publicar el sitio.

## Secciones editables

- Configuracion general del sitio
- Menu principal
- Banner principal
- Accesos rapidos
- Noticias
- Comunicados y convocatorias
- Documentos descargables
- Paginas internas
- Fechas importantes
- Enlaces institucionales
- Usuarios administradores

## Colores base

La interfaz usa una linea institucional inspirada en los materiales de SEPyC enviados como referencia visual:

- Guinda: `#9d2449`
- Guinda oscuro: `#6f1230`
- Turquesa: `#1aa6a1`
- Dorado: `#bda468`
- Verde institucional: `#185d4b`
- Fondo calido: `#f7f3ed`

