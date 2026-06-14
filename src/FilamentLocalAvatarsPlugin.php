<?php

namespace TempiMarathon\FilamentLocalAvatars;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TempiMarathon\FilamentLocalAvatars\AvatarProviders\LocalInitialsAvatarProvider;

final class FilamentLocalAvatarsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-local-avatars';
    }

    public function register(Panel $panel): void
    {
        $panel->defaultAvatarProvider(LocalInitialsAvatarProvider::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new self;
    }
}
