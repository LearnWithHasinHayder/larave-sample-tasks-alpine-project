# 🔄 Conversion Guide: HTML to Alpine.js Project

This guide will help you convert the markup files into a structured Alpine.js application.

---

## 🎯 Conversion Approaches

### Approach 1: Keep as Standalone (Easiest)
**Best for:** Quick prototypes, demos
- Keep files as-is
- Open directly in browser
- CDN-loaded libraries

### Approach 2: Split into Components (Moderate)
**Best for:** Reusable components, better organization
- Extract Alpine.js logic into separate files
- Use ES6 modules
- Bundle with Vite or Webpack

### Approach 3: Full Alpine.js Build System (Advanced)
**Best for:** Production apps, complex projects
- npm packages instead of CDN
- Build pipeline with Vite
- Component system
- Environment variables

---

## 📦 Approach 2: Component-Based Structure

### Recommended File Structure

```
alpine-project/
├── index.html                  # Auth page
├── tasks.html                  # Tasks page
├── src/
│   ├── components/
│   │   ├── authApp.js         # Auth component
│   │   └── tasksApp.js        # Tasks component
│   ├── utils/
│   │   ├── api.js             # API client
│   │   └── storage.js         # localStorage helpers
│   └── app.js                 # Main entry point
├── styles/
│   └── main.css               # Custom styles
├── package.json
└── vite.config.js
```

---

## 🔧 Step-by-Step Conversion

### Step 1: Initialize Project

```bash
mkdir alpine-project
cd alpine-project
npm init -y
npm install alpinejs axios
npm install -D tailwindcss vite
```

### Step 2: Extract Auth Component

**File: `src/components/authApp.js`**

```javascript
import { api } from '../utils/api';
import { storage } from '../utils/storage';

export function authApp() {
    return {
        isLogin: true,
        loading: false,
        error: '',
        success: '',
        loginForm: {
            email: '',
            password: ''
        },
        registerForm: {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        },

        init() {
            if (storage.hasToken()) {
                window.location.href = '/tasks.html';
            }
        },

        async login() {
            this.loading = true;
            this.error = '';
            this.success = '';

            try {
                const data = await api.login(this.loginForm);
                storage.setToken(data.token);
                storage.setUser(data.user);
                this.success = data.message;
                
                setTimeout(() => {
                    window.location.href = '/tasks.html';
                }, 500);
            } catch (error) {
                this.error = error.message || 'Login failed';
            } finally {
                this.loading = false;
            }
        },

        async register() {
            this.loading = true;
            this.error = '';
            this.success = '';

            try {
                const data = await api.register(this.registerForm);
                storage.setToken(data.token);
                storage.setUser(data.user);
                this.success = data.message;
                
                setTimeout(() => {
                    window.location.href = '/tasks.html';
                }, 500);
            } catch (error) {
                this.error = error.message || 'Registration failed';
            } finally {
                this.loading = false;
            }
        }
    }
}
```

### Step 3: Extract Tasks Component

**File: `src/components/tasksApp.js`**

```javascript
import { api } from '../utils/api';
import { storage } from '../utils/storage';

export function tasksApp() {
    return {
        tasks: [],
        user: {},
        newTask: { title: '', description: '' },
        loading: false,
        message: '',
        messageType: 'success',
        filter: 'all',

        get filteredTasks() {
            if (this.filter === 'all') return this.tasks;
            if (this.filter === 'completed') return this.tasks.filter(t => t.is_completed);
            if (this.filter === 'pending') return this.tasks.filter(t => !t.is_completed);
            return this.tasks;
        },

        get completedCount() {
            return this.tasks.filter(t => t.is_completed).length;
        },

        get pendingCount() {
            return this.tasks.filter(t => !t.is_completed).length;
        },

        init() {
            if (!storage.hasToken()) {
                window.location.href = '/index.html';
                return;
            }

            this.user = storage.getUser();
            this.loadTasks();
        },

        async loadTasks() {
            try {
                this.tasks = await api.getTasks();
            } catch (error) {
                if (error.status === 401) {
                    storage.clear();
                    window.location.href = '/index.html';
                } else {
                    this.showMessage('Failed to load tasks', 'error');
                }
            }
        },

        async addTask() {
            if (!this.newTask.title.trim()) return;

            this.loading = true;
            try {
                const task = await api.createTask(this.newTask);
                this.tasks.unshift(task);
                this.newTask = { title: '', description: '' };
                this.showMessage('Task created successfully! 🎯');
            } catch (error) {
                this.showMessage('Failed to add task', 'error');
            } finally {
                this.loading = false;
            }
        },

        async toggleTask(task) {
            try {
                const updated = await api.updateTask(task.id, {
                    is_completed: !task.is_completed
                });
                task.is_completed = updated.is_completed;
                this.showMessage('Task updated successfully! ✅');
            } catch (error) {
                this.showMessage('Failed to update task', 'error');
            }
        },

        async deleteTask(taskId) {
            if (!confirm('Are you sure you want to delete this task?')) return;

            try {
                await api.deleteTask(taskId);
                this.tasks = this.tasks.filter(t => t.id !== taskId);
                this.showMessage('Task deleted successfully! 🗑️');
            } catch (error) {
                this.showMessage('Failed to delete task', 'error');
            }
        },

        async logout() {
            try {
                await api.logout();
            } catch (error) {
                console.error('Logout error:', error);
            } finally {
                storage.clear();
                window.location.href = '/index.html';
            }
        },

        showMessage(msg, type = 'success') {
            this.message = msg;
            this.messageType = type;
            setTimeout(() => {
                this.message = '';
            }, 3000);
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        }
    }
}
```

