-- ----------------------------
-- 1. ROLES DE USUARIO
-- ----------------------------
INSERT INTO rol_usuario (id, tipo) VALUES
(1, 'Asistente'),
(2, 'Ponente'),
(3, 'Admin');

-- ----------------------------
-- 2. USUARIOS
-- ----------------------------
INSERT INTO usuario (nombre, email, password, id_rol) VALUES
('Ana García López', 'ana@info.com', '1234', 1),
('Carlos Martínez Ruiz', 'carlos@tech.com', '1234', 2),
('Lucía Fernández Díaz', 'lucia@cloud.com', '1234', 2),
('Pedro Sánchez Gómez', 'pedro@render.com', '1234', 3),
('Marta Jiménez Torres', 'marta@congreso.com', '1234', 3),
('David Romero Castillo', 'david@informatica.com', '1234', 2),
('Laura Navarro Pérez', 'laura@internet.com', '1234', 1);

-- ----------------------------
-- 3. TIPOS DE PONENCIA
-- ----------------------------
INSERT INTO tipo_ponencia (id, nombre) VALUES
(1, 'Poster'),
(2, 'Oral');

-- ----------------------------
-- 4. CATEGORIAS
-- ----------------------------
INSERT INTO categoria (nombre, descripcion) VALUES
('Inteligencia Artificial', 'Ponencias sobre IA y Machine Learning'),
('Ciberseguridad', 'Seguridad informática y protección de datos'),
('Desarrollo Web', 'Tecnologías y frameworks web'),
('Big Data', 'Análisis y gestión de grandes volúmenes de datos'),
('Robótica', 'Automatización y sistemas inteligentes');

-- ----------------------------
-- 5. PONENCIAS
-- ----------------------------
INSERT INTO ponencia (titulo, url, id_usuario, id_tipo_ponencia, id_categoria) VALUES
('Avances en Machine Learning', 'storage/ponencias/avances.pptx', 2, 2, 1),
('Seguridad en la Nube', 'storage/ponencias/seguridad.pptx', 3, 2, 2),
('Frameworks Modernos JS', 'storage/posters/frameworks.jpeg', 2, 1, 3),
('Análisis Predictivo con Big Data', 'storage/posters/analisis.jpeg', 4, 1, 4),
('Robots Autónomos', 'storage/ponencias/robots.pptx', 3, 2, 5),
('Tendencias Tecnológicas 2026', 'storage/ponencias/tendencias.pptx', 2, 2, NULL),
('Introducción a Python', 'storage/posters/python.jpeg', 5, 1, NULL);

-- ----------------------------
-- 6. TIPOS DE PATROCINADOR
-- ----------------------------
INSERT INTO tipo_patrocinador (id, nombre) VALUES
(1, 'Oro'),
(2, 'Plata'),
(3, 'Bronce'),
(4, 'Colaborador'),
(5, 'Institucional');

-- ----------------------------
-- 7. PATROCINADORES
-- ----------------------------
INSERT INTO patrocinador (nombre, telefono, cantidad_aportada, id_tipo_patrocinador) VALUES
('TechCorp', '600111222', 10000.00, 1),
('SecureIT', '600222333', 7000.00, 2),
('WebSolutions', '600333444', 4000.00, 3),
('DataWorld', '600444555', 8500.00, 2),
('RoboTech', '600555666', 12000.00, 4),
('UniTech', '600666777', 3000.00, 5);
