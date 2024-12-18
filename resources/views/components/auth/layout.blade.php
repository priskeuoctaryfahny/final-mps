<x-auth.header>
    @slot('title')
        {{ $title }}
    @endslot
</x-auth.header>

{{ $slot }}

<x-auth.footer>
    {{ $title }}
</x-auth.footer>
