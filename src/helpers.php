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
     * @since   0.2.2
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
        if (!$wasAccessible) {
            $property->setAccessible(true);
        }

        // If no value was specified, only return value of specified property.
        if ($value === null && !$setNull) {
            return $property->getValue($object);
        }

        $property->setValue($object, $value);

        // If needed, restore previous accessibility.
        if (!$wasAccessible) {
            $property->setAccessible(false);
        }

        return $value;
    }
}
if (!function_exists('classify')) {
    /**
     * Returns class name of given object, if object was passed or variable type, if passed value-type
     * variable.
     *
     * @param mixed $thing Value to be classified.
     *
     * @return string The class or type of given value.
     * @since   0.3.2
     */
    function classify($thing): string
    {
        $type = gettype($thing);
        switch (true) {
            case $type === 'object':
                // If some object instance was given, return its class name.
                return get_class($thing);

            case $type === 'string' && (class_exists($thing) || trait_exists($thing) || interface_exists($thing)):
                // When class/trait/interface name was provided, return it back, because it's already a class name.
                return $thing;

            default:
                return $type;
        }
    }
}
