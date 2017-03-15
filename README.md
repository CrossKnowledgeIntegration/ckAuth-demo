# ckAuth demo

This project is a sample that explains how you can implement the ckAuth login process.

This is a 3 steps process:

1. Get a token from your instance's profile page. This token is a "key" (ex. AFGREUS), that encapsulates your user login and instance URL you are attached to.

2. Use this token to validate it (prupose of this sample project)

3. Once validated, you get back from the service
    * The learner's login
    * The instance URL
    * The passkey associated to this account (it's not the actual password, but a private key)

    You can now call the [REST API](http://integration.crossknowledge.com/REST_API_description) using these credentials.

## Rules

You have to store on your application the login (local storage for instance), url and passkey - and reuse it each time your learner wants to access the API.

If you do not so, then, each time the learner will have to get a token from his profile page.

You have however to implement a session expiration, 30 days for instance. 

You also have to implement a manual log out.

Both actions above will result in deleting the information you've stored, so, next time the learner uses your application, he will have to get a token.

## Limitation

Currently, our web services (the one to validate the token and the REST API) do not allow cross-scripting. Therefore, these calls must be done server-side (or via native mobile application code). They will not work in client code, JavaScript for instance.

In this sample, the "validate" method is in the proxy.php - so, to run it, you have to host it on a php web server (php -S to use the php runtime builtin server for testig purpose)

## Disclaimer

This code is provided "AS IS", and the [MIT licence](https://opensource.org/licenses/MIT) is applied