<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 13:34
 */
    class PLay_with_mocks_test extends TestCase
    {
        public function test_mocking_Temperature_converter()
        {
            $mock = $this->getMockBuilder('Temperature_converter')->getMock();

            $mock->method('FtoC')->willReturn(99.9);

           // $mock2 = $this->getMockBuilder('Temperature_converter')->set_Methods(['FtoC'])->getMock();
           // $mock2->method('FtoC')->willReturn(99.99);
            //eval(\Psy\sh());
            //var_dump($mock, $mock->FtoC(100), $mock->CtoF(0)); exit;
        }

        public function test_mock_expectations()
        {
            $mock = $this->getMockBuilder('Temperature_converter')
                ->getMock();
            $mock->expects($this->once())
                ->method('FtoC')
                ->with(0);
            $mock->FtoC(0);
        }

        public function test_mock_at_method()
        {
            $mock = $this->getMockBuilder('Temperature_converter')
                ->getMock();
            $mock->expects($this->at(0))
                ->method('FtoC')
                ->with(0);
            $mock->expects($this->at(1))
                ->method('CtoF')
                ->with(100);
            $mock->FtoC(0);
            $mock->CtoF(100);
        }
    }