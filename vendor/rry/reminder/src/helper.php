<?php

if (! function_exists('reminder')) {
    /**
     * Return the instance of reminder.
     *
     * @return Rry\Reminder\Reminder
     */
    function reminder() {
        return app('reminder');
    }
}
