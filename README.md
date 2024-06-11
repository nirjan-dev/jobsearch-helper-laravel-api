# Job Search Helper app API

This was a laravel API project created to support a Nuxt frontend app which helped users keep track of their job applications and create custom resumes for each job. In the end, I ended up going with using Nuxt fullstack with it's APIs instead of using a laravel backend. However, this project can be useful for learning purposes later if I want to do laravel again.

## Key dependencies

This project uses the following key dependencies for different features

-   octane: we're using frankenPHP with octane to keep the app in memory and improve performance
-   sanctum: API authentication
-   socialite: OAuth logins with github and google
-   resend-laravel: for sending emails using the resend service
-   postgres: for the DB (but any laravel compatible DB should work with a few changes to the migrations)

## features

-   OAuth login with google and github (need to specify the credentials in the .env file)
-   Magic link login with resend
-   API endpoints for updating the resume for the logged in user
-   github workflow to deploy automatically to fly.io on push to main.

## deployment

-   there is a Dockerfile for docker based deployments and a fly.toml file to configure deployments to fly.io. There is also a github action to deploy automatically to fly.io on push to main. Make sure the required env variables are set properly though.
