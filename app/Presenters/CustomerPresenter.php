<?php

namespace App\Presenters;

trait CustomerPresenter {
    public function daysBeforeTrialEnds() : int {
        return (int) now()->diff($this->trial_ends_at)->format('%r%a');
    }

    public function timeBeforeTrialEnds() : string {
        return now()->diff($this->trial_ends_at)->format('%d days %h hours');
    }
}