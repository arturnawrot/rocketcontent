<?php

namespace App\Presenters;

trait CustomerPresenter {
    public function daysBeforeTrialEnds() : int {
        $days = (int) now()->diff($this->trial_ends_at)->format('%r%a');

        if(!$this->entity->isOnTrial()) {
            return 0;
        }

        return $days + 1;
    }

    public function timeBeforeTrialEnds() : string {
        return now()->diff($this->trial_ends_at)->format('%d days %h hours');
    }
}