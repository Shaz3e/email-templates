@extends(config('email-templates.layout'))

@section(config('email-templates.content'))
    <x-page-title title="{{ __('email-templates::email-templates.title.email_global_setting') }}" :breadcrumbs="[
        ['url' => '/', 'label' => __('app.breadcrumb.dashboard')],
        [
            'url' => route(config('email-templates.route_prefix') . '.email-templates.index'),
            'label' => __('email-templates::email-templates.breadcrumb.index'),
        ],
        ['label' => __('email-templates::email-templates.breadcrumb.email_global_setting')],
    ]" />

    <form action="{{ route(config('email-templates.route_prefix') . '.email-templates.header-footer.post') }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <x-form.file-upload name="header_image"
                                    label="{{ __('email-templates::email-templates.form.header_image') }}"
                                    help_text="{{ __('email-templates::email-templates.help_text.header_image') }}" />
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-4 col-sm-12">
                                <x-form.input type="color" name="footer_text_color" class="form-control-color w-100"
                                    label="{{ __('email-templates::email-templates.form.footer_text_color') }}"
                                    value="{{ $footer_text_color }}" />
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-4 col-sm-12">
                                <x-form.input type="color" name="footer_background_color" class="form-control-color w-100"
                                    label="{{ __('email-templates::email-templates.form.footer_background_color') }}"
                                    value="{{ $footer_background_color }}" />
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-12">
                                <x-form.text-area label="{{ __('email-templates::email-templates.form.footer_text') }}"
                                    name="footer_text" value="{!! $footer_text !!}" />
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <x-form.button />
                    </div>
                    {{-- /.card-footer --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
        </div>
        {{-- /.row --}}
    </form>

    {{-- Email Preview --}}
    <div class="row">
        <div class="col-md-12">
            <h5 class="page-title">Email Preview</h5>
            <img src="{{ asset($header_image) }}" alt="{{ config('app.name') }}" class="img-fluid" />
            <div class="card-text mt-3 mb-3">Email content will be placed here...</div>
            <div style="background-color: {{ $footer_background_color }}; color: {{ $footer_text_color }}">
                {!! $footer_text !!}
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push(config('email-templates.styles'))
    <!-- Add your styles here -->
@endpush

@push(config('email-templates.scripts'))
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            0 < $("#footer_text").length && tinymce.init({
                selector: "textarea#footer_text",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [{
                    title: "Bold text",
                    inline: "b"
                }, {
                    title: "Red text",
                    inline: "span",
                    styles: {
                        color: "#ff0000"
                    }
                }, {
                    title: "Red header",
                    block: "h1",
                    styles: {
                        color: "#ff0000"
                    }
                }, {
                    title: "Example 1",
                    inline: "span",
                    classes: "example1"
                }, {
                    title: "Example 2",
                    inline: "span",
                    classes: "example2"
                }, {
                    title: "Table styles"
                }, {
                    title: "Table row 1",
                    selector: "tr",
                    classes: "tablerow1"
                }]
            })
        });
    </script>
@endpush
