@extends(config('email-templates.layout'))

@section(config('email-templates.content'))
    <x-page-title title="{{ __('email-templates::email-templates.title.show') }}" :breadcrumbs="[
        ['url' => '/', 'label' => __('app.breadcrumb.dashboard')],
        [
            'url' => route(config('email-templates.route_prefix') . '.email-templates.index'),
            'label' => __('email-templates::email-templates.breadcrumb.index'),
        ],
        [
            'url' => route(config('email-templates.route_prefix') . '.email-templates.edit', $emailTemplate->id),
            'label' => __('email-templates::email-templates.breadcrumb.edit'),
        ],
        ['label' => __('email-templates::email-templates.breadcrumb.show')],
    ]" />
    <div class="row mb-5">
        <div class="col-md-12">
            <h6>Subject</h6>
            <h4>{{ $emailTemplate->subject }}</h4>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
    <div class="row mb-5">
        <div class="col-md-12">
            <h6>Email Body</h6>
            {!! $emailTemplate->content !!}
        </div>
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <small>Email Unique Key</small>
                    <h5 class="card-title">{{ $emailTemplate->key }}</h5>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <small>Email Template Name</small>
                    <h5 class="card-title">{{ $emailTemplate->name }}</h5>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <small>Created At</small>
                    <h5 class="card-title">{{ $emailTemplate->created_at }}</h5>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <small>Updated At</small>
                    <h5 class="card-title">{{ $emailTemplate->updated_at }}</h5>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <small>Status</small>
                    <h5 class="card-title">
                        @if ($emailTemplate->is_active == 1)
                            Active
                        @else
                            Inactive
                        @endif
                    </h5>
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <small>Email Template Tags</small><br>
                    @php
                        // Ensure placeholders is an array, decoding if it's stored as a JSON string
                        $placeholders = is_string($emailTemplate->placeholders)
                            ? json_decode($emailTemplate->placeholders, true)
                            : $emailTemplate->placeholders;
                    @endphp

                    @if (empty($placeholders) || $placeholders === ['[]'])
                        <span class="badge bg-danger">This email does not contains any tags</span>
                    @else
                        <p>Tags found:</p>
                        @foreach ($placeholders as $placeholder)
                            <span class="badge bg-dark">{{ str_replace(['[', ']', '"'], '', $placeholder) }}</span>
                        @endforeach
                    @endif
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
    <div class="row">
        <div class="col-md-12">
            <x-form.action-link
                route="{{ route(config('email-templates.route_prefix') . '.email-templates.edit', $emailTemplate->id) }}"
                text="{{ __('button.edit') }}" icon="ri-pencil-line"
                permission="config('email-templates.permissions.update')" />
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row mt-5">
        <div class="col-md-12">
            <h6>Use the following code with your application from where you want to send email</h6>
            <code class="highlighter-rouge">
                <pre>
use Shaz3e\EmailTemplates\Services\EmailService; // Import class from package

$emailService = new EmailService(); // Create instance of EmailService
@php
    // Ensure placeholders is an array, decoding if it's stored as a JSON string
    $placeholders = is_string($emailTemplate->placeholders)
        ? json_decode($emailTemplate->placeholders, true)
        : $emailTemplate->placeholders;
@endphp

@if (empty($placeholders) || $placeholders === ['[]'])
$emailService->sendEmailByKey('{{ $emailTemplate->key }}', $user->email);
@else
$emailService->sendEmailByKey('{{ $emailTemplate->key }}', $user->email, [
@foreach ($emailTemplate->placeholders ?? [] as $placeholder)
'{{ str_replace(['[', ']', '"'], '', $placeholder) }}' => model->{{ str_replace(['[', ']', '"'], '', $placeholder) }},
@endforeach
]);
@endif
                </pre>
            </code>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push(config('email-templates.styles'))
    <!-- Add your styles here -->
@endpush

@push(config('email-templates.scripts'))
    <!-- Add your scripts here -->
@endpush
