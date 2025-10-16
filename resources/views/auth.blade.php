@extends('layout')

@section('title', 'Login / Register')

@section('content')
<div class="flex items-center justify-center min-h-screen px-4">
    <div x-data="authApp()" x-init="init()" class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">✨ Task Manager</h1>
                <p class="text-gray-600">Organize your life, one task at a time</p>
            </div>

            <!-- Error Message -->
            <div x-show="error" x-transition class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <p class="text-sm" x-text="error"></p>
            </div>

            <!-- Success Message -->
            <div x-show="success" x-transition class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                <p class="text-sm" x-text="success"></p>
            </div>

            <!-- Toggle Tabs -->
            <div class="flex border-b border-gray-200 mb-6">
                <button
                    @click="isLogin = true; error = ''; success = ''"
                    :class="isLogin ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500'"
                    class="flex-1 py-2 font-medium transition-colors">
                    Login
                </button>
                <button
                    @click="isLogin = false; error = ''; success = ''"
                    :class="!isLogin ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500'"
                    class="flex-1 py-2 font-medium transition-colors">
                    Register
                </button>
            </div>

            <!-- Login Form -->
            <form x-show="isLogin" @submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        x-model="loginForm.email"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="demo@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        type="password"
                        x-model="loginForm.password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="password">
                </div>
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Login 🚀</span>
                    <span x-show="loading">Logging in...</span>
                </button>
            </form>

            <!-- Register Form -->
            <form x-show="!isLogin" @submit.prevent="register" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input
                        type="text"
                        x-model="registerForm.name"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        x-model="registerForm.email"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="you@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        type="password"
                        x-model="registerForm.password"
                        required
                        minlength="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="min. 8 characters">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input
                        type="password"
                        x-model="registerForm.password_confirmation"
                        required
                        minlength="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="same as above">
                </div>
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Create Account 🎉</span>
                    <span x-show="loading">Creating account...</span>
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600 text-center">
                    <strong>Demo Account:</strong><br>
                    Email: demo@example.com<br>
                    Password: password
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function authApp() {
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
            // Check if user is already logged in
            const token = localStorage.getItem('token');
            if (token) {
                // Redirect to tasks page if already logged in
                window.location.href = '/tasks';
            }
        },

        async login() {
            this.loading = true;
            this.error = '';
            this.success = '';

            try {
                const response = await axios.post('/api/login', this.loginForm);

                if (response.data.token) {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    this.success = response.data.message;

                    // Redirect to tasks page
                    setTimeout(() => {
                        window.location.href = '/tasks';
                    }, 500);
                }
            } catch (error) {
                this.error = error.response?.data?.message || 'Login failed. Please check your credentials.';
                if (error.response?.data?.errors) {
                    this.error = Object.values(error.response.data.errors).flat().join(', ');
                }
            } finally {
                this.loading = false;
            }
        },

        async register() {
            this.loading = true;
            this.error = '';
            this.success = '';

            try {
                const response = await axios.post('/api/register', this.registerForm);

                if (response.data.token) {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    this.success = response.data.message;

                    // Redirect to tasks page
                    setTimeout(() => {
                        window.location.href = '/tasks';
                    }, 500);
                }
            } catch (error) {
                this.error = error.response?.data?.message || 'Registration failed.';
                if (error.response?.data?.errors) {
                    this.error = Object.values(error.response.data.errors).flat().join(', ');
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
