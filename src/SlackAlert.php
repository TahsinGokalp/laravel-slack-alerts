<?php

namespace Spatie\SlackAlerts;

use Spatie\SlackAlerts\ValueObjects\Section;

class SlackAlert
{
    protected string $webhookUrlName = 'default';

    public function to(string $webhookUrlName): self
    {
        $this->webhookUrlName = $webhookUrlName;

        return $this;
    }

    public function message(string $text): void
    {
        $webhookUrl = Config::getWebhookUrl($this->webhookUrlName);

        $jobArguments = [
            'type' => 'mrkdown',
            'text' => $text,
            'webhookUrl' => $webhookUrl,
        ];

        $job = Config::getJob($jobArguments);

        dispatch($job);
    }

    public function section(string $text): void
    {
        $webhookUrl = Config::getWebhookUrl($this->webhookUrlName);

        $jobArguments = [
            'type' => 'section',
            'text' => Section::fromText($text),
            'webhookUrl' => $webhookUrl,
        ];

        $job = Config::getJob($jobArguments);

        dispatch($job);
    }
}
