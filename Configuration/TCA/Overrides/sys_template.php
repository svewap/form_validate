<?php
defined('TYPO3_MODE') or die();

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'form_validate',
    'Configuration/TypoScript/',
    'AJAX Form Validation'
);
