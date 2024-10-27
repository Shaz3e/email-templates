@extends(config('email-templates.layout'))

@section(config('email-templates.content'))
    <x-page-title title="{{ __('email-templates::email-templates.title.index') }}" :breadcrumbs="[
        ['url' => '/', 'label' => __('app.breadcrumb.dashboard')],
        ['label' => __('email-templates::email-templates.breadcrumb.index')],
    ]" />

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="d-grid">
                                <x-form.action-link class="btn-sm btn-success mb-3"
                                    text="{{ __('email-templates::email-templates.button.create') }}" icon="ri-pencil-line"
                                    :route="route(
                                        config('email-templates.route_prefix') . '.email-templates.create',
                                    )" permission="email-template.create" />
                                <x-form.action-link class="btn-sm btn-dark mb-3"
                                    text="{{ __('email-templates::email-templates.button.email_global_setting') }}" icon="ri-pencil-line"
                                    :route="route(
                                        config('email-templates.route_prefix') . '.email-templates.header-footer',
                                    )" permission="email-template.update" />
                            </div>
                        </div>
                        {{-- /.col --}}
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-9">
            <livewire:email-template-list />
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
