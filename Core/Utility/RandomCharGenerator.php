<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare (strict_types = 1);

namespace Abc\Utility;

class RandomCharGenerator
{

    /**
     * Generate a random character string default to 12 characters. Can be used to generate
     * random characters to use a password, hash etc...
     */
    public static function generate(int $length = 12, bool $specialChars = true) : string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($specialChars) {
            $chars .= '!@#$%^&*()';
        }
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $random;

    }

    public static function randomNumberGenerator($requiredLength = 7, $highestDigit = 8): string
    {
        $sequence = '';
        for ($i = 0; $i < $requiredLength; ++$i) {
            $sequence .= mt_rand(0, $highestDigit);
        }
        return $sequence;
    }

    public static function name(int $length = 8, bool $specialChars = false) : string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($specialChars) {
            $chars .= '!@#$%^&*()';
        }
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $random;

    }

    public static function address(int $length = 8, bool $specialChars = false) : string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($specialChars) {
            $chars .= '!@#$%^&*()';
        }
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $random;

    }

    public static function password(int $length = 64, bool $specialChars = true) : string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($specialChars) {
            $chars .= '!@#$%^&*()';
        }
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $random;

    }
}
