<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
</head>

<body>
    @if ($headerImage)
        <img src="{{ $headerImage }}" alt="Header Image" style="max-width: 100%;">
    @endif
    <div>
        {!! $content !!}
    </div>
    <footer style="background-color: {{ $footerBackgroundColor }}; color: {{ $footerTextColor }}; padding: 10px;">
        {!! $footerText !!}
    </footer>
</body>

</html>
