<?php

namespace Shaz3e\EmailTemplates\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Shaz3e\EmailTemplates\App\Models\EmailTemplate;

use function Laravel\Prompts\info;

class UpdateEmailTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'max:255',
                Rule::unique(EmailTemplate::class, 'key')->ignore($this->email_template),
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'subject' => [
                'required',
                'max:255',
            ],
            'placeholders' => [
                'nullable',
                'string',
            ],
            'content' => [
                'required',
            ],
            'is_active' => [
                'required',
                'boolean'
            ]
        ];
    }
}