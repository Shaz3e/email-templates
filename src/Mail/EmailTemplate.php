<?php

namespace Shaz3e\EmailTemplates\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTemplate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $placeholders;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $content
     * @param array $placeholders
     */
    public function __construct($subject, $content, $placeholders = [])
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->placeholders = $placeholders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Replace placeholders in the content
        $contentWithPlaceholders = $this->replacePlaceholders($this->content, $this->placeholders);

        return $this->subject($this->subject)
            ->view('email-templates::emails.email-template') // Use your dynamic email blade file
            ->with(['content' => $contentWithPlaceholders]);
    }

    /**
     * Replace placeholders with actual values.
     *
     * @param string $content
     * @param array $placeholders
     * @return string
     */
    protected function replacePlaceholders($content, $placeholders)
    {
        foreach ($placeholders as $key => $value) {
            $content = str_replace("{{ $key }}", $value, $content);
        }
        return $content;
    }
}
