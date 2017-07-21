<?php
/**
 * Created by PhpStorm.
 * User: Bastian Erler
 * Date: 21.07.2017
 * Time: 15:06
 */
    class News_model_with_mocks_test extends TestCase
    {
        public function setUp()
        {
            // Reset CodeIgniter super object
            $this->resetInstance();

            // Create mock object for CI_Loader
            $loader = $this->getMockBuilder('CI_Loader')
                ->setMethods(['database'])
                ->getMock();
            $loader->method('database')->willReturn($loader);

            // Inject mock object into CodeIgniter super object
            $this->CI->load = $loader;

            if (!class_exists('CI_DB', false)) {
                // Define CI_DB class
                eval('class CI_DB extends CI_DB_query_builder { }');
            }

            $this->obj = new News_model();
        }

        public function test_When_call_get_news_without_args_Then_get_all_items()
        {
            $result_array = [
                [
                    "id"    =>  "1",
                    "title" =>  "News test",
                    "slug"  =>  "news-test",
                    "text"  =>  "News text",
                ],[
                    "id"    =>  "2",
                    "title" =>  "News test 2",
                    "slug"  =>  "news-test-2",
                    "text"  =>  "News text 2",
                ],
            ];

            // Create mock object for CI_DB_result
            $db_result = $this->getMock_CI_DB_result('result_array', $result_array);

            // Create mock object for CI_DB
            $db = $this->getMock_CI_DB('get', ['news'], $db_result);

            // Inject mock object into the model
            $this->obj->db = $db;

            $result = $this->obj->get_news();
            $this->assertEquals($result_array, $result);
        }

        public function test_When_call_get_news_with_slug_Then_get_the_item()
        {
            $slug = 'news-test-2';
            $row_array = [
                "id" => "2",
                "title" => "News test 2",
                "slug" => "news-test-2",
                "text" => "News text 2",
            ];

            // Create mock object for CI_DB_result
            $db_result = $this->getMock_CI_DB_result('row_array', $row_array);

            // Create mock object for CI_DB
            $db = $this->getMock_CI_DB('get_where', ['news', ['slug' => $slug]], $db_result);

            // Inject mock object into the model
            $this->obj->db = $db;
            $item = $this->obj->get_news($slug);
            $this->assertEquals($row_array, $item);
        }

        public function test_When_post_data_Then_inserted_into_news_table_and_return_true()
        {
            // Create mock object for CI_Input
            $input = $this->getMockBuilder('CI_Input')
                ->disableOriginalConstructor()
                ->getMock();

            // Can't use '$input->method()', because CI_Input has method() method
            $input->expects($this->any())->method('post')
                ->willReturnMap(
                    [
                        // post($index = NULL, $xss_clean = NULL)
                        ['title', null, 'News Title'],
                        ['text', null, 'News Text'],
                    ]
                );

            // Create mock object for CI_DB
            $db = $this->getMock_CI_DB(
                'insert',
                [
                    'news',
                    [
                        "title" => "News Title",
                        "slug" => "news-title",
                        "text" => "News Text",
                    ]
                ],
                true
            );

            // Inject mock object into the model
            $this->obj->input = $input;
            $this->obj->db = $db;
            $result = $this->obj->set_news();
            $this->assertTrue($result);
        }

        /**
         * Create Mock Object for CI_DB_result
         *
         * @param string $method method name to mock
         * @param array $return the return value
         * @return Mock_CI_DB_result_xxxxxxxx
         */
        public function getMock_CI_DB_result($method, $return)
        {
            $db_result = $this->getMockBuilder('CI_DB_result')
                ->disableOriginalConstructor()
                ->getMock();
            $db_result->method($method)->willReturn($return);
            return $db_result;
        }

        /**
         * Create Mock Object for CI_DB
         *
         * @param string $method method name to mock
         * @param array $args the arguments
         * @param array $return the return value
         * @return Mock_CI_DB_xxxxxxxx
         */
        public function getMock_CI_DB($method, $args, $return)
        {
            $db = $this->getMockBuilder('CI_DB')
                ->disableOriginalConstructor()
                ->getMock();
            $mocker = $db->expects($this->once())
                ->method($method);
            switch (count($args)) {
                case 1:
                    $mocker->with($args[0]);
                    break;
                case 2:
                    $mocker->with($args[0], $args[1]);
                    break;
                case 3:
                    $mocker->with($args[0], $args[1], $args[2]);
                    break;
                case 4:
                    $mocker->with($args[0], $args[1], $args[2], $args[3]);
                    break;
                default:
                    break;
            }
            $mocker->willReturn($return);
            return $db;
        }
    }