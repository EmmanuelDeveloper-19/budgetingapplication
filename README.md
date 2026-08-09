# Finansus (Gestiona tus finanzas personales)

**Finansus** es una aplicación web desarrollada para la gestión de gastos personales, desarrollada en **PHP** basada en una arquitectura **MVC (Modelo Vista Controlador)**.

El proyecto tiene dos métodos principales de interacción:

* Una **aplicación web tradicional**, basada en controladores, vistas y modelos.
* Una **API REST**, con controladores independientes para manejar peticiones y respuestas en formato JSON.

Ambas capas utilizan los mismos modelos y la misma base de datos, permitiendo separar la presentación de la lógica de acceso a datos.

---

## Acerca del proyecto

Finansus nace como un proyecto personal orientado a centralizar diferentes aspectos de las finanzas personales, como:

* Registro de ingresos y gastos.
* Consulta de transacciones.
* Gestión de cuentas y métodos de pago.
* Tarjetas de crédito y débito.
* Deudas.
* Suscripciones.
* Información financiera asociada al usuario.

El proyecto se desarrolla **sin utilizar un framework PHP como Laravel o Symfony**, con el objetivo de comprender y controlar directamente componentes fundamentales de una aplicación web, como:

* Routing.
* Controladores.
* Modelos.
* Manejo de sesiones y autenticación.
* Acceso a base de datos.
* API REST.
* Manejo de respuestas HTTP.
* Configuración mediante variables de entorno.

---

#  Características

## Aplicación Web

* Arquitectura MVC desarrollada en PHP.
* Sistema de routing propio.
* Controladores y vistas independientes.
* Modelos para acceso a datos.
* Manejo de respuestas y mensajes para la interfaz.
* Sistema de autenticación de usuarios.

## API REST

La aplicación cuenta con una capa específica para endpoints de API.

Las peticiones que utilizan el prefijo `/api` son identificadas automáticamente por el sistema de routing y procesadas mediante los controladores ubicados en la capa de API.

La API permite:

* Recibir peticiones HTTP.
* Validar autenticación mediante JWT.
* Identificar al usuario autenticado.
* Ejecutar operaciones mediante los modelos.
* Devolver respuestas JSON estandarizadas.

Ejemplo:

```http
GET /api/transaction/index
Authorization: Bearer <JWT>
```

Respuesta:

```json
{
    "success": true,
    "data": [
        {
            "name": "Subscripción a Apple Music"
            "type": "Servicios",
            "amount": "233.00",
            "payment_method": "cash",
            "description": "Subscripción mensual de apple music con el plan de estudiantes"
        }
    ],
    "error": null
}
```

## Autenticación

La API utiliza **JSON Web Tokens (JWT)** para autenticar las peticiones protegidas.

El flujo general es:

```text
Usuario
   │
   ▼
Login
   │
   ▼
Validación de credenciales
   │
   ▼
Generación del JWT
   │
   ▼
Cliente
   │
   ▼
Authorization: Bearer <JWT>
   │
   ▼
App
   │
   ▼
Validación del token
   │
   ▼
Identificación del usuario
   │
   ▼
API Controller
```

Las rutas públicas de la API se encuentran definidas en el núcleo de la aplicación:

```php
protected $public_api_routes = [
    'auth/login',
    'auth/register',
];
```

Las demás rutas de la API requieren un JWT válido.

La librería utilizada para trabajar con JWT es:

```text
firebase/php-jwt
```

---

#  Arquitectura

Finansus utiliza una arquitectura **MVC personalizada**, complementada con una capa independiente para la API.

```text
                         Finansus
                              │
                 ┌────────────┴────────────┐
                 │                         │
          Aplicación Web                 API
                 │                         │
        ┌────────┼────────┐       ┌───────┼────────┐
        │        │        │       │       │        │
   Controller   View    Model   API Controller    Model
        │                 │       │                 │
        └─────────────────┴───────┴─────────────────┘
                              │
                              ▼
                           MySQL
```

## Aplicación Web

El flujo tradicional de la aplicación es:

