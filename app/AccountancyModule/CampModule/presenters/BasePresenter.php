<?php

declare(strict_types=1);

namespace App\AccountancyModule\CampModule;

use Model\Auth\Resources\Camp;
use Model\Cashbook\ObjectType;
use Model\EventEntity;

class BasePresenter extends \App\AccountancyModule\BasePresenter
{
    /** @var \stdClass */
    protected $event;

    /** @var EventEntity */
    protected $eventService;

    protected function startup() : void
    {
        parent::startup();
        $this->eventService  = $this->context->getService('campService');
        $this->type          = ObjectType::CAMP;
        $this->template->aid = $this->aid;

        if ($this->aid === null) {
            return;
        }

        $this->template->event      = $this->event = $this->eventService->event->get($this->aid);
        $this->template->isEditable = $this->isEditable = $this->authorizator->isAllowed(Camp::UPDATE_REAL, $this->aid);
    }

    protected function editableOnly() : void
    {
        if ($this->isEditable) {
            return;
        }

        $this->flashMessage('Akce je uzavřena a nelze ji upravovat.', 'danger');
        if ($this->isAjax()) {
            $this->sendPayload();
        } else {
            $this->redirect('Default:');
        }
    }
}
