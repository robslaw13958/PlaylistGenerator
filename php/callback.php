<?php
session_start();

$stateData = json_decode(base64_decode($_GET['state']), true);
$codeVerifier = $stateData['code_verifier'];

if (!isset($codeVerifier)) {
    error_log("PKCE callback bez code_verifier - IP: " . $_SERVER['REMOTE_ADDR'] . " - URL: " . $_SERVER['REQUEST_URI']);
    session_destroy();
    header('Location: http://127.0.1:80/PlaylistGenerator/index.php?error=invalid_state');
    exit;
}

$postData = [
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'] ?? '',
    'redirect_uri' => 'http://127.0.0.1:80/PlaylistGenerator/php/callback.php',
    'client_id' => getenv('SPOTIFY_CLIENT_ID'),
    'code_verifier' => $codeVerifier,
];

$ch = curl_init('https://accounts.spotify.com/api/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($httpCode === 200) {
    
    $tokenData = json_decode($response, true);

    $_SESSION['access_token'] = $tokenData['access_token'];
    $_SESSION['refresh_token'] = $tokenData['refresh_token'];
    $_SESSION['expires_in'] = $tokenData['expires_in'];

    unset($_SESSION['code_verifier']);

    $stateData = [
      'verified' => 'true'
  ];
  $state = base64_encode(json_encode($stateData));

  $params = [
    'state' => $state
  ];

    header('Location: http://127.0.0.1:80/PlaylistGenerator/index.php' . '?' . http_build_query($params));
    exit;
} else {
    echo "Error: HTTP Code $httpCode<br>";
    echo "Response: $response<br>";
    exit;
}

?>