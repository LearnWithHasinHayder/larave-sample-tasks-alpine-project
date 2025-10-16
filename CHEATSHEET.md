# 🚀 Developer Cheat Sheet

## Common Commands

### Development
```bash
# Start Vite dev server (assets)
npm run dev

# Start Laravel server
php artisan serve

# Watch for file changes (optional)
npm run watch
```

### Database
```bash
# Run migrations
php artisan migrate

# Reset database and seed
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create model with migration and factory
php artisan make:model ModelName -mf
```

### Laravel Artisan
```bash
# Create controller
php artisan make:controller ControllerName

# Create API controller
php artisan make:controller ControllerName --api

# Create request (for validation)
php artisan make:request RequestName

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# List all routes
php artisan route:list
```

## Quick API Testing (cURL)

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password"}'
```

### Get Tasks (replace TOKEN)
```bash
curl http://localhost:8000/api/tasks \
  -H "Authorization: Bearer TOKEN"
```

### Create Task
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"New Task","description":"Task details"}'
```

### Update Task (ID = 1)
```bash
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"Updated","is_completed":true}'
```

### Delete Task (ID = 1)
```bash
curl -X DELETE http://localhost:8000/api/tasks/1 \
  -H "Authorization: Bearer TOKEN"
```

## JavaScript Snippets

### Login with Axios
```javascript
const response = await axios.post('/api/login', {
    email: 'demo@example.com',
    password: 'password'
});
const token = response.data.token;
localStorage.setItem('token', token);
```

### Set Authorization Header
```javascript
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
```

### Get Tasks
```javascript
const response = await axios.get('/api/tasks');
const tasks = response.data.tasks;
```

### Create Task
```javascript
const response = await axios.post('/api/tasks', {
    title: 'New Task',
    description: 'Task description'
});
```

### Update Task
```javascript
const response = await axios.put(`/api/tasks/${taskId}`, {
    is_completed: true
});
```

### Delete Task
```javascript
await axios.delete(`/api/tasks/${taskId}`);
```

## Alpine.js Quick Reference

### Data Component
```javascript
x-data="{ count: 0, name: 'John' }"
```

### Show/Hide
```html
<div x-show="isVisible">Content</div>
```

### Click Event
```html
<button @click="count++">Click</button>
```

### Model (Two-way binding)
```html
<input x-model="name" type="text">
```

### Loop
```html
<template x-for="item in items" :key="item.id">
    <div x-text="item.name"></div>
</template>
```

### Conditional Class
```html
<div :class="isActive ? 'bg-blue-500' : 'bg-gray-500'">
```

## Tailwind CSS Utilities

### Layout
```html
<!-- Flexbox -->
<div class="flex justify-between items-center">

<!-- Grid -->
<div class="grid grid-cols-3 gap-4">

<!-- Container -->
<div class="container mx-auto px-4">
```

### Spacing
```html
<!-- Padding -->
<div class="p-4 px-6 py-8">

<!-- Margin -->
<div class="m-4 mx-auto my-6">
```

### Colors
```html
<!-- Background -->
<div class="bg-blue-500 bg-indigo-600">

<!-- Text -->
<p class="text-gray-700 text-white">

<!-- Border -->
<div class="border border-gray-300 border-red-500">
```

### Typography
```html
<h1 class="text-3xl font-bold text-gray-800">
<p class="text-sm text-gray-600">
```

### Effects
```html
<!-- Rounded corners -->
<div class="rounded-lg rounded-full">

<!-- Shadow -->
<div class="shadow-md shadow-xl">

<!-- Hover -->
<button class="hover:bg-blue-700 hover:shadow-lg">

<!-- Transition -->
<div class="transition-colors transition-all">
```

## Troubleshooting

### "Vite manifest not found"
**Solution:** Run `npm run dev` in a separate terminal

### Tasks not loading
**Solutions:**
1. Check you're logged in (check localStorage for token)
2. Check browser console for errors
3. Verify API is running: `php artisan serve`
4. Check database: `php artisan migrate:fresh --seed`

### CORS errors
**Solution:** Since frontend and backend are on same domain, shouldn't be an issue. If using separate frontend, configure CORS in Laravel.

### 401 Unauthorized
**Solutions:**
1. Make sure you're sending the token in Authorization header
2. Token format: `Bearer YOUR_TOKEN_HERE`
3. Token might be expired - login again (tokens now last 1 year)
4. Check `personal_access_tokens` table in database

### Token Expiring Too Quickly
**Solution:** Tokens are now configured to last 1 year. See `TOKEN_CONFIGURATION.md` for details.
- Config: `config/sanctum.php` → `'expiration' => 525600`
- Per-token: `createToken('auth-token', ['*'], now()->addYear())`

### Database connection error
**Solutions:**
1. Check `.env` database credentials
2. Create database if it doesn't exist
3. Run `php artisan config:clear`

## Pro Tips

1. **Use Postman/Insomnia** for API testing - easier than cURL
2. **Browser DevTools** - Check Network tab for API calls
3. **Vue DevTools** also works with Alpine.js for debugging
4. **Laravel Debugbar** - Install for detailed debugging info
5. **Git commits** - Commit after each feature!

## Useful Links

- Laravel Docs: https://laravel.com/docs
- Sanctum Docs: https://laravel.com/docs/sanctum
- Alpine.js Docs: https://alpinejs.dev
- Tailwind CSS Docs: https://tailwindcss.com
- Axios Docs: https://axios-http.com

---

**Keep this handy while developing! 🚀**
