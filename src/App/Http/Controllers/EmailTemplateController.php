<?php

namespace Shaz3e\EmailTemplates\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Shaz3e\EmailTemplates\App\Models\EmailTemplate;
use Shaz3e\EmailTemplates\App\Http\Requests\StoreEmailTemplateRequest;
use Shaz3e\EmailTemplates\App\Http\Requests\UpdateEmailTemplateRequest;
use Shaz3e\EmailTemplates\App\Models\EmailGlobalSetting;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->permission('list');
        return view('email-templates::email-templates.index', [
            'title' => __('email-templates::email-templates.title.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->permission('create');
        return view('email-templates::email-templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmailTemplateRequest $request)
    {
        $this->permission('create');

        $validated = $request->validated();

        $emailTemplate = EmailTemplate::create($validated);

        // Ensure placeholders are formatted as an array
        if (isset($validated['placeholders']) && !empty($validated['placeholders'])) {
            // Split by comma and trim whitespace
            $validated['placeholders'] = array_map('trim', explode(',', $validated['placeholders']));
        } else {
            // Default to an empty array if not set
            $validated['placeholders'] = [];
        }

        $emailTemplate->placeholders = json_encode($validated['placeholders']);
        $emailTemplate->save();

        flash()->success(__('email-templates::email-templates.success.created'));

        return redirect()->route(config('email-templates.route_prefix') . '.email-templates.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        $this->permission('read');

        return view('email-templates::email-templates.show', [
            'emailTemplate' => $emailTemplate
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $this->permission('update');

        return view('email-templates::email-templates.edit', [
            'emailTemplate' => $emailTemplate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        $this->permission('update');

        $validated = $request->validated();

        $emailTemplate->update($validated);

        // Ensure placeholders are formatted as an array
        if (isset($validated['placeholders']) && !empty($validated['placeholders'])) {
            // Split by comma and trim whitespace
            $validated['placeholders'] = array_map('trim', explode(',', $validated['placeholders']));
        } else {
            // Default to an empty array if not set
            $validated['placeholders'] = [];
        }

        $emailTemplate->placeholders = json_encode($validated['placeholders']);
        $emailTemplate->save();

        flash()->success(__('email-templates::email-templates.success.updated'));

        return redirect()->route(config('email-templates.route_prefix') . '.email-templates.index');
    }

    /**
     * Create/Update Global Header
     */
    public function emailGlobalSetting()
    {
        $this->permission('update');

        $header_image = EmailGlobalSetting::where('name', 'header_image')->value('value');
        $footer_text_color = EmailGlobalSetting::where('name', 'footer_text_color')->value('value');
        $footer_background_color = EmailGlobalSetting::where('name', 'footer_background_color')->value('value');
        $footer_text = EmailGlobalSetting::where('name', 'footer_text')->value('value');


        return view('email-templates::email-templates.header-footer', [
            'title' => __('email-templates::email-templates.title.header'),
            'header_image' => $header_image,
            'footer_text_color' => $footer_text_color,
            'footer_background_color' => $footer_background_color,
            'footer_text' => $footer_text,
        ]);
    }

    public function emailGlobalSettingUpdate(Request $request)
    {
        $this->permission('update');

        $validated = $request->validate([
            'header_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'footer_text_color' => ['nullable', 'string'],
            'footer_background_color' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
        ]);

        // Loop through the validated fields
        foreach ($validated as $key => $value) {
            // Check if the field has a value and is an uploaded file
            if ($key === 'header_image' && $request->hasFile('header_image')) {
                // Store image and get path
                $value = $request->file('header_image')->store('email_headers', 'public');
            }

            // Update only if the key has a value
            if ($value !== null) {
                EmailGlobalSetting::updateOrCreate(
                    ['name' => $key],
                    ['value' => $value]
                );
            }
        }

        flash()->success(__('email-templates::email-templates.success.email_global_setting'));
        return back();
    }

    private function permission($permission)
    {
        if (!Gate::allows('email-template.' . $permission)) {
            return redirect()->route('admin.dashboard')->send();
        }
    }
}
