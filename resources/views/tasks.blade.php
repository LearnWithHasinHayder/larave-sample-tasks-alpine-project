@extends('layout')

@section('title', 'My Tasks')

@section('content')
<div x-data="tasksApp()" x-init="init()" class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">📝 My Tasks</h1>
                <p class="text-gray-600" x-text="'Welcome back, ' + user.name + '!'"></p>
            </div>
            <button
                @click="logout"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                Logout 👋
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Tasks</p>
                    <p class="text-3xl font-bold text-indigo-600" x-text="tasks.length"></p>
                </div>
                <div class="text-4xl">📊</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Completed</p>
                    <p class="text-3xl font-bold text-green-600" x-text="completedCount"></p>
                </div>
                <div class="text-4xl">✅</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending</p>
                    <p class="text-3xl font-bold text-orange-600" x-text="pendingCount"></p>
                </div>
                <div class="text-4xl">⏳</div>
            </div>
        </div>
    </div>

    <!-- Add Task Form -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">➕ Add New Task</h2>
        <form @submit.prevent="addTask" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                <input
                    type="text"
                    x-model="newTask.title"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="e.g., Buy groceries">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                <textarea
                    x-model="newTask.description"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Add more details about this task..."></textarea>
            </div>
            <button
                type="submit"
                :disabled="loading"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50">
                <span x-show="!loading">Add Task 🎯</span>
                <span x-show="loading">Adding...</span>
            </button>
        </form>
    </div>

    <!-- Messages -->
    <div x-show="message" x-transition class="mb-4">
        <div :class="messageType === 'error' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700'"
             class="border px-4 py-3 rounded-lg">
            <p class="text-sm" x-text="message"></p>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">📋 Your Tasks</h2>
            <div class="flex gap-2">
                <button
                    @click="filter = 'all'"
                    :class="filter === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                    All
                </button>
                <button
                    @click="filter = 'pending'"
                    :class="filter === 'pending' ? 'bg-orange-600 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                    Pending
                </button>
                <button
                    @click="filter = 'completed'"
                    :class="filter === 'completed' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                    Completed
                </button>
            </div>
        </div>

        <div class="space-y-3">
            <template x-for="task in filteredTasks" :key="task.id">
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-3">
                        <!-- Checkbox -->
                        <input
                            type="checkbox"
                            :checked="task.is_completed"
                            @change="toggleTask(task)"
                            class="mt-1 w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">

                        <!-- Task Content -->
                        <div class="flex-1">
                            <h3
                                :class="task.is_completed ? 'line-through text-gray-500' : 'text-gray-800'"
                                class="font-medium"
                                x-text="task.title"></h3>
                            <p
                                x-show="task.description"
                                :class="task.is_completed ? 'line-through text-gray-400' : 'text-gray-600'"
                                class="text-sm mt-1"
                                x-text="task.description"></p>
                            <p class="text-xs text-gray-500 mt-2">
                                Created: <span x-text="formatDate(task.created_at)"></span>
                            </p>
                        </div>

                        <!-- Delete Button -->
                        <button
                            @click="deleteTask(task.id)"
                            class="text-red-500 hover:text-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="filteredTasks.length === 0" class="text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-600 text-lg">No tasks found</p>
                <p class="text-gray-500 text-sm" x-show="filter !== 'all'">Try changing your filter</p>
            </div>
        </div>
    </div>
</div>

<script>
function tasksApp() {
    return {
        tasks: [],
        user: {},
        newTask: {
            title: '',
            description: ''
        },
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
            // Check if user is logged in
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Set axios default headers
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            // Get user info
            const userStr = localStorage.getItem('user');
            if (userStr) {
                this.user = JSON.parse(userStr);
            }

            // Load tasks
            this.loadTasks();
        },

        async loadTasks() {
            try {
                const response = await axios.get('/api/tasks');
                this.tasks = response.data.tasks;
            } catch (error) {
                if (error.response?.status === 401) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    window.location.href = '/login';
                } else {
                    this.showMessage('Failed to load tasks', 'error');
                }
            }
        },

        async addTask() {
            if (!this.newTask.title.trim()) return;

            this.loading = true;
            try {
                const response = await axios.post('/api/tasks', this.newTask);
                this.tasks.unshift(response.data.task);
                this.newTask = { title: '', description: '' };
                this.showMessage(response.data.message);
            } catch (error) {
                this.showMessage('Failed to add task', 'error');
            } finally {
                this.loading = false;
            }
        },

        async toggleTask(task) {
            try {
                const response = await axios.put(`/api/tasks/${task.id}`, {
                    is_completed: !task.is_completed
                });
                task.is_completed = response.data.task.is_completed;
                this.showMessage(response.data.message);
            } catch (error) {
                this.showMessage('Failed to update task', 'error');
            }
        },

        async deleteTask(taskId) {
            if (!confirm('Are you sure you want to delete this task?')) return;

            try {
                const response = await axios.delete(`/api/tasks/${taskId}`);
                this.tasks = this.tasks.filter(t => t.id !== taskId);
                this.showMessage(response.data.message);
            } catch (error) {
                this.showMessage('Failed to delete task', 'error');
            }
        },

        async logout() {
            try {
                await axios.post('/api/logout');
            } catch (error) {
                console.error('Logout error:', error);
            } finally {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/login';
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
</script>
@endsection
