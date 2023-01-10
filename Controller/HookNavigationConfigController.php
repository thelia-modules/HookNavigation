<?php

/*
 * This file is part of the Thelia package.
 * http://www.thelia.net
 *
 * (c) OpenStudio <info@thelia.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HookNavigation\Controller;

use HookNavigation\HookNavigation;
use HookNavigation\Model\Config\HookNavigationConfigValue;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Template\ParserContext;
use Thelia\Form\Exception\FormValidationException;

/**
 * Class HookNavigationConfigController.
 *
 * @author Etienne PERRIERE <eperriere@openstudio.fr> - OpenStudio
 */
class HookNavigationConfigController extends BaseAdminController
{
    public function defaultAction(Session $session)
    {
        $bodyConfig = HookNavigation::getConfigValue(HookNavigationConfigValue::FOOTER_BODY_FOLDER_ID);
        $bottomConfig = HookNavigation::getConfigValue(HookNavigationConfigValue::FOOTER_BOTTOM_FOLDER_ID);

        $session->getFlashBag()->set('bodyConfig', $bodyConfig ?? 0);
        $session->getFlashBag()->set('bottomConfig', $bottomConfig ?? 0);

        return $this->render('hooknavigation-configuration');
    }

    public function saveAction(Session $session,ParserContext $parserContext)
    {
        $baseForm = $this->createForm('hooknavigation.configuration');

        $errorMessage = null;

        try {
            $form = $this->validateForm($baseForm);
            $data = $form->getData();

            HookNavigation::setConfigValue(HookNavigationConfigValue::FOOTER_BODY_FOLDER_ID, \is_bool($data['footer_body_folder_id']) ? (int) ($data['footer_body_folder_id']) : $data['footer_body_folder_id']);
            HookNavigation::setConfigValue(HookNavigationConfigValue::FOOTER_BOTTOM_FOLDER_ID, \is_bool($data['footer_bottom_folder_id']) ? (int) ($data['footer_bottom_folder_id']) : $data['footer_bottom_folder_id']);
        } catch (FormValidationException $ex) {
            // Invalid data entered
            $errorMessage = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            // Any other error
            $errorMessage = $this->getTranslator()->trans('Sorry, an error occurred: %err', ['%err' => $ex->getMessage()], [], HookNavigation::MESSAGE_DOMAIN);
        }

        if (null !== $errorMessage) {
            // Mark the form as with error
            $baseForm->setErrorMessage($errorMessage);

            // Send the form and the error to the parser
            $parserContext
                ->addForm($baseForm)
                ->setGeneralError($errorMessage)
            ;
        } else {
            $parserContext
                ->set('success', true)
            ;
        }

        return $this->defaultAction($session);
    }
}
