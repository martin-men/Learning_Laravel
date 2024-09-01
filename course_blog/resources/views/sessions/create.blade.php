<x-layout-blade-component>
    <x-slot name="content">
        <section class="px-6 py-8">
            <main class="max-w-lg mx-auto mt-10">
                <x-panel>
                    <h1 class="text-center font-bold text-xl">Log in</h1>

                    <form method="POST" action="/login" class="mt-10">
                        @csrf
                        <x-form.input name="email" type="email" autocomplete="username" />
                        <x-form.input name="password" type="password" autocomplete="current-password" />
                        <x-form.button>Log in</x-form.button>
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-500 text-xs">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </form>
                </x-panel>
            </main>
        </section>
    </x-slot>
</x-layout-blade-component>
