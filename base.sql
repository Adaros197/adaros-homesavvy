DROP DATABASE IF EXISTS Homesavvy;
CREATE DATABASE IF NOT EXISTS Homesavvy;
USE Homesavvy;

-- Tabla Cliente
CREATE TABLE Cliente (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellido_p VARCHAR(50),
    apellido_m VARCHAR(50),
    numero VARCHAR(15),
    email VARCHAR(100),
    direccion VARCHAR(200),
    contraseña VARCHAR(100),
    ine VARCHAR(500),
    comprobante_domicilio VARCHAR(500),
    foto_perfil VARCHAR(500)
);

-- Tabla Profesional
CREATE TABLE Profesional (
    id_profesional INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellido_p VARCHAR(50),
    apellido_m VARCHAR(50),
    numero VARCHAR(15),
    email VARCHAR(100),
    direccion VARCHAR(200),
    contraseña VARCHAR(100),
    ine VARCHAR(500),
    comprobante_domicilio VARCHAR(500),
    foto_perfil VARCHAR(500),
    profesion VARCHAR(20),
    rfc VARCHAR(20),
    curriculum VARCHAR(500),
    antecedentes VARCHAR(500),
    cartas_recomendacion VARCHAR(500),
    constancia_situacion_fiscal VARCHAR(500)
);

-- Tabla Admin
CREATE TABLE Admin (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    email VARCHAR(100),
    contraseña VARCHAR(100)
);

-- Tabla SolicitudServicio
CREATE TABLE SolicitudServicio (
    id_solicitud_servicio INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    titulo VARCHAR(100),
    descripcion TEXT,
    horarios VARCHAR(100),
    metodo_pago VARCHAR(50),
    foto VARCHAR(500),
    estado VARCHAR(20) DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente) ON DELETE CASCADE
);

-- Tabla SolicitudTrabajo
CREATE TABLE SolicitudTrabajo (
    id_solicitud_trabajo INT PRIMARY KEY AUTO_INCREMENT,
    id_profesional INT,
    titulo VARCHAR(100),
    descripcion TEXT,
    categoria VARCHAR(50),
    tarifa DECIMAL(10, 2),
    foto VARCHAR(500),
    estado VARCHAR(20) DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_profesional) REFERENCES Profesional(id_profesional) ON DELETE CASCADE
);

-- Tabla PostulacionServicio
CREATE TABLE PostulacionServicio (
    id_postulacion_servicio INT PRIMARY KEY AUTO_INCREMENT,
    id_solicitud_servicio INT,
    id_profesional INT,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_solicitud_servicio) REFERENCES SolicitudServicio(id_solicitud_servicio) ON DELETE CASCADE,
    FOREIGN KEY (id_profesional) REFERENCES Profesional(id_profesional) ON DELETE CASCADE
);

-- Tabla PeticionTrabajo
CREATE TABLE PeticionTrabajo (
    id_peticion_trabajo INT PRIMARY KEY AUTO_INCREMENT,
    id_solicitud_trabajo INT,
    id_cliente INT,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_peticion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_solicitud_trabajo) REFERENCES SolicitudTrabajo(id_solicitud_trabajo) ON DELETE CASCADE,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente) ON DELETE CASCADE
);

