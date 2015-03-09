<?php

class BaseModel extends Eloquent
{
    /*
     * Translate any integers stored in any foreignKey fields
     * into their related models.
     */
    // Because events are stupid and they don't work
    public function save(array $options = [])
    {
        if (!$this->beforeSave()) {
            return false;
        }

        return parent::save($options);
    }

    private function beforeSave()
    {
        if (isset($this->foreignKeys) && $this->foreignKeys) {
            $this->loadForeignKeys();
        }

        return true;
    }

    private function loadForeignKeys()
    {
        foreach ($this->foreignKeys as $key) {
            $this->loadForeignKey($key);
        }
    }

    private function loadForeignKey($key)
    {
        if (is_int($this->$key)) {
            $class = ucfirst($key);
            $foreign_model = $class::findOrFail($this->$key);
            $this->$key()->associate($foreign_model);
            unset($this->attributes[$key]);
        }
    }

    /*
     * Load visiblePivotAttributes onto the model
     */
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

    /*
     * Delegate business logic to a domain entity
     */
    protected function delegate($class)
    {
        // Instantiate the class we were given
        $reflection = new ReflectionClass($class);
        $entity = $reflection->newInstanceArgs([$this]);

        // Get the calling method's name
        $callerName = debug_backtrace()[1]['function'];

        // Get the name of this attribute based on the function that called us
        preg_match('/^get(.*)Attribute$/', $callerName, $matches);
        $attributeName = lcfirst($matches[1]);

        // Pass this object into the class's attribute method
        return $entity->$attributeName();
    }
}
