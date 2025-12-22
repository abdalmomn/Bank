<?php

namespace App\Jobs;

use App\Mail\InfoMail;
use App\Models\Account;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    public User $user;
    public Account $account;
    public string $tempPassword;
    public string $otp;

    public function __construct(User $user, Account $account, $tempPassword, $otp)
    {
        $this->user = $user;
        $this->account = $account;
        $this->tempPassword = $tempPassword;
        $this->otp = $otp;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(
            new InfoMail($this->user, $this->account, $this->tempPassword, $this->otp)
        );
    }
}
