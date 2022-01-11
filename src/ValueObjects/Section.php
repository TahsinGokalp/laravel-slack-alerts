<?php

namespace Spatie\SlackAlerts\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Section implements Arrayable
{
    private function __construct(
        private string $type,
        private Text $text,
    ) {
    }

    public static function fromText(string $text): static
    {
        return new self('section', Text::fromText($text));
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text->toArray(),
        ];
    }
}
