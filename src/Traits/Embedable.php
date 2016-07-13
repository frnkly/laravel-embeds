<?php

namespace Frnkly\Traits;

trait Embedable
{
    /**
     * @param   Illuminate\Database\Eloquent\Builder        $query
     * @param   string|array|Illuminate\Support\Collection  $embed
     * @return  Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmbed($query, $embed)
    {
        // Relations and accessors to append.
        $separator = isset($this->embedSeparator) ? $this->embedSeparator : ',';
        $attributes = is_string($embed) ? @explode($separator, $embed) : (array) $embed;

        // Extract the accessors from the list of attributes.
        $embedable = isset($this->embedable) ? $this->embedable : [];
        $accessors = array_intersect(array_keys($embedable), $attributes);

        // Extract the relations from the list of attributes.
        $relations = array_filter(array_diff($attributes, array_keys($embedable)));

        // If the accessors require any relation, add them to the list.
        array_walk($accessors, function($attribute) use ($embedable, &$relations)
        {
            // Performance check.
            if (empty($embedable[$attribute])) {
                return;
            }

            $relations = array_merge($relations, $embedable[$attribute]);
        });

        // Remove duplicates.
        $relations = array_unique($relations);

        // TODO: find a way to add accessors.

        return $query->with($relations);
    }
}
