<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 20.07.2017
 * Time: 17:30
 */
    class Temperature_converter_test extends TestCase
    {
        public function setUp()
        {
            $this->obj = new Temperature_converter();
        }
        /**
         * @dataProvider provide_temperature_data
         */
        public function test_FtoC($degree, $expected)
        {
            $actual = $this->obj->FtoC($degree);
            $this->assertEquals($expected, $actual, '', 0.01);
        }

        /**
         * @dataProvider provide_temperature_data
         */
        public function test_CtoF($expected, $degree)
        {
            $actual = $this->obj->CtoF($degree);
            $this->assertEquals($expected, $actual, '', 0.01);
        }

        public function provide_temperature_data()
        {
            return[
                //[Fahrenheit, Celsius]
                [-40,   -40.0],
                [0  ,   -17.8],
                [32 ,     0.0],
                [100,    37.8],
                [212,   100.0],
            ];
        }
    }

