<?php

namespace Idleworks\FormBadwords;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

final class Configuration
{
    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
    )
    {}

    public function get(string $option): string
    {
        try {
            return $this->extensionConfiguration->get('form_badwords', $option) ?: '';
        } catch (ExtensionConfigurationExtensionNotConfiguredException|ExtensionConfigurationPathDoesNotExistException)
        {}

        return '';
    }
}
