<?php

namespace Frnkly\ControllerTraits;

trait Embedable
{
    /**
     *
     */
    public function embed()
    {

    }

    /**
     * @param   Illuminate\Database\Eloquent\Builder        $query
     * @param   string|array|Illuminate\Support\Collection  $embed
     * @return  Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmbed($query, $embed)
    {
        // Relations and attributes to append.
        $separator = isset($this->embedSeparator) ? $this->embedSeparator : ',';
        $relations = is_string($embed) ? @explode($separator, $embed) : (array) $embed;

        // Extract the attributes from the list of embeds.
        $embedable = isset($this->embedable) ? $this->embedable : [];
        $accessors = array_intersect($embedable, $embed);

        // Separate the database relations from the appendable accessors.
        foreach ($relations as $key => $attribute)
        {
            // Remove invalid relations.
            $attribute = preg_replace('/[^0-9a-z_]/i', '', $attribute);
            if (empty($attribute)) {
                unset($embed[$key]);
            }

            if (in_array($attribute, $accessors)) {
                unset($embed[$key]);
            }
        }

        // TODO: find a way to add accessors.

        return $query->with($relations);
    }
}
