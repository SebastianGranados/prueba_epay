# Prueba Técnica Epayco - Sistema de Pagos

Este proyecto es una aplicación web full-stack que simula un sistema de procesamiento de pagos, permitiendo el registro de clientes, la gestión de billeteras virtuales y la realización de transacciones. La aplicación está completamente containerizada con Docker para facilitar su despliegue y ejecución.

## ✨ Características Principales

- **Registro de Clientes**: Permite registrar nuevos clientes en el sistema.
- **Gestión de Billeteras**: Cada cliente tiene una billetera virtual con la capacidad de consultar y recargar saldo.
- **Procesamiento de Pagos**: Simula el proceso de pago, generando una sesión y una transacción.
- **API RESTful**: Backend robusto construido con Lumen (un micro-framework de Laravel) que expone endpoints para todas las operaciones.
- **Frontend Moderno**: Interfaz de usuario reactiva construida con React, TypeScript y Vite.
- **Containerización Completa**: Todo el entorno (servidor, cliente, base de datos) se gestiona a través de Docker y Docker Compose.

## 🚀 Arquitectura y Stack Tecnológico

El proyecto sigue una arquitectura de microservicios desacoplada, con un frontend y un backend que se comunican a través de una API REST.

- **Backend (Servidor)**:
  - **Framework**: PHP 8.2 / Lumen
  - **Base de Datos**: MySQL 8.0

- **Frontend (Cliente)**:
  - **Librería**: React 18 con TypeScript
  - **Build Tool**: Vite
  - **Estilos**: Tailwind CSS

- **Orquestación**:
  - **Docker & Docker Compose**: Para crear y gestionar los contenedores de la aplicación.

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes componentes en tu sistema:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## ⚙️ Guía de Instalación y Despliegue

Sigue estos pasos para levantar el proyecto en tu entorno local usando Docker.

### 1. Clonar el Repositorio

```bash
git clone https://github.com/SebastianGranados/prueba_epay.git
cd prueba-epayco
```

### 2. Construir y Levantar los Contenedores

Este es el único comando que necesitas para construir las imágenes de Docker y poner en marcha todos los servicios.

```bash
docker-compose up --build -d
```

- `--build`: Fuerza la reconstrucción de las imágenes a partir de los `Dockerfile`. Es importante usarlo la primera vez o después de hacer cambios en la configuración.
- `-d`: Ejecuta los contenedores en modo "detached" (en segundo plano).

### 3. Acceder a la Aplicación

Una vez que los contenedores estén en funcionamiento, podrás acceder a los servicios a través de los siguientes puertos:

- **Aplicación Frontend**: [http://localhost:3000](http://localhost:3000)
- **API Backend**: [http://localhost:8080/api](http://localhost:8080/api)
- **Base de Datos (MySQL)**: Se conecta en el puerto `3307` desde tu máquina local (por si necesitas un cliente de base de datos como DBeaver o TablePlus).

### 4. Detener la Aplicación

Para detener todos los contenedores, ejecuta el siguiente comando en la raíz del proyecto:

```bash
docker-compose down
```

Esto detendrá y eliminará los contenedores, pero no los volúmenes de la base de datos, por lo que tus datos persistirán entre sesiones.

### 5. Uso de la Colección de Postman

El proyecto incluye una colección de Postman (`prueba-epayco.postman_collection.json`) con ejemplos de todas las solicitudes a la API.
El cual tiene una variable que se llama server_url que debe tener el valor `http://localhost:8080/api`.

1.  **Abre Postman**: Inicia la aplicación de Postman.
2.  **Importar la Colección**:
    - Haz clic en `File` > `Import...`.
    - Selecciona el archivo `prueba-epayco.postman_collection.json` que se encuentra en la raíz del proyecto.
3.  **Probar los Endpoints**:
    - La colección ya está preconfigurada para apuntar a `http://localhost:8080/api`, que es la URL del backend corriendo en Docker.
    - Podrás probar endpoints como la creación de clientes, recarga de billeteras y procesamiento de pagos.

## 🌐 Endpoints de la API

La API ofrece los siguientes endpoints para interactuar con el sistema:

### Clientes

- **`POST /api/customer/create`**: Registra un nuevo cliente.
  - **Body**: `{ "name": "string", "last_name": "string", "email": "string", "phone": "string" }`

### Billetera

- **`POST /api/wallet/recharge`**: Recarga el saldo de la billetera de un cliente.
  - **Body**: `{ "document": "string", "phone": "string", "amount": "number" }`

- **`GET /api/wallet/balance`**: Consulta el saldo de la billetera de un cliente.
  - **Query Params**: `?document=string&phone=string`

### Pagos

- **`POST /api/payment/request`**: Inicia una nueva solicitud de pago.
  - **Body**: `{ "customer_id": "string", "amount": "number" }`

- **`POST /api/payment/confirm`**: Confirma un pago utilizando un token (OTP).
  - **Body**: `{ "session_id": "string", "token": "string" }`


## 📂 Estructura del Proyecto

El repositorio está organizado en dos carpetas principales:

- **`/client`**: Contiene todo el código fuente de la aplicación frontend en React.
  - `src/`: El código principal de la aplicación.
  - `src/modules/`: Lógica de negocio separada por módulos (Customer, Payment, etc.).
  - `Dockerfile`: Define cómo construir la imagen de producción del cliente.
  - `docker/nginx.conf`: Configuración de Nginx para servir la aplicación React.

- **`/server`**: Contiene todo el código fuente de la API backend en Lumen.
  - `app/`: El núcleo de la aplicación Lumen (Controladores, Modelos, Servicios).
  - `routes/api.php`: Define todos los endpoints de la API.
  - `database/migrations/`: Las migraciones para crear el esquema de la base de datos.
  - `Dockerfile`: Define la imagen del servidor con PHP, Nginx y las extensiones necesarias.
  - `docker/supervisord.conf`: Configuración para gestionar los procesos de Nginx y PHP-FPM.

- **`docker-compose.yml`**: El archivo principal que orquesta la construcción y ejecución de todos los servicios (cliente, servidor y base de datos).
