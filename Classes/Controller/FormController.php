<?php
declare(strict_types=1);
namespace WapplerSystems\FormValidate\Controller;



use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Extbase\Service\FlexFormService;
use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Form\Domain\Factory\ArrayFormFactory;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;


class FormController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface
     */
    protected $formPersistenceManager;


    /**
     * @param \TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface $formPersistenceManager
     * @internal
     */
    public function injectFormPersistenceManager(\TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface $formPersistenceManager)
    {
        $this->formPersistenceManager = $formPersistenceManager;
    }


    public function ajaxAction()
    {


        $data = BackendUtility::getRecord('tt_content',(int)GeneralUtility::_GP('cid'),'pi_flexform');


        $flexformService = GeneralUtility::makeInstance(FlexFormService::class);
        $ffContent = $flexformService->convertFlexFormContentToArray($data['pi_flexform']);

        $formDefinitionArray = $this->formPersistenceManager->load($ffContent['settings']['persistenceIdentifier']);


        $arguments = GeneralUtility::_GP('tx_form_formframework');
        
        if(is_array($arguments[$formDefinitionArray['identifier'] . '-' . (int)GeneralUtility::_GP('cid')])) {
            $arguments = $arguments[$formDefinitionArray['identifier'] . '-' . (int)GeneralUtility::_GP('cid')];
        }
        
        $this->request->setArguments($arguments);


        $prototypeName = isset($overrideConfiguration['prototypeName']) ? $formDefinitionArray['prototypeName'] : 'standard';

        $factory = $this->objectManager->get(ArrayFormFactory::class);
        /** @var FormDefinition $formDefinition */
        $formDefinition = $factory->build($formDefinitionArray, $prototypeName);
        $response = $this->objectManager->get(Response::class, $this->response);
        /** @var FormRuntime $form */
        $formRuntime = $formDefinition->bind($this->request, $response);


        $validationResults = $formRuntime->getRequest()->getOriginalRequestMappingResults();

        $errors = $validationResults->getFlattenedErrors();

        //echo DebugUtility::convertVariableToString($validationResults->getFlattenedErrors());

        $errorsA = [];

        /**
         * @var string $identifier
         * @var array $errorsOfField
         */
        foreach ($errors as $identifier => $errorsOfField) {
            
            $identifier = str_replace($formDefinitionArray['identifier'] . '.', '', $identifier);
            
            /** @var Error $error */
            foreach ($errorsOfField as $error) {
                $t = [];
                $t['code'] = $error->getCode();
                $t['message'] = $error->getMessage();
                $errorsA[$identifier][] = $t;
            }
        }
        $this->view->assign('errors',$errorsA);
    }

}
