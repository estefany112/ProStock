<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>PROSERVE</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        /*
        |--------------------------------------------------------------------------
        | ALPINE.JS
        |--------------------------------------------------------------------------
        | Evita que elementos con x-show aparezcan antes de que Alpine cargue.
        */
        [x-cloak] {
            display: none !important;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR SCROLL
        |--------------------------------------------------------------------------
        */

        .custom-sidebar-scroll::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        .custom-sidebar-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }


        /*
        |--------------------------------------------------------------------------
        | BODY
        |--------------------------------------------------------------------------
        | Evita desplazamiento horizontal.
        */

        html,
        body {
            overflow-x: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | EVITAR PARPADEO DEL LAYOUT
        |--------------------------------------------------------------------------
        */

        body {
            margin: 0;
        }

    </style>

</head>


<body
    class="bg-slate-900 antialiased"
    x-data="{
        sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
        openUser: false
    }"
>


    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <header
        class="fixed top-0 left-0 w-full h-16
               bg-white
               border-b border-slate-200
               z-50
               flex items-center justify-between
               px-4 sm:px-6
               shadow-sm"
    >

        {{-- ===================================================== --}}
        {{-- IZQUIERDA --}}
        {{-- ===================================================== --}}

        <div class="flex items-center gap-4">

            {{-- BOTÓN SIDEBAR --}}
            <button
                type="button"
                @click="
                    sidebarOpen = !sidebarOpen;
                    localStorage.setItem('sidebarOpen', sidebarOpen)
                "
                class="p-2
                       text-slate-500
                       hover:text-emerald-600
                       hover:bg-emerald-50
                       rounded-xl
                       transition-all
                       duration-300
                       focus:outline-none
                       focus:ring-2
                       focus:ring-emerald-200"
                aria-label="Abrir o cerrar menú"
            >

                <svg
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />

                </svg>

            </button>


            {{-- LOGO / NOMBRE --}}
            <div class="flex items-center gap-3">

                <span
                    class="text-xl
                           font-extrabold
                           text-slate-900
                           tracking-tight
                           uppercase"
                >
                    PROSERVE
                </span>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- USUARIO --}}
        {{-- ===================================================== --}}

        <div class="relative">

            <button
                type="button"
                @click="openUser = !openUser"
                class="flex
                       items-center
                       gap-3
                       focus:outline-none
                       group"
            >

                {{-- INFORMACIÓN DEL USUARIO --}}
                <div class="text-right hidden sm:block">

                    <p class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p
                        class="text-[10px]
                               uppercase
                               tracking-widest
                               font-extrabold
                               bg-gradient-to-r
                               from-emerald-600
                               to-blue-600
                               bg-clip-text
                               text-transparent"
                    >
                        {{ auth()->user()->roles->first()->label ?? 'Usuario' }}
                    </p>

                </div>


                {{-- AVATAR --}}
                <div
                    class="relative
                           w-11
                           h-11
                           rounded-full
                           overflow-hidden
                           ring-2
                           ring-transparent
                           group-hover:ring-emerald-300
                           transition-all"
                >

                    @if(auth()->user()->avatar)

                        <img
                            src="{{ asset('storage/' . auth()->user()->avatar) }}"
                            alt="Avatar"
                            class="w-full h-full object-cover"
                        >

                    @else

                        <div
                            class="w-full
                                   h-full
                                   bg-gradient-to-br
                                   from-emerald-400
                                   to-blue-500
                                   flex
                                   items-center
                                   justify-center
                                   text-white
                                   font-bold"
                        >

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    @endif

                </div>

            </button>


            {{-- ================================================= --}}
            {{-- DROPDOWN USUARIO --}}
            {{-- ================================================= --}}

            <div
                x-cloak
                x-show="openUser"
                @click.away="openUser = false"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute
                       right-0
                       mt-3
                       w-56
                       bg-white
                       border
                       border-slate-100
                       rounded-xl
                       shadow-xl
                       py-2
                       z-[60]"
            >

                {{-- EDITAR PERFIL --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="block
                           px-4
                           py-2
                           text-sm
                           text-slate-700
                           hover:bg-slate-50
                           transition"
                >
                    Editar perfil
                </a>


                {{-- CERRAR SESIÓN --}}
                <a
                    href="{{ route('logout.loading') }}"
                    class="block
                           w-full
                           text-left
                           px-4
                           py-2
                           text-sm
                           text-red-600
                           hover:bg-red-50
                           transition"
                >
                    Cerrar sesión
                </a>

            </div>

        </div>

    </header>



    {{-- ========================================================= --}}
    {{-- WRAPPER PRINCIPAL --}}
    {{-- ========================================================= --}}

    <div
        class="flex
               pt-16
               min-h-screen
               w-full"
    >


        {{-- ===================================================== --}}
        {{-- SIDEBAR --}}
        {{-- ===================================================== --}}

        @include('layouts.partials.sidebar')



        {{-- ===================================================== --}}
        {{-- CONTENIDO --}}
        {{-- ===================================================== --}}

        <main
            class="flex-1
                   min-w-0
                   overflow-x-hidden
                   transition-[margin]
                   duration-300
                   ease-in-out"
            :class="sidebarOpen
                ? 'md:ml-64'
                : 'ml-0'"
        >

            <div
                class="p-4
                       lg:p-8"
            >

                @yield('content')

                @yield('scripts')

            </div>

        </main>

    </div>



    {{-- ========================================================= --}}
    {{-- ALPINE --}}
    {{-- ========================================================= --}}

    {{-- Alpine se carga desde resources/js/app.js mediante Vite --}}

</body>

</html>

