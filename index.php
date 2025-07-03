<?php

session_start();
if (!isset($_SESSION['access_token'])) {
    
    function generateRandomString($length) {
    $possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= $possible[random_int(0, strlen($possible) - 1)];
    }

    return $result;
  }

  $codeVerifier = generateRandomString(64);
  $codeChallenge = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(hash('sha256', $codeVerifier, true)));

  $clientID = getenv('SPOTIFY_CLIENT_ID');
  if (!$clientID) {
      die('Brak zmiennej środowiskowej SPOTIFY_CLIENT_ID.');
  }

  $redirectURI = 'http://127.0.0.1:80/PlaylistGenerator/php/callback.php';

  $scope = 'user-read-private user-read-email playlist-modify-public playlist-modify-private user-top-read user-read-recently-played user-library-read';
  $authURL = "https://accounts.spotify.com/authorize";

  $_SESSION['code_verifier'] = $codeVerifier;

  $stateData = [
      'code_verifier' => $codeVerifier,
      'timestamp' => time()
  ];

  $state = base64_encode(json_encode($stateData));

  $params = [
      'response_type' => 'code',
      'client_id' => $clientID,
      'redirect_uri' => $redirectURI,
      'scope' => $scope,
      'code_challenge' => $codeChallenge,
      'code_challenge_method' => 'S256',
      'state' => $state
  ];

  header('Location: ' . $authURL . '?' . http_build_query($params));
  exit;
}
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="description" content="">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta property="og:image:alt" content="">

  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="icon" href="/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="icon.png">

  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <header>
    <h1>Generator playlist</h1>
  </header>
  <main>
    <section id="tracklist_generation">
      <form id="playlist-form">
        <div class="playlist_info">
          <input type="text" id="playlistName" name="playlistName" placeholder="Podaj nazwę playlisty"><br />

          <input type="text" id="playlistDescription" name="playlistDescription"
            placeholder="Wprowadź opis playlisty"><br />
        </div>

        <div class="prompt_container">
          <input type="text" id="prompt_input" name="prompt_input" placeholder="Dodatkowe informacje, wymagania"><br /><br />
<p>Języki piosenek:</p>
          <div class="languages_container">
            <div class="language_group">
              <input type="checkbox" id="language1" name="language" value="polski">
            <label for="language1">Polski</label><br />
            </div>
<div class="language_group">
<input type="checkbox" id="language2" name="language" value="angielski">
            <label for="language2">Angielski</label><br />
</div>
            
<div class="language_group">
<input type="checkbox" id="language3" name="language" value="inne">
            <label for="language3">Inne</label><br />
