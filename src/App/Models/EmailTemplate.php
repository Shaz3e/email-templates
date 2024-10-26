<?php

namespace Shaz3e\EmailTemplates\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    protected $fillable = [
        'key',
        'name',
        'subject',
        'placeholders',
        'content',
        'is_active',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $casts = [
        'placeholders' => 'array',  // Automatically casts JSON to array
        'is_active' => 'boolean',
    ];

    /**
     * Render the content with provided placeholders replaced.
     *
     * @param array $data
     * @return string
     */
    public function renderContent(array $data)
    {
        $content = $this->content;
        if (!empty($this->placeholders)) {
            foreach ($this->placeholders as $placeholder) {
                $value = $data[$placeholder] ?? '';
                $content = str_replace("{{{$placeholder}}}", $value, $content);
            }
        }
        return $content;
    }

    /**
     * Scope for active templates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Mutator for the placeholders attribute.
     *
     * @param  string|array  $value
     */
    public function setPlaceholdersAttribute($value)
    {
        // Ensure value is a string and replace spaces with commas
        if (is_string($value)) {
            $value = str_replace(' ', ',', $value);
        }

        // Convert string to array based on commas, then remove empty values
        $this->attributes['placeholders'] = json_encode(array_filter(explode(',', $value)));
    }
}
