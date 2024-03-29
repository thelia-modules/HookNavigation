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

namespace HookNavigation\Hook;

use HookNavigation\HookNavigation;
use HookNavigation\Model\Config\HookNavigationConfigValue;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class FrontHook.
 *
 * @author Julien Chanséaume <jchanseaume@openstudio.fr>, Etienne PERRIERE <eperriere@openstudio.fr> - OpenStudio
 */
class FrontHook extends BaseHook
{
    public function onMainFooterBody(HookRenderBlockEvent $event): void
    {
        $bodyConfig = HookNavigation::getConfigValue(HookNavigationConfigValue::FOOTER_BODY_FOLDER_ID);

        $content = trim($this->render('main-footer-body.html', ['bodyFolderId' => $bodyConfig]));
        if ('' !== $content) {
            $event->add([
                'id' => 'navigation-footer-body',
                'class' => 'links',
                'title' => $this->trans('Latest articles', [], HookNavigation::MESSAGE_DOMAIN),
                'content' => $content,
            ]);
        }
    }

    public function onMainFooterBottom(HookRenderEvent $event): void
    {
        $bottomConfig = HookNavigation::getConfigValue(HookNavigationConfigValue::FOOTER_BOTTOM_FOLDER_ID);

        $content = $this->render('main-footer-bottom.html', ['bottomFolderId' => $bottomConfig]);
        $event->add($content);
    }
}
