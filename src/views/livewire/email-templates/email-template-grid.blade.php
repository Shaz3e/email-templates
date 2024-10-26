<div>
    <div class="row mb-3">
        <div class="col-md-1 col-sm-12 mb-2">
            <select wire:model.live="perPage" class="form-control form-control-sm form-control-border">
                <option value="3">3</option>
                <option value="6">6</option>
                <option value="12">12</option>
                <option value="24">24</option>
                <option value="48">48</option>
                <option value="96">96</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-7 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filters</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <x-form.action-link class="btn-sm btn-primary" text="{{ __('button.view') }}" icon="ri-pencil-line"
                    :route="route(config('email-templates.route_prefix') . '.email-templates.index')" permission="email-template.create" />
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div wire:poll.visible>
        <div class="row">
            @foreach ($records as $record)
                <div class="col-lg-4">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 font-size-12 mb-1">KEY: {{ strtolower($record->key) }}</h6>
                                    <small class="mt-0 font-size-12 mb-1">Subject:</small>
                                    <h5 class="mt-0 font-size-18 mb-1">{{ ucwords($record->subject) }}</h5>
                                    <p class="text-muted font-size-14">
                                        @php
                                            // Ensure placeholders is an array, decoding if it's stored as a JSON string
                                            $placeholders = is_string($record->placeholders)
                                                ? json_decode($record->placeholders, true)
                                                : $record->placeholders;
                                        @endphp

                                        @if (empty($placeholders) || $placeholders === ['[]'])
                                            <span class="badge bg-danger">This email does not contains any tags</span>
                                        @else
                                            @foreach ($placeholders as $placeholder)
                                                <span
                                                    class="badge bg-dark">{{ str_replace(['[', ']', '"'], '', $placeholder) }}</span>
                                            @endforeach
                                        @endif
                                    </p>

                                    <ul class="social-links list-inline mb-0">

                                        @if ($showDeleted)
                                            <x-form.action-button wire:click="confirmRestore({{ $record->id }})"
                                                class="btn-sm btn-warning" text="{{ __('button.restore') }}"
                                                icon="ri-delete-bin-7-line" permission="email-template.restore" />
                                            <x-form.action-button wire:click="confirmForceDelete({{ $record->id }})"
                                                class="btn-sm btn-danger" text="{{ __('button.delete') }}"
                                                permission="email-template.force.delete" />
                                        @else
                                            <x-form.action-link class="btn-sm btn-primary"
                                                text="{{ __('button.preview') }}" icon="ri-pencil-line"
                                                :route="route(
                                                    config('email-templates.route_prefix') . '.email-templates.show',
                                                    $record->id,
                                                )" permission="email-template.read" />
                                            <x-form.action-link class="btn-sm btn-success"
                                                text="{{ __('button.edit') }}" icon="ri-pencil-line" :route="route(
                                                    config('email-templates.route_prefix') . '.email-templates.edit',
                                                    $record->id,
                                                )"
                                                permission="email-template.update" />
                                            <x-form.action-button wire:click="confirmDelete({{ $record->id }})"
                                                class="btn-sm btn-danger" permission="email-template.delete" />
                                        @endif
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- /.row --}}
    </div>
    {{ $records->links() }}
</div>
@push('styles')
@endpush

@push('scripts')
@endpush
