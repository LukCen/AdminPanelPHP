
Hey! This is my very first real PHP project - an admin/control panel, wired to the RAWG API, allowing you to explore and browse games available through that API.

For now it just displays some basic stuff but as I learn the language, more features will appear over time.

It makes use of RAWG API - <https://rawg.io/apidocs> and you will need an API key to access it. 

After aquiring your API key, create an '.env' file in the root directory, and add to it the following:

```
  RAWG_API_KEY="Your_Key_Goes_Here"
```

Without it, data will not be properly downloaded and you likely won't see anything. RAWG will probably also ban you from accessing their API.

