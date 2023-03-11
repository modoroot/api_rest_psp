# API Rest PSP: operaciones CRUD
## Introducción
Esta API ha sido desarrollada en PHP, usando diferentes clases para cada tabla de la base de datos, conceptos de herencia de clases, y teniendo en cuenta los modificadores de acceso para optimizar el código. Cada clase tiene sus propios métodos para realizar las operaciones CRUD. Para la conexión con la base de datos se ha usado mysqli. Además, se ha implementado una clase adicional donde se gestionan los errores de respuesta de la API, junto a sus códigos de errores.

El tema de la API trata de elementos del universo, como planetas, estrellas, galaxias, etc. Cada elemento tiene sus propios atributos, como el nombre, la masa, la gravedad, etc. La API permite realizar las operaciones CRUD sobre cada tabla.
<i>Aclaración: la información que hay no es 100% real. Hay estrellas que no tienen galaxias, sino constelaciones</i>

## Instalación
Para poder usar la API, es necesario tener instalado un servidor web, (en mi caso Apache), y un servidor de base de datos (en mi caso MySQL). Además, es necesario tener instalado PHP en el servidor web. Una vez instalado todo, se debe crear una base de datos en el servidor de base de datos, y ejecutar el script de creación de tablas que se encuentra en la carpeta "sql" del proyecto. Por último, se debe modificar el archivo "config" con los datos de conexión a la base de datos si tienes otras credenciales.
## Uso
Para poder usar la API, es necesario tener instalado un cliente HTTP, como Postman, u otra herramienta de API's. Una vez instalado, se debe realizar una petición HTTP a la API, usando el método correspondiente a la operación que se quiera realizar. En mi caso he utilizado Thunder Client, una extensión de Visual Studio Code.

## Peticiones
Véase la documentación de la API para ver los métodos y parámetros de cada petición <strong>(index.html)</strong>.

## Ejemplos de peticiones a la API
### Obtención de todos los elementos de datos de una tabla
---
![Alt text](api_rest/img/ksnip_20230310-101631.png)

### Obtención de un elemento de datos de una tabla
---
![Alt text](api_rest/img/ksnip_20230310-103353.png)

### Obtención de todos los elementos de tres tablas
---
![Alt text](api_rest/img/ksnip_20230310-111726.png)

### Creación de un elemento de datos de una tabla
---
![Alt text](api_rest/img/ksnip_20230310-104319.png)

![Alt text](api_rest/img/ksnip_20230310-104415.png)

### Actualización de un elemento de datos de una tabla
---
![Alt text](api_rest/img/ksnip_20230310-112159.png)
![Alt text](api_rest/img/ksnip_20230310-112331.png)
![Alt text](api_rest/img/ksnip_20230310-112417.png)

### Eliminación de un elemento de datos de una tabla
---
<i>Aclaración: como mis tablas tienen una columna con claves ajenas, algunos registros no pueden ser eliminados por dependencia de clave ajena</i>

![Alt text](api_rest/img/ksnip_20230310-114521.png)

![Alt text](api_rest/img/ksnip_20230310-115735.png)

# ENTREGA 5.1 PSP
