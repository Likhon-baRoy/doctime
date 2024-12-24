<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientAccountActivationNotification extends Notification
{
  use Queueable;

  private $token;
  private $name;

  /**
   * Create a new notification instance.
   */
  public function __construct($patient)
  {
    //
    $this -> name = $patient -> name;
    $this -> token = $patient -> access_token;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    return (new MailMessage)
                    ->line('Hi ' . $this -> name . ', Thanks for creating your account. Now you have to activate you account by clicking on the given link.')
                    ->action('Activate', url('/patient_account_activation/' . $this -> token))
                    ->line('Thank you for using our application!');
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
