<?php

namespace Shaz3e\EmailTemplates\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Shaz3e\EmailTemplates\App\Models\EmailGlobalSetting;

class EmailTemplate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $placeholders;
    public $headerImage;
    public $footerText;
    public $footerTextColor;
    public $footerBackgroundColor;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $content
     * @param array $placeholders
     */
    public function __construct($subject, $content, $placeholders = [], $header = null, $footer = null)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->placeholders = $placeholders;

        // Load global settings
        $globalSettings = EmailGlobalSetting::whereIn('name', [
            'header_image',
            'footer_text',
            'footer_text_color',
            'footer_background_color'
        ])->pluck('value', 'name');

         $this->headerImage = url('storage/' . $globalSettings['header_image']);
        $this->footerText = $globalSettings['footer_text'] ?? '';
        $this->footerTextColor = $globalSettings['footer_text_color'] ?? '';
        $this->footerBackgroundColor = $globalSettings['footer_background_color'] ?? '';
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
            ->with([
                'content' => $contentWithPlaceholders,
                'headerImage' => $this->headerImage,
                'footerText' => $this->footerText,
                'footerTextColor' => $this->footerTextColor,
                'footerBackgroundColor' => $this->footerBackgroundColor,
            ]);
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
