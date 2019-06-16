<?php

if (!function_exists('access_prop')) {
    /**
     * Force get/set the object's property value - even if it's not public (access modifier).
     *
     * @param mixed  $object       The object or class name that owns property
     *                             that will be accessed.
     * @param string $propertyName Name of the property to retrieve or change.
     * @param null   $value        (Optional) If given, the value that will be
     *                             assigned to property.
     * @param bool   $setNull      (Optional) Whether to set property value to null.
     *
     * @return mixed|null Returns property value if value to set was not specified.
     * @throws ReflectionException Raised when class does not exists.
     * @since   0.1.2
     * @see     \call_method() Allows to call not accessible method (i.e. private or protected).
     */
    function access_prop(
        $object,
        string $propertyName,
        $value = null,
        bool $setNull = false
    ) {
        // Make field accessible.
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $wasAccessible = $property->isPublic();
        if (! $wasAccessible) {
            $property->setAccessible(true);
        }

        // If no value was specified, only return value of specified property.
        if ($value === null && ! $setNull) {
            return $property->getValue($object);
        }

        $property->setValue($object, $value);

        // If needed, restore previous accessibility.
        if (! $wasAccessible) {
            $property->setAccessible(false);
        }

        return $value;
    }
}
