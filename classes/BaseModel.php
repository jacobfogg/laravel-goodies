<?php

class BaseModel extends Eloquent
{
    public function toArray()
    {
        $array = parent::toArray();

        if (!isset($this->visiblePivotAttributes)) {
            return $array;
        }

        foreach ($this->visiblePivotAttributes as $relationship => $attributes) {
            $array[$relationship] = $this->fetchRelationshipPivotAttributes($relationship, $attributes);
        }

        return $array;
    }

    private function fetchRelationshipPivotAttributes($relationship, $attributes)
    {
        $array = [];

        foreach ($this->$relationship as $relatedModel) {
            $array[] = array_merge(
                $relatedModel->toArray(),
                $this->fetchPivotAttributes($relatedModel, $attributes)
            );
        }

        return $array;
    }

    private function fetchPivotAttributes($model, $attributes)
    {
        $array = [];

        foreach ($attributes as $attribute) {
            $array[$attribute] = $this->fetchPivotAttribute($model, $attribute);
        }

        return $array;
    }

    private function fetchPivotAttribute($model, $attribute)
    {
        // Simple attribute
        if (isset($model->pivot->$attribute)) {
            return $model->pivot->$attribute;
        }

        // Relationship
        $attribute = studly_case($attribute);
        $relatedModel = new $attribute;
        $foreignKey = $relatedModel->getForeignKey();

        return $relatedModel->find($model->pivot->$foreignKey)->toArray();
    }
}
