
Hey! This is my very first real PHP project - a game library, wired to the RAWG API, allowing you to explore and browse games available through that API.

Current features :

- fetches and displays games from the RAWG api
- fetches and displays developers from the RAWG api
- allows you to add favourites

It makes use of RAWG API - <https://rawg.io/apidocs> and you will need an API key to access it. 

After aquiring your API key, create an '.env' file in the root directory, and add to it the following:

```
  RAWG_API_KEY="Your_Key_Goes_Here"
```

Without it, data will not be properly downloaded and you likely won't see anything. RAWG will probably also ban you from accessing their API.

I assume you also have Composer installed.

After cloning the repo, enter the project directory and run

```
composer install
```

This will download any required packages into a 'vendor' directory.

You'll also need a PHP server to run it on. I use XAMPP for development - <https://www.apachefriends.org/pl/download.html>

