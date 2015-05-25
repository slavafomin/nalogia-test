<?php

namespace Utils;


/**
 * Class StringComparator
 * @package Utils
 *
 * @author Slava Fomin II <s.fomin@betsol.ru>
 */
class StringComparator
{
    /**
     * @param string $string1
     * @param string $string2
     *
     * @return string
     */
    public function compare($string1, $string2)
    {
        $length1 = mb_strlen($string1);
        $length2 = mb_strlen($string2);

        $lengthDiff = ($length2 - $length1);

        if (0 == $lengthDiff) {
            if ($string1 == $string2) {
                return 'РАВЕНСТВО';
            } else {
                // Looking for permutations.
                $result = $this->lookForPermutations($string1, $string2, $length1);
                if (null !== $result) {
                    return 'ПОМЕНЯТЬ ' . $result;
                }
            }
        } else if (-1 == $lengthDiff) {
            // Looking for deletions.
            $result = $this->lookForDeletion($string1, $string2);
            if (null !== $result) {
                return 'УДАЛИТЬ ' . $result;
            }
        } else if (1 == $lengthDiff) {
            // Looking for additions.
            $result = $this->lookForAddition($string1, $string2);
            if (null !== $result) {
                return 'ВСТАВИТЬ ' . $result;
            }
        }

        // No solution.
        return 'НЕВОЗМОЖНО';
    }

    /**
     * @param string $string1
     * @param string $string2
     *
     * @return string|null
     */
    protected function lookForPermutations($string1, $string2, $length)
    {
        for ($i = 0; $i < $length - 1; $i++) {
            $firstChar = mb_substr($string1, $i, 1);
            $secondChar = mb_substr($string1, $i + 1, 1);
            $newString =
                  mb_substr($string1, 0, $i)
                . $secondChar
                . $firstChar
                . mb_substr($string1, $i + 2)
            ;
            if ($newString == $string2) {
                return $firstChar . ' ' . $secondChar;
            }
        }

        return null;
    }

    /**
     * @param string $string1
     * @param string $string2
     *
     * @return string|null
     */
    protected function lookForAddition($string1, $string2)
    {
        $firstChar = mb_substr($string2, 0, 1);
        if (($firstChar . $string1) == $string2) {
            return $firstChar;
        } else {
            $lastChar = mb_substr($string2, -1);
            if (($string1 . $lastChar) == $string2) {
                return $lastChar;
            }
        }

        return null;
    }

    /**
     * @param string $string1
     * @param string $string2
     *
     * @return string|null
     */
    protected function lookForDeletion($string1, $string2)
    {
        $charToDelete = null;

        if (mb_substr($string1, 1) == $string2) {
            // First letter removed.
            $charToDelete = mb_substr($string1, 0, 1);
        } else if (mb_substr($string1, 0, -1) == $string2) {
            // Last letter removed.
            $charToDelete = mb_substr($string1, -1);
        }

        return $charToDelete;
    }
}
