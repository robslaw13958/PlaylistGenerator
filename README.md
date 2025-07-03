# AI Playlist Generator

Aplikacja webowa która jednym kliknięciem generuje playlisty na profilu Spotify przy pomocy sztucznej inteligencji.
Użytkownik może pozwolić AI na wygenerowanie listy piosenek na podstawie promptu i preferencji, lub wprowadzić własną listę utworów.

## Funkcjonalności

- **Generowanie przez AI**: Wpisz prompt opisujący jaką muzykę chcesz, wybierz język i gatunek
- **Edycja rezultatów**: Możliwość modyfikacji wygenerowanej listy piosenek
- **Ręczne tworzenie**: Pomiń AI i wprowadź własną listę utworów
- **Eksport do Spotify**: Jednym kliknięciem stwórz playlistę na swoim koncie Spotify
- **Podgląd rezultatu**: Po utworzeniu playlisty wyświetla się jej nazwa, opis i link

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

###Plany rozwoju
- Lepsze zarządzanie błędami
- Refraktoryzacja kodu - stworzenie funkcji do zarządzania żądaniami
- Dodanie obsługi Refresh Tokenu
- Ulepszenia UI/UX
- Dodatkowe opcje personalizacji
- Walidacja piosenek od AI
- TBA...
