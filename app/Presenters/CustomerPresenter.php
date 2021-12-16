<?php

namespace App\Presenters;

trait CustomerPresenter {
    public function timeBeforeTrialEnds() {
        return now()->diff($this->trial_ends_at)->format('%d days %h hours');
    }
}