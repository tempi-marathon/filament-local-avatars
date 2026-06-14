<?php

namespace TempiMarathon\FilamentLocalAvatars\Support;

use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

final class InitialsAvatarSvg
{
    public function forRecord(Model | Authenticatable $record): string
    {
        $initials = $this->initialsFor($record);
        $background = $this->backgroundColor();

        return 'data:image/svg+xml;base64,' . base64_encode($this->svg($initials, $background));
    }

    public function initialsFor(Model | Authenticatable $record): string
    {
        return str(Filament::getNameForDefaultAvatar($record))
            ->trim()
            ->explode(' ')
            ->map(fn (string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
            ->filter()
            ->join('');
    }

    public function backgroundColor(): string
    {
        $configured = config('filament-local-avatars.background_color');

        if (is_string($configured) && $configured !== '') {
            return $configured;
        }

        $primary = FilamentColor::getColor('primary') ?? Color::Green;
        $shade = $primary[600] ?? $primary[500] ?? Color::Green[600];

        return Color::convertToHex(is_string($shade) ? $shade : '#16a34a');
    }

    protected function svg(string $initials, string $background): string
    {
        $initials = htmlspecialchars($initials, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $background = htmlspecialchars($background, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $size = $this->configInt('size', 120);
        $fontSize = $this->configInt('font_size', 48);
        $textColor = htmlspecialchars($this->configString('text_color', '#FFFFFF'), ENT_XML1 | ENT_QUOTES, 'UTF-8');

        return <<<SVG
            <svg xmlns="http://www.w3.org/2000/svg" width="{$size}" height="{$size}" viewBox="0 0 {$size} {$size}" role="img">
                <rect width="{$size}" height="{$size}" fill="{$background}"/>
                <text x="50%" y="50%" dominant-baseline="central" text-anchor="middle" fill="{$textColor}" font-family="system-ui, sans-serif" font-size="{$fontSize}" font-weight="600">{$initials}</text>
            </svg>
            SVG;
    }

    protected function configInt(string $key, int $default): int
    {
        $value = config("filament-local-avatars.{$key}", $default);

        return is_int($value) ? $value : $default;
    }

    protected function configString(string $key, string $default): string
    {
        $value = config("filament-local-avatars.{$key}", $default);

        return is_string($value) ? $value : $default;
    }
}
