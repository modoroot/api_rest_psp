<?php
require_once 'clases/conexion/Conexion.php';
// Creamos una instancia de la clase Conexion
$conexion = new Conexion();

// Consulta SQL para obtener los datos de la tabla access_tokens
$sql = "SELECT * FROM access_tokens";

// Obtenemos los datos de la base de datos
$datos = $conexion->obtenerDatos($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>API - Guía de uso</title>
  <!-- Importación CSS de Tailwind. Iba a usarla con paquetes npm, pero no me funcionaba del todo -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Importación de la librería jQuery para hacer las peticiones AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Importación de la librería Clipboard.js para copiar el token de acceso -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
  <style>
    /* Estilos para la ventana modal */
    .modal {
      display: none;
      /* Ocultada por defecto */
      position: fixed;
      /* Posición fija */
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);

    }

    /* Estilos para el contenido de la ventana modal */
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px;
    }

    /* Estilos para el botón de cerrar */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>

<body class="bg-gray-900 text-white">
  <div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold text-center mb-8">API: guía de uso</h1>
    <hr class="my-8 border border-gray-400">
    <section>
      <h2 class="text-2xl font-bold mb-4">Referencias</h2>
      <table class="w-full border">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="py-2 px-4">Ruta final</th>
            <th class="py-2 px-4">Método</th>
            <th class="py-2 px-4">Parámetros</th>
            <th class="py-2 px-4">Descripción</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="py-2 px-4">/estrellas, /galaxias, /planetas</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Te devuelve los registros de la tabla seleccionada</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/estrellas, /galaxias, /planetas</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4">page=?</td>
            <td class="py-2 px-4">Te devuelve los registros según el número de página indicado</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/estrellas, /galaxias, /planetas</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4">id=?</td>
            <td class="py-2 px-4">Te devuelve el registro según el ID indicado</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/estrellas, /galaxias, /planetas</td>
            <td class="py-2 px-4">POST</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Crea un registro. Mínimo necesitas: nombre, token_id, email</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/estrellas, /galaxias, /planetas</td>
            <td class="py-2 px-4">PUT</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Modifica un registro. Mínimo necesitas: id_(tabla), token_id, email</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/estrellas, /galaxias, /planetas</td>
            <td class="py-2 px-4">DELETE</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Elimina un registro. Mínimo necesitas: id_(tabla), token, email</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/multiples_tablas</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Te muestra todos los registros de tres tablas en un array</td>
          </tr>
        </tbody>
      </table>
    </section>
    <section>
      <h2 class="text-2xl font-bold mb-4">Ejemplo GIF</h2>
      <img src="../res/img/fino.gif" alt="Ejemplo de uso en GIF">
    </section>
    <section>
      <h2 class="text-2xl font-bold mb-4">Tus Tokens</h2>
      <table class="w-full border">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="py-2 px-4">Token ID</th>
            <th class="py-2 px-4">Acción</th>
          </tr>
        </thead>
        <tbody id="tabla-registros" class="text-center">
          <?php
          // Recorremos los datos obtenidos de la base de datos
          foreach ($datos as $dato) {
            // Creamos una fila de la tabla
            echo "<tr>";
            // Creamos las celdas de la tabla
            echo "<td class='py-2 px-4'><a href='#' class='token-link' data-token='" . $dato['token_id'] . "'>" . substr($dato['token_id'], 0, 15) . "...</a></td>";
            echo "<td class='py-2 px-4'><button class='bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded' onclick='eliminarRegistro(" . $dato['id_access_token'] . ")'>Eliminar</button></td>";
            echo "</tr>";
          }
          ?>

        </tbody>
      </table>
      <!-- Plantilla ventana modal Tailwind -->
    </section>
    <div id="modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full sm:p-6">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Token ID
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500" id="modal-description">
                  <code id="token-code"></code>
                </p>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" id="cerrar-modal">
              Cerrar
            </button>
            <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" id="copiar-portapapeles">
              Copiar
            </button>
          </div>
        </div>
      </div>
    </div>
    <script>
      // Crea un objeto ClipboardJS para copiar el token al portapapeles
      var clipboard = new ClipboardJS('#copiar-portapapeles', {
        // Define el texto a copiar como el contenido del elemento con id "token-code"
        text: function() {
          return document.querySelector('#token-code').textContent;
        }
      });

      // Agrega un manejador de eventos para el éxito en la copia al portapapeles
      clipboard.on('success', function(e) {
        alert('Copiado al portapapeles');
      });

      // Obtiene todos los elementos con clase "token-link"
      const tokenLinks = document.querySelectorAll('.token-link');

      // Obtiene la ventana modal y el botón de cerrar
      const modal = document.getElementById('modal');
      const cerrarModal = document.getElementById('cerrar-modal');

      // Obtiene el elemento que muestra el código del token
      const tokenCode = document.getElementById('token-code');

      // Agrega un manejador de eventos a cada enlace de token
      tokenLinks.forEach(link => {
        link.addEventListener('click', (event) => {
          event.preventDefault();
          // Obtiene el valor del atributo "data-token" del enlace clicado
          const token = event.target.dataset.token;
          // Muestra el código del token en el elemento correspondiente
          tokenCode.innerText = token;
          // Muestra la ventana modal
          modal.classList.remove('hidden');
        });
      });

      // Agrega un manejador de eventos al botón de cerrar la ventana modal
      cerrarModal.addEventListener('click', () => {
        // Ocultar la ventana modal
        modal.classList.add('hidden');
      });

      // Define una función para eliminar un registro de la base de datos
      function eliminarRegistro(id_access_token) {
        // Pregunta al usuario si está seguro de que quiere eliminar el registro
        if (confirm('¿Estás seguro de que quieres eliminar este registro?')) {
          // Envia una solicitud AJAX para eliminar el registro
          $.ajax({
            type: 'POST',
            url: 'eliminar_registro.php',
            data: {
              id_access_token: id_access_token
            },
            success: function(response) {
              // Elimina la fila correspondiente de la tabla (NO SE MUESTRAN LOS REGISTROS ACTUALIZADOS AL BORRAR UNO)
              $('tr[data-token="' + id_access_token + '"]').remove();
              alert('Token eliminado (no se muestran los registros actualizados)');
            }
          });
        }
      }
    </script>

</body>

</html>