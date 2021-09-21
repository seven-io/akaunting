<?php

namespace Modules\Sms77\Traits;

trait Settings {
    private function getCompanyName(): string {
        return setting('company.name');
    }

    /**
     * @return string|null
     */
    private function getApiKey(): ?string {
        return $this->getSetting('api_key');
    }

    /**
     * @return string|null
     */
    private function getOnInvoiceCreationText(): ?string {
        return $this->getSetting('on_invoice_creation_text');
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function getSetting(string $key, $default = null) {
        $settings = $this->getSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * @return array
     */
    private function getSettings(): array {
        $settings = setting($this->getModuleAlias());
        return $settings ?: [];
    }

    /**
     * @return string
     */
    private function getModuleAlias(): string {
        return $this->getModule()->alias;
    }

    /**
     * @return mixed
     */
    private function getModule() {
        return module('sms77');
    }

    /**
     * @return string
     */
    private function getSettingsRoute(): string {
        return route('settings.module.edit', ['alias' => $this->getModuleAlias()]);
    }
}
