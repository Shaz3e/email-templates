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
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'placeholders' => 'array',  // Automatically casts JSON to array
    ];

    /**
     * Render the content with provided placeholders replaced.
     *
     * @return string
     */
    public function renderContent(array $data)
    {
        $content = $this->content;
        if (! empty($this->placeholders)) {
            foreach ($this->placeholders as $placeholder) {
                $value = $data[$placeholder] ?? '';
                $content = str_replace("{{{$placeholder}}}", $value, $content);
            }
        }

        return $content;
    }

    /**
     * Set the key attribute, converting it to a normalized format.
     *
     * This method transforms the input value by converting it to lowercase,
     * replacing spaces with underscores, removing consecutive underscores,
     * and trimming leading/trailing underscores.
     *
     * @param  string  $value
     * @return void
     */
    public function setKeyAttribute($value)
    {
        // Transform the key value to a normalized format
        $this->attributes['key'] = strtolower(
            preg_replace(
                ['/ +/', '/_+/', '/^_+|_+$/'], // Patterns to match
                ['_', '_', ''],                // Replacements for the patterns
                str_replace(' ', '_', $value)  // Replace spaces with underscores
            )
        );
    }

    /**
     * Mutator for the placeholders attribute.
     *
     * This method takes the input value and formats it appropriately for storage.
     * If the value is a string, it is converted to lowercase, spaces are replaced with commas,
     * and the resulting string is exploded into an array. The array is then filtered to remove
     * any empty values, and the resulting array is saved as JSON in the 'placeholders' attribute.
     *
     * @param  string|array  $value
     */
    public function setPlaceholdersAttribute($value)
    {
        // If the value is a string, ensure it's a string, replace spaces with commas, and convert to lowercase
        if (is_string($value)) {
            $value = strtolower(str_replace(' ', ',', $value));
        }

        // Convert the string to an array based on commas, remove empty values, and save as JSON
        $this->attributes['placeholders'] = json_encode(
            array_filter(explode(',', $value))
        );
    }
}
