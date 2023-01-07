    FROM nginx:latest   
    COPY ./default.conf /etc/nginx/conf.d/default.conf
    COPY /etc/letsencrypt/live/journalr.ca/fullchain.pem /etc/nginx/conf.d/fullchain.pem
    COPY /etc/letsencrypt/live/journalr.ca/privkey.pem /etc/nginx/conf.d/privkey.pem