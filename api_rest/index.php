<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>API - Guía de uso</title>
  <!-- Importación CSS de Tailwind. Iba a usarla con paquetes npm, pero no me funcionaba del todo -->
  <script src="https://cdn.tailwindcss.com"></script>
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
            <td class="py-2 px-4">/usuarios</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Te devuelve los usuarios</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/usuarios</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4">page=?</td>
            <td class="py-2 px-4">Te devuelve los usuarios según el número de página indicado</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/usuarios</td>
            <td class="py-2 px-4">GET</td>
            <td class="py-2 px-4">id=?</td>
            <td class="py-2 px-4">Te devuelve el usuario según el ID indicado</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/usuarios</td>
            <td class="py-2 px-4">POST</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Crea un usuario. Mínimo necesitas: username, password, token</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/usuarios</td>
            <td class="py-2 px-4">PUT</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Modifica un usuario. Mínimo necesitas: id_usuario, token</td>
          </tr>
          <tr>
            <td class="py-2 px-4">/usuarios</td>
            <td class="py-2 px-4">DELETE</td>
            <td class="py-2 px-4"></td>
            <td class="py-2 px-4">Elimina un usuario. Mínimo necesitas: id_usuario, token</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</body>

</html>