```text
HTTP Request
      │
      ▼
     App
      │
      ▼
 Controller
      │
      ▼
    Model
      │
      ▼
    View
      │
      ▼
 HTML Response
```

Los controladores web se encargan principalmente de manejar las peticiones relacionadas con la interfaz y renderizar las vistas correspondientes.

## API

Las peticiones de API siguen un flujo diferente:

```text
HTTP Request
      │
      ▼
     App
      │
      ▼
API Controller
      │
      ▼
    Model
      │
      ▼
 JSON Response
```

Esto permite que una misma funcionalidad pueda utilizarse desde la aplicación web o desde otros clientes que consuman la API.

### Separación de controladores

Por ejemplo, las transacciones cuentan con una implementación para la aplicación web y otra para la API:

```text
Web
 │
 └── Transaction Controller
          │
          └── View / HTML


API
 │
 └── Transaction Controller
          │
          └── JSON
```

Los controladores pueden ser diferentes sin necesidad de duplicar el acceso a la base de datos, ya que ambos pueden utilizar el mismo `TransactionModel`.

Esta separación permite mantener diferentes formas de presentación para una misma fuente de datos.

---

# Sistema de Routing

El routing se encuentra implementado mediante una clase `App` propia.

La clase se encarga de:

1. Obtener la URL solicitada.
2. Determinar si la petición corresponde a la aplicación web o a la API.
3. Localizar el controlador.
4. Determinar el método solicitado.
5. Obtener los parámetros de la URL.
6. Validar la autenticación cuando corresponde.
7. Ejecutar el controlador y método solicitado.

Las peticiones cuyo primer segmento sea `api` son identificadas como peticiones de API.

Por ejemplo:

```text
/api/transaction/index
```

se procesa como una petición de API.

Mientras que:

```text
/transaction/index
```

se procesa mediante el flujo tradicional de la aplicación web.

El routing también permite definir rutas de API públicas y rutas protegidas mediante autenticación.

---

#  Estructura del proyecto

La estructura actual del proyecto sigue una organización similar a:

```text
BudgetingApp/
│
├── aplicacion/
│   │
│   ├── app/
│   │   │
│   │   ├── controllers/
│   │   │   └── ...
│   │   │
│   │   ├── core/
│   │   │   ├── app.php
│   │   │   ├── controller.php
│   │   │   └── ...
│   │   │
│   │   ├── includes/
│   │   │   └── ...
│   │   │
│   │   ├── models/
│   │   │   └── ...
│   │   │
│   │   └── views/
│   │       └── ...
│   │
│   └── public/
│       ├── index.php
│       ├── assets/
│       └── build/
│           ├── css/
│           └── js/
│
├── vendor/
│
├── .env
├── composer.json
├── composer.lock
├── .gitignore
└── README.md
```

> A medida que el proyecto va integrando nuevas funcionalidades, la estructura puede experimentar cambios.

---

#  Componentes principales

## `App`

Es el núcleo de la aplicación y se encarga de procesar cada petición HTTP desde la resolución de la URL hasta la ejecución del controlador y método correspondiente.

Entre sus responsabilidades se encuentran:

* Inicialización de los valores predeterminados del controlador, método y parámetros.
* Creación de la conexión con la base de datos mediante `Db`.
* Procesamiento y sanitización de la URL solicitada.
* Detección de peticiones dirigidas a la API mediante el prefijo `/api`.
* Selección dinámica del directorio de controladores según el tipo de petición.
* Verificación de la existencia del controlador solicitado.
* Carga dinámica de los archivos de los controladores.
* Identificación y validación del método solicitado mediante `method_exists()`.
* Obtención y procesamiento de los parámetros incluidos en la URL.
* Identificación de la ruta mediante la combinación de controlador y método.
* Definición de rutas públicas de la API que no requieren autenticación.
* Validación de usuarios mediante JSON Web Tokens (JWT).
* Obtención del JWT desde el header `Authorization` para las peticiones de API.
* Obtención del JWT desde la cookie `jwt_token` para las peticiones web.
* Validación del token utilizando `JWT_SECRET` y el algoritmo `HS256`.
* Almacenamiento de la información del usuario autenticado en la propiedad `$user`.
* Inyección del usuario autenticado en el controlador mediante `$controller->user`.
* Ejecución del controlador y método solicitados mediante `call_user_func_array()`.
* Manejo de peticiones no autenticadas mediante respuestas HTTP `401` para la API.
* Redirección del flujo hacia el controlador de login cuando una petición web no está autenticada.
* Manejo de tokens inválidos o expirados y eliminación de la cookie de autenticación en peticiones web.
* Gestión de rutas o métodos inexistentes mediante el método `e404`.

