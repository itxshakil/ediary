<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<url>
		<loc>https://ediary.shakiltech.com/</loc>

		<lastmod>2023-01-07</lastmod>

		<changefreq>daily</changefreq>

		<priority>1.0</priority>

	</url>
	@foreach ($routes as $route)
	@if (strpos($route->uri, '{') !== false)
		@continue
	@endif
	<url>
		<loc>{{ url($route->uri) }}</loc>

		<lastmod>{{ date('Y-m-d') }}</lastmod>

		<changefreq>weekly</changefreq>

		<priority>0.9</priority>
	</url>
	@endforeach
	@foreach ($users as $user)
    <url>
        <loc>{{url("/user/{$user->username}")}}</loc>

        <lastmod>{{$user->updated_at->tz('UTC')->toAtomString()}}</lastmod>

        <changefreq>weekly</changefreq>

        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>