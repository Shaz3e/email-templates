# Email Templates

![Packagist Version](https://img.shields.io/packagist/v/shaz3e/email-templates)
![Packagist Downloads](https://img.shields.io/packagist/dt/shaz3e/email-templates)
![License](https://img.shields.io/packagist/l/shaz3e/email-templates)
![Laravel Version](https://img.shields.io/badge/laravel-11.x-blue)


Email templates are pre-designed email messages that can be customized to fit your needs. They can be used to send automated emails, such as welcome emails, abandoned cart reminders, and order confirmations all emails will written in html and queueable mean there is no need to create additional jobs or mailable everytime for all your email and best thing is you can write your own email from dashboard and use template placeholders like `{{ name }}` in your email but you need to register placeholders in the specific email.

Before proceeding the installation steps please read the complete documention to take only the step which is necessary for your application. We suggest only publish config file as this may be necessary to manage prefix, routes and middleware and only publish views when you need to modify it. It built with livewire grid view which poll data only visible mode.

**Note**
This package is built for [S3 Dashboard](https://github.com/Shaz3e/S3-Dashboard) and require extra efforts to use with any laravel application.

Install via composer

```bash
composer require shaz3e/email-templates
```

Publish migration only

```bash
php artisan vendor:publish --tag=email-templates-migration
```

Migrate database and permissions

```bash
php artisan migrate
```

```bash
php artisan storage:link
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

Publish language files only

```bash
php artisan vendor:publish --tag=email-templates-lang
```

Or Publish everything

```bash
php artisan vendor:publish --tag=email-templates-all
```


#### Contributing

* If you have any suggestions please let me know : https://github.com/Shaz3e/email-templates/pulls.
* Please help me improve code https://github.com/Shaz3e/email-templates/pulls

#### License
Email Templates with [S3 Dashboard](https://github.com/Shaz3e/S3-Dashboard) is licensed under the MIT license. Enjoy!

## Credit
* [Shaz3e](https://www.shaz3e.com) | [YouTube](https://www.youtube.com/@shaz3e) | [Facebook](https://www.facebook.com/shaz3e) | [Twitter](https://twitter.com/shaz3e) | [Instagram](https://www.instagram.com/shaz3e) | [LinkedIn](https://www.linkedin.com/in/shaz3e/)
* [Diligent Creators](https://www.diligentcreators.com) | [Facebook](https://www.facebook.com/diligentcreators) | [Instagram](https://www.instagram.com/diligentcreators/) | [Twitter](https://twitter.com/diligentcreator) | [LinkedIn](https://www.linkedin.com/company/diligentcreators/) | [Pinterest](https://www.pinterest.com/DiligentCreators/) | [YouTube](https://www.youtube.com/@diligentcreator) [TikTok](https://www.tiktok.com/@diligentcreators) | [Google Map](https://g.page/diligentcreators)

![GitHub commit activity](https://img.shields.io/github/commit-activity/m/shaz3e/email-templates)

![GitHub Stats](https://github-readme-stats.vercel.app/api?username=shaz3e&show_icons=true&count_private=true&theme=default)

![GitHub Contributions Graph](https://github-profile-summary-cards.vercel.app/api/cards/profile-details?username=shaz3e&theme=default)