<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AuthorizationCodeMatches implements Rule
{
    protected $code;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->code = env('REGISTRATION_AUTHORIZATION_CODE', '');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value === $this->code;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The authorization code is not valid.';
    }
}
