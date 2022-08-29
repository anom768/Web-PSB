<?php

namespace Anyar\Web\PSB\Repository;

use Anyar\Web\PSB\Config\Database;
use PHPUnit\Framework\TestCase;

class AdminRepositoryTest extends TestCase
{
    private AdminRepository $adminRepository;

    protected function setUp(): void
    {
        $this->adminRepository = new AdminRepository(Database::getConnection());
    }

    public function testFindByEmailSuccess()
    {
        $return = $this->adminRepository->findByEmail("bangkitunom87@gmail.com");

        self::assertEquals("bangkitunom87@gmail.com",$return->email);
        self::assertEquals("123",$return->password);
    }

    public function testFindByEmailNotFound()
    {
        $return = $this->adminRepository->findByEmail("notfound");

        self::assertNull($return);
    }
}