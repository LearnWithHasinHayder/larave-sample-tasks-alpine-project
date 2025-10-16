# 🚀 Quick Start Guide

## Step 1: Start the Development Server

Open two terminal windows:

**Terminal 1 - Start Vite (for assets):**
```bash
npm run dev
```

**Terminal 2 - Start Laravel:**
```bash
php artisan serve
```

## Step 2: Open Your Browser

Visit: `http://localhost:8000`

## Step 3: Login

Use the demo credentials:
- **Email:** demo@example.com
- **Password:** password

## Step 4: Enjoy! 🎉

You now have a fully functional task management app with:
- ✅ User authentication
- ✅ Create, edit, and delete tasks
- ✅ Mark tasks as complete
- ✅ Filter by status
- ✅ Beautiful UI with Alpine.js and Tailwind

## 🔧 Troubleshooting

### If you get "Vite manifest not found"
Make sure `npm run dev` is running in a separate terminal.

### If tasks don't load
1. Check that database is set up: `php artisan migrate:fresh --seed`
2. Make sure you're logged in
3. Check browser console for errors

### To reset everything
```bash
php artisan migrate:fresh --seed
```

## 📱 Testing the API

You can test the API using tools like:
- Postman
- Insomnia
- Thunder Client (VS Code extension)
- cURL (see API_DOCUMENTATION.md)

### Example: Get Tasks via API

1. Login first to get token:
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password"}'
```

2. Copy the token from response

3. Get tasks:
```bash
curl http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## 🎨 Customization Ideas

1. **Add task priorities** (low, medium, high)
2. **Add due dates** for tasks
3. **Add categories/tags** for organizing tasks
4. **Add task sharing** between users
5. **Add email notifications** for due tasks
6. **Add dark mode** toggle

Have fun building! 🎉
