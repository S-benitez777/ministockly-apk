CREATE DATABASE miniStockly_api;

USE miniStockly_api;

CREATE TABLE productos (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre NVARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    creado_en DATETIME DEFAULT GETDATE()
);
