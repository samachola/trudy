<?php 

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer;

class NewRequestNotificationMail extends Mailable
{
		public $payload;

	 /**
     * Create a new message instance.
     *
     * @param array $payload payload
     * @param string $recipient recipient
     *
		 */
		 public function __construct($payload)
		 {
				  $this->payload = $payload;
		 }

		 /**
     * Build the message.
     *
     * @return $this
		 */
		 public function build()
		 {
					return $this->to("sam.achola@live.com")
								->from("acholasam1@gmail.com", "Trudy Alerts")
								->view('new_request_email')
								->with(
										[
											"payload" => $this->payload
										]
								);
		 }
}