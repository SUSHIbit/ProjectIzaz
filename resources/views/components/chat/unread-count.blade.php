<!-- resources/views/components/chat/unread-count.blade.php -->
@props(['count'])

@if($count > 0)
    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
        {{ $count > 99 ? '99+' : $count }}
    </span>
@endif