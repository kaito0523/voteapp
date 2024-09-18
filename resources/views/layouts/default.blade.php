<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap"
    />
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>
<body>
    <div class="relative flex size-full min-h-screen flex-col bg-[#F0F0F0] group/design-root overflow-x-hidden" style='font-family: "Plus Jakarta Sans", "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#ddf4f2] px-10 py-5">
                <div class="flex items-center gap-4 text-[#0a1f1d]">
                    <h2 class="text-[#0a1f1d] text-lg font-bold leading-tight tracking-[-0.015em]" style="font-size: 1.8rem;">Survey</h2>
                </div>

                <!-- ログイン後の状態 -->
                <div class="flex gap-2">
                    <!-- New Topicボタン -->
                    <a href="{{ route('posts.create') }}">
                        <button
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-11 px-6 bg-[#15e6d5] text-[#0a1f1d] text-sm font-bold leading-normal tracking-[0.015em]"
                        >
                            <span class="truncate">New Topic</span>
                        </button>
                    </a>

                    <!-- ログアウトボタン -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-11 px-6 bg-[#DFEBE9] text-[#0a1f1d] text-sm font-bold leading-normal tracking-[0.015em]"
                        >
                            <span class="truncate">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <main>
                @yield('content')
            </main>
        
            <footer>
            </footer>
        </div>
    </div>
</body>
</html>