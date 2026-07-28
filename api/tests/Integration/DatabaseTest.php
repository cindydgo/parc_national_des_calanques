<?php
require_once __DIR__ . '/TestUserRepository.php';

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private TestUserRepository $repository;


    protected function setUp(): void
    {
        $this->repository = new TestUserRepository();

        $this->repository->clearTable();
    }


public function testCreateUser(): void
    {
        $id = $this->repository->createUser([
            'name' => 'Jean',
            'email' => 'jean@test.com'
        ]);

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Jean', $user['name']);
    }


    public function testReadOneUser(): void
    {
        $id = $this->repository->createUser([
            'name' => 'Alice',
            'email' => 'alice@test.com'
        ]);

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Alice', $user['name']);
        $this->assertSame('alice@test.com', $user['email']);
    }


    public function testReadUnknownUser(): void
    {
        $user = $this->repository->getUser(999);

        $this->assertNull($user);
    }


    public function testUpdateUser(): void
    {
        $id = $this->repository->createUser([
            'name' => 'Bob',
            'email' => 'bob@test.com'
        ]);

        $result = $this->repository->updateUser($id, [
            'name' => 'Robert'
        ]);

        $this->assertTrue($result);

        $user = $this->repository->getUser($id);

        $this->assertSame(
            'Robert',
            $user['name']
        );
    }


    public function testDeleteUser(): void
    {
        $this->repository->createUser([
            'name' => 'Marc',
            'email' => 'marc@test.com'
        ]);


        $result = $this->repository->deleteUser(1);

        $this->assertTrue($result);

        $user = $this->repository->getUser(1);

        $this->assertNull($user);
    }


    public function testWhereFilter(): void
    {
        $this->repository->createUser([
            'name' => 'Paul',
            'email' => 'paul@test.com'
        ]);

        $this->repository->createUser([
            'name' => 'Julie',
            'email' => 'julie@test.com'
        ]);


        $users = $this->repository->getUsers([
            'name' => 'Julie'
        ]);


        $this->assertCount(1, $users);
        $this->assertSame(
            'Julie',
            $users[0]['name']
        );
    }


    public function testOrderBy(): void
    {
        $this->repository->createUser([
            'name' => 'Zoe',
            'email' => 'zoe@test.com'
        ]);

        $this->repository->createUser([
            'name' => 'Alice',
            'email' => 'alice@test.com'
        ]);


        $users = $this->repository->getUsers([
            'order_by' => 'name',
            'order_dir' => 'ASC'
        ]);


        $this->assertSame(
            'Alice',
            $users[0]['name']
        );
    }


    public function testLimit(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->repository->createUser([
                'name' => "User $i",
                'email' => "user$i@test.com"
            ]);
        }


        $users = $this->repository->getUsers([
            'limit' => 2
        ]);

        $this->assertCount(2, $users);
    }
}