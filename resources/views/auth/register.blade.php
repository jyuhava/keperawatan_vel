<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - NurseCare Documentation System</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Custom Styles -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .medical-pattern {
            background-image: 
                radial-gradient(circle at 25px 25px, rgba(255,255,255,0.1) 2px, transparent 2px),
                radial-gradient(circle at 75px 75px, rgba(255,255,255,0.05) 2px, transparent 2px);
            background-size: 100px 100px;
        }
        
        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .input-focus:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }
    </style>
</head>

<body class="min-h-screen gradient-bg medical-pattern overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Floating Medical Icons -->
        <div class="absolute top-20 left-10 animate-float text-white opacity-10">
            <ion-icon name="medical" class="text-8xl"></ion-icon>
        </div>
        <div class="absolute top-40 right-20 animate-float text-white opacity-10" style="animation-delay: -2s;">
            <ion-icon name="heart-outline" class="text-6xl"></ion-icon>
        </div>
        <div class="absolute bottom-32 left-20 animate-float text-white opacity-10" style="animation-delay: -4s;">
            <ion-icon name="pulse-outline" class="text-7xl"></ion-icon>
        </div>
        <div class="absolute bottom-20 right-10 animate-float text-white opacity-10" style="animation-delay: -1s;">
            <ion-icon name="fitness-outline" class="text-5xl"></ion-icon>
        </div>
        
        <!-- Gradient Orbs -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow"></div>
        <div class="absolute top-3/4 right-1/4 w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow" style="animation-delay: -4s;"></div>
    </div>

    <!-- Main Container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            <!-- Register Card -->
            <div class="glass-effect rounded-2xl shadow-2xl overflow-hidden">
                
                <!-- Header -->
                <div class="px-8 pt-8 pb-6 text-center">
                    <!-- Logo -->
                    <div class="mx-auto w-20 h-20 bg-gradient-to-br from-green-600 to-blue-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                        <ion-icon name="person-add" class="text-3xl text-white"></ion-icon>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Join NurseCare</h1>
                    <p class="text-gray-600">Create your nursing documentation account</p>
                </div>

                <!-- Register Form -->
                <div class="px-8 pb-8">
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                            <div class="flex items-center mb-1">
                                <ion-icon name="alert-circle" class="mr-2"></ion-icon>
                                <span class="font-medium">Registration Failed</span>
                            </div>
                            @foreach ($errors->all() as $error)
                                <p class="text-xs">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Full Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <ion-icon name="person" class="text-gray-400"></ion-icon>
                                </div>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       required 
                                       autofocus 
                                       autocomplete="name"
                                       placeholder="Enter your full name"
                                       class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200 bg-white/50">
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <ion-icon name="mail" class="text-gray-400"></ion-icon>
                                </div>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       required 
                                       autocomplete="username"
                                       placeholder="Enter your email"
                                       class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200 bg-white/50">
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Role
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <ion-icon name="people" class="text-gray-400"></ion-icon>
                                </div>
                                <select id="role" 
                                        name="role" 
                                        required
                                        class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200 bg-white/50">
                                    <option value="">Select your role</option>
                                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Student (Mahasiswa)</option>
                                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Teacher (Dosen)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Student ID (conditional) -->
                        <div id="student_id_field" style="display: none;">
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Student ID
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <ion-icon name="card" class="text-gray-400"></ion-icon>
                                </div>
                                <input type="text" 
                                       id="student_id" 
                                       name="student_id" 
                                       value="{{ old('student_id') }}"
                                       placeholder="Enter your student ID"
                                       class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200 bg-white/50">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <ion-icon name="lock-closed" class="text-gray-400"></ion-icon>
                                </div>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Create a password"
                                       class="input-focus block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200 bg-white/50">
                                <button type="button" 
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <ion-icon name="eye" id="eye-icon-password" class="text-gray-400 hover:text-gray-600"></ion-icon>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <ion-icon name="lock-closed" class="text-gray-400"></ion-icon>
                                </div>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Confirm your password"
                                       class="input-focus block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200 bg-white/50">
                                <button type="button" 
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <ion-icon name="eye" id="eye-icon-password_confirmation" class="text-gray-400 hover:text-gray-600"></ion-icon>
                                </button>
                            </div>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="flex items-start">
                            <input type="checkbox" 
                                   id="terms" 
                                   name="terms" 
                                   required
                                   class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> 
                                and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" 
                                class="btn-gradient w-full py-3 px-4 text-white font-semibold rounded-lg shadow-lg flex items-center justify-center space-x-2">
                            <ion-icon name="person-add" class="text-xl"></ion-icon>
                            <span>Create Account</span>
                        </button>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Already have an account? 
                                <a href="{{ route('login') }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-white/80 text-sm">
                <p>&copy; {{ date('Y') }} NurseCare Documentation System</p>
                <p class="mt-1">Professional Nursing Care Documentation Platform</p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon-' + fieldId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('name', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('name', 'eye');
            }
        }

        // Show/hide student ID field based on role selection
        document.getElementById('role').addEventListener('change', function() {
            const studentIdField = document.getElementById('student_id_field');
            const studentIdInput = document.getElementById('student_id');
            
            if (this.value === 'mahasiswa') {
                studentIdField.style.display = 'block';
                studentIdInput.required = true;
            } else {
                studentIdField.style.display = 'none';
                studentIdInput.required = false;
                studentIdInput.value = '';
            }
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Check password strength criteria
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            // Visual feedback could be added here
        });

        // Add floating animation to form on load
        window.addEventListener('load', function() {
            const card = document.querySelector('.glass-effect');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });

        // Check if role is already selected on page load
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'mahasiswa') {
                document.getElementById('student_id_field').style.display = 'block';
                document.getElementById('student_id').required = true;
            }
        });
    </script>
</body>
</html>
