<?php

namespace HookNavigation\Form;

use HookNavigation\HookNavigation;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

/**
 * Class HookNavigationConfigForm.
 *
 * @author Etienne PERRIERE <eperriere@openstudio.fr> - OpenStudio
 */
class HookNavigationConfigForm extends BaseForm
{
    public function getName()
    {
        return 'hooknavigation_configuration';
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'footer_body_folder_id',
                'number',
                [
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'label' => $this->translator->trans('Folder in footer body', [], HookNavigation::MESSAGE_DOMAIN),
                ]
            )
            ->add(
                'footer_bottom_folder_id',
                'number',
                [
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'label' => $this->translator->trans('Folder in footer bottom', [], HookNavigation::MESSAGE_DOMAIN),
                ]
            );
    }
}
