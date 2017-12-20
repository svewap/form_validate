<?php
/**
 * Created by PhpStorm.
 * User: svewap
 * Date: 17.12.17
 * Time: 21:02
 */

namespace WapplerSystems\FormValidate;


use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\Page;

class FormManipulator
{

    /**
     * @param \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable
     * @return void
     */
    public function afterBuildingFinished(\TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable)
    {

    }

    /**
     * @param \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime
     * @param \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $currentPage
     * @param null|\TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $lastPage
     * @param mixed $elementValue submitted value of the element *before post processing*
     * @return \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface
     */
    public function afterInitializeCurrentPage(\TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime, \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $currentPage, \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface $lastPage = null, array $requestArguments = []): \TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface
    {
        //DebugUtility::debug($formRuntime);

        return $currentPage;
    }


    /**
     * @param \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime
     * @param \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable
     * @param mixed $elementValue submitted value of the element *before post processing*
     * @param array $requestArguments submitted raw request values
     * @return void
     */
    public function afterSubmit(\TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime, \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable, $elementValue, array $requestArguments = [])
    {

        if ($renderable instanceof Page) {

            //DebugUtility::debug("dedeede");

            //DebugUtility::debug($renderable);


            //DebugUtility::debug($formRuntime);

            //$name->addValidator(GeneralUtility::makeInstance(ObjectManager::class)->get(NotEmptyValidator::class));

            //DebugUtility::debug($formRuntime->getFormDefinition()->getProcessingRules());

            //$formRuntime->getFormDefinition()->getFinishers()

        }

        return $elementValue;
    }


}