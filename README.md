# Implementation of parking project for self learning.

## Main Functionalities
***
This Application handles the query to backend based on search on frontend and makes sql query to docorized mysql server. 
The main aim of this project is to automate the process of setting up environment and make simple search to database based on some parameters and return response.

> This application utilises vue.js, axios.js and bootstrap for the frontend and .php in the backend.
It also uses docker for setting up the entire application with customised bin/* commands that will come as handy while dealing with docker-compose.

When the docker is started, application automatically adds basic schema from schema_skeleton.sql file and populate some test data using bash script. 

## Required before-hand
1. Git installed locally
2. Docker engine on the computer

## Starting the application
***
```
$ git clone git@github.com:suabsa/parkings.git
$ cd parking
$ bin/start 
and you are good to go. 
127.0.0.1:8080
```
## Specifications: 
***
```
$ bin/start -> builds and docker-compose up -d 
$ bin/stop -> stops the docker compose
$ bin/cli -> It will take to phpfpm container with root user prevelliages
$ bin/restart -> same as start/stop together
```

## Project Level
> variables.env is for defining variables for database. default.conf for nginx configuration.


