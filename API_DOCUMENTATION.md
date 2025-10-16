# ✨ Task Manager API - Laravel 12 + Sanctum + Alpine.js

A fun and beginner-friendly task management application built with Laravel 12, Sanctum authentication, Alpine.js, and Tailwind CSS!

## 🎯 Features

- **Full REST API** with Laravel Sanctum token authentication
- **User Authentication** (Register, Login, Logout with tokens)
- **Task Management** (Create, Read, Update, Delete)
- **Beautiful UI** with Alpine.js and Tailwind CSS
- **Smart Redirects** - Login page auto-redirects if already authenticated
- **Route Protection** - Tasks page redirects to login if not authenticated
- **Real-time Stats** showing total, completed, and pending tasks
- **Filtering** by all, pending, or completed tasks
- **Seeded Demo Data** ready to use!

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL/PostgreSQL

### Installation

1. **Install dependencies:**
```bash
composer install
npm install
```

2. **Set up environment:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure database in `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_api
DB_USERNAME=root
DB_PASSWORD=
```

4. **Run migrations and seed data:**
```bash
php artisan migrate:fresh --seed
```

5. **Build assets:**
```bash
npm run dev
```

6. **Start the server:**
```bash
php artisan serve
```

7. **Open your browser:**
Navigate to `http://localhost:8000`

## 🎉 Demo Account

Use these credentials to login:
- **Email:** demo@example.com
- **Password:** password

## 📚 API Endpoints

### Authentication

#### Register
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "demo@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "message": "Login successful! Welcome back! 👋",
    "user": {
        "id": 1,
        "name": "Demo User",
        "email": "demo@example.com"
    },
    "token": "1|abc123xyz..."
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Get Current User
```http
GET /api/user
Authorization: Bearer {token}
```

### Tasks (All require authentication)

#### Get All Tasks
```http
GET /api/tasks
Authorization: Bearer {token}
```

#### Create Task
```http
POST /api/tasks
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Buy groceries",
    "description": "Milk, eggs, bread"
}
```

#### Get Single Task
```http
GET /api/tasks/{id}
Authorization: Bearer {token}
```

#### Update Task
```http
PUT /api/tasks/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated title",
    "description": "Updated description",
    "is_completed": true
}
```

#### Delete Task
```http
DELETE /api/tasks/{id}
Authorization: Bearer {token}
```

## 🧪 Testing with cURL

### Login and Get Token
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password"}'
```

### Get Tasks
```bash
curl http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Create Task
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Task","description":"This is a test"}'
```

## 🎨 Frontend Pages

- **`/login`** - Login and Registration page
- **`/tasks`** - Task management dashboard

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── AuthController.php    # Authentication endpoints
│   └── TaskController.php     # Task CRUD operations
├── Models/
│   ├── Task.php              # Task model
│   └── User.php              # User model with HasApiTokens

database/
├── factories/
│   └── TaskFactory.php       # Fake task generator
├── migrations/
│   └── create_tasks_table.php
└── seeders/
    └── DatabaseSeeder.php    # Seeds demo user + tasks

resources/
├── views/
│   ├── layout.blade.php      # Base layout
│   ├── auth.blade.php        # Login/Register page
│   └── tasks.blade.php       # Task dashboard

routes/
├── api.php                   # API routes
└── web.php                   # Web routes
```

## 🔒 Security Features

- **Password Hashing** with bcrypt
- **Token-based Authentication** via Laravel Sanctum
- **User Authorization** - Users can only access their own tasks
- **CSRF Protection** on web routes
- **Validation** on all inputs

## 💡 How It Works

### Authentication Flow
1. User visits `/login` - automatically redirected to `/tasks` if already logged in
2. User registers or logs in via `/api/register` or `/api/login`
3. Server returns a Sanctum token
4. Frontend stores token in localStorage
5. User is redirected to `/tasks` dashboard
6. All subsequent API requests include token in Authorization header

### Route Protection
- `/login` checks for existing token and redirects to `/tasks` if found
- `/tasks` checks for token and redirects to `/login` if not found
- Logout removes token from localStorage and redirects to `/login`

### Task Management
1. Frontend sends authenticated requests to `/api/tasks`
2. Backend validates token via Sanctum middleware
3. Controller ensures user owns the task (authorization)
4. CRUD operations are performed
5. Response sent back to frontend
6. Alpine.js updates the UI reactively

## 🎓 Learning Points

This project demonstrates:
- **RESTful API design** with Laravel
- **Token authentication** with Sanctum
- **Reactive frontend** with Alpine.js
- **Database relationships** (User has many Tasks)
- **Factory & Seeder** patterns
- **Form validation** (backend + frontend)
- **Error handling** and user feedback
- **Clean code structure** and separation of concerns

## 🛠️ Built With

- **Laravel 12** - PHP Framework
- **Laravel Sanctum** - API Authentication
- **Alpine.js** - Reactive JavaScript framework
- **Tailwind CSS** - Utility-first CSS framework
- **Axios** - HTTP client
- **Vite** - Frontend build tool

## 📝 License

This is a demo/educational project. Feel free to use it however you like!

## 🤝 Contributing

This is a learning project, but suggestions are welcome!

---

Made with ❤️ for learning Laravel and API development!

**Happy Coding! 🚀**
