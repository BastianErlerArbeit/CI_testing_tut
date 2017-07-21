<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 15:52
 */
    /**
     * @group controller
     * @group database
     */
    class News_test extends TestCase
    {
        public static function setUpBeforeClass()
        {
            parent::setUpBeforeClass();

            $CI =& get_instance();
            $CI->load->library('Seeder');
            $CI->seeder->call('NewsSeeder');
        }

        public function test_When_access_news_Then_see_news_archive()
        {
            $output = $this->request('GET', '/news');
            $this->assertContains('<h1>News archive</h1>', $output);
            $this->assertContains('<h3>News test</h3>', $output);
        }

        public function test_When_access_news_with_not_existing_slug_Then_get_404()
        {
            $slug = 'not-existing-slug';
            $this->request('GET', "/news/$slug");
            $this->assertResponseCode(404);
        }

        public function test_When_access_news_with_slug_Then_see_the_item()
        {
            $slug = 'news-test';
            $output = $this->request('GET', "/news/view/$slug");
            $this->assertContains('<h1>News test</h1>', $output);
        }

        public function test_When_post_valid_news_item_Then_see_successful_message()
        {
            $output = $this->request(
                'POST',
                '/news/create',
                [
                    'title' => 'Codeigniter is easy to write tests',
                    'text'  => 'You can write tests for controllers very easily!',
                ]
            );
            $this->assertContains('<h2>Successfully created</h2>', $output);
        }

        public function test_When_access_news_Then_see_two_items()
        {
            $output = $this->request('GET', '/news');
            $this->assertContains('<h3>News test</h3>', $output);
            $this->assertContains('<h3>Codeigniter is easy to write tests</h3>', $output);
        }

        public function test_When_post_invalid_news_item_Then_see_error_messages()
        {
            $output = $this->request(
                'POST',
                '/news/create',
                [
                    'title' => '',
                    'text' => '',
                ]
            );
            $this->assertContains('<p>The Title field is required.</p>', $output);
            $this->assertContains('<p>The Text field is required.</p>', $output);
        }
    }