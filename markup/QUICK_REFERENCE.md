# 📋 Quick Reference

## 📁 Files in This Folder

| File | Description | Purpose |
|------|-------------|---------|
| `auth-plain.html` | Login/Register page (static) | HTML structure without Alpine.js |
| `auth-markup.html` | Login/Register page (interactive) | Full HTML with Alpine.js and Tailwind |
| `tasks-plain.html` | Tasks dashboard (static) | HTML structure without Alpine.js |
| `tasks-markup.html` | Tasks dashboard (interactive) | Full HTML with Alpine.js and Tailwind |
| `README.md` | Main documentation | Features, usage, dependencies |
| `VISUAL_GUIDE.md` | Visual layouts | Page structure, color scheme, components |
| `CONVERSION_GUIDE.md` | Conversion steps | How to convert to Alpine project |
| `PLAIN_VS_ALPINE.md` | Comparison guide | Differences between plain and Alpine versions |

---

## 🚀 Quick Start Options

### Option 1: View Plain HTML Structure (No JavaScript)
```bash
# Open static files to see layout only
open auth-plain.html
open tasks-plain.html

# Perfect for: Understanding HTML structure, UI design reference
```

### Option 2: Test Interactive Version (With Alpine.js)
```bash
# Open files directly in browser
open auth-markup.html
open tasks-markup.html

# Make sure Laravel API is running:
cd .. && php artisan serve

# Perfect for: Testing functionality, seeing Alpine.js in action
```

### Option 3: Create Standalone Alpine Project
```bash
# Create new project
mkdir my-alpine-app
cd my-alpine-app

# Copy markup files
cp ../markup/*.html .

# Edit API endpoint if needed
# Change: http://localhost:8000/api
# To: your-api-url
```

### Option 4: Full Build System (See CONVERSION_GUIDE.md)
```bash
# Follow the detailed steps in CONVERSION_GUIDE.md
# Involves: npm, Vite, component extraction
```

---

## 🎨 Quick Customization

### Change Colors
Find and replace in HTML files:

```html
<!-- Primary color -->
indigo-600 → blue-600
indigo-700 → blue-700

<!-- Success color -->
green-600 → emerald-600

<!-- Warning color -->
orange-600 → amber-600

<!-- Danger color -->
red-500 → rose-500
```

### Change API Endpoint
Find and replace:

```javascript
// Current
axios.post('/api/login', ...)

// Change to
axios.post('https://your-api.com/api/login', ...)
```

### Add New Features
Example: Add task priority

```html
<!-- In tasks-markup.html, add to form -->
<select x-model="newTask.priority">
    <option value="low">Low</option>
    <option value="medium">Medium</option>
    <option value="high">High</option>
</select>
```

---

## 🧪 Testing Checklist

### Auth Page
- [ ] Can switch between Login and Register tabs
- [ ] Form validation works
- [ ] Error messages display correctly
- [ ] Success messages display correctly
- [ ] Login redirects to tasks page
- [ ] Register redirects to tasks page
- [ ] Already logged-in users redirect to tasks
- [ ] Demo credentials display

### Tasks Page
- [ ] Not logged-in users redirect to auth
- [ ] Stats display correctly
- [ ] Can add new task
- [ ] Can toggle task completion
- [ ] Can delete task with confirmation
- [ ] Filters work (All, Pending, Completed)
- [ ] Empty state displays when no tasks
- [ ] Logout redirects to auth page
- [ ] Messages auto-dismiss after 3 seconds

---

## 🔧 Common Issues & Fixes

### Issue: "Axios is not defined"
**Fix:** Make sure CDN is loaded before script:
```html
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
```

### Issue: "Alpine is not defined"
**Fix:** Check Alpine.js CDN:
```html
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

### Issue: API calls fail (CORS error)
**Fix:** Laravel CORS configuration (already set up in this project)

### Issue: Token expires quickly
**Fix:** Already configured to last 1 year in this project

### Issue: Styles not applying
**Fix:** Ensure Tailwind CDN loads:
```html
<script src="https://cdn.tailwindcss.com"></script>
```

---

## 📱 Browser Compatibility

Tested and works on:
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

---

## 🎯 Key Alpine.js Patterns

```javascript
// Data binding
x-data="{ count: 0 }"

// Two-way binding
x-model="form.email"

// Show/hide
x-show="isVisible"

// Click handler
@click="handleClick"

// Submit handler
@submit.prevent="handleSubmit"

// Dynamic classes
:class="active ? 'bg-blue-500' : 'bg-gray-500'"

// Text content
x-text="message"

// Loop
x-for="item in items"

// Init hook
x-init="init()"

// Computed property
get completedCount() { return this.tasks.filter(...).length; }
```

---

## 📚 Essential Documentation Links

- **Alpine.js**: https://alpinejs.dev
- **Tailwind CSS**: https://tailwindcss.com
- **Axios**: https://axios-http.com
- **Laravel Sanctum**: https://laravel.com/docs/sanctum

---

## 💼 Project Information

- **Framework**: Alpine.js 3.x
- **Styling**: Tailwind CSS 3.x
- **HTTP Client**: Axios
- **Backend**: Laravel 12 with Sanctum
- **Authentication**: Token-based (Bearer)
- **Storage**: localStorage

---

## 📞 Need Help?

1. Check README.md for detailed documentation
2. Check VISUAL_GUIDE.md for layout reference
3. Check CONVERSION_GUIDE.md for project setup
4. Review Alpine.js docs for syntax
5. Check browser console for errors

---

**Everything you need is in this folder! Happy coding! 🚀**
