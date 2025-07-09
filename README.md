# AI Playlist Generator

Aplikacja webowa która jednym kliknięciem generuje playlisty na profilu Spotify przy pomocy sztucznej inteligencji.
Użytkownik może pozwolić AI na wygenerowanie listy piosenek na podstawie promptu i preferencji, lub wprowadzić własną listę utworów.

## Funkcjonalności

- **Generowanie przez AI**: Wpisz prompt opisujący jaką muzykę chcesz, wybierz język i gatunek
- **Edycja rezultatów**: Możliwość modyfikacji wygenerowanej listy piosenek
- **Ręczne tworzenie**: Pomiń AI i wprowadź własną listę utworów
- **Eksport do Spotify**: Jednym kliknięciem stwórz playlistę na swoim koncie Spotify
- **Podgląd rezultatu**: Po utworzeniu playlisty wyświetla się jej nazwa, opis i link

### Zrzuty ekranu

#### 1. Ekran po uruchomieniu aplikacji
![image](https://github.com/user-attachments/assets/c594f2bd-19e7-499f-89f3-a01fdb36323f)
#### 2. Wprowadzenie danych i kliknięcie 'WYGENERUJ PIOSENKI' - lista pojawia się po prawej stronie
![image](https://github.com/user-attachments/assets/85a309d3-52e4-46d7-8382-eb9265775710)
#### 3. Po kliknięciu 'STWÓRZ PLAYLISTĘ' pojawia się ona na profilu użytkownika
![image](https://github.com/user-attachments/assets/310a292a-747d-40b5-a097-b03bee4fbc42)


## Technologie

- Frontend: HTML, CSS, jQuery
- Backend: PHP
- API: 
  - Spotify Web API
  - OpenAI API
- Konfiguracja: plik .htaccess

### Przykład pliku .htaccess
SetEnv SPOTIFY_CLIENT_ID *twoj_spotify_client_id*<br>
SetEnv OPENAI_API_KEY *twoj_openai_api_key*

## Sposób użycia
1. Lewa sekcja: Wpisz tytuł i opis planowanej playlisty
2. Prompt dla AI: Opisz jaki rodzaj muzyki Cię interesuje
3. Preferencje: Wybierz język i gatunek muzyczny
4. Kliknij "Generuj piosenki" lub przejdź do kroku 6
5. Prawa sekcja: Sprawdź wygenerowaną listę, edytuj jeśli potrzeba
6. Alternatywnie: Wprowadź własną listę piosenek pomijając AI
7. Kliknij "Stwórz playlistę" - zostaniesz przekierowany do Spotify
8. Rezultat: W stopce pojawi się link do utworzonej playlisty

## Status
MVP - podstawowa funkcjonalność działa

### Plany rozwoju
- Lepsze zarządzanie błędami
- Refraktoryzacja kodu - stworzenie funkcji do zarządzania żądaniami
- Dodanie obsługi Refresh Tokenu
- Ulepszenia UI/UX
- Dodatkowe opcje personalizacji
- Walidacja piosenek od AI
- TBA...
