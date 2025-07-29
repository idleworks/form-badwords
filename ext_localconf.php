<?php
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die;

ExtensionManagementUtility::addTypoScriptSetup(trim('
    plugin.tx_form {
        settings.yamlConfigurations.840 = EXT:form_badwords/Configuration/Yaml/Badwords.yaml
    }
'));
