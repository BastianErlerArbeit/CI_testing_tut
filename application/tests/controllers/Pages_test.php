<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 10:35
 */

/**
 * @group controller
 */
    class Pages_test extends TestCase
    {
        public function test_When_you_access_home_Then_you_see_Home()
        {
            $output = $this->request('GET', '/');
            $this->assertContains('<h1>Home</h1>', $output);
        }

        public function test_When_you_access_about_Then_you_see_About()
        {
            $output = $this->request('GET', 'about');
            $this->assertContains('<h1>About</h1>', $output);
        }

        public function test_When_you_access_notfound_Then_you_get_404()
        {
            $this->request('GET', 'notfound');
            $this->assertResponseCode(404);
        }
    }