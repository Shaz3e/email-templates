# Email Templates

Email templates are pre-designed email messages that can be customized to fit your needs. They can be used to send automated emails, such as welcome emails, abandoned cart reminders, and order confirmations all emails will written in html and queueable mean there is no need to create additional jobs or mailable everytime for all your email and best thing is you can write your own email from dashboard and use template placeholders like `{{ name }}` in your email but you need to register placeholders in the specific email.

Before proceeding the installation steps please read the complete documention to take only the step which is necessary for your application. We suggest only publish config file as this may be necessary to manage prefix, routes and middleware and only publish views when you need to modify it. It built with livewire grid view which poll data only visible mode.

**Note**
This package is built for [S3 Dashboard](https://github.com/Shaz3e/S3-Dashboard) and require extra efforts to use with any laravel application.

Install via composer

```bash
composer require shaz3e/email-templates
```

Migrate database and permissions

```bash
php artisan migrate
```

Create template from dashboard visit `http://s3-dashboard.test/manage/email-templates/create`

#### Create Template from Console

```bash
php artisan email-templates:create
```

-   Provide Unique Template Key
-   Provide Template Name
-   Provide Email Subject

#### Or create all together

```bash
php artisan email-templates:create "key" "name" "subject"
```

replace key, name, subject according to your requirements

To send email use the following function in your application or preview/view the template and use the code at the end of show route

```php
use Shaz3e\EmailTemplates\Services\EmailService;

$emailService = new EmailService();
$emailService->sendEmailByKey('{template_key}', $user->email, [
    'name' => $user->name,
    'email' => $user->email,
]);
```

#### Publisables

Publish config only

```bash
php artisan vendor:publish --tag=email-templates-config
```

Publish views only

```bash
php artisan vendor:publish --tag=email-templates-view
```

Publish migration only

```bash
php artisan vendor:publish --tag=email-templates-migration
```

Publish language files only

```bash
php artisan vendor:publish --tag=email-templates-lang
```

Or Publish everything

```bash
php artisan vendor:publish --tag=email-templates-all
```
