<div>
    <div class="row mb-3">
        <div class="col-md-1 col-sm-12 mb-2">
            <select wire:model.live="perPage" class="form-control form-control-sm form-control-border">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-7 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <x-form.action-link class="btn-sm btn-success" text="{{ __('button.create') }}" icon="ri-pencil-line"
                    :route="route(config('email-templates.route_prefix') . '.email-templates.create')" permission="email-template.create" />
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <select wire:model.live="showDeleted" class="form-control form-control-sm form-control-border">
                <option value="" selected="selected">Filters</option>
                <option value="">Show Active Record</option>
                <option value="true">Show Deleted Record</option>
            </select>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div wire:poll.visible>
        <x-table :headers="[
            '#',
            __('email-templates::email-templates.table.key'),
            __('email-templates::email-templates.table.name'),
            __('email-templates::email-templates.table.subject'),
            __('email-templates::email-templates.table.placeholders'),
            __('email-templates::email-templates.table.is_active'),
        ]" :records="$records">
            @php
                $totalRecords = $records->total();
                $currentPage = $records->currentPage();
                $perPage = $records->perPage();
                $id = $totalRecords - ($currentPage - 1) * $perPage;
            @endphp
            @foreach ($records as $record)
                <tr wire:key="{{ $record->id }}">
                    <td>{{ $id-- }}</td>
                    <td>{{ $record->key }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->subject }}</td>
                    <td>
                        @foreach ($record->placeholders ?? [] as $placeholder)
                            <span class="badge bg-primary">{{ str_replace(['[', ']', '"'], '', $placeholder) }}</span>
                        @endforeach
                    </td>
                    <td><x-form.toggle-checkbox :record="$record" field="is_active" /></td>
                    <td class="text-end">
                        @if ($showDeleted)
                            <x-form.action-button wire:click="confirmRestore({{ $record->id }})"
                                class="btn-sm btn-warning" text="{{ __('button.restore') }}" icon="ri-delete-bin-7-line"
                                permission="email-template.restore" />
                            <x-form.action-button wire:click="confirmForceDelete({{ $record->id }})"
                                class="btn-sm btn-danger" text="{{ __('button.delete') }}"
                                permission="email-template.force.delete" />
                        @else
                            <x-form.action-link class="btn-sm btn-primary" text="{{ __('button.view') }}"
                                icon="ri-pencil-line" :route="route(
                                    config('email-templates.route_prefix') . '.email-templates.show',
                                    $record->id,
                                )" permission="email-template.read" />
                            <x-form.action-link class="btn-sm btn-success" text="{{ __('button.edit') }}"
                                icon="ri-pencil-line" :route="route(
                                    config('email-templates.route_prefix') . '.email-templates.edit',
                                    $record->id,
                                )" permission="email-template.update" />
                            <x-form.action-button wire:click="confirmDelete({{ $record->id }})"
                                class="btn-sm btn-danger" permission="email-template.delete" />
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
    {{ $records->links() }}
</div>
@push('styles')
@endpush

@push('scripts')
@endpush
