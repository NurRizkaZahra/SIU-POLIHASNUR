<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ExamScheduleNotificationMail extends Mailable
{
    public $exam;
    public $status;

    public function __construct($exam, $status)
    {
        $this->exam = $exam;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Notifikasi Jadwal Ujian')
                    ->view('emails.exam-schedule-notification');
    }
}