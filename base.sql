DROP DATABASE IF EXISTS Homesavvy;
CREATE DATABASE Homesavvy;
USE Homesavvy;


-- Tabla Cliente
CREATE TABLE Cliente (
    id_cliente INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido_p VARCHAR(50),
    apellido_m VARCHAR(50),
    numero VARCHAR(15),
    email VARCHAR(100),
    direccion VARCHAR(200),
    contraseña VARCHAR(100),
    ine BLOB,
    comprobante_domicilio BLOB,
    foto_perfil BLOB
);

-- Tabla Profesional
CREATE TABLE Profesional (
    id_profesional INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido_p VARCHAR(50),
    apellido_m VARCHAR(50),
    numero VARCHAR(15),
    email VARCHAR(100),
    direccion VARCHAR(200),
    contraseña VARCHAR(100),
    ine BLOB,
    comprobante_domicilio BLOB,
    foto_perfil BLOB,
    profesion VARCHAR(20),
    rfc BLOB,
    curriculum BLOB,
    antecedentes BLOB,
    cartas_recomendacion BLOB,
    constancia_situacion_fiscal BLOB
);

-- Tabla SolicitudServicio
CREATE TABLE SolicitudServicio (
    id_solicitud_servicio INT PRIMARY KEY,
    id_cliente INT,
    descripcion TEXT,
    estado VARCHAR(20) DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);

-- Tabla SolicitudTrabajo
CREATE TABLE SolicitudTrabajo (
    id_solicitud_trabajo INT PRIMARY KEY,
    id_profesional INT,
    descripcion TEXT,
    estado VARCHAR(20) DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_profesional) REFERENCES Profesional(id_profesional)
);

-- Tabla PostulacionServicio
CREATE TABLE PostulacionServicio (
    id_postulacion_servicio INT PRIMARY KEY,
    id_solicitud_servicio INT,
    id_profesional INT,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_solicitud_servicio) REFERENCES SolicitudServicio(id_solicitud_servicio),
    FOREIGN KEY (id_profesional) REFERENCES Profesional(id_profesional)
);

-- Tabla PeticionTrabajo
CREATE TABLE PeticionTrabajo (
    id_peticion_trabajo INT PRIMARY KEY,
    id_solicitud_trabajo INT,
    id_cliente INT,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha_peticion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_solicitud_trabajo) REFERENCES SolicitudTrabajo(id_solicitud_trabajo),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente)
);