<?php

use Illuminate\Support\Carbon;

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
if (! function_exists('call_method')) {
    /**
     * Force calls method - even if it's not accessible (if its private/protected).
     *
     * @param string               $method  Method name to invoke
     * @param object|string        $object  Object instance or class name (if method is static).
     * @param array|mixed|\Closure ...$args optional arguments that will be passed. Can be passed as closure, to defer the moment of args resolving.
     *
     * @return mixed
     * @throws \ReflectionException
     * @see     \access_prop() Allows to access private or protected class/object property.
     * @since   0.7.5
     */
    function call_method(string $method, $object, ...$args)
    {
        if (! is_object($object) || ! class_exists(classify($object))) {
            $class = classify($object);
            throw new InvalidArgumentException(
                'Invalid value. Tip: pass object instance or a class name as' .
                " \$object argument. Passed value's type: {$class}."
            );
        }

        $reflection = new ReflectionClass($object);
        $method = $reflection->getMethod($method);

        // Remember current accessibility of the method to eventually restore it later.
        $wasAccessible = ($method->getModifiers() & ReflectionMethod::IS_PUBLIC) !== 0;

        // Check if closure was passed to resolve args from it.
        if (! empty($args) && is_callable($args[0])) {
            $args = [call_user_func($args[0])];
        }

        $method->setAccessible(true);
        $result = $method->invokeArgs($object, $args);

        // If needed, restore previous modifier.
        if (! $wasAccessible) {
            $method->setAccessible(false);
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
if (! function_exists('carbonize')) {
    /**
     * Unifies various date/datetime types into \Illuminate\Support\Carbon object.
     * Supports:
     * - date-, time- or datetime strings; everything that could be parsed be Carbon::parse method,
     * - \Carbon\Carbon and \Illuminate\Support\Carbon objects (it clones them),
     * - DateTime, DateTimeImmutable objects.
     *
     * Returns null if conversion fails.
     *
     * @param string|\DateTime|\DateTimeImmutable|\Illuminate\Support\Carbon|\Carbon\Carbon $date The value to be unified
     *
     * @return \Illuminate\Support\Carbon|null If successfully unified, returns an instance of \Illuminate\Support\Carbon; null otherwise.
     * @throws InvalidArgumentException When cannot carbonize given value
     * @since   0.6.3
     * @todo    Carbonizer class - manager that could be extended (i.e. with macros) to support user specified converters
     */
    function carbonize($date)
    {
        switch (true) {
            case is_string($date):
                return Illuminate\Support\Carbon::parse($date);

            case $date instanceof \Carbon\Carbon:
                return Illuminate\Support\Carbon::create(
                    $date->year,
                    $date->month,
                    $date->day,
                    $date->hour,
                    $date->minute,
                    $date->second,
                    $date->tz
                );

            case $date instanceof Carbon:
                return $date->copy();

            case $date instanceof DateTime:
            case $date instanceof DateTimeImmutable:
                return Illuminate\Support\Carbon::instance($date);

            default:
                return null;
        }
    }
}
if (! function_exists('clamp')) {
    /**
     * Clamps given value in the given range in an intuitive way.
     *
     * @param float      $value The number to be clamped
     * @param float|null $min   (Optional) Lower bound of clamp
     * @param float|null $max   (Optional) Upper bound of clamp
     *
     * @return float Clamped value
     * @since   0.8.5
     */
    function clamp(float $value, $min = null, $max = null): float
    {
        if (null === $min && null === $max) {
            return $value;
        }

        if (null !== $min && $value < $min) {
            return (float)$min;
        } elseif (null !== $max && $value > $max) {
            return (float)$max;
        } else {
            return $value;
        }
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

        if (($caller = caller($backwards)) === null) {
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
if (! function_exists('cli')) {
    /**
     * @return \Malbrandt\Lori\Utils\Console|null
     * @since 0.9.5
     */
    function cli()
    {
        return app()->has('lori.cli') ? app('lori.cli') : null;
    }
}
if (! function_exists('cli_in')) {
    /**
     * If app is running in console (i.e. executing some command),
     * it will return instance of input interface of that command.
     *
     * @return \Symfony\Component\Console\Input\InputInterface|null Input interface when running command or null otherwise.
     * @since   0.9.5
     */
    function cli_in()
    {
        return ($cli = cli()) !== null ? $cli->getInput() : null;
    }
}
if (! function_exists('cli_out')) {
    /**
     * If app is running in console (i.e. executing some command),
     * it will return instance of output interface of that command.
     *
     * @return \Symfony\Component\Console\Output\OutputInterface|null Output interface when running command or null otherwise.
     * @since   0.9.5
     */
    function cli_out()
    {
        return ($cli = cli()) !== null ? $cli->getOutput() : null;
    }
}
if (! function_exists('create_fake')) {
    /**
     * A simple alias for Laravel's factory make method.
     *
     * @param string|\Illuminate\Database\Eloquent\Model $class      The name of the class to fake or the model's instance
     * @param int                                        $count      The number of instance you wan't to generate (default: 1)
     * @param array                                      $attributes Attributes that would be overridden
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection craeted model or models collection
     * @since   0.10.5
     * @todo    unit tests
     */
    function create_fake($class, int $count = 1, array $attributes = [])
    {
        $created = factory(classify($class), $count)->create($attributes);

        return $count === 1 ? $created[0] : $created;
    }
}
if (! function_exists('equals')) {
    /**
     * Safely compares two float numbers if they are equal. This functions should
     * be used instead of all equal (==) and identical (===) comparisions of
     * float numbers, because during mathematical operations on small numbers,
     * we are losing accuracy.
     *
     * Analyse example below:
     * ```
     * // Adding 0.1 ten times is not equal 1
     * (0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1) === 1; // false
     *
     * // Using equals function, it returns correct result
     * equals(0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1, 1) // true
     * ```
     *
     * @param float $first   First number to compare.
     * @param float $second  Second number to compare.
     * @param float $epsilon Smallest acceptable difference.
     *
     * @return bool
     * @since   0.11.6
     */
    function equals(
        float $first,
        float $second,
        float $epsilon = 2.2204460492503e-16 /* PHP_FLOAT_EPSILON */
    ): bool
    {
        return abs($first - $second) < $epsilon;
    }
}
if (! function_exists('fileline')) {
    /**
     * Returns the file and line number from which function was called in format: "file.ext:line",
     * i.e. 'somefile.php:12'. By default, it does not include full file path.
     *
     * @param bool   $fullPath  (Optional) True, if should return full path of file.
     * @param string $separator (Optional) Separator that will implode path with line.
     *
     * @return string
     * @see     \caller(), \method()
     * @since   0.12.6
     * @todo    unit tests
     */
    function fileline(
        int $backwards = 1,
        bool $fullPath = false,
        string $separator = ':'
    ): string {
        $caller = caller($backwards, null);
        $file = $caller['file'] ?? null;
        $line = $caller['line'] ?? null;
        if ($file === null || $line === null) {
            throw new LogicException('Cannot examine caller\'s file/line or both.');
        }
        $path = $fullPath ? $file : basename($file);
        return $path . $separator . $line;
    }
}
if (! function_exists('flash_error')) {
    /**
     * Flashes a message in Laravel's session under the key 'error'.
     * When you provide second argument, it would be stored under the key 'errors'.
     *
     * @param string $message
     * @param mixed  $errors
     * @param string $messageKey
     * @param string $errorsKey
     *
     * @since   0.13.6
     */
    function flash_error(
        string $message,
        $errors = null,
        string $messageKey = 'error',
        string $errorsKey = 'errors'
    ): void {
        if (! empty($message) && ! empty($messageKey)) {
            session()->flash($messageKey, $message);
        }

        if ($errors !== null && ! empty($errorsKey)) {
            session()->flash($errorsKey, $errors);
        }
    }
}
if (! function_exists('flash_info')) {
    /**
     * Flashes a message in Laravel's session under the key 'info'.
     *
     * @param string $message The message to flash.
     * @param string $key     The key under the messages should be flashed (default: info).
     *
     * @since   0.13.6
     */
    function flash_info(string $message, $key = 'info'): void
    {
        session()->flash($key, $message);
    }
}
if (! function_exists('flash_success')) {
    /**
     * Flashes a message in Laravel's session under the key 'success'.
     *
     * @param string $message The message to flash.
     * @param string $key     The key under the messages should be flashed (default: success).
     *
     * @since   0.13.6
     */
    function flash_success(string $message, $key = 'success'): void
    {
        session()->flash($key, $message);
    }
}
if (! function_exists('flash_warning')) {
    /**
     * Flashes a message in Laravel's session under the key 'warning'.
     *
     * @param string $message The message to flash.
     * @param string $key     The key under the messages should be flashed (default: warning).
     *
     * @since   0.13.6
     */
    function flash_warning(string $message, $key = 'warning'): void
    {
        session()->flash($key, $message);
    }
}
if (! function_exists('make_fake')) {
    /**
     * A simple alias for Laravel's factory make method.
     *
     * @param string $class      The name of the class to fake or the model's instance
     * @param int    $count      The number of instance you wan't to generate
     * @param array  $attributes Attributes that would be overriden
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection created model or models collection
     * @since   0.10.5
     * @todo    unit tests
     */
    function make_fake(string $class, int $count = 1, array $attributes = [])
    {
        $made = factory(classify($class), $count)->make($attributes);

        return $count === 1 ? $made[0] : $made;
    }
}