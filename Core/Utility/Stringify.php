<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare(strict_types = 1);

namespace Abc\Utility;

class Stringify
{
    private const PLURAL_EXCEPTIONS = [
        'o' => ['photo', 'halo', 'piano'],
        'f' => ['roof', 'belief', 'chef', 'chief'],
    ];

    private const VOWELS = ['a', 'e', 'i', 'o', 'u'];
    private const CONSONANTS = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];
    private const ION_EXCEPTIONS = ['transaction', 'section', 'permission'];

    private static function translateString(string $string): string
    {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        if ($text) {
            return $text;
        }
    }

    public static function slugify($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text); // replace non letter or digits by -
        $text = trim($text, '-');
        $text = self::translateString($text); // transliterate
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text); // remove unwanted characters
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    /**
     * Convert a string into words, to use for labels and menu names
     */
    public static function justify($string, string $atts = '')
    {
        if (empty($string)) {
            //Log::write('String is empty', 'error');
            return;
        }

        $search = array('-', '_', '[]', '[', ']');
        $replace_search = array(' ', ' ', '', ' ', '');
        $str_replace = str_replace($search, $replace_search, $string);

        /* Capitalize the first letter */
        if ('ucwords' == $atts) {
//            //Log::write('Capitalizing the first letter');
            return ucwords(str_replace($search, $replace_search, $string));
        } elseif ('strtolower' == $atts) {
//            //Log::write('Converting string to lowercase');
            return strtolower(str_replace($search, $replace_search, $string));
        }
    }

    public static function pluralize($string): string
    {
//        //Log::write('Converting string ' . $string . ' to plural');
        if ($string[strlen($string) - 1] == 'y') {
            if (self::is_vowel($string[strlen($string) - 2])) {
//                //Log::write('Appending \'s\'');
                $plural = $string . 's'; //append s
            } else {
//                //Log::write('Converting \'y\' to \'ies\'');
                $cut = substr($string, 0, -1);
                $plural = $cut . 'ies'; //convert y to ies
            }
        } elseif ($string[strlen($string) - 1] == 's' || $string[strlen($string) - 1] == 'x' || $string[strlen($string) - 1] == 'z' || ($string[strlen($string) - 2] == 'c' && $string[strlen($string) - 1] == 'h') || ($string[strlen($string) - 2] == 's' && ($string[strlen($string) - 1] == 's' || $string[strlen($string) - 1] == 'h'))) {
//            //Log::write('Converting \'s\'/\'x\'/\'z\'/\'ch\'/\'ss/\'sh\' to \'es\'');
            $plural = $string . 'es'; //convert s || x || z || ch || ss || sh to es
        } elseif (($string[strlen($string) - 1] == 'f' || $string[strlen($string) - 2] == 'f')  && !in_array($string, self::PLURAL_EXCEPTIONS['f'])) {
            if ($string[strlen($string) - 1] == 'f') {
//                //Log::write('String ending with \'f\'');
                $cut = substr($string, 0, -1);
            } else {
//                //Log::write('String ending with \'fe\'');
                $cut = substr($string, 0, -2);
            }
//            //Log::write('Converting \'fe\'/\'f\' to \'ves\'');
            $plural = $cut . 'ves'; //convert fe||f to ves
        } elseif ($string[strlen($string) - 1] == 'o' && !in_array($string, self::PLURAL_EXCEPTIONS['o'])) {
//            //Log::write('Appending \'es\'');
            $plural = $string . 'es'; //just append es
        } elseif ($string[strlen($string) - 2] == 'u' && $string[strlen($string) - 1] == 's') {
//            //Log::write('Converting \'us\' to \'i\'');
            $cut = substr($string, 0, -2);
            $plural = $cut . 'i'; //convert us to i
        } elseif ($string[strlen($string) - 2] == 'i' && $string[strlen($string) - 1] == 's') {
//            //Log::write('Converting \'is\' to \'es\'');
            $cut = substr($string, 0, -2);
            $plural = $cut . 'es'; //convert is to es
        }/* elseif ($string[strlen($string) - 2] == 'o' && $string[strlen($string) - 1] == 'n' && !in_array($string, self::ION_EXCEPTIONS)) {
            $cut = substr($string, 0, -2);
            $plural = $cut . 'a'; //convert on to a
        } */else {
//            //Log::write('Appending \'s\'');
            $plural = $string . 's'; // just attach an s
        }

//        //Log::write('Returning plural form: ' . $plural);
        return $plural;
    }

    private static function is_vowel (string $letter): bool
    {
//        //Log::write('Checking if the letter' . $letter .' is a vowel');
        return in_array(strtolower($letter), self::VOWELS);
    }

    private static function is_consonant (string $letter): bool
    {
//        //Log::write('Checking if the letter' . $letter .' is a consonant');
        return in_array(strtolower($letter), self::CONSONANTS);
    }

    public static function capitalize($string, bool $full = false)
    {
        if (!empty($string)) {
//            //Log::write('String is not empty. Translating string');
            // transliterate
            $text = self::translateString($string);
//            //Log::write('Capitalizing the string');
            $text = $full ? strtoupper($text) : ucwords(strtolower($text));
            //$text = preg_replace('~[^-\w]+~', '', $text);
            if (empty($text)) {
                //Log::write('Text is empty', 'error');
                return "n-a";
            }
//            //Log::write('Returning the text');
            return $text;
        }
//        //Log::write('String is empty');
        return false;
    }

    public static function titlelize($string): string
    {
//        //Log::write('Creating a title from a string');
        return ucwords(str_replace(['-', '_'], ' ', strtolower($string)));
    }

    public static function underscoreSeparate($string, $capitals = false): string
    {
//        //Log::write('separating words with underscore(_)');
        if ($capitals) {
            return str_replace(' ', '_', $string);
        }
        return str_replace(' ', '_', strtolower($string));
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     */
    public static function convertToStudlyCaps(string $string) : string
    {
//        //Log::write('Converting to StudlyCaps');
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     */
    public static function convertToCamelCase(string $string) : string
    {
//        //Log::write('Converting to camelCase');
        return lcfirst(self::convertToStudlyCaps($string));
    }

    /**
     * Regular expression function that replaces spaces between words with hyphens.
     */
    public static function slugToUrl(string $str)
    {
        if (empty($str)) {
            //Log::write('String is empty', 'error');
            return false;
        }
//        //Log::write('Converting slug to URL');
        return preg_replace('/[^A-Za-z0-9-]+/', '-', $str);
    }
}
