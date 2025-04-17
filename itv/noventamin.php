<?php
// Definir el paquete de la aplicaci?n permitida
$allowed_package = "com.noventaminutos.oficial";
// Obtener el encabezado 'X-Requested-With'
$requested_with = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : "";
// Verificar si el acceso proviene de la aplicaci?n con el paquete correcto
if ($requested_with === $allowed_package) {
// Si el acceso es permitido, mostrar la p?gina HTML
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Noventaminutos</title>
<!-- Agregar FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
*{-webkit-tap-highlight-color:transparent;user-select:none;margin:0;padding:0;/*box-sizing:border-box;*/outline:none;}
body{font-family:Arial,sans-serif;background-color:#000;color:#fff;margin:0;padding:0;text-align:center}
.header{display:flex;justify-content:space-around;padding:15px;background-color:#000;border-bottom:2px solid #FFC107}
.header button{background:none;border:none;font-size:22px;color:#fff;font-weight:700;cursor:pointer}
.header button.active{color:#FFC107}
.container{padding:10px}
select{padding:8px;font-size:16px;width:100%;margin-bottom:10px}
#searchContainer{display:none;margin-bottom:10px}
#searchInput{width:calc(100% - 20px);padding:8px;font-size:16px;display:block;margin:0 auto;text-align:left}
.card{background-color:#222;padding:15px;margin-bottom:10px;border-radius:10px;display:flex;align-items:center;justify-content:space-between;transition:0.3s}
.card img{width:50px;height:50px;border-radius:10px;margin-right:15px}
.card-content{flex:1;text-align:left;display:flex;align-items:center}
.card-text{margin-left:10px}
.heart{font-size:24px;cursor:pointer;transition:0.3s;color:#fff}
.favorite{color:red}
.section{display:none}
.active-section{display:block}
.footer{position:fixed;bottom:0;width:100%;background-color:#111;display:flex;justify-content:space-around;padding:15px;border-top:2px solid #FFC107}
.footer button{background:none;border:none;font-size:20px;color:#fff;cursor:pointer}
</style>
</head>
<body>
<div class="header">
<button id="btnCanales" class="active" onclick="mostrarSeccion('canales')">CANALES</button>
<button id="btnFavoritos" onclick="mostrarSeccion('favoritos')">FAVORITOS <i class="fa-solid fa-heart"></i></button>
</div>
<div class="container">
<select id="filtroCategoria" onchange="filtrarCategoria()">
<option value="todas">Todas las Categorías</option>
<option value="Entretenimiento">Entretenimiento</option>
<option value="Deportes">Deportes</option>
<option value="24/7">Canales 24/7</option>
<option value="Cine 24/7">Cine 24/7</option>
<option value="HD">HD</option>
<option value="Nacionales">Nacionales</option>
</select>
<div id="searchContainer">
<input type="text" id="searchInput" placeholder="Buscar canal..." onkeyup="buscarCanal()">
</div>
<div id="canales" class="section active-section"></div>
<div id="favoritos" class="section"></div>
</div>
<!--<div class="footer">
<button onclick="verTV()">📺 TV Vivo</button>
<button onclick="toggleSearch()">🔍 Buscar</button>
</div>-->
<div class="footer">
<button onclick="verTV()"><i class="fa-solid fa-tv"></i> TV</button>
<button onclick="toggleSearch()"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
</div>

<?php
// Ruta 
$urlM3U = "https://web-tv.playsport00.com/listas/teleclub-canalesLatinos.m3u";
$canales = [];
$secret = "com.noventaminutos.oficial"; // clave secreta fuerte

// Obtener el timestamp
$timestamp = $_GET['timestamp'] ?? time();  // usamos el tiempo actual

$contenido = @file_get_contents($urlM3U);
if ($contenido) {
    $lineas = array_filter(array_map('trim', explode("\n", $contenido)));
    for ($i = 0; $i < count($lineas) - 1; $i++) {
        if (strpos($lineas[$i], '#EXTINF') === 0) {
            $info = $lineas[$i];
            $url = isset($lineas[$i + 1]) && strpos($lineas[$i + 1], 'http') === 0 ? trim($lineas[$i + 1]) : '';

            preg_match('/tvg-logo="(.*?)"/', $info, $logoMatch);
            preg_match('/group-title="(.*?)"/', $info, $grupoMatch);
            preg_match('/,(.*)/', $info, $nombreMatch);

            if ($url) {
                // Generar el token esperado para cada canal
                $nombreCanal = $nombreMatch[1] ?? 'Sin título';
                $datos = $nombreCanal . '|' . $timestamp;
                $tokenEsperado = hash_hmac('sha256', $datos, $secret);

                // Crear el canal con su información
                $canales[] = [
                    'image' => $logoMatch[1] ?? '',
                    'category' => $grupoMatch[1] ?? 'Sin categoría',
                    'title' => $nombreCanal,
                    'id' => $nombreCanal, // ID exacto igual al nombre
                    'token' => $tokenEsperado // Añadir token a la respuesta
                ];
            }
        }
    }
}
?>

<script>
// Obtenemos el timestamp desde los parámetros GET de la URL
const timestamp = '<?= $timestamp ?>';

// Obtenemos los canales con sus tokens
const canales = <?= json_encode($canales, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

const contenedorCanales = document.getElementById('canales');
contenedorCanales.innerHTML = '';

canales.forEach(canal => {
    const tarjeta = document.createElement('div');
    tarjeta.classList.add('card');
    tarjeta.setAttribute('data-id', canal.title);
    tarjeta.setAttribute('data-categoria', canal.category);

    tarjeta.innerHTML = `
        <div class="card-content">
            <img src="${canal.image}" alt="${canal.title}">
            <div class="card-text">
                <h4>${canal.title}</h4>
            </div>
        </div>
        <div class="heart" onclick="toggleFavorito(this, '${canal.title}')"><i class="far fa-heart"></i></div>
        <div>
            <a href="noventaplayer.php?canal=${encodeURIComponent(canal.id)}&timestamp=${timestamp}&token=${canal.token}" style="color:#FFC107;text-decoration:none;font-weight:bold;">Ver Canal</a>
        </div>
    `;
    contenedorCanales.appendChild(tarjeta);
});
</script>

</body>
</html>

<?php
} else {
    // Si el acceso es denegado, mostrar un mensaje de error
    header("HTTP/1.1 403 Forbidden");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: black;
            color: white;
        }
        h1 {
            color: red; /* Color del texto de error */
        }
        .centrar-video video {
            margin-top: 20px; /* Añadir un pequeño espacio entre el mensaje y el video */
            width: 350px; /* Ajusta el ancho del video */
            height: 250px; /* Ajusta la altura del video */
        }
        
        #countdown {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            color: yellow;
        }
    </style>
</head>
<body>
    <h1>Acceso Denegado</h1>
    <p>No tienes permiso para ver este contenido.</p>

    <div class="centrar-video">
        <!-- Video con autoplay, loop y mute -->
        <video autoplay loop muted controls>
            <!-- Fuentes en diferentes formatos para compatibilidad -->
            <source src="https://original24.x10.mx/packdroid/originalp.mp4" type="video/mp4">
            <source src="https://original24.x10.mx/packdroid/originalp.webm" type="video/webm">
            <source src="https://original24.x10.mx/packdroid/originalp.ogv" type="video/ogg">
            Tu navegador no soporta la etiqueta de video.
        </video>
    </div>
    
   <p id="countdown">Redirigiendo en 10 segundos...</p>

    <script>
        let timeLeft = 10;
        let countdownElement = document.getElementById("countdown");

        let countdown = setInterval(function() {
            timeLeft--;
            countdownElement.textContent = "Redirigiendo en " + timeLeft + " segundos...";
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.location.href = "https://playsport00.com/";
            }
        }, 1000);
    </script>
    
</body>
</html>
<?php
}
?>