----

## `Controller`

Es la clase base utilizada por los controladores de la aplicación web. Centraliza funcionalidades comunes relacionadas con el acceso a modelos, renderizado de vistas, carga de helpers, manejo de respuestas y procesamiento de formularios.

Entre sus responsabilidades se encuentran:

* Mantener la información del usuario autenticado mediante la propiedad `$user`.
* Mantener el resultado de operaciones realizadas mediante modelos en `$model_response`.
* Cargar dinámicamente modelos de la aplicación.
* Obtener la respuesta generada por una operación de modelo mediante `get_model_response()`.
* Renderizar vistas completas utilizando `view()`.
* Cargar automáticamente componentes comunes de la interfaz, como:

  * `header.php`
  * `response.php`
  * `alerts.php`
  * `footer.php`
* Renderizar plantillas estáticas mediante `view_static()`.
* Reemplazar marcadores dentro de plantillas estáticas utilizando los datos proporcionados.
* Renderizar vistas sin estilos o componentes adicionales mediante `view_nostyle()`.
* Cargar helpers dinámicamente mediante el método `helper()`.
* Proporcionar respuestas para páginas de error `404`.
* Proporcionar respuestas para páginas de acceso denegado `403`.
* Procesar formularios mediante `prueba_de_post()`.
* Validar campos enviados utilizando el helper de validación.
* Ejecutar dinámicamente métodos de modelos para procesar formularios.
* Generar mensajes de éxito, advertencia o error según el resultado de la operación.
* Conservar los datos enviados del formulario dentro de la sesión mediante `$_SESSION["response"]`.

### Renderizado de vistas

La clase proporciona diferentes métodos para renderizar contenido dependiendo de las necesidades del controlador:

```php
$this->view("transaction/index");
```

Renderiza una vista utilizando la estructura completa de la aplicación.

Para una plantilla estática:

```php
$this->view_static("template/example", $data);
```

Y para una vista independiente sin cargar los componentes generales:

```php
$this->view_nostyle("example");
```

### Carga de modelos

Los modelos pueden cargarse dinámicamente desde los controladores:

```php
$model = $this->model('TransactionModel');
```

El método `model()` incluye el archivo correspondiente y devuelve una instancia del modelo solicitado.

### Procesamiento de formularios

El método `prueba_de_post()` centraliza parte del procesamiento de formularios, incluyendo validación de campos, ejecución de operaciones mediante modelos y almacenamiento de mensajes de respuesta en la sesión.

El flujo general es:

```text
Formulario
    │
    ▼
prueba_de_post()
    │
    ▼
Validación de campos
    │
    ├── Error ──► Mensaje de error
    │
    └── Correcto
            │
            ▼
        Modelo
            │
            ▼
       Resultado
        │       │
        ▼       ▼
     Éxito   Advertencia
        │       │
        └───┬───┘
            ▼
      $_SESSION["response"]
```
---

## `ApiController`

Es la clase base para los controladores de la API.

Centraliza la generación de respuestas JSON mediante un método como:

```php
$this->json(200, $data);
```

Las respuestas mantienen una estructura uniforme:

```json
{
    "success": true,
    "data": {},
    "error": null
}
```

En caso de error:

```json
{
    "success": false,
    "data": null,
    "error": "No autorizado"
}
```

También proporciona funcionalidad para obtener cuerpos de peticiones JSON.

