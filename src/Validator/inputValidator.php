<?php

namespace Validator;

use App\Validator;

class InputValidator implements Validator
{
    private $validators = [];

    public function isValid($object): bool
    {
        $arr = json_decode(json_encode($object), true);
        $validatedValues = [];

        foreach ($this->validators as $field => $validators) {
            if (empty($arr[$field])) {
                continue;
            }

            $val = $arr[$field];

            foreach ($validators as $validator) {
                if (!$validator->isValid($val)) {
                    return false;
                }
            }

            $validatedValues[$field] = $val;
        }

        foreach ($validatedValues as $field => $value) {
            $method = 'set' . ucfirst($field);

            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }

        return true;
    }

    public function add(string $field, array $validators)
    {
        foreach ($validators as $validator) {
            $this->validators[$field][] = $validator;
        }
    }
}
