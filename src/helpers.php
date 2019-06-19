<?php

if (! function_exists('access_prop')) {
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
if (! function_exists('classify')) {
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
if (! function_exists('method')) {
    /**
     * Returns the caller name in Laravel's action format ("Class@method").
     *
     * @param int $backwards How many steps in call stack we should go backwards? Must be greater then 0.
     * @param int $format    Format to use
     *
     * @return array|string|null Caller class and method name in Laravel's action format.
     * @see     \caller() Returns caller part or more details.
     * @see     \fileline() Returns file and line from which call was invoked.
     * @since   0.5.3
     */
    function method(
        int $backwards = 2,
        int $format = METHOD_FORMAT_CALLABLE
    ) {
        $result = null;

        if (($caller = caller($backwards, null)) === null) {
            return null;
        }
        $isClosure = strpos($caller['function'], '{closure}') > -1;
        if ($isClosure) {
            // TODO: is it possible to return callable Closure (caller) using some reflection/debug backtrace techniques?
            return null;
        }

        switch ($format) {
            case METHOD_FORMAT_ACTION:
                $result = class_basename($caller['class']) . '@' . $caller['function'];
                break;

            case METHOD_FORMAT_ACTION_FQCN:
                $result = $caller['class'] . '@' . $caller['function'];
                break;

            case METHOD_FORMAT_CALLABLE:
                if (! isset($caller['class'])) {
                    $result = $caller['function'];
                } elseif (isset($caller['object'])) {
                    $result = [$caller['object'], $caller['function']];
                } else {
                    $result = $caller['class'] . '::' . $caller['function'];
                }

                break;

            default:
                throw new InvalidArgumentException('Invalid result format. Tip: use one of the constants prefixed "METHOD_FORMAT_*".');
        }

        return $result;
    }
}
if (! function_exists('caller')) {
    /**
     * Returns the caller's method name. You can obtain other parts of caller details if you specify
     * other part argument. In addition, if you provide null, you'll receive whole object obtained from debug_backtrace function.
     *
     * @param int               $backwards How many steps in call stack we should go backwards? Must be greater then 0.
     * @param string|null|array $parts     Name of the part of caller to return. Remember, it will be not always accessible (i.e. Closures does not have "class" part). In such circumstances, null will be returned. For possible options visit: http://php.net/manual/en/function.debug-backtrace.php
     *
     * @return string|array|null Caller part(s) (string, string[]), whole details (array) or nothing (null).
     * @see     \method()
     * @since   0.5.3
     */
    function caller(int $backwards = 1, $parts = null)
    {
        if ($backwards < 0) {
            throw new InvalidArgumentException(
                'Negative backwards parameter. Tip: specify smaller number of steps to go back.'
            );
        }

        $caller = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,
                $backwards + 1)[$backwards] ?? null;

        if ($caller === null) {
            return null;
        }

        if ($parts === null) {
            return $caller;
        } elseif (is_string($parts) && isset($caller[$parts])) {
            return $caller[$parts];
        } elseif (is_array($parts)) {
            $callerParts = [];
            foreach ($parts as $part) {
                if (isset($caller[$part])) {
                    $callerParts[$part] = $caller[$part];
                }
            }
            return $callerParts;
        } else {
            throw new InvalidArgumentException(
                'Invalid type of part passed. Tip: pass null if you need whole' .
                ' object, string if you need only one part or an array, if you need more.'
            );
        }
    }
}