
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy & Beef Farm Management | BHU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-green-900 text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <a href="/" class="text-xl font-bold">
                🐄 BHU Farm Management
            </a>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="rounded-lg bg-white px-4 py-2 font-semibold text-green-900">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-green-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="rounded-lg bg-white px-4 py-2 font-semibold text-green-900">
                            Get Started
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="bg-gradient-to-br from-green-950 via-green-800 to-green-700 text-white">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 py-24 md:grid-cols-2">

                <div>
                    <p class="mb-4 font-semibold uppercase tracking-widest text-green-200">
                        Bule Hora University · Agricultural Center
                    </p>

                    <h1 class="text-4xl font-extrabold leading-tight md:text-6xl">
                        Smart Dairy & Beef Farm Management
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-green-100">
                        Manage animals, monitor milk production, track sales,
                        organize breeding, and improve animal health through
                        one computerized farm management system.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('login') }}"
                           class="rounded-lg bg-white px-6 py-3 font-bold text-green-900 hover:bg-green-100">
                            Access System →
                        </a>

                        <a href="#features"
                           class="rounded-lg border border-white px-6 py-3 font-semibold hover:bg-white/10">
                            Explore Features
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/20 bg-white/10 p-8 shadow-2xl">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-white p-6 text-center text-green-900">
                            <div class="text-4xl">🐄</div>
                            <h2 class="mt-3 font-bold">Animal Management</h2>
                            <p class="mt-2 text-sm text-gray-600">Digital animal records</p>
                        </div>

                        <div class="rounded-2xl bg-white p-6 text-center text-green-900">
                            <div class="text-4xl">🥛</div>
                            <h2 class="mt-3 font-bold">Milk Production</h2>
                            <p class="mt-2 text-sm text-gray-600">Daily yield tracking</p>
                        </div>

                        <div class="rounded-2xl bg-white p-6 text-center text-green-900">
                            <div class="text-4xl">💰</div>
                            <h2 class="mt-3 font-bold">Sales & Finance</h2>
                            <p class="mt-2 text-sm text-gray-600">Sales and payments</p>
                        </div>

                        <div class="rounded-2xl bg-white p-6 text-center text-green-900">
                            <div class="text-4xl">🩺</div>
                            <h2 class="mt-3 font-bold">Animal Health</h2>
                            <p class="mt-2 text-sm text-gray-600">Treatment records</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="features" class="mx-auto max-w-7xl px-6 py-20">
            <div class="text-center">
                <p class="font-semibold uppercase tracking-widest text-green-700">
                    Our System
                </p>
                <h2 class="mt-3 text-3xl font-bold md:text-4xl">
                    Everything Your Farm Needs
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                    A centralized platform for managing daily farm operations,
                    improving productivity, and supporting university research.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['🐄', 'Animal Management', 'Register cattle and maintain animal histories.'],
                    ['🥛', 'Milk Production', 'Record morning and evening milk yields.'],
                    ['🐮', 'Breeding Management', 'Track mating, pregnancy, and calving.'],
                    ['🩺', 'Animal Health', 'Manage treatments, vaccinations, and health alerts.'],
                    ['📦', 'Inventory', 'Monitor medicines and farm supplies.'],
                    ['📊', 'Reports & Analytics', 'Review production, sales, and farm performance.'],
                ] as $feature)
                    <article class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="text-4xl">{{ $feature[0] }}</div>
                        <h3 class="mt-4 text-xl font-bold">{{ $feature[1] }}</h3>
                        <p class="mt-3 leading-7 text-gray-600">{{ $feature[2] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="bg-green-950 px-6 py-8 text-center text-green-100">
        <p class="font-semibold">Bule Hora University Agricultural Center</p>
        <p class="mt-2 text-sm">Dairy and Beef Farm Management System</p>
        <p class="mt-4 text-xs text-green-300">
            &copy; {{ date('Y') }} · Farm Management Platform
        </p>
    </footer>

</body>
</html>