---

## `Model`

Los modelos son responsables de interactuar con la base de datos y encapsular las operaciones relacionadas con los datos.

Por ejemplo:

```text
Transaction Controller
        │
        ▼
TransactionModel
        │
        ▼
Database
```

Esto permite que los controladores no tengan que realizar directamente las consultas SQL correspondientes a cada operación.

---

#  Base de datos

BudgetingApp utiliza **MySQL** como sistema de gestión de base de datos.

El modelo de datos contempla diferentes entidades relacionadas con la gestión financiera personal, entre ellas:

* Usuarios.
* Autenticación.
* Transacciones.
* Tarjetas de crédito.
* Tarjetas de débito.
* Relaciones entre transacciones y tarjetas.
* Suscripciones.
* Deudas.
* Contactos.
* Lista de deseos.

La estructura está diseñada para permitir que las transacciones puedan asociarse al usuario autenticado y, posteriormente, ampliar la gestión de diferentes fuentes de ingresos, gastos y obligaciones financieras.

---

#  Configuración

El proyecto utiliza variables de entorno para almacenar información de configuración y credenciales sensibles.

La gestión de estas variables se realiza mediante:

```text
vlucas/phpdotenv
```

Un archivo `.env` puede contener variables como:

```env
DB_HOST=
DB_NAME=
DB_USER=
DB_PASSWORD=

JWT_SECRET=
```

Los valores reales no deben almacenarse en el repositorio.

Se recomienda mantener un archivo:

```text
.env.example
```

con valores de ejemplo:

```env
DB_HOST=
DB_NAME=
DB_USER=
DB_PASSWORD=

JWT_SECRET=
```

y mantener `.env` dentro de `.gitignore`.

---

#  Dependencias

Las dependencias del proyecto son administradas mediante **Composer**.

Para instalarlas:

```bash
composer install
```

Dependencias principales:

| Dependencia        | Propósito                                  |
| ------------------ | ------------------------------------------ |
| `firebase/php-jwt` | Generación y validación de JSON Web Tokens |
| `vlucas/phpdotenv` | Carga de variables de entorno              |

---

#  Tecnologías

### Backend

* PHP
* Arquitectura MVC
* MySQL
* REST API
* JSON
* JWT

### Dependencias

* Composer
* `firebase/php-jwt`
* `vlucas/phpdotenv`

### Desarrollo

* Apache
* XAMPP
* MySQL
* Git
* GitHub

---

#  Instalación

## Requisitos

Antes de ejecutar el proyecto se requiere:

* PHP
* Apache
* MySQL
* Composer
* Extensiones PHP necesarias para la conexión con MySQL y procesamiento JSON.

El desarrollo actual se realiza principalmente utilizando **XAMPP**.

---

## 1. Clonar el repositorio

```bash
git clone https://github.com/EmmanuelDeveloper-19/budgetingapp.git
cd budgetingapp
```

## 2. Instalar dependencias

```bash
composer install
```

## 3. Configurar variables de entorno

Crear un archivo `.env` en la raíz del proyecto.

Ejemplo:

```env
DB_HOST=localhost
DB_NAME=budgetingapp
DB_USER=root
DB_PASSWORD=

JWT_SECRET=your-secret-key
```

Modificar los valores según la configuración local.

## 4. Configurar MySQL

Crear la base de datos utilizada por la aplicación y ejecutar los scripts SQL correspondientes al proyecto.

Ejemplo:

