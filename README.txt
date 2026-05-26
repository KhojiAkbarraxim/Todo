TODO Project Overview
=====================

What this project is
--------------------
This is a small full-stack todo application.

It has:
- a PHP backend
- a static HTML/CSS/JavaScript frontend
- an SQLite database
- Docker Compose for local startup


Project structure
-----------------
docker-compose.yml
Starts the frontend and backend containers.

backend/
Contains the PHP API and database setup.

backend/index.php
Main backend entry file. Sets headers, loads the database, and includes routes.

backend/db.php
Creates the SQLite connection and ensures the todos table exists.

backend/routes/todo.php
Implements the todo API endpoints.

frontend/
Contains the browser UI.

frontend/index.html
Basic page markup.

frontend/app.js
Loads todos and sends create, update, and delete requests to the backend.

frontend/style.css
Very simple styling.

frontend/nginx.conf
Serves the frontend and proxies `/todos` requests to the backend container.


How the app works
-----------------
1. The browser loads the frontend from the nginx container.
2. JavaScript in `frontend/app.js` calls `/todos`.
3. nginx forwards `/todos` to the backend container.
4. PHP handles the request and talks to SQLite through PDO.
5. Results are returned as JSON.


API summary
-----------
GET /todos
Returns all todos.

POST /todos
Creates a todo.
Expected JSON:
{ "title": "Buy milk" }

PUT /todos
Updates a todo title.
Expected JSON:
{ "id": 1, "title": "Buy bread" }

DELETE /todos?id=1
Deletes a todo by id.


SQLite location
---------------
The database is configured here:
backend/db.php

Connection string:
sqlite:/app/todos.db

Important:
- `todos.db` is not stored in the repository by default
- it is created at runtime inside the backend container
- because there is no Docker volume for it, data will be lost if the backend container is recreated


Database schema
---------------
Table: todos

Columns:
- id INTEGER PRIMARY KEY AUTOINCREMENT
- title TEXT NOT NULL


How to run
----------
From the project root:

docker compose up --build

Then open:
http://localhost:3000


Current limitations and risks
-----------------------------
1. Backend routing is fragile
The backend uses PHP's built-in server, but requests to `/todos` depend on how that server resolves paths. A router script would make this more reliable.

2. No input validation
The backend trusts request JSON and does not validate missing or invalid values.

3. XSS risk in frontend
Todo titles are inserted into `innerHTML`, which can allow HTML or script injection if malicious content is stored.

4. No persistent database volume
SQLite data is stored only inside the backend container filesystem.

5. Minimal error handling
The frontend does not show useful messages when requests fail.


Good next improvements
----------------------
- add a PHP router or cleaner API entrypoint
- validate request data and return proper HTTP status codes
- render todo text safely without `innerHTML`
- mount a Docker volume for the SQLite database
- add better frontend error handling
- add a README.md later if you want standard GitHub documentation


Quick summary
-------------
This project is a simple Dockerized todo app using:
- nginx for frontend serving and proxying
- PHP for backend API logic
- SQLite for storage
- vanilla JavaScript for the UI
