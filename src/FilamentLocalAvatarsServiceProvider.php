<?php

namespace TempiMarathon\FilamentLocalAvatars;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TempiMarathon\FilamentLocalAvatars\Support\InitialsAvatarSvg;

class FilamentLocalAvatarsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-local-avatars';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(InitialsAvatarSvg::class);
    }
}