```sql
CREATE DATABASE tuBaseDeDatos
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

## 5. Ejecutar Apache y MySQL

Si se utiliza XAMPP, iniciar:

```text
Apache
MySQL
```

## 6. Acceder a la aplicación

La entrada pública de la aplicación se encuentra en:

```text
aplicacion/public/
```

En un entorno local de XAMPP puede accederse mediante:

```text
http://localhost/budgetingapp/aplicacion/public/
```

---

# Endpoints de la API

La API se encuentra actualmente en desarrollo.

Las rutas de autenticación públicas incluyen:

```http
POST /api/auth/login
POST /api/auth/register
```

Las rutas protegidas requieren:

```http
Authorization: Bearer <JWT>
```

## Transacciones

Actualmente existe un endpoint para consultar las transacciones del usuario autenticado:

```http
GET /api/transaction/index
```

### Headers

```http
Authorization: Bearer <JWT>
Content-Type: application/json
```

### Respuesta exitosa

```json
{
    "success": true,
    "data": [
        {
            "name": "Subscripción Apple Music",
            "type": "Subscripciones",
            "amount": "199",
            "payment_method": "cash",
            "description": "Subscripcion al plan mensual para estudiantes"
        }
    ],
    "error": null
}
```

La consulta utiliza el usuario identificado mediante el JWT para obtener sus transacciones.

---

#  Flujo de autorización de la API

Una petición protegida sigue aproximadamente este flujo:

```text
GET /api/transaction/index
          │
          ▼
        App
          │
          ▼
  ¿Es una petición API?
          │
          ▼
   Buscar controlador
          │
          ▼
 ¿La ruta es pública?
       │       │
      Sí       No
       │       │
       │       ▼
       │   Buscar JWT
       │       │
       │       ▼
       │  Validar JWT
       │       │
       │       ▼
       │ Identificar usuario
       │       │
       └───────┴───────► Controller
                              │
                              ▼
                            Model
                              │
                              ▼
                            MySQL
                              │
                              ▼
                         JSON Response
```

Si no existe un token válido para una ruta protegida, la API devuelve una respuesta HTTP `401 Unauthorized`.

---

# Estado actual del proyecto

**BudgetingApp se encuentra actualmente en desarrollo activo.**

La infraestructura principal de la aplicación ya se encuentra funcional:

* [x] Arquitectura MVC.
* [x] Sistema de routing propio.
* [x] Separación entre aplicación web y API.
* [x] Controladores independientes para la API.
* [x] Carga de modelos.
* [x] Conexión con MySQL.
* [x] Autenticación mediante JWT.
* [x] Protección de endpoints.
* [x] Identificación del usuario autenticado.
* [x] Respuestas JSON estandarizadas.
* [x] Endpoint de consulta de transacciones.
* [x] Variables de entorno mediante `.env`.
* [x] Gestión de dependencias mediante Composer.

La siguiente etapa está enfocada principalmente en **ampliar las funcionalidades de la aplicación y completar los módulos financieros**.

---

# Roadmap

## Gestión financiera

* [ ] CRUD completo de transacciones.
* [ ] Categorías de ingresos y gastos.
* [ ] Gestión de tarjetas de crédito.
* [ ] Gestión de tarjetas de débito.
* [ ] Gestión de deudas.
* [ ] Gestión de suscripciones.
* [ ] Historial financiero.

## Dashboard

* [ ] Resumen de ingresos.
* [ ] Resumen de gastos.
* [ ] Balance disponible.
* [ ] Estadísticas por categoría.
* [ ] Gráficas financieras.
* [ ] Filtros por fecha.

## API

* [ ] Completar CRUD de transacciones.
* [ ] Endpoints para categorías.
* [ ] Endpoints para tarjetas.
* [ ] Endpoints para deudas.
* [ ] Endpoints para suscripciones.
* [ ] Validaciones más completas.
* [ ] Documentación completa de endpoints.
* [ ] Pruebas automatizadas de API.

## Producción

* [ ] Configuración de entorno de producción.
* [ ] Despliegue de la aplicación.
* [ ] Configuración de dominio.
* [ ] Configuración HTTPS.
* [ ] Optimización de seguridad.
* [ ] Respaldos de base de datos.

---

#  Autor

**Jose Emmanuel Reyes Hernandez**

Desarrollador de Software.

* GitHub: `@EmmanuelDeveloper-19`
* LinkedIn: `Jose Emmanuel Reyes Hernández`

---

# Licencia

Este proyecto se encuentra disponible bajo la licencia MIT.

Consulta el archivo `LICENSE` para obtener los términos completos de la licencia.
