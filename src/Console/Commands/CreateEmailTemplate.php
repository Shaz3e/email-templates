<?php

namespace Shaz3e\EmailTemplates\Console\Commands;

use Illuminate\Console\Command;
use Shaz3e\EmailTemplates\App\Models\EmailTemplate;

class CreateEmailTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * php artisan email-templates:create user_registration "User Registration" "Welcome to Our Platform"
     */
    protected $signature = 'email-templates:create {key?} {name?} {subject?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new email template';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get or prompt for 'key'
        $key = $this->getInput('key', 'Please enter the template key');

        // Get or prompt for 'name'
        $name = $this->getInput('name', 'Please enter the template name');

        // Get or prompt for 'subject'
        $subject = $this->getInput('subject', 'Please enter the email subject');

        // Check if template with the same key already exists
        $existingTemplate = EmailTemplate::where('key', $key)->first();
        if ($existingTemplate) {
            $this->error("An email template with the key '{$key}' already exists.");
            return;
        }

        // Create a new email template
        $emailTemplate = EmailTemplate::create([
            'key' => $key,
            'subject' => $subject,
            'name' => $name,
            'content' => '<p>Your email content here</p>',
        ]);

        $this->info("Email template '{$emailTemplate->key}' created successfully!");
    }

    /**
     * Get or prompt for required input.
     *
     * @param string $argument
     * @param string $prompt
     * @return string
     */
    private function getInput(string $argument, string $prompt): string
    {
        // Try to get the argument value or prompt for it
        $value = $this->argument($argument) ?? $this->ask($prompt);

        // If the value is empty, keep asking until a valid value is entered
        while (empty($value)) {
            $this->error("The {$argument} is required. Please provide a value.");
            $value = $this->ask($prompt);
        }

        return $value;
    }
}
