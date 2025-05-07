# 📚 LifeMaxxing – Track Your Academic Goals

Welcome to **LifeMaxxing** – a clean, no-fluff dashboard to log your study goals, track tasks, and stay on top of your uni grind.

---

## 🧠 What’s This Project About?

I built this as a university project to keep track of:
- 🎯 Study goals and milestones
- 📋 Tasks with descriptions and progress
- 🗃️ Categories to organize everything
- 🧑 Friends & Follow features to simulate basic social connection

Everything is modular, clean, and extendable if I want to go further.

---

## ⚙️ How It Works

- **Frontend**: Built with the SeoDash free Bootstrap 5 template.
- **Backend**: Pure **vanilla PHP** using **MySQL**.
- REST-like endpoints in `/backend/dao/*` return JSON.
- Uses **modular DAO** structure (`TaskDao`, `UserDao`, etc.).
- All requests from frontend use `fetch()` with CORS.
- **Swagger UI** is set up **locally** to test the API.

---

## 🛠️ Tech Stack

- HTML / CSS / JavaScript
- Bootstrap 5 (SeoDash UI)
- PHP (no framework)
- MySQL (local database)
- FlightPHP (for routing + Composer autoload)
- Swagger / OpenAPI (for docs)

---

## 📁 Folder Structure

/frontend/ ← The dashboard UI
/backend/
├── dao/ ← All PHP APIs (tasks, users, etc.)
│ ├── tasks/
│ ├── users/
│ ├── categories/
│ ├── friends/
│ └── follows/
├── Database.php
├── BaseDao.php
├── vendor/ ← Composer deps (FlightPHP)
├── swagger-ui/ ← Local Swagger Viewer
└── lifemaxxing.yaml ← OpenAPI spec

---

## 🚀 Run It Locally

1. ✅ Make sure you have **PHP** and **MySQL** installed.
2. 🔽 Clone or download this repo.
3. 🛠 Create a MySQL database (import the provided `.sql` if needed).
4. ▶️ Run this from the `backend/` folder:
5. 🌐 Visit: php -S localhost:8000
   
🧪 Swagger API Docs (Local)
1. Go to:

http://localhost:8000/swagger-ui/

2. It will load lifemaxxing.yaml automatically and show a clean UI.
3. You can test every endpoint — GET, POST, DELETE, etc.

💡 Professor Tips
Swagger is fully working locally and reflects every API file from /backend/dao.

Each entity (Task, User, Friend, etc.) has full CRUD.

Code is clean, modular, and ready to expand (e.g. auth, charts, filters).

There are no external APIs — it’s all local and simple to follow.

Personal note
I didn’t wanna use stuff like WAMP or XAMPP for this. I wanted to run everything myself — set up PHP’s built-in server, connect to the database manually, and really understand how it all works under the hood. No shortcuts. Just me figuring it out piece by piece, so I actually get what’s going on behind the scenes. It was more fun that way too.