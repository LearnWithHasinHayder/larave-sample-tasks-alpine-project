# 🎨 Visual Structure Guide

## File Organization

```
markup/
├── README.md                  # This documentation
├── auth-markup.html          # Login/Register page
└── tasks-markup.html         # Task management page
```

---

## 📱 Page Layouts

### Auth Page (`auth-markup.html`)

```
┌─────────────────────────────────────────┐
│                                         │
│         ✨ Task Manager                 │
│    Organize your life, one task         │
│           at a time                     │
│                                         │
│  ┌────────────┬────────────┐           │
│  │   Login    │  Register  │           │  ← Tabs
│  └────────────┴────────────┘           │
│                                         │
│  ┌─────────────────────────┐           │
│  │ Email                   │           │
│  │ [________________]      │           │
│  │                         │           │
│  │ Password                │           │
│  │ [________________]      │           │
│  │                         │           │
│  │  [Login 🚀]             │           │
│  └─────────────────────────┘           │
│                                         │
│  ┌─────────────────────────┐           │
│  │ Demo Account:           │           │
│  │ demo@example.com        │           │
│  │ password                │           │
│  └─────────────────────────┘           │
│                                         │
└─────────────────────────────────────────┘
```

---

### Tasks Page (`tasks-markup.html`)

```
┌──────────────────────────────────────────────────────────────┐
│  📝 My Tasks                           [Logout 👋]           │
│  Welcome back, User!                                         │
└──────────────────────────────────────────────────────────────┘

┌──────────────┐ ┌──────────────┐ ┌──────────────┐
│ 📊 Total     │ │ ✅ Completed │ │ ⏳ Pending   │
│    15        │ │     8        │ │     7        │
└──────────────┘ └──────────────┘ └──────────────┘

┌──────────────────────────────────────────────────────────────┐
│  ➕ Add New Task                                             │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Title: [_____________________________________]         │ │
│  │                                                        │ │
│  │ Description: [________________________________        │ │
│  │              _________________________________]        │ │
│  │                                                        │ │
│  │                    [Add Task 🎯]                       │ │
│  └────────────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│  📋 Your Tasks              [All] [Pending] [Completed]      │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ ☐ Buy groceries                                    🗑️ │ │
│  │   Get milk, eggs, and bread                            │ │
│  │   Created: Oct 16, 2025 10:30 AM                       │ │
│  └────────────────────────────────────────────────────────┘ │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ ☑ Finish project report                            🗑️ │ │
│  │   Complete final sections                              │ │
│  │   Created: Oct 15, 2025 3:45 PM                        │ │
│  └────────────────────────────────────────────────────────┘ │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ ☐ Call dentist                                     🗑️ │ │
│  │   Schedule appointment                                 │ │
│  │   Created: Oct 14, 2025 9:00 AM                        │ │
│  └────────────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────┘
```

---

## 🎨 Color Scheme

### Primary Colors
- **Indigo**: Main actions, active states
  - `bg-indigo-600` - Buttons, active tabs
  - `bg-indigo-700` - Hover states
  - `text-indigo-600` - Active text

### Status Colors
- **Green**: Success, completed
  - `bg-green-600` - Completed count
  - `text-green-700` - Success messages
  
- **Orange**: Warning, pending
  - `bg-orange-600` - Pending count
  
- **Red**: Danger, errors
  - `bg-red-500` - Logout button
  - `text-red-700` - Error messages

### Neutral Colors
- **Gray**: Text, borders, backgrounds
  - `text-gray-800` - Headings
  - `text-gray-600` - Body text
  - `border-gray-200` - Borders

### Background
- **Gradient**: `from-blue-50 to-indigo-100`

---

## 🧩 Component Breakdown

### Auth Page Components

1. **Header Section**
   - App title with emoji
   - Tagline

2. **Message Alerts**
   - Error messages (red)
   - Success messages (green)

3. **Tab Navigation**
   - Login tab
   - Register tab
   - Dynamic active state

4. **Login Form**
   - Email input
   - Password input
   - Submit button with loading state

5. **Register Form**
   - Name input
   - Email input
   - Password input
   - Password confirmation input
   - Submit button with loading state

6. **Demo Credentials Box**
   - Blue background
   - Demo account info

---

### Tasks Page Components

1. **Header Card**
   - Page title
   - User greeting
   - Logout button

2. **Stats Grid (3 cards)**
   - Total tasks counter
   - Completed tasks counter
   - Pending tasks counter
   - Each with emoji icon

3. **Add Task Form**
   - Title input (required)
   - Description textarea (optional)
   - Submit button with loading state

4. **Message Alert**
   - Success/error notification
   - Auto-dismiss after 3 seconds

5. **Tasks List Card**
   - Filter buttons (All, Pending, Completed)
   - Task items with:
     - Checkbox for completion
     - Title (strikes through when completed)
     - Description (optional)
     - Created date
     - Delete button

6. **Empty State**
   - Emoji icon
   - "No tasks found" message
   - Filter suggestion

---

## 📐 Responsive Breakpoints

### Mobile (< 768px)
- Stats cards stack vertically
- Single column layout
- Full-width buttons
- Reduced padding

### Tablet/Desktop (≥ 768px)
- Stats cards in 3-column grid
- Wider max-width container
- Better spacing

---

## 🎭 Interactive States

### Hover States
- Buttons: Darker background
- Task cards: Shadow increase
- Delete button: Darker red

### Active States
- Selected tab: Blue border bottom
- Selected filter: Colored background
- Checkbox: Indigo color when checked

### Loading States
- Submit buttons: Reduced opacity
- Button text changes
- Cursor: not-allowed

### Disabled States
- Buttons: Opacity 50%
- Cursor: not-allowed

---

## 🔄 User Flow

```
Start
  │
  ├─ Has Token? ─ Yes → Tasks Page
  │                         │
  No                        ├─ View Stats
  │                         ├─ Add Task
  ├─ Auth Page             ├─ Filter Tasks
  │   ├─ Login             ├─ Toggle Complete
  │   └─ Register          ├─ Delete Task
  │                         └─ Logout → Auth Page
  └─ Success → Tasks Page
```

---

## 🎯 Key Features

### Auth Page
✅ Tab switching without page reload
✅ Form validation (client-side)
✅ Error/success messages
✅ Loading indicators
✅ Auto-redirect if logged in
✅ Demo credentials display

### Tasks Page
✅ Real-time stats calculation
✅ Task filtering (All/Pending/Completed)
✅ Add tasks with description
✅ Toggle completion status
✅ Delete with confirmation
✅ Empty state handling
✅ Auto-redirect if not logged in
✅ Success/error notifications

---

**These markup files are ready to be converted into your Alpine.js project!** 🚀
