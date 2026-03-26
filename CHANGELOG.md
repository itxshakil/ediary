# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased] - 2026-03-26

### Added

- **Apple-like design tokens** (`app.css`): Added `--font-sans` system font stack (`-apple-system, BlinkMacSystemFont, 'SF Pro Display'`), `--color-surface`, `--color-surface-dark`, `--color-border`, `--color-border-dark`, and `--radius-sm/md/lg/full` CSS custom properties for a consistent, refined visual language.
- **Frosted-glass navbar** (`app.css`, `navbar.blade.php`): Added `.navbar-glass` class using `backdrop-filter: blur(20px) saturate(180%)` and `rgba` surface colors; navbar is now `sticky top-0` with a subtle border instead of a flat `bg-gray-800` background.
- **Scroll-driven navbar shadow** (`app.css`): Added `@keyframes navbar-shadow` driven by `animation-timeline: scroll()` so the navbar gains a shadow automatically when the page is scrolled — no JavaScript scroll listeners.
- **Native `<details>`/`<summary>` navbar dropdown** (`navbar.blade.php`): Replaced the Vue `Dropdown` component and Alpine `x-data` toggle with a native `<details>`/`<summary>` element (`.nav-details`), eliminating all JS toggle state and the invisible overlay hack.
- **CSS-only flash animation** (`app.css`, `Flash.vue`): Added `@keyframes flash-in-out` (slide-in → hold → fade-out) with `animation-fill-mode: forwards`; `Flash.vue` now uses an `animKey` to force re-mount and restart the animation on repeated flashes — no `setTimeout` for show/hide.
- **`field-sizing: content` auto-grow textarea** (`app.css`, `ResizableTextarea.vue`): Added `.auto-grow` CSS class using the native `field-sizing: content` property; `ResizableTextarea.vue` is now a thin wrapper rendering `<textarea class="auto-grow">` with no JS scroll-height logic.
- **CSS `line-clamp` + `<details>` diary card expand** (`Diary.vue`, `app.css`): Replaced JS-based "show more / show less" text truncation with native CSS `line-clamp-4` inside a `<details>`/`<summary>` pattern; replaced the manual `formatDate` method with a one-liner `Intl.DateTimeFormat`.
- **View Transitions API** (`app.js`): Added `@view-transition { navigation: auto }` in CSS and a `document.startViewTransition` intercept for same-origin link clicks, providing smooth cross-fade/morph transitions between pages without hard DOM swaps.
- **PWA banner `@starting-style` entrance** (`app.css`, `app.js`): Replaced JS `bottom`/`opacity` animation with a CSS `@starting-style` + `transition` entrance; `maybeShowBanner`/`hideBanner` now toggle a `pwa-visible` CSS class instead of manipulating inline styles.
- **Web Share API floating button** (`app.js`): The floating share button now calls `navigator.share()` directly, removing the need for a custom `Share.vue` component.
- **Diary card redesign** (`diary-card.blade.php`, `app.css`): Replaced the old JS expand/collapse script and `toggleActions` inline `<script>` blocks with a clean `<details>`/`<summary>` pattern; simplified layout to header (date + mood/privacy emoji), optional title, tags, and content — zero JavaScript. Added `.diary-card` CSS block with frosted-glass surface, `var(--radius-lg)` border-radius, subtle shadow, and dark-mode support.

### Changed

- **`navbar.blade.php`**: Switched from `bg-gray-800` flat background to `.navbar-glass` frosted-glass; replaced Vue/Alpine dropdown with native `<details>`.
- **`Flash.vue`**: Removed `setTimeout`-based show/hide; animation lifecycle is now fully CSS-driven via `flash-in-out` keyframes.
- **`ResizableTextarea.vue`**: Removed JS `scrollHeight` resize logic; component delegates entirely to CSS `field-sizing: content`.
- **`Diary.vue`**: Removed manual `formatDate` method; date formatting now uses `Intl.DateTimeFormat` with the user's locale.
- **`diary-card.blade.php`**: Removed all inline `<script>` blocks and PHP truncation logic; card is now fully static HTML + CSS.

### Removed

- Invisible overlay `<button>` hack from the Vue `Dropdown` component (replaced by native `<details>`).
- JS `scroll` event listeners for navbar shadow (replaced by CSS scroll-driven animations).
- JS `bottom`/`opacity` PWA banner animation (replaced by CSS `@starting-style` transition).
- JS-based text truncation and `toggleActions` scripts from diary cards.
