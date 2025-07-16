{\rtf1\ansi\ansicpg1252\cocoartf2761
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fnil\fcharset0 HelveticaNeue;\f1\fnil\fcharset0 .AppleSystemUIFontMonospaced-Regular;}
{\colortbl;\red255\green255\blue255;\red0\green0\blue0;\red31\green107\blue192;\red252\green33\blue37;
}
{\*\expandedcolortbl;;\cspthree\c0\c0\c0;\cspthree\c25645\c49867\c77726;\cspthree\c92129\c30453\c24049;
}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx560\tx1120\tx1680\tx2240\tx2800\tx3360\tx3920\tx4480\tx5040\tx5600\tx6160\tx6720\pardirnatural\partightenfactor0

\f0\fs26 \cf2 <?php\
// Comprobar si se ha proporcionado un ID\
if (isset($_GET['id'])) \{\
    $id = $_GET['id'];\
    $url = "\cf3 https://yfkijlwj1wm320xr.youaresoselfish.online/$id\cf2 ";\
\
    // Usar cURL para obtener el contenido de la URL\
    $ch = curl_init($url);\
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);\
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecciones\
    curl_setopt($ch, CURLOPT_HTTPHEADER, [\
        'User -Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'\
    ]);\
    $response = curl_exec($ch);\
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);\
    curl_close($ch);\
\
    // Enviar el contenido de vuelta al navegador\
    if ($httpCode == 200) \{\
        header('Content-Type: application/vnd.apple.mpegurl');\
        echo $response;\
        exit; // Terminar el script aqu\'ed si se ha procesado la solicitud\
    \} else \{\
        echo "Error al acceder a la URL: " . $httpCode;\
        exit;\
    \}\
\}\
?>\
\
<!DOCTYPE html>\
<html lang="es">\
<head>\
  <meta charset="UTF-8" />\
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />\
  <title>Redirecci\'f3n</title>\
  <script>\
    // Obtener el par\'e1metro "id" de la URL\
    const urlParams = new URLSearchParams(\cf3 window.location.search\cf2 );\
    const canalId = urlParams.get('id');\
\
    // Verificar si se obtuvo el canalId\
    if (canalId) \{\
      // Redirigir al mismo archivo con el ID\
      window.location.href = 
\f1 \cf4 ?id=$\{encodeURIComponent(canalId)\}
\f0 \cf2 ;\
    \} else \{\
      // Si no se proporciona el id, mostrar un mensaje\
      document.write("<p>No se ha proporcionado un ID v\'e1lido.</p>");\
    \}\
  </script>\
</head>\
<body>\
  <p>Redirigiendo...</p>\
</body>\
</html>}