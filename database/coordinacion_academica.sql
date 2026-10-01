CREATE DATABASE IF NOT EXISTS coordinacion_academica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE coordinacion_academica;

CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(80) NOT NULL DEFAULT 'general',
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    label VARCHAR(160) NOT NULL,
    setting_value TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE menu_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(120) NOT NULL,
    url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE slides (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(220) NOT NULL,
    subtitle TEXT NULL,
    button_text VARCHAR(80) NULL,
    button_url VARCHAR(255) NULL,
    image VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE quick_links (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(160) NOT NULL,
    url VARCHAR(255) NOT NULL,
    color VARCHAR(20) NOT NULL DEFAULT '#9d2449',
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('noticia','comunicado','convocatoria') NOT NULL DEFAULT 'noticia',
    body TEXT NULL,
    image VARCHAR(255) NULL,
    published_at DATETIME NOT NULL,
    status ENUM('published','draft') NOT NULL DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE documents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    file_path VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    body TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    description TEXT NULL,
    event_date DATE NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE allies (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(180) NOT NULL,
    url VARCHAR(255) NOT NULL DEFAULT '#',
    image VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO settings (group_name, setting_key, label, setting_value) VALUES
('general','site_name','Nombre del sitio','Coordinacion Academica'),
('general','site_description','Descripcion SEO','Sitio oficial de la Coordinacion Academica de la Subsecretaria de Educacion Basica de Sinaloa.'),
('general','email','Correo','coordinacion.academica@sepyc.gob.mx'),
('general','phone','Telefono','(667) 000 0000'),
('general','address','Direccion','Blvd. Pedro Infante Cruz 2200 Pte. Col. Recursos Hidraulicos, Culiacan, Sinaloa. C.P. 80105.'),
('general','facebook_url','Facebook','#'),
('general','youtube_url','YouTube','#'),
('general','x_url','X','#'),
('calendario','calendar_title','Titulo calendario','Calendario Escolar 2026-2027'),
('calendario','calendar_text','Texto calendario','de Educacion Basica vigente para las escuelas publicas y particulares incorporadas al Sistema Educativo Nacional.'),
('calendario','calendar_url','Liga calendario','documentos.php'),
('calendario','calendar_image','Imagen calendario',''),
('footer','footer_department','Dependencia footer','Secretaria de Educacion Publica y Cultura'),
('footer','footer_title','Titulo footer','Coordinacion Academica');

INSERT INTO menu_items (label, url, sort_order, is_active) VALUES
('Nosotros','nosotros.php',1,1),
('Noticias','noticias.php',2,1),
('Convocatorias','convocatorias.php',3,1),
('Documentos','documentos.php',4,1),
('Contacto','contacto.php',5,1);

INSERT INTO slides (title, subtitle, button_text, button_url, image, sort_order, is_active) VALUES
('Coordinacion Academica','Acompanamiento, materiales y seguimiento academico para fortalecer la Educacion Basica en Sinaloa.','Conocer mas','nosotros.php',NULL,1,1),
('Recursos para la comunidad educativa','Consulta comunicados, calendarios, documentos y acciones academicas de la Subsecretaria de Educacion Basica.','Ver documentos','documentos.php',NULL,2,1);

INSERT INTO quick_links (title, url, color, sort_order, is_active) VALUES
('Educacion Basica','pagina.php?slug=educacion-basica','#1aa6a1',1,1),
('Planeacion Academica','pagina.php?slug=planeacion-academica','#bda468',2,1),
('Materiales Educativos','documentos.php','#b13d51',3,1),
('Acompanamiento Escolar','pagina.php?slug=acompanamiento-escolar','#185d4b',4,1),
('Servicios Administrativos','contacto.php','#9d2449',5,1);

INSERT INTO posts (title, slug, type, body, image, published_at, status) VALUES
('Arrancan acciones academicas para fortalecer los aprendizajes','arrancan-acciones-academicas','noticia','La Coordinacion Academica impulsa estrategias de acompanamiento pedagogico, seguimiento y mejora continua para las escuelas de Educacion Basica en Sinaloa.',NULL,'2026-09-28 09:00:00','published'),
('Sesion de trabajo con equipos tecnico pedagogicos','sesion-equipos-tecnico-pedagogicos','noticia','Autoridades educativas y equipos academicos revisaron lineas de accion para favorecer comunidades escolares organizadas, participativas y enfocadas en el aprendizaje.',NULL,'2026-09-27 09:00:00','published'),
('Materiales de apoyo para el ciclo escolar 2026-2027','materiales-apoyo-ciclo-2026-2027','noticia','Ya se encuentran disponibles materiales de consulta para directivos, docentes y figuras de acompanamiento academico.',NULL,'2026-09-25 09:00:00','published'),
('Comunicado sobre calendario de actividades academicas','comunicado-calendario-actividades','comunicado','Se informa a la comunidad educativa el calendario de actividades academicas correspondientes al periodo vigente.',NULL,'2026-09-20 09:00:00','published'),
('Convocatoria para registro de proyectos escolares','convocatoria-proyectos-escolares','convocatoria','La Coordinacion Academica invita a registrar proyectos escolares orientados a la mejora de los aprendizajes y la convivencia escolar.',NULL,'2026-09-18 09:00:00','published'),
('Circular de seguimiento academico','circular-seguimiento-academico','comunicado','Circular dirigida a supervisiones escolares, direcciones y colectivos docentes para el seguimiento academico institucional.',NULL,'2026-09-15 09:00:00','published');

INSERT INTO documents (title, description, file_path, sort_order, is_active) VALUES
('Calendario Escolar 2026-2027','Calendario de Educacion Basica para escuelas publicas y particulares incorporadas.',NULL,1,1),
('Formato de seguimiento academico','Documento editable para registrar avances y acuerdos de acompanamiento.',NULL,2,1),
('Lineamientos de trabajo academico','Guia de referencia para actividades, reuniones y procesos de seguimiento.',NULL,3,1);

INSERT INTO pages (title, slug, body, is_active) VALUES
('Nosotros','nosotros','La Coordinacion Academica depende de la Subsecretaria de Educacion Basica y contribuye al fortalecimiento de los procesos pedagogicos, la planeacion academica, la orientacion institucional y el acompanamiento a escuelas, zonas y sectores educativos en el estado de Sinaloa.\n\nSu trabajo se enfoca en organizar recursos, comunicar lineas de accion, facilitar materiales y dar seguimiento a estrategias que favorecen el aprendizaje, la convivencia escolar y la mejora continua.',1),
('Educacion Basica','educacion-basica','Espacio dedicado a informacion, orientaciones y recursos relacionados con preescolar, primaria y secundaria.',1),
('Planeacion Academica','planeacion-academica','Seccion para consultar acciones de planeacion, seguimiento y organizacion academica.',1),
('Acompanamiento Escolar','acompanamiento-escolar','Informacion sobre procesos de apoyo pedagogico y seguimiento a escuelas de Educacion Basica.',1);

INSERT INTO events (title, description, event_date, is_active) VALUES
('Dia Internacional de la Paz','Actividad para promover convivencia, respeto y cultura de paz en las escuelas.','2026-09-21',1),
('Dia Internacional de la No Violencia','Jornada de reflexion y materiales para comunidades educativas.','2026-10-02',1),
('Consejo Tecnico Escolar','Sesion ordinaria de Consejo Tecnico Escolar.','2026-10-30',1),
('Dia de los Derechos Humanos','Recursos para trabajar valores, inclusion y participacion escolar.','2026-12-10',1),
('Dia Escolar de la No Violencia y la Paz','Actividades sugeridas para aulas y colectivos docentes.','2027-01-30',1),
('Dia Internacional de la Mujer y la Nina en la Ciencia','Materiales para fortalecer vocaciones cientificas y equidad.','2027-02-11',1);

INSERT INTO allies (name, url, image, sort_order, is_active) VALUES
('ISDE','#',NULL,1,1),
('UPES','#',NULL,2,1),
('COBAES','#',NULL,3,1),
('ICATSIN','#',NULL,4,1),
('Instituto Sinaloense de la Juventud','#',NULL,5,1);

INSERT INTO users (name, username, password_hash, is_active) VALUES
('Administrador','admin','240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9',1);

