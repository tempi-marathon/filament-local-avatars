<?php

use Filament\Facades\Filament;
use TempiMarathon\FilamentLocalAvatars\AvatarProviders\LocalInitialsAvatarProvider;
use TempiMarathon\FilamentLocalAvatars\Tests\Fixtures\Models\Team;
use TempiMarathon\FilamentLocalAvatars\Tests\Fixtures\Models\User;

beforeEach(function (): void {
    Filament::setCurrentPanel(Filament::getPanel('test'));
});

test('provider returns a local svg data uri without remote hosts', function (): void {
    $user = new User(['name' => 'Jane Doe']);

    $url = app(LocalInitialsAvatarProvider::class)->get($user);

    expect($url)
        ->toStartWith('data:image/svg+xml;base64,')
        ->not->toContain('ui-avatars.com')
        ->not->toContain('https://');
});

test('generated svg contains user initials', function (): void {
    $user = new User(['name' => 'Jane Doe']);

    $url = app(LocalInitialsAvatarProvider::class)->get($user);
    $svg = base64_decode(str_replace('data:image/svg+xml;base64,', '', $url));

    expect($svg)->toContain('JD');
});

test('provider works for tenant records', function (): void {
    $team = new Team(['name' => 'Oak Street Home']);

    $url = app(LocalInitialsAvatarProvider::class)->get($team);

    expect($url)
        ->toStartWith('data:image/svg+xml;base64,')
        ->not->toContain('ui-avatars.com');

    $svg = base64_decode(str_replace('data:image/svg+xml;base64,', '', $url));

    expect($svg)->toContain('OSH');
});

test('filament resolves user avatar url through the local provider', function (): void {
    $user = new User(['name' => 'Jane Doe']);

    $url = Filament::getUserAvatarUrl($user);

    expect($url)
        ->toStartWith('data:image/svg+xml;base64,')
        ->not->toContain('ui-avatars.com');
});

test('filament resolves tenant avatar url through the local provider', function (): void {
    $team = new Team(['name' => 'Oak Street Home']);

    $url = Filament::getTenantAvatarUrl($team);

    expect($url)
        ->toStartWith('data:image/svg+xml;base64,')
        ->not->toContain('ui-avatars.com');
});
