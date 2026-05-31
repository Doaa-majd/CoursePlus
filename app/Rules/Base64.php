<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64 implements Rule
{
    protected $allowedMimes;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $allowedMimes = [])
    {
        $this->allowedMimes = $allowedMimes;
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
        // Check if the input is a valid base64 encoded string
        if (!is_string($value)) {
            return false;
        }
        if (preg_match('/^data:(\w+\/[\w\-\+\.]+);base64,/', $value, $matches)) {
            $mimeType = $matches[1];

            // Validate the MIME type if allowed MIME types are specified
            if (!empty($this->allowedMimes) && !in_array($mimeType, $this->allowedMimes)) {
                return false;
            }

            // Remove the mime type prefix
            $base64Data = substr($value, strpos($value, ',') + 1);

            // Decode the base64 string
            $decodedData = base64_decode($base64Data, true);

            // Check if the decoded data is valid and if the original input re-encodes to the same value
            if ($decodedData === false || base64_encode($decodedData) !== $base64Data) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid base64 encoded string with an allowed MIME type.';    }
}