### Step 4: Create API Client

**File: `src/utils/api.js`**

```javascript
import axios from 'axios';
import { storage } from './storage';

const client = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json'
    }
});

// Add token to requests automatically
client.interceptors.request.use(config => {
    const token = storage.getToken();
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Handle response errors
client.interceptors.response.use(
    response => response.data,
    error => {
        const message = error.response?.data?.message || 
                       error.response?.data?.errors ||
                       'An error occurred';
        return Promise.reject({
            status: error.response?.status,
            message: typeof message === 'object' 
                ? Object.values(message).flat().join(', ') 
                : message
        });
    }
);

export const api = {
    // Auth
    login: (credentials) => client.post('/login', credentials),
    register: (data) => client.post('/register', data),
    logout: () => client.post('/logout'),
    getUser: () => client.get('/user'),

    // Tasks
    getTasks: () => client.get('/tasks').then(res => res.tasks),
    createTask: (task) => client.post('/tasks', task).then(res => res.task),
    updateTask: (id, data) => client.put(`/tasks/${id}`, data).then(res => res.task),
    deleteTask: (id) => client.delete(`/tasks/${id}`)
};
```

### Step 5: Create Storage Helper

**File: `src/utils/storage.js`**

```javascript
export const storage = {
    hasToken() {
        return !!localStorage.getItem('token');
    },

    getToken() {
        return localStorage.getItem('token');
    },

    setToken(token) {
        localStorage.setItem('token', token);
    },

    getUser() {
        const userStr = localStorage.getItem('user');
        return userStr ? JSON.parse(userStr) : null;
    },

    setUser(user) {
        localStorage.setItem('user', JSON.stringify(user));
    },

    clear() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }
};
```

### Step 6: Create Main Entry Point

**File: `src/app.js`**

```javascript
import Alpine from 'alpinejs';
import { authApp } from './components/authApp';
import { tasksApp } from './components/tasksApp';

// Register components
window.authApp = authApp;
window.tasksApp = tasksApp;

// Start Alpine
Alpine.start();
```

### Step 7: Update HTML Files

**File: `index.html`**

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Task Manager</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    
    <!-- Copy the body content from auth-markup.html -->
    
    <script type="module" src="/src/app.js"></script>
</body>
</html>
```

### Step 8: Configure Vite

**File: `vite.config.js`**

```javascript
import { defineConfig } from 'vite';

export default defineConfig({
    server: {
        port: 3000
    },
    build: {
        rollupOptions: {
            input: {
                main: 'index.html',
                tasks: 'tasks.html'
            }
        }
    }
});
```

### Step 9: Configure Tailwind

**File: `tailwind.config.js`**

```javascript
module.exports = {
    content: [
        './index.html',
        './tasks.html',
        './src/**/*.{js,jsx,ts,tsx}'
    ],
    theme: {
        extend: {}
    },
    plugins: []
};
```

**File: `styles/main.css`**

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Step 10: Update package.json

```json
{
  "name": "alpine-tasks-app",
  "version": "1.0.0",
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  },
  "dependencies": {
    "alpinejs": "^3.13.0",
    "axios": "^1.6.0"
  },
  "devDependencies": {
    "tailwindcss": "^3.3.0",
    "vite": "^5.0.0"
  }
}
```

---

## 🚀 Running the Project

```bash
# Development mode
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

---

## 💡 Optimization Tips

1. **Code Splitting**: Load components on demand
2. **Lazy Loading**: Defer non-critical resources
3. **Caching**: Cache API responses
4. **Error Boundaries**: Handle errors gracefully
5. **Loading States**: Show feedback for all async operations

---

## 🎯 Next Steps

1. ✅ Extract components into separate files
2. ✅ Create API client utility
3. ✅ Add localStorage helper
4. ✅ Set up build system
5. ⬜ Add TypeScript (optional)
6. ⬜ Add unit tests
7. ⬜ Add E2E tests
8. ⬜ Deploy to production

---

**You now have everything you need to convert the markup into a full Alpine.js application!** 🎉
