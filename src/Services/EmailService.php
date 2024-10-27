<?php

namespace Shaz3e\EmailTemplates\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Shaz3e\EmailTemplates\App\Models\EmailTemplate;
use Shaz3e\EmailTemplates\Mail\EmailTemplate as MailEmailTemplate;

class EmailService
{
    /**
     * Send an email based on the template key.
     *
     * @param string $key
     * @param string $toEmail
     * @param array $data
     * @return void
     */
    public function sendEmailByKey($key, $toEmail, $data = [])
    {
        try {
            // Fetch the email template by key
            $template = EmailTemplate::where('key', $key)->firstOrFail();

            // Replace placeholders in the template content and subject
            $content = $this->replacePlaceholders($template->content, $data);
            $subject = $this->replacePlaceholders($template->subject, $data);

            // Send the email
            Mail::to($toEmail)->send(new MailEmailTemplate($subject, $content));
        } catch (Exception $e) {
            Log::error("Email sending failed for key $key: " . $e->getMessage());
        }
    }

    /**
     * Replace placeholders in the template content.
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    protected function replacePlaceholders($template, $data)
    {
        return preg_replace_callback('/\{\{\s*(\w+)\s*\}\}/', function ($matches) use ($data) {
            $placeholder = $matches[1];
            return $data[$placeholder] ?? ''; // Default to empty string if placeholder not provided
        }, $template);
    }
}
