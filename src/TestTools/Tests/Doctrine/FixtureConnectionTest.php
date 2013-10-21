<?php

namespace TestTools\Tests\Doctrine;

use TestTools\Fixture\FileFixture;
use TestTools\TestCase\UnitTestCase;

/**
 * @author Michael Mayer <michael@liquidbytes.net>
 * @package TestTools
 * @license MIT
 */
class FixtureConnectionTest extends UnitTestCase
{
    protected $db;

    public function setUp()
    {
        $this->db = $this->get('database_connection');
    }

    public function testUsesFixtures()
    {
        $this->assertTrue($this->db->usesFixtures());
    }

    public function testFetchAll()
    {
        $expected = array(
            array('id' => 1, 'name' => 'Foo', 'email' => 'foo@example.com'),
            array('id' => 2, 'name' => 'Bar', 'email' => 'bar@example.com')
        );

        $result = $this->db->fetchAll('SELECT * FROM users');

        $this->assertEquals($expected, $result);
    }

    public function testFetchAssoc()
    {
        $expected = array('id' => 2, 'name' => 'Bar', 'email' => 'bar@example.com');

        $result = $this->db->fetchAssoc('SELECT * FROM users WHERE id = 2');

        $this->assertEquals($expected, $result);
    }

    public function testFetchArray()
    {
        $expected = array(2, 'Bar', 'bar@example.com');

        $result = $this->db->fetchArray('SELECT * FROM users WHERE id = 2');

        $this->assertEquals($expected, $result);
    }

    public function testFetchColumn()
    {
        $expected = 'Bar';

        $result = $this->db->fetchColumn('SELECT name FROM users WHERE id = 2');

        $this->assertEquals($expected, $result);
    }

    public function testInsert()
    {
        $expected = 1;

        $row = array('name' => 'Baz', 'email' => 'baz@example.com');

        $result = $this->db->insert('users', $row);

        $this->assertEquals($expected, $result);
    }

    /**
     * @depends testInsert
     */
    public function testUpdate()
    {
        $expected = 1;

        $result = $this->db->update('users', array('name' => 'Changed'), array('id' => 3));

        $this->assertEquals($expected, $result);
    }

    /**
     * @depends testInsert
     */
    public function testDelete()
    {
        $expected = 1;

        $result = $this->db->delete('users', array('id' => 3));

        $this->assertEquals($expected, $result);
    }
}