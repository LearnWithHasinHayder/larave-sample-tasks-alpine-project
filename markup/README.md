# 📁 Markup Files for Alpine.js Conversion

This folder contains standalone HTML markup files ready to be converted into a functional Alpine.js application.

## 📄 Files

### 1. `auth-markup.html`
**Login & Registration Page**

Features:
- ✅ Tab switching between Login and Register forms
- ✅ Email and password validation
- ✅ Error and success message displays
- ✅ Loading states during form submission
- ✅ Demo credentials display
- ✅ Auto-redirect if already logged in
- ✅ Beautiful gradient background
- ✅ Responsive design

**Alpine.js Components:**
- `authApp()` - Main component with login/register logic
- `init()` - Check if user is already logged in
- `login()` - Handle login API call
- `register()` - Handle registration API call

**API Endpoints Used:**
- `POST /api/login` - User login
- `POST /api/register` - User registration

---

### 2. `tasks-markup.html`
**Task Management Dashboard**

Features:
- ✅ Header with user greeting and logout button
- ✅ Statistics cards (Total, Completed, Pending)
- ✅ Add new task form with title and description
- ✅ Task list with filtering (All, Pending, Completed)
- ✅ Toggle task completion with checkbox
- ✅ Delete task with confirmation
- ✅ Empty state messages
- ✅ Success/error notifications
- ✅ Auto-redirect if not logged in

**Alpine.js Components:**
- `tasksApp()` - Main component with task management logic
- `init()` - Check authentication and load tasks
- `loadTasks()` - Fetch tasks from API
- `addTask()` - Create new task
- `toggleTask()` - Mark task as complete/incomplete
- `deleteTask()` - Remove task
- `logout()` - Log out user

**Computed Properties:**
- `filteredTasks` - Filter tasks by status
- `completedCount` - Count completed tasks
- `pendingCount` - Count pending tasks

**API Endpoints Used:**
- `GET /api/tasks` - Get all tasks
- `POST /api/tasks` - Create new task
- `PUT /api/tasks/{id}` - Update task
- `DELETE /api/tasks/{id}` - Delete task
- `POST /api/logout` - Logout user

---

## 🚀 How to Use These Files

### Option 1: Open Directly in Browser
1. Open the HTML file in your browser
2. Make sure your Laravel API is running (`php artisan serve`)
3. The files will work standalone with CDN-loaded libraries

### Option 2: Test Without Backend (Mock Data)
You can modify the files to use mock data instead of API calls:

```javascript
// Instead of:
const response = await axios.get('/api/tasks');
this.tasks = response.data.tasks;

// Use:
this.tasks = [
    { id: 1, title: 'Sample Task', description: 'Test', is_completed: false, created_at: new Date() },
    { id: 2, title: 'Another Task', description: 'Demo', is_completed: true, created_at: new Date() }
];
```

### Option 3: Convert to Alpine.js Component System
Extract the Alpine.js logic into separate component files:

**File structure:**
```
src/
  components/
    authApp.js
    tasksApp.js
  index.html
  tasks.html
```

---

## 🎨 Styling

Both files use:
- **Tailwind CSS** (via CDN) - Utility-first CSS framework
- **Custom gradient backgrounds** - `from-blue-50 to-indigo-100`
- **Consistent color scheme**:
  - Primary: Indigo (600/700)
  - Success: Green (600)
  - Warning: Orange (600)
  - Danger: Red (500/600)
- **Rounded corners** - `rounded-lg`, `rounded-xl`, `rounded-2xl`
- **Shadows** - `shadow-md`, `shadow-xl`
- **Transitions** - Smooth hover and state changes

---

## 🔧 Key Alpine.js Patterns Used

### 1. Reactive Data
```html
<div x-data="{ count: 0 }">
    <button @click="count++">Increment</button>
    <span x-text="count"></span>
</div>
```

### 2. Conditional Rendering
```html
<div x-show="isVisible">Content</div>
<div x-show="!isVisible">Alternative</div>
```

### 3. Form Binding
```html
<input x-model="form.email" type="email">
```

### 4. Event Handling
```html
<form @submit.prevent="handleSubmit">
<button @click="toggleModal">
```

### 5. Dynamic Classes
```html
<div :class="active ? 'bg-blue-500' : 'bg-gray-500'">
```

### 6. Loops
```html
<template x-for="item in items" :key="item.id">
    <div x-text="item.name"></div>
</template>
```

### 7. Computed Properties
```javascript
get completedCount() {
    return this.tasks.filter(t => t.is_completed).length;
}
```

---

## 📦 Dependencies (via CDN)

1. **Tailwind CSS**
   ```html
   <script src="https://cdn.tailwindcss.com"></script>
   ```

2. **Alpine.js**
   ```html
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
   ```

3. **Axios**
   ```html
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   ```

---

## 🎯 Converting to Your Alpine Project

### Step 1: Extract HTML Structure
Copy the HTML markup (without the `<script>` tags) into your component templates.

### Step 2: Extract Alpine.js Logic
Move the JavaScript functions into separate component files or a state management system.

### Step 3: Replace CDN Links
Install packages via npm:
```bash
npm install alpinejs axios
npm install -D tailwindcss
```

### Step 4: Configure Build System
Set up Vite, Webpack, or your preferred bundler to compile the assets.

### Step 5: Add API Configuration
Create a centralized API configuration file:
```javascript
// api.js
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.headers.common['Content-Type'] = 'application/json';

export default axios;
```

---

## 🔐 Authentication Flow

1. User visits auth page
2. Submits login/register form
3. Token received and stored in localStorage
4. User redirected to tasks page
5. Tasks page checks for token
6. All API requests include token in Authorization header
7. Logout removes token and redirects to auth page

---

## 💡 Pro Tips

1. **Test individually** - Open each HTML file directly in browser to test
2. **Use DevTools** - Inspect Alpine.js data with `$data` in console
3. **Mock API first** - Use mock data before connecting to real API
4. **Component isolation** - Each component should be self-contained
5. **Error handling** - Always have try-catch blocks for API calls

---

## 🐛 Troubleshooting

**Problem:** Alpine.js not working
- **Solution:** Make sure Alpine.js CDN loads before your script

**Problem:** API calls failing
- **Solution:** Check that Laravel server is running and CORS is configured

**Problem:** Token expired errors
- **Solution:** Login again to get a fresh token (tokens last 1 year)

**Problem:** Styles not applying
- **Solution:** Ensure Tailwind CDN is loaded

---

## 📚 Learning Resources

- Alpine.js Docs: https://alpinejs.dev
- Tailwind CSS Docs: https://tailwindcss.com
- Axios Docs: https://axios-http.com
- MDN Web Docs: https://developer.mozilla.org

---

**Happy coding! 🚀**
