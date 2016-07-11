<?php

namespace Frnkly\ControllerTraits;

trait Embedable
{
    /**
     * Retrieves the relations and attributes that may be appended to a model.
     *
     * @param array|string $embed   The properties to be appended to a model.
     * @param array $appendable     Those properties which aren't database relations.
     * @return array
     */
    protected function getEmbedArray($embed = null, array $appendable = [])
    {
        // Relations and attributes to append.
        $separator = isset($this->embedSeparator) ? $this->embedSeparator : ',';
        $embed = is_string($embed) ? @explode($separator, $embed) : (array) $embed;

        // Extract the attributes from the list of embeds.
        $attributes = array_intersect($appendable, $embed);

        // Separate the database relations from the appendable attributes.
        foreach ($embed as $key => $embedable)
        {
            // Remove invalid relations.
            $embedable = preg_replace('/[^0-9a-z_]/i', '', $embedable);
            if (empty($embedable)) {
                unset($embed[$key]);
            }

            if (in_array($embedable, $attributes)) {
                unset($embed[$key]);
            }
        }

        return [
            'relations' => collect($embed),
            'attributes' => collect($attributes)
        ];
    }

    /**
     * Applies the appendable attributes to the model.
     *
     * @param mixed $model      Model to append attributes to.
     * @param array $attributes Attributes to append to the model.
     * @return void
     */
    protected function applyEmbedableAttributes($model, array $attributes = null)
    {
        // TODO: support passing a colletion of models.
        if (is_a($model, 'Illuminate\Support\Collection'))
        {

        }

        // Retrieve list of appendable attributes.
        if (is_null($attributes))
        {
            $className = get_class($model);
            if (isset($className::$embedableAttributes) && is_array($className::$embedableAttributes)) {
                $attributes = $className::$embedableAttributes;
            }

            // ...
            elseif (isset($model->embedableAttributes) && is_array($model->embedableAttributes)) {
                $attributes = $model->embedableAttributes;
            }

            // ...
            else {
                $attributes = [];
            }
        }

        // Append extra attributes.
        if (count($attributes))
        {
            foreach ($attributes as $accessor)
            {
                // TODO: support model types other than Illuminate\Database\Eloquent\Model
                $model->setAttribute($accessor, $model->$accessor);
            }
        }
    }
}
