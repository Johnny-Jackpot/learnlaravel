<?php

namespace App\Mail;

use App\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackRejected extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Feedback
     */
    public $feedback;

    /**
     * @var string
     */
    public $authorName;

    /**
     * @var string
     */
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param Feedback $feedback
     * @param string $authorName
     * @param string $reason
     */
    public function __construct(Feedback $feedback, string $authorName, string $reason)
    {
        $this->feedback = $feedback;
        $this->authorName = $authorName;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@guestbook.com')
                    ->text('email');
    }
}
