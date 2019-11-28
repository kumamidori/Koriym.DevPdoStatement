<?php
/**
 * This file is part of the Koriym.DevPdoStatement
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Koriym\DevPdoStatement;

final class QueryInterpolater
{
    /**
     * Replaces any parameter placeholders in a query with the value of that
     * parameter. Useful for debugging. Assumes anonymous parameters from
     * $params are are in the same order as specified in $query
     *
     * @param string $query  The sql query with parameter placeholders
     * @param array  $params The array of substitution parameters
     *
     * @return string The interpolated query
     *
     * @link http://stackoverflow.com/a/8403150
     * thanks
     */
    public function interpolate($query, $params)
    {
        $keys = [];
        $values = $params;
        # build a regular expression for each parameter
        foreach ($params as $key => $value) {
            $keys[] = is_string($key) ? '/' . $key . '/' : '/[?]/';
            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            }
            if (is_array($value)) {
                $values[$key] = "'" . implode("','", $value) . "'";
            }
            if (is_null($value)) {
                $values[$key] = 'null';
            }
        }

        return preg_replace($keys, $values, $query, 1);
    }
}