-- Poblar la tabla Cliente con registros aleatorios
INSERT INTO Cliente (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña)
VALUES
('Carlos', 'Hernández', 'López', '5559876543', 'carlos.hernandez@example.com', 'Calle Luna 1', 'pass123'),
('María', 'Ramírez', 'Castro', '5558765432', 'maria.ramirez@example.com', 'Calle Sol 2', 'pass456'),
('Luis', 'Gómez', 'Martínez', '5557654321', 'luis.gomez@example.com', 'Calle Estrella 3', 'pass789'),
('Laura', 'Fernández', 'Pérez', '5556543210', 'laura.fernandez@example.com', 'Calle Noche 4', 'pass012'),
('Sofía', 'Díaz', 'Morales', '5555432109', 'sofia.diaz@example.com', 'Calle Amanecer 5', 'pass345'),
('Pedro', 'Jiménez', 'Torres', '5554321098', 'pedro.jimenez@example.com', 'Calle Horizonte 6',  'pass678'),
('Andrea', 'Vargas', 'Gutiérrez', '5553210987', 'andrea.vargas@example.com', 'Calle Mar 7', 'pass901'),
('Javier', 'Mendoza', 'Ortiz', '5552109876', 'javier.mendoza@example.com', 'Calle Río 8', 'pass234'),
('Daniela', 'Cruz', 'Álvarez', '5551098765', 'daniela.cruz@example.com', 'Calle Lago 9', 'pass567'),
('Miguel', 'Castillo', 'Reyes', '5550987654', 'miguel.castillo@example.com', 'Calle Montaña 10', 'pass890');

-- Poblar la tabla Profesional con registros aleatorios
INSERT INTO Profesional (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña, profesion, rfc)
VALUES
('Alberto', 'Luna', 'Ríos', '5551237890', 'alberto.luna@example.com', 'Avenida Central 1', 'pass123', 'Ingeniero', 'ALUR123456789'),
('Claudia', 'Estrada', 'Peña', '5559871234', 'claudia.estrada@example.com', 'Avenida Sur 2', 'pass456', 'Arquitecta', 'CEPE123456789'),
('Sergio', 'Moreno', 'Villa', '5556547890', 'sergio.moreno@example.com', 'Avenida Norte 3', 'pass789', 'Electricista', 'SMVI123456789'),
('Lucía', 'Reyes', 'Galván', '5553214567', 'lucia.reyes@example.com', 'Avenida Este 4', 'pass012', 'Plomera', 'LRGA123456789'),
('Mario', 'Torres', 'Flores', '5557891234', 'mario.torres@example.com', 'Avenida Oeste 5', 'pass345', 'Carpintero', 'MTFL123456789'),
('Isabel', 'Vega', 'Navarro', '5554567890', 'isabel.vega@example.com', 'Avenida Centro 6', 'pass678', 'Pintora', 'IVNA123456789'),
('Roberto', 'Carrillo', 'Castañeda', '5559876543', 'roberto.carrillo@example.com', 'Avenida Sur 7', 'pass901', 'Albañil', 'RCCA123456789'),
('Elena', 'Santos', 'Hernández', '5558765432', 'elena.santos@example.com', 'Avenida Norte 8', 'pass234', 'Jardinera', 'ESHE123456789'),
('Tomás', 'López', 'Ramos', '5557654321', 'tomas.lopez@example.com', 'Avenida Este 9', 'pass567', 'Cerrajero', 'TLRA123456789'),
('Patricia', 'Ramírez', 'Pérez', '5556543210', 'patricia.ramirez@example.com', 'Avenida Oeste 10', 'pass890', 'Mecánica', 'PRPE123456789');

INSERT INTO Admin (nombre, email, contraseña)
VALUES
('Admin1', 'admin1@example.com', 'adminpass1'),
('Admin2', 'admin2@example.com', 'adminpass2'),
('Admin3', 'admin3@example.com', 'adminpass3'),
('Admin4', 'admin4@example.com', 'adminpass4'),
('Admin5', 'admin5@example.com', 'adminpass5'),
('Admin6', 'admin6@example.com', 'adminpass6'),
('Admin7', 'admin7@example.com', 'adminpass7'),
('Admin8', 'admin8@example.com', 'adminpass8'),
('Admin9', 'admin9@example.com', 'adminpass9'),
('Admin10', 'admin10@example.com', 'adminpass10');

