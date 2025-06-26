<?php
$input = json_decode(file_get_contents('php://input'), true);


$playlistName = $input['playlistName'] ?? '';
$playlistDescription = $input['playlistDescription'] ?? '';
$generationMethod = $input['generationMethod'];
if($generationMethod == 'tracklist') {
    $tracklist = $input['tracklist_input'] ?? [];
} else if ($generationMethod == 'prompt') {
    $prompt = $input['prompt_input'] ?? '';
    $languages = $input['languages'] ?? [];
    $genres = $input['genres'] ?? [];
}

$response = ["playlistName" => htmlspecialchars($playlistName),
            "playlistDescription" => htmlspecialchars($playlistDescription),
            "generationMethod" => $generationMethod,
            "tracklist" => $tracklist ?? [],
            "prompt" => htmlspecialchars($prompt ?? ''),
            "languages" => $languages ?? [],
            "genres" => $genres ?? []];

header('Content-Type: application/json');
echo json_encode($response);
?>