<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 17:01
 */

    /**
     * @group controller
     */
    class Dbfixture_test extends TestCase
    {
        public function setUp()
        {
            $this->resetInstance();
            $this->obj = new Dbfixture();
        }

        public function tearDown()
        {
            parent::tearDown();
            set_is_cli(true);
        }

//        /**
//         * @expectedException CIPHPUnitTestExitException
//         * @expectedExceptionMessage exit() called in Dbfixture::__construct()
//         */
//        public function test_When_not_running_under_CLI_Then_exit()
//        {
//            set_is_cli(false);
//            try {
//                new Dbfixture();
//            } catch (CIPHPUnitTestExitException $e) {
//                $this->assertNull($e->exit_status);
//            }
//        }

        public function test_When_migration_error_Then_you_see_the_error()
        {
            // Create mock object for CI_Loader
            $loader = $this->getDouble(
                'CI_Loader',
                [
                    'library'       =>  null,
                ]
            );

            // Create mock object for CI_Migration
            $error_msg = 'Migration error';
            $migration = $this->getDouble(
                'CI_Migration',
                [
                    'current'       =>  falsem,
                    'error_string'  =>  $error_msg,
                ]
            );

            // Inject mock objects
            $this->obj->load        =   $loader;
            $this->obj->migration   =   $migration;

            $this->expectOutputString($error_msg . PHP_EOL);
            $this->obj->migrate();
        }
    }