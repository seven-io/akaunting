<?php

namespace Modules\Seven\Traits;

trait Settings {
    private function getCompanyName(): string {
        return setting('company.name');
    }

    private function getApiKey(): ?string {
        return $this->getSetting('api_key');
    }

    private function getOnInvoiceCreationText(): ?string {
        return $this->getSetting('on_invoice_creation_text');
    }

    private function getSetting(string $key, mixed $default = null): mixed {
        $settings = $this->getSettings();
        return $settings[$key] ?? $default;
    }

    private function getSettings(): array {
        $settings = setting($this->getModuleAlias());
        return $settings ?: [];
    }

    private function getModuleAlias(): string {
        return $this->getModule()->alias;
    }

    private function getModule(): mixed {
        return module('seven');
    }

    private function getSettingsRoute(): string {
        return route('settings.module.edit', ['alias' => $this->getModuleAlias()]);
    }
}
