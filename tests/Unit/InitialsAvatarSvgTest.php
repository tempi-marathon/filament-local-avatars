<?php

use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use TempiMarathon\FilamentLocalAvatars\Support\InitialsAvatarSvg;
use TempiMarathon\FilamentLocalAvatars\Tests\Fixtures\Models\User;

beforeEach(function (): void {
    Filament::setCurrentPanel(Filament::getPanel('test'));
});

test('forRecord returns a local svg data uri without remote hosts', function (): void {
    $user = new User(['name' => 'Jane Doe']);

    $url = app(InitialsAvatarSvg::class)->forRecord($user);

    expect($url)
        ->toStartWith('data:image/svg+xml;base64,')
        ->not->toContain('ui-avatars.com')
        ->not->toContain('https://');
});

test('generated svg contains user initials', function (): void {
    $user = new User(['name' => 'Jane Doe']);

    $url = app(InitialsAvatarSvg::class)->forRecord($user);
    $svg = base64_decode(str_replace('data:image/svg+xml;base64,', '', $url));

    expect($svg)->toContain('JD');
});

test('initialsFor extracts initials from record name', function (): void {
    $user = new User(['name' => 'Jane Doe']);

    expect(app(InitialsAvatarSvg::class)->initialsFor($user))->toBe('JD');
});

test('backgroundColor uses configured color when set', function (): void {
    config(['filament-local-avatars.background_color' => '#112233']);

    expect(app(InitialsAvatarSvg::class)->backgroundColor())->toBe('#112233');
});

test('backgroundColor falls back to panel primary color', function (): void {
    config(['filament-local-avatars.background_color' => null]);

    $primary = FilamentColor::getColor('primary') ?? Color::Green;
    $shade = $primary[600] ?? $primary[500] ?? Color::Green[600];
    $expected = Color::convertToHex(is_string($shade) ? $shade : '#16a34a');

    expect(app(InitialsAvatarSvg::class)->backgroundColor())->toBe($expected);
});

test('svg uses default config when values are invalid', function (): void {
    config([
        'filament-local-avatars.size' => 'invalid',
        'filament-local-avatars.font_size' => 'invalid',
        'filament-local-avatars.text_color' => 123,
    ]);

    $user = new User(['name' => 'Jane Doe']);
    $url = app(InitialsAvatarSvg::class)->forRecord($user);
    $svg = base64_decode(str_replace('data:image/svg+xml;base64,', '', $url));

    expect($svg)
        ->toContain('width="120"')
        ->toContain('font-size="48"')
        ->toContain('fill="#FFFFFF"');
});

test('svg respects configured size font size and text color', function (): void {
    config([
        'filament-local-avatars.size' => 80,
        'filament-local-avatars.font_size' => 32,
        'filament-local-avatars.text_color' => '#FF0000',
        'filament-local-avatars.background_color' => '#000000',
    ]);

    $user = new User(['name' => 'Jane Doe']);
    $url = app(InitialsAvatarSvg::class)->forRecord($user);
    $svg = base64_decode(str_replace('data:image/svg+xml;base64,', '', $url));

    expect($svg)
        ->toContain('width="80"')
        ->toContain('font-size="32"')
        ->toContain('fill="#FF0000"')
        ->toContain('fill="#000000"');
});

test('svg escapes special characters in initials', function (): void {
    $user = new User(['name' => 'Tom <script>']);

    $url = app(InitialsAvatarSvg::class)->forRecord($user);
    $svg = base64_decode(str_replace('data:image/svg+xml;base64,', '', $url));

    expect($svg)
        ->toContain('T&lt;')
        ->not->toContain('<script>');
});
