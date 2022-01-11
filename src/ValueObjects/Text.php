<?php

namespace Spatie\SlackAlerts\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Text implements Arrayable
{
    private function __construct(
        private string $type,
        private string $text,
    ) {
    }

    public static function fromText(string $text): static
    {
        return new self('mrkdwn', $text);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
        ];
    }
}
