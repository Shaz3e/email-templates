@extends(config('email-templates.layout'))

@section(config('email-templates.content'))
    <x-page-title title="{{ __('email-templates::email-templates.title.edit') }}" :breadcrumbs="[
        ['url' => '/', 'label' => __('app.breadcrumb.dashboard')],
        [
            'url' => route(config('email-templates.route_prefix') . '.email-templates.index'),
            'label' => __('email-templates::email-templates.breadcrumb.index'),
        ],
        [
            'url' => route(config('email-templates.route_prefix') . '.email-templates.show', $emailTemplate->id),
            'label' => __('email-templates::email-templates.breadcrumb.show'),
        ],
        ['label' => __('email-templates::email-templates.breadcrumb.edit')],
    ]" />
    <form action="{{ route(config('email-templates.route_prefix') . '.email-templates.update', $emailTemplate->id) }}"
        method="POST" class="needs-validation" novalidate>
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-form.input type="text"
                                        label="{{ __('email-templates::email-templates.form.subject') }}" name="subject"
                                        required value="{{ $emailTemplate->subject }}" />
                                </div>
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}

                        <div class="row">
                            <div class="col-md-12">
                                <x-form.text-area label="{{ __('email-templates::email-templates.form.content') }}"
                                    name="content" value="{!! $emailTemplate->content !!}" required />
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
            <div class="col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <x-form.input type="text"
                                        label="{{ __('email-templates::email-templates.form.key') }}" name="key"
                                        value="{{ $emailTemplate->key }}" required />
                                </div>
                            </div>
                            {{-- /.col --}}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <x-form.input type="text"
                                        label="{{ __('email-templates::email-templates.form.name') }}" name="name"
                                        value="{{ $emailTemplate->name }}" required />
                                </div>
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-12">
                                @php
                                    $placeholderList = implode(
                                        ',',
                                        array_map(
                                            fn($placeholder) => str_replace(['[', ']', '"'], '', $placeholder),
                                            $emailTemplate->placeholders ?? [],
                                        ),
                                    );
                                @endphp

                                <!-- Display badges as before -->
                                @foreach ($emailTemplate->placeholders ?? [] as $placeholder)
                                    <span class="badge bg-dark">{{ str_replace(['[', ']', '"'], '', $placeholder) }}</span>
                                @endforeach

                                <!-- Text area with placeholders as comma-separated values -->
                                <x-form.text-area label="{{ __('email-templates::email-templates.form.placeholders') }}"
                                    name="placeholders" value="{{ $placeholderList }}" />
                            </div>
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
@endsection

@push(config('email-templates.styles'))
    <!-- Add your styles here -->
@endpush

@push(config('email-templates.scripts'))
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            0 < $("#content").length && tinymce.init({
                selector: "textarea#content",
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
    <script>
        document.getElementById('placeholders').addEventListener('input', function(event) {
            let input = event.target.value;

            // Replace multiple spaces and commas with a single comma
            input = input.replace(/\s+/g, ',').replace(/,+/g, ',').trim();

            // Update the textarea value with formatted placeholders
            event.target.value = input;
        });

        // Optional: Convert to JSON array when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            const placeholdersField = document.getElementById('placeholders');

            // Convert the input string to an array before submission
            if (placeholdersField.value.trim() !== '') {
                placeholdersField.value = JSON.stringify(placeholdersField.value.split(','));
            }
        });
    </script>
    <!-- Add your scripts here -->
@endpush
