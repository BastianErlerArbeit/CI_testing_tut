<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 20.07.2017
 * Time: 17:06
 */
    class Temperature_converter
    {
        /*
         * Converts Celsius to Fahrenheit
         *
         * @param float $degree
         * @return float
         */
        public function CtoF($degree)
        {
            return round((9/5) * $degree + 32, 1);
        }
        /*
         *
         * Converts Fahrenheit to Celsius
         *
         * @param float $degree
         * @return float
         */
        public function FtoC($degree)
        {
            return round((5/9) * ($degree - 32),1);
        }
    }