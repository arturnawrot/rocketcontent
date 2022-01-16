<?php

namespace App\Presenters;

trait CustomerPresenter {
    public function daysBeforeTrialEnds() : int {
        if(!$this->entity->isOnTrial()) {
            return 0;
        }

        $dateDifference = strtotime($this->trial_ends_at) - strtotime(now());

        return round($dateDifference / (60 * 60 * 24));
    }

    public function timeBeforeTrialEnds() : string {
        return now()->diff($this->trial_ends_at)->format('%d days %h hours');
    }
}