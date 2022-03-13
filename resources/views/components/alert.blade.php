@props(['message', 'type', 'color' => 'green'])

@php
switch ($type) {
    case 'success':
        $color = 'green';
        break;
    case 'error':
        $color = 'red';
        break;
    default:
        $color = 'green';
        break;
}
@endphp
<div class="max-w-7xl mx-auto pt-2 px-4 sm:px-6 lg:px-8">
    <div class="bg-{{ $color }}-100 border-{{ $color }}-500 text-{{ $color }}-900 border-t-4  rounded-b px-4 py-3 shadow-md" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-{{ $color }}-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
            <p class="font-bold">{{ $type }}</p>
            <p class="text-sm">{{ $message }}</p>
            </div>
        </div>
    </div>
</div>
