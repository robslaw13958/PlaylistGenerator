<?php
session_start();

$input = json_decode(file_get_contents('php://input'), true);
$token = $_SESSION['access_token'];

if (empty($token)) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Access token is missing or invalid']);
    exit;
}

$playlistName = $input['playlistName'] ?? '';
$playlistDescription = $input['playlistDescription'] ?? '';

if (empty($playlistName)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Playlist name is required']);
    exit;
}

$userPrompt = $input['prompt_input'] ?? '';
$languages = $input['languages'] ?? [];
$genres = $input['genres'] ?? [];

$prompt = "Jesteś ekspertem muzycznym, który tworzy playlisty na podstawie danych od użytkownika. Twoim zadaniem jest wygenerowanie listy **prawdziwych, popularnych piosenek** (nie wymyślaj!) dostępnych na platformach streamingowych takich jak Spotify.

Nazwa playlisty: \"" . htmlspecialchars($playlistName) . "\".";

if (!empty($playlistDescription))
    $prompt .= " Opis playlisty: \"" . htmlspecialchars($playlistDescription) . "\".";

if (!empty($languages)) {
    $prompt .= " Uwzględnij tylko piosenki w językach: " . implode(', ', array_map('htmlspecialchars', $languages)) . ".";
}

if (!empty($genres)) {
    $prompt .= " Uwzględnij tylko gatunki muzyczne: " . implode(', ', array_map('htmlspecialchars', $genres)) . ".";
}

if (!empty($userPrompt)) {
    $prompt .= " Użytkownik dodał dodatkowy kontekst: \"" . htmlspecialchars($userPrompt) . "\".";
}

$output_schema = [
  'type'=> 'object',
  'properties'=> [
    'songs'=> [
      'type'=> 'array',
      'items'=> [
        'type'=> 'object',
        'properties'=> [
          'artist'=> ['type'=> 'string'],
          'title'=> ['type'=> 'string']
        ],
        'required'=> ['artist', 'title'],
        'additionalProperties'=> false
      ]
    ]
  ],
  'required'=> ['songs'],
  'additionalProperties'=> false
];

$data = [
    'model' => 'gpt-4.1-mini',
    'input' => $prompt,
    'temperature' => 0.5,
    'text' => [
        'format' => [
            'type' => 'json_schema',
            'schema' => $output_schema,
            'name' => 'track_list',
        ],
    ]
];

$ch = curl_init('https://api.openai.com/v1/responses');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . getenv('OPENAI_API_KEY'),
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $result = 'Błąd: ' . curl_error($ch);
} else {
    $text = json_decode($response, true)['output'][0]['content'][0]['text'];
    $result = json_decode($text, true);
    //$result = json_decode($response, true);
}

curl_close($ch);

header('Content-Type: application/json');
echo json_encode($result);
?>