<?php echo '<?xml version="1.0" encoding="UTF-8"?>'?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>https://appediary.herokuapp.com/</loc>

        <lastmod>2020-07-01</lastmod>

        <changefreq>daily</changefreq>

        <priority>1.0</priority>

    </url>
    @foreach ($routes as $route)
    <url>
        <loc>{{url($route->uri)}}</loc>

        <lastmod>{{date('Y-m-d H:i:s')}}</lastmod>

        <changefreq>weekly</changefreq>

        <priority>0.9</priority>
    </url>
    @endforeach

</urlset>