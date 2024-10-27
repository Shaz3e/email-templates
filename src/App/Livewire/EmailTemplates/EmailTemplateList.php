<?php

namespace Shaz3e\EmailTemplates\App\Livewire\EmailTemplates;

use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Shaz3e\EmailTemplates\App\Models\EmailTemplate;

class EmailTemplateList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';
    #[Url()]
    public $perPage = 9;
    public $recordToDelete;
    public $showDeleted = false;

    public function render()
    {
        $query = EmailTemplate::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('email_templates');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $records = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('email-templates::livewire.email-templates.email-template-grid', [
            'records' => $records
        ]);
    }
    /**
     * Reset Search
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Update perPage records
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    /**
     * Confirm Delete
     */
    public function confirmDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('showDeleteConfirmation');
    }

    /**
     * Delete Record
     */
    #[On('deleteConfirmed')]
    public function delete()
    {
        // Check if a record to delete is set
        if (!$this->recordToDelete) {
            $this->dispatch('error');
            return;
        }

        // get id
        $emailTemplate = EmailTemplate::find($this->recordToDelete);

        // Check record exists
        if (!$emailTemplate) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $emailTemplate->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        EmailTemplate::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        EmailTemplate::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
