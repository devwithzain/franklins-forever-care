<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Franklin's Forever Care</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-theme-bg min-h-screen flex items-center justify-center relative">
    <div
        class="fixed top-[-120px] left-[-120px] w-[400px] h-[400px] bg-[radial-gradient(circle,rgba(26,60,220,0.12)_0%,transparent_70%)] rounded-full pointer-events-none">
    </div>
    <div
        class="fixed bottom-[-100px] right-[-100px] w-[350px] h-[350px] bg-[radial-gradient(circle,rgba(26,60,220,0.10)_0%,transparent_70%)] rounded-full pointer-events-none">
    </div>
    <div class="w-full max-w-[440px]">
        <div
            class="bg-theme-card rounded-[14px] border border-theme-border shadow-[0_4px_24px_rgba(26,60,220,0.12)] p-9">
            <div class="text-center mb-7">
                <div
                    class="w-14 h-14 bg-theme-primary rounded-[16px] flex items-center justify-center mx-auto mb-3 shadow-[0_8px_24px_rgba(26,60,220,0.25)]">
                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9,22 9,12 15,12 15,22" />
                    </svg>
                </div>
                <div class="text-[22px] font-bold text-theme-text-main">Franklin's Forever Care</div>
                <div class="text-[13px] text-theme-text-muted mt-1">Sign in to your Portal account</div>
            </div>
            <div class="grid grid-cols-3 gap-2 mb-6" id="roleTabs">
                <button type="button"
                    class="role-tab active flex flex-col items-center p-2.5 border-[1.5px] border-theme-primary rounded-[10px] cursor-pointer transition-all duration-150 bg-theme-primary-light hover:bg-theme-hover"
                    onclick="selectRole('admin', this)">
                    <svg class="w-5 h-5 mb-1.25 text-theme-primary transition-colors" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    <span class="text-[12px] font-semibold text-theme-primary transition-colors">Admin</span>
                </button>
                <button type="button"
                    class="role-tab flex flex-col items-center p-2.5 border-[1.5px] border-theme-border rounded-[10px] cursor-pointer transition-all duration-150 bg-theme-card hover:bg-theme-hover"
                    onclick="selectRole('employee', this)">
                    <svg class="w-5 h-5 mb-1.25 text-theme-text-muted transition-colors" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <span class="text-[12px] font-semibold text-theme-text-muted transition-colors">Employee</span>
                </button>
                <button type="button"
                    class="role-tab flex flex-col items-center p-2.5 border-[1.5px] border-theme-border rounded-[10px] cursor-pointer transition-all duration-150 bg-theme-card hover:bg-theme-hover"
                    onclick="selectRole('client', this)">
                    <svg class="w-5 h-5 mb-1.25 text-theme-text-muted transition-colors" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span class="text-[12px] font-semibold text-theme-text-muted transition-colors">Client</span>
                </button>
            </div>
            @if ($errors->any())
                <div
                    class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-[9px] p-3 text-[13px] text-red-700 dark:text-red-400 mb-4">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if (session('status'))
                <div
                    class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-[9px] p-3 text-[13px] text-green-700 dark:text-green-400 mb-4">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" id="selectedRole" value="admin">
                <div class="mb-4">
                    <label class="block text-[13px] font-semibold text-theme-text-main mb-1.5" for="email">Email
                        address</label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-theme-text-muted pointer-events-none">
                            <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </span>
                        <input
                            class="w-full pl-9 pr-3.5 py-2.5 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                            type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required autofocus autocomplete="email" />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-[13px] font-semibold text-theme-text-main mb-1.5"
                        for="password">Password</label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-theme-text-muted pointer-events-none">
                            <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <input
                            class="w-full pl-9 pr-3 py-2 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                            type="password" id="password" name="password" placeholder="••••••••" required
                            autocomplete="current-password" />
                    </div>
                </div>
                <div class="flex justify-between items-center mb-10">
                    <label class="flex items-center gap-1.5 text-[13px] text-theme-text-muted cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="accent-theme-primary w-[15px] h-[15px] rounded-sm border-theme-border bg-theme-card">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-[13px] text-theme-primary font-semibold no-underline hover:underline">Forgot
                            password?</a>
                    @endif
                </div>
                <button type="submit"
                    class="w-full py-3 bg-theme-primary text-white border-none rounded-[9px] text-[14px] font-bold cursor-pointer transition hover:bg-theme-primary-hover hover:shadow-[0_4px_16px_rgba(26,60,220,0.2)] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" x2="3" y1="12" y2="12" />
                    </svg>
                    Sign In to Portal
                </button>
            </form>
        </div>
    </div>
    </div>
    <script>
        function selectRole(role, el) {
            const roleInput = document.getElementById('selectedRole');
            if (roleInput) roleInput.value = role;

            document.querySelectorAll('.role-tab').forEach(t => {
                t.classList.remove('active', 'border-theme-primary', 'bg-theme-primary-light');
                t.classList.add('border-theme-border', 'bg-theme-card');
                t.querySelector('svg').classList.remove('text-theme-primary');
                t.querySelector('span').classList.remove('text-theme-primary');
                t.querySelector('svg').classList.add('text-theme-text-muted');
                t.querySelector('span').classList.add('text-theme-text-muted');
            });

            el.classList.remove('border-theme-border', 'bg-theme-card');
            el.classList.add('active', 'border-theme-primary', 'bg-theme-primary-light');
            el.querySelector('svg').classList.remove('text-theme-text-muted');
            el.querySelector('span').classList.remove('text-theme-text-muted');
            el.querySelector('svg').classList.add('text-theme-primary');
            el.querySelector('span').classList.add('text-theme-primary');
        }
    </script>
</body>

</html>