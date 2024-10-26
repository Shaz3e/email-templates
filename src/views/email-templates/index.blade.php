@extends(config('email-templates.layout'))

@section(config('email-templates.content'))
    <x-page-title title="{{ __('email-templates::email-templates.title.index') }}" :breadcrumbs="[
        ['url' => '/', 'label' => __('app.breadcrumb.dashboard')],
        ['label' => __('email-templates::email-templates.breadcrumb.index')],
    ]" />

    <livewire:email-template-list />
@endsection

@push(config('email-templates.styles'))
    <!-- Add your styles here -->
@endpush

@push(config('email-templates.scripts'))
    <!-- Add your scripts here -->
@endpush
