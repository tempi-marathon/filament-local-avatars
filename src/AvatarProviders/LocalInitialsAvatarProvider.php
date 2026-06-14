<?php

namespace TempiMarathon\FilamentLocalAvatars\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Database\Eloquent\Model;
use TempiMarathon\FilamentLocalAvatars\Support\InitialsAvatarSvg;

class LocalInitialsAvatarProvider implements AvatarProvider
{
    public function get(Model $record): string
    {
        return app(InitialsAvatarSvg::class)->forRecord($record);
    }
}
