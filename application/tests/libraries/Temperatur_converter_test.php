<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 20.07.2017
 * Time: 17:11
 */
    class Temperatur_converter_test extends TestCase
    {
        public function test_FtoC()
        {
            $obj = new Temperature_converter();
            $actual = $obj->FtoC(100);
            $expect = 37.8;
            $this->assertEquals($expect, $actual, '', 0.01);
        }
    }