# journalr
A digital planner

## What is this
This is mainly a passion project to make a convenient day planner as an eventual PWA and figure out how to use docker in a production environment 

## How to install
Install Docker and docker-compose
Obtain a Google oauth2 client.json (https://support.google.com/cloud/answer/6158849?hl=en)
Clone or fork repo, put file in **secrets** as **google_secret.txt** as per docker-compose.yml
Obtain SSL cert and modify nginx configuration to your certificate. 
You are now ready to run the containers

## How to run
Run `docker-compose up -d` to run containers detached in the background 
Run `docker-compose down -v` to shutdown and remove containers and volumes
Run `docker-compose up --build` to force a image rebuild of all referenced containers


### Built with:
Docker
docker-compose
PHP
MariaBD
Nginx
Composer for PHP
FullCalendar
EditorJS

#### Todo
Setup Docker Swarm for production clusters.
Make readme better :)
