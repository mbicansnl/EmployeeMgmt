<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in | Springer Nature Employee Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Merriweather+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --sn-primary: #01324b;
            --sn-secondary: #0070a8;
            --sn-focus: #0088cc;
            --sn-accent: #f58220;
            --sn-grey-100: #f8f8f8;
            --sn-grey-200: #f3f3f3;
            --sn-grey-300: #dadada;
            --sn-grey-400: #999999;
            --sn-grey-500: #666666;
            --sn-grey-600: #555555;
            --sn-grey-700: #222222;
        }
        body {
            font-family: "Merriweather Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #f8f8f8 0%, #ffffff 50%, #f3f3f3 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-[var(--sn-grey-700)]">
    <main class="w-full max-w-lg bg-white shadow-xl rounded-3xl overflow-hidden border border-[var(--sn-grey-200)]">
        <div class="px-10 py-8 bg-[var(--sn-primary)] text-white">
            <p class="uppercase tracking-[0.3em] text-xs text-white/70">Springer Nature</p>
            <h1 class="text-3xl font-semibold mt-2">Employee Manager</h1>
            <p class="text-sm text-white/80 mt-2">Secure local access for offline or hosted deployments.</p>
        </div>
        <form class="px-10 py-8 space-y-6" method="post" action="{{ route('login.store') }}">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[var(--sn-grey-600)]">Work email</label>
                <input type="email" name="email" required class="mt-2 w-full rounded-xl border border-[var(--sn-grey-300)] px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--sn-focus)]" />
            </div>
            <div>
                <label class="block text-sm font-medium text-[var(--sn-grey-600)]">Password</label>
                <input type="password" name="password" required class="mt-2 w-full rounded-xl border border-[var(--sn-grey-300)] px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--sn-focus)]" />
            </div>
            <button class="w-full rounded-xl bg-[var(--sn-secondary)] text-white font-semibold py-3 hover:bg-[var(--sn-focus)] transition" type="submit">
                Sign in
            </button>
            <p class="text-xs text-[var(--sn-grey-500)]">Need SSO? <a class="text-[var(--sn-focus)] font-medium" href="{{ route('okta.redirect') }}">Use Okta</a>.</p>
        </form>
    </main>
</body>
</html>
