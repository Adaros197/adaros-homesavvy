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

-- Insertar un cliente
INSERT INTO Cliente (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña)
VALUES ('Juan', 'Pérez', 'García', '5551234567', 'juan.perez@example.com', 'Calle Falsa 123', 'password123');

-- Insertar un profesional
INSERT INTO Profesional (nombre, apellido_p, apellido_m, numero, email, direccion, contraseña, profesion, rfc)
VALUES ('Ana', 'López', 'Martínez', '5557654321', 'ana.lopez@example.com', 'Avenida Siempre Viva 456', 'password456', 'Electricista', 'RFC123456789');

-- Insertar un admin
INSERT INTO Admin (nombre, email, contraseña)
VALUES ('Admin', 'admin@example.com', 'admin');

-- Insertar una solicitud de servicio
INSERT INTO SolicitudServicio (id_cliente, titulo, descripcion, horarios, metodo_pago, estado)
VALUES (1, 'Reparación de tuberías', 'Necesito reparar las tuberías del baño', 'Lunes a Viernes, 9am - 5pm', 'Efectivo', 'activa');

-- Insertar una solicitud de trabajo
INSERT INTO SolicitudTrabajo (id_profesional, titulo, descripcion, categoria, tarifa, estado)
VALUES (1, 'Instalación de sistema eléctrico', 'Instalación completa de sistema eléctrico en una casa nueva', 'Electricidad', 1500.00, 'activa');

-- Insertar una postulación de servicio
INSERT INTO PostulacionServicio (id_solicitud_servicio, id_profesional, estado)
VALUES (1, 1, 'pendiente');

-- Insertar una petición de trabajo
INSERT INTO PeticionTrabajo (id_solicitud_trabajo, id_cliente, estado)
VALUES (1, 1, 'pendiente');