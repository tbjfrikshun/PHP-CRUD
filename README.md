# Project Title

Stand alone PHP CRUD application

## Getting Started

Clone or download to local project folder.

### Prerequisites

You will need a webserver, mySQL, git and composer already installed.

### Installing configuring

1) In project root directory: git clone "clone string copied from github"
2) create database 'crud' in mySQL with choosen login and password.
3) create table in 'crud' called 'data' with column id int(11) (check mark AUTO_INCREMENT), name varchar(100) and location varchar(100)
4) copy .env.example to .env modifing to actual database enviroment variables in .env
5) From project root run: composer install --no-dev
6) invoke index.php from web browser document root

