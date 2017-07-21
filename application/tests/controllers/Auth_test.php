<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 16:50
 */
    class Auth_test extends TestCase
    {
        public function test_When_not_login_user_get_auth_Then_redirected()
        {
            $this->request('GET', 'auth');
            $this->assertRedirect('auth/login');
        }

        public function test_When_admin_user_get_auth_Then_returns_user_list()
        {
            $this->request->setCallable(
                function ($CI) {
                    $auth = $this->getDouble(
                        'Ion_auth', ['logged_in' => true, 'is_admin' => true]
                    );
                    $CI->ion_auth = $auth;
                }
            );
            $output = $this->request('GET', 'auth');
            $this->assertContains('<p>Below is a list of the users.</p>', $output);
        }
    }