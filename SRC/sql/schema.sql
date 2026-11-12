-- Esquema PostgreSQL para Biblioteca Digital
-- Ejecútalo en una base de datos PostgreSQL vacía.
-- Ejemplo:
-- CREATE DATABASE biblioteca_digital;

BEGIN;

CREATE TABLE IF NOT EXISTS roles (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS usuarios (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    rol_id BIGINT NOT NULL REFERENCES roles(id),
    activo BOOLEAN NOT NULL DEFAULT TRUE,
    fecha_registro TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    avatar_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS perfiles_usuario (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL UNIQUE REFERENCES usuarios(id) ON DELETE CASCADE,
    tipo_membresia VARCHAR(50) NOT NULL DEFAULT 'Estándar',
    fecha_ingreso DATE,
    puntos INTEGER NOT NULL DEFAULT 0,
    nivel INTEGER NOT NULL DEFAULT 1,
    bio TEXT
);

CREATE TABLE IF NOT EXISTS categorias (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS autores (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    nacionalidad VARCHAR(100),
    bio TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS libros (
    id BIGSERIAL PRIMARY KEY,
    isbn VARCHAR(20) UNIQUE,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    portada_url VARCHAR(255),
    categoria_id BIGINT REFERENCES categorias(id),
    autor_id BIGINT REFERENCES autores(id),
    anio_publicacion INTEGER,
    edad_recomendada INTEGER,
    destacado BOOLEAN NOT NULL DEFAULT FALSE,
    disponible BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS copias_libro (
    id BIGSERIAL PRIMARY KEY,
    libro_id BIGINT NOT NULL REFERENCES libros(id) ON DELETE CASCADE,
    codigo_barras VARCHAR(100) NOT NULL UNIQUE,
    estado VARCHAR(30) NOT NULL DEFAULT 'disponible' CHECK (estado IN ('disponible', 'prestado', 'reservado', 'deteriorado', 'en_reparacion')),
    ubicacion VARCHAR(150),
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS prestamos (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios(id),
    copia_id BIGINT NOT NULL REFERENCES copias_libro(id),
    fecha_prestamo TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    fecha_limite TIMESTAMPTZ NOT NULL,
    fecha_devolucion TIMESTAMPTZ,
    estado VARCHAR(20) NOT NULL DEFAULT 'activo' CHECK (estado IN ('activo', 'devuelto', 'atrasado', 'renovado')),
    observaciones TEXT
);

CREATE TABLE IF NOT EXISTS reservas (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios(id),
    libro_id BIGINT NOT NULL REFERENCES libros(id),
    fecha_reserva TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    estado VARCHAR(20) NOT NULL DEFAULT 'pendiente' CHECK (estado IN ('pendiente', 'confirmada', 'cancelada', 'entregada'))
);

CREATE TABLE IF NOT EXISTS favoritos (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    libro_id BIGINT NOT NULL REFERENCES libros(id) ON DELETE CASCADE,
    fecha_agregado TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    UNIQUE (usuario_id, libro_id)
);

CREATE TABLE IF NOT EXISTS noticias (
    id BIGSERIAL PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_publicacion TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    categoria VARCHAR(100),
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS juegos (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    url_juego VARCHAR(255),
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS progreso_juegos (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios(id),
    juego_id BIGINT NOT NULL REFERENCES juegos(id),
    nivel_actual INTEGER NOT NULL DEFAULT 1,
    puntuacion INTEGER NOT NULL DEFAULT 0,
    precision NUMERIC(5,2) NOT NULL DEFAULT 0.00,
    wpm INTEGER NOT NULL DEFAULT 0,
    libros_recogidos INTEGER NOT NULL DEFAULT 0,
    actualizado_en TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    UNIQUE (usuario_id, juego_id)
);

CREATE TABLE IF NOT EXISTS preguntas_trivia (
    id BIGSERIAL PRIMARY KEY,
    categoria_id BIGINT REFERENCES categorias(id),
    enunciado TEXT NOT NULL,
    opcion_a VARCHAR(255) NOT NULL,
    opcion_b VARCHAR(255) NOT NULL,
    opcion_c VARCHAR(255) NOT NULL,
    opcion_d VARCHAR(255) NOT NULL,
    respuesta_correcta CHAR(1) NOT NULL,
    dificultad VARCHAR(20) NOT NULL DEFAULT 'media'
);

CREATE TABLE IF NOT EXISTS respuestas_trivia (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios(id),
    pregunta_id BIGINT NOT NULL REFERENCES preguntas_trivia(id),
    respuesta_seleccionada CHAR(1) NOT NULL,
    es_correcta BOOLEAN NOT NULL DEFAULT FALSE,
    fecha_respuesta TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS eventos_biblioteca (
    id BIGSERIAL PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    fecha_evento TIMESTAMPTZ NOT NULL,
    ubicacion VARCHAR(200),
    activo BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS notificaciones (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL REFERENCES usuarios(id),
    tipo VARCHAR(50) NOT NULL,
    mensaje TEXT NOT NULL,
    leida BOOLEAN NOT NULL DEFAULT FALSE,
    fecha_creacion TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

INSERT INTO roles (nombre, descripcion) VALUES
    ('administrador', 'Gestión completa del sistema y recursos bibliotecarios'),
    ('bibliotecario', 'Administración de catálogo, préstamos y reservas'),
    ('usuario', 'Acceso a catálogo, perfil, prestamos y actividades')
ON CONFLICT (nombre) DO NOTHING;

INSERT INTO categorias (nombre, descripcion, slug) VALUES
    ('Literatura Infantil', 'Libros dirigidos a la lectura inicial y escolar', 'literatura-infantil'),
    ('Ciencia y Naturaleza', 'Recursos de astronomía, biología y medio ambiente', 'ciencia-naturaleza'),
    ('Historia', 'Material documental y narrativa histórica', 'historia'),
    ('Tecnología', 'Temas educativos digitales y computación', 'tecnologia')
ON CONFLICT (nombre) DO NOTHING;

INSERT INTO juegos (nombre, tipo, descripcion, url_juego, activo) VALUES
    ('Mecanografía Infantil', 'educativo', 'Juego para reforzar la rapidez y precisión al escribir', 'juego_de_mecanograf_a_infantil/code.html', TRUE),
    ('Trivia de libros', 'quiz', 'Evaluación de lectura y conocimiento literario', 'trivia_de_libros_infantil/code.html', TRUE)
ON CONFLICT DO NOTHING;

COMMIT;
