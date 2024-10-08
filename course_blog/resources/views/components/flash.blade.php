@props(['flashAttribute'])

@if(session()->has( $flashAttribute ))
    <div x-data="{ show: true }"
         class="fixed bg-blue-500 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
    >
        <p>
            {{ session('success') }}
        </p>
    </div>
@endif
