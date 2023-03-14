# ENTREGA 5.1 PSP
## Introducción
---
He implementado Google OAuth 2.0 para la autenticación y autorización de usuarios. Para ello, he creado una aplicación en la consola de desarrolladores de Google, y he configurado la API para que acepte peticiones de usuarios externos. El paquete de autenticación de Google OAuth 2.0 para PHP lo he implementado a través de Composer, ejecutando en la terminal del sistema dentro del directorio padre:

```bash
composer require google/apiclient:"^2.0"
```
## Preguntas
---
### ¿Por qué es seguro el acceso a tu API REST usando autenticación y autorización? Aquí debéis explicar la diferencia entre autenticación y autorización, y también de qué manera asegura OAUTH2 el uso correcto de vuestra API REST.
---
La seguridad del acceso a una API REST se asegura a través de la implementación de autenticación y autorización.

La autenticación se refiere al proceso de verificar la identidad de un usuario que intenta acceder a la API. En el caso de OAuth2, la autenticación se realiza mediante un flujo de autenticación basado en tokens. Cuando un usuario inicia sesión en un proveedor de servicios de autenticación (por ejemplo, Google), se le asigna un token de acceso que se utiliza para acceder a la API. Este token contiene información sobre la identidad del usuario y su autorización para acceder a ciertos recursos.

La autorización se refiere al proceso de verificar que un usuario tenga permiso para acceder a un recurso específico dentro de la API. En OAuth2, esto se hace mediante el uso de scopes (método addScope()), que son permisos específicos que se otorgan a un token de acceso. Los scopes se utilizan para limitar el acceso de un usuario solo a los recursos para los que tienen permiso. En mi caso sólo utilizo el nombre y correo del usuario logeado.

### ¿Se utiliza algún tipo de cifrado de la información, cuál? Bueno, aquí hemos visto algo en clase, aunque en otro contexto. Por ejemplo, para los JWT se usan algoritmos de tipo HS256, sirven para cifrar los tokens de identificación y acceso.
---
Sí, utiliza el algoritmo de cifrado HMAC con una clave compartida para firmar los tokens de acceso. El token incluye información como la identidad del usuario, la fecha de expiración y otros datos necesarios para autorizar la solicitud.

El cifrado HMAC utiliza una función hash criptográfica para agregar seguridad a los datos. En la implementación de Google OAuth 2.0, se utiliza una clave compartida entre el cliente y el servidor para generar una firma digital que protege la integridad del token de acceso.

### ¿De qué manera intervienen los sockets en la autenticación o en la autorización? Relaciona SSL con OAUTH2
---
Los sockets no intervienen directamente en la autenticación o autorización en la implementación de Google OAuth 2.0 con PHP, sino que son utilizados por el protocolo HTTPS, que es utilizado por OAuth 2.0 para cifrar las comunicaciones entre el cliente y el servidor.

SSL (Secure Sockets Layer) proporciona cifrado de extremo a extremo para proteger las comunicaciones, y utiliza HTTPS como su mecanismo de seguridad subyacente, por lo que que SSL se utiliza para proteger la comunicación entre el cliente y el servidor.
