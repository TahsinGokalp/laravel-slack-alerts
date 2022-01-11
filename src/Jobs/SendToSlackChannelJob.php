<?php

namespace Spatie\SlackAlerts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendToSlackChannelJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 3;

    public function __construct(
        public string|Arrayable $text,
        public string $type,
        public string $webhookUrl
    ) {
    }

    public function handle(): void
    {
        if (is_string($this->text)) {
            $this->sendMessage();

            return;
        }

        $this->sendBlock();
    }

    private function sendMessage(): void
    {
        $payload = ['type' => $this->type, 'text' => $this->text];

        Http::post($this->webhookUrl, $payload);
    }

    private function sendBlock(): void
    {
        $payload = [
            'blocks' => [
                $this->text->toArray(),
            ],
        ];

        Http::post($this->webhookUrl, $payload);
    }
}