INSERT INTO SolicitudServicio (id_cliente, titulo, descripcion, horarios, metodo_pago, estado)
VALUES
(1, 'Reparación de tuberías', 'Reparar fugas en el baño y cocina', 'Lunes a Viernes, 9am - 5pm', 'Efectivo', 'activa'),
(2, 'Instalación de lámparas', 'Colocar lámparas nuevas en sala y comedor', 'Sábado, 10am - 3pm', 'Tarjeta', 'activa'),
(3, 'Pintura de interiores', 'Pintar sala, cocina y recámaras', 'Lunes a Miércoles, 8am - 4pm', 'Transferencia', 'activa'),
(4, 'Reparación de techos', 'Arreglar goteras en el techo', 'Viernes, 9am - 6pm', 'Efectivo', 'activa'),
(5, 'Limpieza profunda', 'Limpieza completa de casa, 3 habitaciones', 'Sábado, 8am - 2pm', 'Tarjeta', 'activa'),
(6, 'Instalación de cámaras', 'Colocar cámaras de seguridad en casa', 'Martes, 9am - 4pm', 'Transferencia', 'activa'),
(7, 'Cambio de cerraduras', 'Actualizar todas las cerraduras de casa', 'Jueves, 8am - 12pm', 'Efectivo', 'activa'),
(8, 'Reparación eléctrica', 'Arreglar cortocircuito en sala y cocina', 'Miércoles, 10am - 2pm', 'Tarjeta', 'activa'),
(9, 'Instalación de aire acondicionado', 'Colocar unidad nueva en la sala', 'Lunes, 11am - 3pm', 'Transferencia', 'activa'),
(10, 'Mantenimiento de jardín', 'Podar césped y árboles del jardín', 'Sábado, 7am - 12pm', 'Efectivo', 'activa');

INSERT INTO SolicitudTrabajo (id_profesional, titulo, descripcion, categoria, tarifa, estado)
VALUES
(1, 'Instalación de sistemas eléctricos', 'Instalación completa para casas nuevas', 'Electricidad', 2500.00, 'activa'),
(2, 'Reparación de techos', 'Arreglo de goteras y filtraciones', 'Construcción', 1800.00, 'activa'),
(3, 'Pintura exterior', 'Pintura completa para fachadas', 'Pintura', 3000.00, 'activa'),
(4, 'Limpieza profunda', 'Limpieza profesional de casas y oficinas', 'Limpieza', 1200.00, 'activa'),
(5, 'Reparación de plomería', 'Reparación de fugas y tuberías rotas', 'Plomería', 1500.00, 'activa'),
(6, 'Cambio de cerraduras', 'Actualización a cerraduras de seguridad', 'Carpintería', 800.00, 'activa'),
(7, 'Instalación de cámaras', 'Colocación de cámaras de seguridad', 'Electricidad', 2000.00, 'activa'),
(8, 'Mantenimiento de jardines', 'Podado y cuidado de césped y plantas', 'Jardinería', 1000.00, 'activa'),
(9, 'Instalación de pisos', 'Colocación de pisos cerámicos o de madera', 'Construcción', 2800.00, 'activa'),
(10, 'Diseño de interiores', 'Decoración y organización de espacios', 'Diseño', 3500.00, 'activa');


INSERT INTO PostulacionServicio (id_solicitud_servicio, id_profesional, estado)
VALUES
(1, 2, 'pendiente'),
(2, 3, 'pendiente'),
(3, 4, 'aceptada'),
(4, 5, 'rechazada'),
(5, 6, 'pendiente'),
(6, 7, 'pendiente'),
(7, 8, 'aceptada'),
(8, 9, 'rechazada'),
(9, 10, 'pendiente'),
(10, 1, 'pendiente');


INSERT INTO PeticionTrabajo (id_solicitud_trabajo, id_cliente, estado)
VALUES
(1, 2, 'pendiente'),
(2, 3, 'aceptada'),
(3, 4, 'rechazada'),
(4, 5, 'pendiente'),
(5, 6, 'pendiente'),
(6, 7, 'aceptada'),
(7, 8, 'rechazada'),
(8, 9, 'pendiente'),
(9, 10, 'pendiente'),
(10, 1, 'pendiente');