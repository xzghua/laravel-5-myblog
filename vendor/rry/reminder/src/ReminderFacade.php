<?php

namespace Rry\Reminder;

use Illuminate\Support\Facades\Facade;

class ReminderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reminder';
    }
}
