<?php 
// Convierte URLs normales de YouTube (youtu.be, watch?v, shorts) a formato embebible (/embed/)
function youtube_to_embed($url, $privacyEnhanced = true) {
    try {
        $u = parse_url($url);
        if (!isset($u['host'])) return $url;

        $host = strtolower($u['host']);
        $path = isset($u['path']) ? $u['path'] : '';
        $query = isset($u['query']) ? $u['query'] : '';

        // Extraer ID del video
        $id = null;

        // youtu.be/<id>
        if ($host === 'youtu.be') {
            $id = ltrim($path, '/');
        }

        // www.youtube.com/watch?v=<id>
        if (!$id && (strpos($host, 'youtube.com') !== false) && $path === '/watch') {
            parse_str($query, $params);
            if (!empty($params['v'])) $id = $params['v'];
        }

        // www.youtube.com/shorts/<id>
        if (!$id && (strpos($host, 'youtube.com') !== false) && strpos($path, '/shorts/') === 0) {
            $id = substr($path, strlen('/shorts/'));
        }

        // www.youtube.com/embed/<id> (ya válido)
        if (!$id && (strpos($host, 'youtube.com') !== false) && strpos($path, '/embed/') === 0) {
            return $url;
        }

        if (!$id) return $url; // no reconocido, devolver original

        $base = $privacyEnhanced
            ? 'https://www.youtube-nocookie.com/embed/'
            : 'https://www.youtube.com/embed/';

        // Preservar ciertos parámetros útiles (ej: start, si, t, list)
        $allowed = ['start', 'si', 't', 'list'];
        $newQuery = [];
        if ($query) {
            parse_str($query, $params);
            foreach ($allowed as $k) {
                if (isset($params[$k])) {
                    $newQuery[$k] = $params[$k];
                }
            }
        }

        $qs = $newQuery ? ('?' . http_build_query($newQuery)) : '';
        return $base . $id . $qs;

    } catch (Throwable $e) {
        return $url;
    }
}

// Ejemplo usando un enlace "normal"; puedes cambiar $videoUrl por cualquier URL de YouTube
$videoUrl = 'https://youtu.be/Qq3-fGPPRLI?si=BsNoYwbREmYJpis0';
$embedSrc = youtube_to_embed($videoUrl);
?>