<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 12:56
 */

/**
 * @group model
 * @group database
 */
    class News_model_test extends TestCase
    {
        public static function setUpBeforeClass()
        {
            parent::setUpBeforeClass();
            $CI =& get_instance();
            $CI->load->library('Seeder');
            $CI->seeder->call('NewsSeeder');
        }

        public function setUp()
        {
            $this->resetInstance();
            $this->CI->load->model('news_model');
            $this->obj = $this->CI->news_model;
        }

        public function test_When_you_get_all_news_Then_you_get_one_item()
        {
            $result = $this->obj->get_news();
            $this->assertCount(1, $result);
        }

        public function test_When_you_set_news_item_Then_you_have_two_items()
        {
            $_POST = [
                'title' => 'CodeIgniter is awesome!',
                'text' =>
                    'It is easy to understand, easy to write tests, and very fast.',
            ];
            $result = $this->obj->set_news();
            $this->assertTrue($result);
            $this->assertCount(2, $this->obj->get_news());
        }

        public function test_When_you_get_news_by_slug_Then_you_get_the_item()
        {
            $item = $this->obj->get_news('codeigniter-is-awesome');
            $this->assertEquals('CodeIgniter is awesome!', $item['title']);
        }
    }