</div>
            
          </div>

          <p>Gatunki muzyczne:</p>
          <div class="genres_container">

            <div class="checkbox-group">
              <input type="checkbox" id="genre1" name="genre" value="pop">
              <label for="genre1">Pop</label><br />

              <input type="checkbox" id="genre2" name="genre" value="rock">
              <label for="genre2">Rock</label><br />

              <input type="checkbox" id="genre3" name="genre" value="hiphop">
              <label for="genre3">Hip-Hop</label><br />

              <input type="checkbox" id="genre4" name="genre" value="rap">
              <label for="genre4">Rap</label><br />

              <input type="checkbox" id="genre5" name="genre" value="rnb">
              <label for="genre5">R&B</label><br />

              <input type="checkbox" id="genre6" name="genre" value="electronic">
              <label for="genre6">Elektroniczna</label><br />

              <input type="checkbox" id="genre7" name="genre" value="dance">
              <label for="genre7">Dance</label><br />

              <input type="checkbox" id="genre8" name="genre" value="house">
              <label for="genre8">House</label><br />
            </div>

            <div class="checkbox-group">
              <input type="checkbox" id="genre9" name="genre" value="disco">
              <label for="genre9">Disco</label><br />

              <input type="checkbox" id="genre10" name="genre" value="techno">
              <label for="genre10">Techno</label><br />

              <input type="checkbox" id="genre11" name="genre" value="metal">
              <label for="genre11">Metal</label><br />

              <input type="checkbox" id="genre12" name="genre" value="reggae">
              <label for="genre12">Reggae</label><br />

              <input type="checkbox" id="genre13" name="genre" value="blues">
              <label for="genre13">Blues</label><br />

              <input type="checkbox" id="genre14" name="genre" value="jazz">
              <label for="genre14">Jazz</label><br />

              <input type="checkbox" id="genre15" name="genre" value="soul">
              <label for="genre15">Soul</label><br />

              <input type="checkbox" id="genre16" name="genre" value="funk">
              <label for="genre16">Funk</label><br />
            </div>

            <div class="checkbox-group">
              <input type="checkbox" id="genre17" name="genre" value="classical">
              <label for="genre17">Klasyczna</label><br />

              <input type="checkbox" id="genre18" name="genre" value="country">
              <label for="genre18">Country</label><br />

              <input type="checkbox" id="genre19" name="genre" value="folk">
              <label for="genre19">Folk</label><br />

              <input type="checkbox" id="genre20" name="genre" value="latino">
              <label for="genre20">Latino</label><br />

              <input type="checkbox" id="genre21" name="genre" value="kpop">
              <label for="genre21">K-Pop</label><br />

              <input type="checkbox" id="genre22" name="genre" value="reggaeton">
              <label for="genre22">Reggaeton</label><br />

              <input type="checkbox" id="genre23" name="genre" value="trap">
              <label for="genre23">Trap</label><br />

              <input type="checkbox" id="genre24" name="genre" value="punk">
              <label for="genre24">Punk</label><br />
            </div>
          </div>
        </div>

      </form>
      <div class="button" id="generate_button">WYGENERUJ PIOSENKI</div>
    </section>
    <section id="playlist_creation">
      <textarea id="response_container"
        placeholder="Tutaj pojawią się piosenki zaproponowane przez AI.&#10&#10Jeśli masz własną listę piosenek, podaj ją tutaj w następującym formacie:&#10&#10Artysta - Tytuł&#10Artysta - Tytuł&#10Artysta - Tytuł"></textarea>
      <div class="button" id="create_button">STWÓRZ PLAYLISTĘ</div>
    </section>
  </main>
  <footer></footer>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $('#generate_button').on('click', async function (e) {

      const playlistName = $('#playlistName').val();
      const playlistDescription = $('#playlistDescription').val();
      const prompt_input = $('#prompt_input').val();

      if(!playlistName) {
        alert('Proszę wprowadzić nazwę playlisty.');
        return;
      }

      let languages = [];
      $('input[name=language]:checked').each(function () {
        languages.push($(this).val());
      });

      let genres = [];
      $('input[name=genre]:checked').each(function () {
        genres.push($(this).val());
      });

      const response = await fetch('./php/generate.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          playlistName: playlistName,
          playlistDescription: playlistDescription,
          prompt_input: prompt_input,
          languages: languages,
          genres: genres
        })
      });

      const data = await response.json();

      console.log(data);
      const songsList = data.songs
        .map(song => `${song.artist} - ${song.title}`)
        .join('\n');

      $('#response_container').text(songsList);
      // $('#response_container').text(JSON.stringify(data, null, 2));

    });

    $('#create_button').on('click', async function (e) {
      const tracklist = $('#response_container').val();
      const tracks = tracklist
        .split('\n')
        .map(track => track.trim())
        .filter(track => track);

      const playlistName = $('#playlistName').val();
      const playlistDescription = $('#playlistDescription').val();

      if(!playlistName) {
        alert('Proszę wprowadzić nazwę playlisty.');
        return;
      }

      const response = await fetch('./php/create.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          tracks: JSON.stringify(tracks, null, 2),
          playlistName: playlistName,
          playlistDescription: playlistDescription
        })
      });

      const data = await response.json();

      console.log(data);


      $('footer').html(`<p>Nazwa playlisty: ${data.name}</p>
                        <p>Opis playlisty: ${data.description}</p>
                        <p>Link do playlisty: <a href="https://open.spotify.com/playlist/${data.id}" target="_blank">https://open.spotify.com/playlist/${data.id}</a></p>`);
    });

  </script>
</body>

</html>