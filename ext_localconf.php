<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterBuildingFinished'][1513540833]
    = \WapplerSystems\FormValidate\FormManipulator::class;

//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterInitializeCurrentPage'][1513540833] = \WapplerSystems\FormValidate\FormManipulator::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterSubmit'][1513540833]
    = \WapplerSystems\FormValidate\FormManipulator::class;



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WapplerSystems.FormValidate',
    'Ajax',
    [
        'Form' => 'ajax',
    ],
    [
    ]
);

