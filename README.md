# journalr
A digital planner

## What is this
This is mainly a passion project to make a convenient day planner as an eventual PWA and figure out how to use docker in a production environment 

## How to install
1. Install Docker and docker-compose

2. Obtain a Google oauth2 client_secret_??????.json (https://developers.google.com/workspace/guides/create-credentials)

3. Clone repo

4. Rename client_secret_????.json to google_secret.txt

5. Put google_secret.txt in the **secrets/** secrets directory as per the docker-compose.yml 

6. Obtain SSL cert and modify nginx configuration in the nginx directory to your certificate. 

7. Run the containers

## How to run
Run `docker-compose up -d` to run containers detached in the background

Run `docker-compose down -v` to shutdown and remove containers and volumes

Run `docker-compose up --build` to force a image rebuild of all referenced containers


### Built with:
- Docker
- docker-compose
- PHP
- MariaBD
- Nginx
- Composer for PHP
- FullCalendar
- EditorJS

#### Todo
Setup Docker Swarm for production clusters.

Make readme better :)
