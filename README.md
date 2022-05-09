# Codenip Weather API
This repository contains the code related to one of our streamings at https://twitch.tv/codenip_devs

Link to the streaming re-uploaded to YouTube https://youtu.be/ewtkNP7kHYo

## Content
- PHP container running version 8.1.1
- MySQL container running version 8.0.26

## Instructions
- `make build` to build the containers
- `make start` to start the containers
- `make stop` to stop the containers
- `make restart` to restart the containers
- `make prepare` to install dependencies with composer (once the project has been created) as well as Yarn dependencies
- `make logs` to see application logs
- `make ssh-be` to SSH into the application container

## View example
![image](https://user-images.githubusercontent.com/6040385/167412559-9a41c9c6-5908-465a-b765-3c484897b6e8.png)
