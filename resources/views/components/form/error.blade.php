@props(['name'])

@error($name)
    <p {{ $attributes->class(['mt-1 text-sm text-red-600 dark:text-red-400']) }} role="alert">{{ $message }}</p>
@enderror
