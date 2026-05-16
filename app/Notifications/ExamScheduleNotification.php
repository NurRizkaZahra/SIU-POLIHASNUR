<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExamScheduleNotification extends Notification
{
    use Queueable;

    protected $exam;
    protected $status;

    public function __construct($exam, $status)
    {
        $this->exam = $exam;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->status == 'approved') {

            return (new MailMessage)
                ->subject('Jadwal Ujian Disetujui')
                ->greeting('Halo, ' . $this->exam->user->name)
                ->line('Pengajuan jadwal ujian Anda telah DISETUJUI.')
                ->line('Gelombang: ' . ($this->exam->examSchedule->wave_name ?? '-'))
                ->line('Tanggal Ujian: ' . \Carbon\Carbon::parse($this->exam->examSchedule->exam_date)->format('d M Y'))
                ->line('Silakan login ke sistem untuk mengikuti ujian.')
                ->salutation('PMB POLIHASNUR');
        }

        return (new MailMessage)
            ->subject('Jadwal Ujian Ditolak')
            ->greeting('Halo, ' . $this->exam->user->name)
            ->line('Pengajuan jadwal ujian Anda telah DITOLAK.')
            ->salutation('PMB POLIHASNUR');
    }
}