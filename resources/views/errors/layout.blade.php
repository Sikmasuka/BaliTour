<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Error') · Balingasag Tourism</title>

    <link rel="icon" type="image/png" href="/Logo/BTLogo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: {
                            950: '#03140E',
                            900: '#061C14',
                            800: '#09271C',
                            700: '#0D3827',
                        },

                        emerald: {
                            300: '#6EE7B7',
                            400: '#34D399',
                            500: '#10B981',
                            600: '#059669',
                            700: '#047857',
                        }
                    },

                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* =========================================================
           BASE
        ========================================================== */

        html {
            height: 100%;
        }

        body {
            min-height: 100%;
            font-family: 'Inter', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }


        /* =========================================================
           GLASS CARD
        ========================================================== */

        .glass-card {
            background:
                linear-gradient(
                    145deg,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.02)
                );

            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);

            border: 1px solid rgba(255, 255, 255, 0.12);

            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }


        /* =========================================================
           AMBIENT ANIMATION
        ========================================================== */

        .ambient {
            animation: float 12s ease-in-out infinite;
        }

        .ambient-delay {
            animation: float 16s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%,
            100% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(20px, -15px, 0) scale(1.05);
            }
        }


        /* =========================================================
           ERROR CODE GLOW
        ========================================================== */

        .code-glow {
            text-shadow:
                0 0 40px rgba(52, 211, 153, 0.18);
        }


        /* =========================================================
           BACKGROUND GRID
        ========================================================== */

        .grid-overlay {
            background-image:
                linear-gradient(
                    rgba(255, 255, 255, 0.025) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.025) 1px,
                    transparent 1px
                );

            background-size: 64px 64px;

            mask-image: linear-gradient(
                to bottom,
                transparent,
                black 20%,
                black 80%,
                transparent
            );

            -webkit-mask-image: linear-gradient(
                to bottom,
                transparent,
                black 20%,
                black 80%,
                transparent
            );
        }


        /* =========================================================
           SHORT SCREEN OPTIMIZATION
        ========================================================== */

        @media (max-height: 800px) {

            .error-main {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            .error-card {
                padding: 1.5rem !important;
            }

            .error-code {
                font-size: 4.5rem !important;
                margin-bottom: 0.5rem !important;
            }

            .error-message {
                margin-bottom: 1.25rem !important;
            }

            .error-footer {
                padding-bottom: 0.75rem !important;
            }
        }


        /* =========================================================
           VERY SHORT SCREEN
        ========================================================== */

        @media (max-height: 650px) {

            .error-main {
                padding-top: 0.75rem !important;
                padding-bottom: 0.75rem !important;
            }

            .error-card {
                padding: 1.25rem !important;
                border-radius: 1.25rem !important;
            }

            .error-code {
                font-size: 3.5rem !important;
                margin-bottom: 0.25rem !important;
            }

            .error-heading {
                font-size: 1.15rem !important;
                margin-bottom: 0.25rem !important;
            }

            .error-message {
                font-size: 0.75rem !important;
                line-height: 1.25rem !important;
                margin-bottom: 1rem !important;
            }

            .error-footer {
                padding-bottom: 0.5rem !important;
            }
        }
    </style>
</head>


<body
    class="
        relative
        h-[100dvh]
        min-h-[100dvh]
        overflow-y-auto
        overflow-x-hidden
        bg-[#03140E]
        text-white
        flex
        flex-col
        justify-between
    "
>


    {{-- =========================================================
         BACKGROUND
    ========================================================== --}}

    <div class="pointer-events-none fixed inset-0">

        {{-- Main forest gradient --}}
        <div
            class="
                absolute inset-0
                bg-gradient-to-br
                from-[#0D3827]
                via-[#061C14]
                to-[#03140E]
            "
        ></div>


        {{-- Top emerald glow --}}
        <div
            class="
                ambient
                absolute
                -top-48
                -left-48
                w-[600px]
                h-[600px]
                rounded-full
                bg-emerald-500/10
                blur-[120px]
            "
        ></div>


        {{-- Right green glow --}}
        <div
            class="
                ambient-delay
                absolute
                top-[20%]
                -right-48
                w-[550px]
                h-[550px]
                rounded-full
                bg-emerald-400/8
                blur-[120px]
            "
        ></div>


        {{-- Bottom subtle glow --}}
        <div
            class="
                absolute
                -bottom-64
                left-1/3
                w-[700px]
                h-[500px]
                rounded-full
                bg-green-900/30
                blur-[130px]
            "
        ></div>


        {{-- Grid texture --}}
        <div
            class="
                grid-overlay
                absolute
                inset-0
                opacity-40
            "
        ></div>


        {{-- Vignette --}}
        <div
            class="
                absolute
                inset-0
                bg-[radial-gradient(circle_at_center,transparent_20%,rgba(0,0,0,0.32)_100%)]
            "
        ></div>

    </div>


    {{-- Spacer for top balance --}}
    <div class="h-2"></div>


    {{-- =========================================================
         MAIN ERROR CONTENT (Card includes Brand Header)
    ========================================================== --}}

    <main
        class="
            error-main
            relative
            z-10
            flex-1
            min-h-0
            flex
            items-center
            justify-center
            px-5
            py-8
            sm:px-6
        "
    >

        <div
            class="
                w-full
                max-w-xl
                mx-auto
            "
        >

            {{-- Error Card --}}
            <div
                class="
                    error-card
                    glass-card
                    rounded-[32px]
                    px-7
                    py-9
                    sm:px-12
                    sm:py-11
                    text-center
                "
            >

                {{-- Clean & Prominent Brand Header (No border/wrapper) --}}
                <div class="flex justify-center mb-6 sm:mb-8">
                    <a
                        href="/"
                        class="
                            group
                            inline-flex
                            items-center
                            gap-3.5
                            transition-transform
                            duration-300
                            hover:scale-105
                        "
                    >
                        <img
                            src="/Logo/BTLogo.png"
                            alt="Balingasag Tourism"
                            class="
                                h-11
                                w-11
                                sm:h-12
                                sm:w-12
                                object-contain
                                drop-shadow-[0_4px_16px_rgba(52,211,153,0.35)]
                                transition-transform
                                duration-300
                                group-hover:rotate-6
                            "
                        >
                        <div class="text-left">
                            <p class="text-base sm:text-lg font-black tracking-wider text-white leading-none">
                                BALINGASAG
                            </p>
                            <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.24em] text-emerald-300 font-semibold mt-1">
                                Tourism Information System
                            </p>
                        </div>
                    </a>
                </div>


                {{-- Error Code --}}
                <div
                    class="
                        error-code
                        code-glow
                        font-serif
                        text-7xl
                        sm:text-8xl
                        font-bold
                        tracking-tight
                        leading-none
                        mb-3

                        @yield(
                            'code_color',
                            'text-emerald-300'
                        )
                    "
                >
                    @yield('code')
                </div>


                {{-- Heading --}}
                <h1
                    class="
                        error-heading
                        font-serif
                        text-xl
                        sm:text-2xl
                        font-bold
                        tracking-tight
                        text-white
                        mb-2.5
                    "
                >
                    @yield('heading')
                </h1>


                {{-- Message --}}
                <p
                    class="
                        error-message
                        mx-auto
                        max-w-md
                        text-xs
                        sm:text-sm
                        leading-relaxed
                        text-emerald-100/70
                        mb-7
                    "
                >
                    @yield('message')
                </p>


                {{-- Actions --}}
                <div
                    class="
                        flex
                        flex-col
                        sm:flex-row
                        items-center
                        justify-center
                        gap-3
                    "
                >

                    {{-- Back --}}
                    <button
                        onclick="
                            window.history.length > 1
                                ? window.history.back()
                                : window.location.href='/'
                        "
                        type="button"
                        class="
                            group
                            w-full
                            sm:w-auto

                            inline-flex
                            items-center
                            justify-center
                            gap-2

                            rounded-xl

                            border
                            border-white/10

                            bg-white/5

                            px-5
                            py-2.5

                            text-xs
                            sm:text-sm
                            font-semibold
                            text-white

                            transition-all
                            duration-300

                            hover:bg-white/10
                            hover:border-white/20

                            cursor-pointer
                        "
                    >

                        <svg
                            class="
                                w-4
                                h-4
                                text-emerald-300

                                transition-transform
                                duration-300

                                group-hover:-translate-x-1
                            "
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                            />
                        </svg>

                        <span>Go Back</span>

                    </button>


                    {{-- Home --}}
                    <a
                        href="/"
                        class="
                            group
                            w-full
                            sm:w-auto

                            inline-flex
                            items-center
                            justify-center
                            gap-2

                            rounded-xl

                            bg-gradient-to-r
                            from-emerald-600
                            to-emerald-700

                            px-5
                            py-2.5

                            text-xs
                            sm:text-sm
                            font-semibold
                            text-white

                            shadow-lg
                            shadow-emerald-950/40

                            transition-all
                            duration-300

                            hover:from-emerald-500
                            hover:to-emerald-600
                            hover:-translate-y-0.5
                            hover:shadow-emerald-900/50
                        "
                    >

                        <svg
                            class="
                                w-4
                                h-4
                                text-emerald-100

                                transition-transform
                                duration-300

                                group-hover:scale-110
                            "
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                            />
                        </svg>

                        <span>Back to Home</span>

                    </a>

                </div>

            </div>

        </div>

    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <footer
        class="
            error-footer
            relative
            z-10
            px-5
            pb-5
            sm:pb-6
            text-center
        "
    >

        <p
            class="
                text-[10px]
                sm:text-[11px]
                text-emerald-100/30
            "
        >
            © {{ date('Y') }} Balingasag Tourism Information System
        </p>

    </footer>

</body>

</html>