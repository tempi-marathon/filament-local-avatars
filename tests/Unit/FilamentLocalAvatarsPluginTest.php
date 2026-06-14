<?php

use Filament\Facades\Filament;
use Filament\Panel;
use TempiMarathon\FilamentLocalAvatars\AvatarProviders\LocalInitialsAvatarProvider;
use TempiMarathon\FilamentLocalAvatars\FilamentLocalAvatarsPlugin;

test('plugin has the expected id', function (): void {
    expect(FilamentLocalAvatarsPlugin::make()->getId())->toBe('filament-local-avatars');
});

test('make returns a plugin instance', function (): void {
    expect(FilamentLocalAvatarsPlugin::make())->toBeInstanceOf(FilamentLocalAvatarsPlugin::class);
});

test('register sets the default avatar provider on the panel', function (): void {
    $panel = Panel::make();

    FilamentLocalAvatarsPlugin::make()->register($panel);

    expect($panel->getDefaultAvatarProvider())->toBe(LocalInitialsAvatarProvider::class);
});

test('boot does nothing', function (): void {
    FilamentLocalAvatarsPlugin::make()->boot(Filament::getPanel('test'));

    expect(true)->toBeTrue();
});
