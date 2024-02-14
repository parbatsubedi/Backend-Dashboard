<?php

namespace App\Wallet\Helpers;

class ErrorGenerator
{
    /**
     * Replace curly braced text into text
     *
     * @param string $string
     * @param string $replace
     * @return string
     */
    protected static function replaceBracesWithText($string,  $replace)
    {
        if (strlen($replace) < 1) {
            return $string;
        }
        $searchWithBrackets = "/\{([^}]+)\}/m";
        if (preg_match($searchWithBrackets, $string)) {
            return (string) preg_replace($searchWithBrackets, $replace, $string);
        }
        return $string;
    }

    /**
     * Generate the error code with message and status key
     * Also replace the braces with default value
     *
     * @param string $vendor
     * @param string $key
     * @param string $defaultValue
     * @param string $error_code
     * @return array
     */
    public static function generate($vendor, $key, $defaultValue = "", $error_code=null)
    {
        $initialMessage = config("error-response." . $vendor . "." . $key);
        return [
            "message" => self::replaceBracesWithText($initialMessage, $defaultValue),
            "status" => config("error-codes." . $vendor . "." . $key),
            "vendor_error_code" => $error_code
        ];
    }

    /**
     * Generate the custom error message
     * Can also add array to merge with the error
     *
     * @param string $vendor
     * @param string $key
     * @param array $data
     * @param string $defaultValue
     * @return array
     */
    public static function generateCustom($vendor, $key, array $data = [], $defaultValue = "")
    {
        $message = self::generate($vendor, $key, $defaultValue);
        return array_merge($message, $data);
    }

    /**
     *
     * Generate custom error message which
     * appends to the generate error message
     *
     * @param $vendor
     * @param $key
     * @param array $data
     * @return array
     */
    public static function customGenerate($vendor, $key, array $data = [])
    {
        $message = self::generate($vendor, $key);
        return array_merge($message, $data);
    }
}
