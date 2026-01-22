<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Ratannam Gold</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Radial gradient spotlight effect */
        .radial-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(217, 119, 6, 0.1) 0%, transparent 50%);
        }
        
        /* Custom gold glow shadow */
        .gold-glow {
            box-shadow: 0 10px 40px -10px rgba(217, 119, 6, 0.3);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-neutral-950 via-neutral-900 to-neutral-950 flex items-center justify-center p-4">
    
    <!-- Radial gradient spotlight -->
    <div class="absolute inset-0 radial-gradient pointer-events-none"></div>
    
    <!-- Login Container -->
    <div class="relative w-full max-w-md">
        
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-2">
                <h1 class="text-2xl font-bold text-gold-500 tracking-wider">ADMIN</h1>
                <svg class="w-5 h-5 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <p class="text-xs text-neutral-400 uppercase tracking-[0.3em]">Ratannam Gold</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 shadow-2xl">
            
            <!-- Heading -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-neutral-500 text-sm">Sign in to access the admin panel</p>
            </div>
            
            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="post" class="space-y-5">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="loginEmail" class="block text-xs font-bold uppercase tracking-widest text-neutral-300 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-neutral-500"></i>
                        </div>
                        <input 
                            type="email" 
                            name="email" 
                            id="loginEmail" 
                            placeholder="admin@ratannamgold.com"
                            required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-12 py-3.5 text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>
                
                <!-- Password Field -->
                <div>
                    <label for="loginPassword" class="block text-xs font-bold uppercase tracking-widest text-neutral-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-lock-fill text-neutral-500"></i>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            id="loginPassword" 
                            placeholder="••••••••"
                            required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-12 py-3.5 text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-neutral-900 font-bold uppercase tracking-widest text-sm py-4 rounded-xl transition-all duration-300 gold-glow"
                >
                    Sign In
                </button>
                
                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mt-4 bg-red-500/10 border border-red-500/20 rounded-lg p-3">
                        <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
                    </div>
                @endif
            </form>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-neutral-600 text-xs">© {{ date('Y') }} Ratannam Gold. All rights reserved.</p>
        </div>
    </div>
    
</body>
</html>
