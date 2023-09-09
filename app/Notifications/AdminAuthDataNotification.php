<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAuthDataNotification extends Notification implements ShouldQueue
{
	use Queueable;

	private $admin, $password;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($admin, $password)
	{
		$this->admin = $admin;
		$this->password = $password;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->subject('Вы зарегистрированы')
			->greeting('Оповещение!')
			->line('Вы были зарегистрированы как администратор на сайте '.config('app.name'))
			->line('Данные для входа в админ панель:')
			->line('Логин: '.$this->admin->login)
			->line('Пароль: '.$this->password);
	}

}
