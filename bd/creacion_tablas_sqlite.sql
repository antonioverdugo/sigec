-- ---------------------------------------
-- Script de creación de la base de datos SQLite
-- ---------------------------------------

PRAGMA foreign_keys = ON;

-- ---------------------------------------
-- CREAR TABLA rol_usuario
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS rol_usuario (
    id INTEGER NOT NULL,
    tipo TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- ---------------------------------------
-- CREAR TABLA usuario
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    id_rol INTEGER NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES rol_usuario(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ---------------------------------------
-- CREAR TABLA tipo_ponencia
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS tipo_ponencia (
    id INTEGER NOT NULL,
    nombre TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- ---------------------------------------
-- CREAR TABLA categoria
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS categoria (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL,
    descripcion TEXT
);

-- ---------------------------------------
-- CREAR TABLA ponencia
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS ponencia (
    id INTEGER PRIMARY KEY,
    titulo TEXT NOT NULL,
    url TEXT NOT NULL,
    id_usuario INTEGER NOT NULL,
    id_tipo_ponencia INTEGER NOT NULL,
    id_categoria INTEGER,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_tipo_ponencia) REFERENCES tipo_ponencia(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- ---------------------------------------
-- CREAR TABLA tipo_patrocinador
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS tipo_patrocinador (
    id INTEGER NOT NULL,
    nombre TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- ---------------------------------------
-- CREAR TABLA patrocinador
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS patrocinador (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL,
    telefono TEXT,
    cantidad_aportada REAL,
    id_tipo_patrocinador INTEGER NOT NULL,
    FOREIGN KEY (id_tipo_patrocinador) REFERENCES tipo_patrocinador(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
