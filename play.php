<?php
// IP y puerto del GXV3500
$destino = "rtp://192.168.1.80:5004"; // ← cambia esta IP por la real

// Ruta al binario de FFmpeg
$ffmpeg = "C:/ffmpeg/bin/ffmpeg.exe";

// Carpeta de audios
$audioBasePath = __DIR__ . "/audios/";

// Validar audio recibido
if (!empty($_POST['audio'])) {
    $archivo = basename($_POST['audio']); // seguridad básica
    $rutaAudio = $audioBasePath . $archivo;

    if (file_exists($rutaAudio)) {
        // Construir comando
        $cmd = "\"$ffmpeg\" -re -i " . escapeshellarg($rutaAudio) . " -acodec pcm_alaw -f rtp $destino";

        // Ejecutar en segundo plano sin bloquear PHP
        pclose(popen("start /B " . $cmd, "r"));

        echo "✅ Enviando: $archivo";
    } else {
        echo "❌ Audio no encontrado.";
    }
} else {
    echo "❌ No se especificó ningún audio.";
}
?>