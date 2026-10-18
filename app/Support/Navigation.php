<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\Request;

/**
 * The primary navigation, shared by the desktop navbar and the mobile tab bar.
 */
final readonly class Navigation
{
    private const array ICONS = [
        'journal' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        'entries' => 'M4 6h16M4 12h16M4 18h10',
        'write' => 'M12 4v16m8-8H4',
        'stats' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'explore' => 'M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5.5-3.5l-2 5-5 2 2-5 5-2z',
    ];

    public function __construct(private Request $request) {}

    /**
     * Destinations for signed-in people. "write" is the primary action in the tab bar.
     *
     * @return list<array{key: string, label: string, url: string, icon: string, active: bool}>
     */
    public function journal(): array
    {
        return [
            $this->item('journal', 'Journal', route('home'), $this->request->routeIs('home')),
            $this->item('entries', 'Entries', url('/diaries'), $this->request->is('diaries') || $this->request->routeIs('diary.tag', 'diary.mood', 'diary.search')),
            $this->item('write', 'Write', route('diary.create'), $this->request->routeIs('diary.create')),
            $this->item('stats', 'Stats', route('diary.stats'), $this->request->routeIs('diary.stats')),
            $this->item('explore', 'Explore', route('diary.explore'), $this->request->routeIs('diary.explore')),
        ];
    }

    /**
     * @return list<array{key: string, label: string, url: string, active: bool}>
     */
    public function site(): array
    {
        return [
            ['key' => 'blog', 'label' => 'Blog', 'url' => url('/blog'), 'active' => $this->request->is('blog', 'blogs/*')],
            ['key' => 'about', 'label' => 'About', 'url' => url('/about'), 'active' => $this->request->is('about')],
            ['key' => 'faq', 'label' => 'FAQ', 'url' => url('/faq'), 'active' => $this->request->is('faq')],
        ];
    }

    /**
     * @return array{key: string, label: string, url: string, icon: string, active: bool}
     */
    private function item(string $key, string $label, string $url, bool $active): array
    {
        return ['key' => $key, 'label' => $label, 'url' => $url, 'icon' => self::ICONS[$key], 'active' => $active];
    }
}
