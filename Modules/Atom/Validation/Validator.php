<?php namespace Modules\Atom\Validation;

use Illuminate\Validation\Validator as base ;
use Illuminate\Support\Str;

class Validator extends base {

    protected function getMessage( $attribute , $rule ) {
        $inlineMessage = $this->getInlineMessage($attribute, $rule);

        // First we will retrieve the custom message for the validation rule if one
        // exists. If a custom validation message is being used we'll return the
        // custom message, otherwise we'll keep searching for a valid message.
        if (! is_null($inlineMessage)) {
            return $inlineMessage;
        }

        $lowerRule = Str::snake($rule);

        $customKey = "validation.custom.{$attribute}.{$lowerRule}";

        $customMessage = $this->getCustomMessageFromTranslator(
                in_array($rule, $this->sizeRules)
                    ? [$customKey.".{$this->getAttributeType($attribute)}", $customKey]
                    : $customKey
        );

        // First we check for a custom defined validation message for the attribute
        // and rule. This allows the developer to specify specific messages for
        // only some attributes and rules that need to get specially formed.
        if ($customMessage !== $customKey) {
            return $customMessage;
        }

        // If the rule being validated is a "size" rule, we will need to gather the
        // specific error message for the type of attribute being validated such
        // as a number, file or string which all have different message types.
        elseif (in_array($rule, $this->sizeRules)) {
            return $this->getSizeMessage($attribute, $rule);
        }

        // Finally, if no developer specified messages have been set, and no other
        // special messages apply for this rule, we will just pull the default
        // messages out of the translator service for this validation rule.
        $key = "Atom::validation.{$lowerRule}";

        if ($key !== ($value = $this->translator->get($key))) {
            return $value;
        }

        return $this->getFromLocalArray(
            $attribute, $lowerRule, $this->fallbackMessages
        ) ?: $key;
    }

}
