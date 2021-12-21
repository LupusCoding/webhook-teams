<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\TeamsTests\SenderLib;

use LupusCoding\Webhooks\Teams\AbstractCard;

/**
 * Class Sender
 * @package LupusCoding\Webhooks\TeamsTests
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 *
 * Just a test helper
 */
class Sender
{
    private string $url;
    private array $body;
    private bool $success;
    private string $lastError;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->resetVars();
    }

    private function resetVars(): void
    {
        $this->body = [];
        $this->success = false;
        $this->lastError = '';
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }

    public function send(AbstractCard $card): bool
    {
        $this->resetVars();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($card));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);

        $result = curl_exec($ch);
        $this->success = (curl_errno($ch) === 0);
        if (!$this->success) {
            $this->lastError = curl_error($ch);
            return false;
        }
        curl_close($ch);
        $this->body = json_decode($result, true);
        return true;
    }
}