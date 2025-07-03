<?php
session_start();

$input = json_decode(file_get_contents('php://input'), true);
$token = $_SESSION['access_token'] ?? null;
if (empty($token)) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Access token is missing or invalid']);
    exit;
}
$tracks = json_decode($input['tracks']) ?? [];

if (empty($tracks)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Tracks are required']);
    exit;
}

$tracks = array_map(fn($track) => getSongId($track, $token), $tracks);

function getSongId($track, $token) {
    $ch = curl_init('https://api.spotify.com/v1/search?q='.urlencode($track).'&type=track&limit=1');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token,
                                        'Content-Type: application/json']);

    if (curl_errno($ch)) {
        $result = 'Błąd: ' . curl_error($ch);
        return null;
    } else {
        $result = json_decode(curl_exec($ch),true);
        $trackId = $result['tracks']['items'][0]['id'] ?? null;
        return 'spotify:track:'.$trackId;
    }
}

$ch = curl_init('https://api.spotify.com/v1/me/');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token,
                                       'Content-Type: application/json']);

if (curl_errno($ch)) {
    $result = 'Błąd: ' . curl_error($ch);
} else {
    $result = json_decode(curl_exec($ch),true);
    $userId = $result['id'] ?? null;
}


curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/users/' . $userId . '/playlists');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'name' => $input['playlistName'] ?? 'Nowa Playlista',
    'description' => $input['playlistDescription'] ?? 'Opis',
    'public' => false
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token,
                                       'Content-Type: application/json']);

if (curl_errno($ch)) {
    $result = 'Błąd: ' . curl_error($ch);
} else {
    $createdPlaylist = json_decode(curl_exec($ch),true);
    $playlistId = $createdPlaylist['id'] ?? null;
}

curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/playlists/' . $playlistId . '/tracks');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'uris' => $tracks
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token,
                                       'Content-Type: application/json']);

if (curl_errno($ch)) {
    $result = 'Błąd: ' . curl_error($ch);
} else {
    $result = json_decode(curl_exec($ch),true);
    $playlistId = $result['id'] ?? null;
}

curl_close($ch);

header('Content-Type: application/json');
echo json_encode($createdPlaylist, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>