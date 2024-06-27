<?php

namespace Vundb\FirestoreBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Vundb\FirestoreBundle\Entity\Entity;

class EntityTest extends TestCase
{
    public function testGetAndSetId()
    {
        $id = random_bytes(8);

        $entity = new TestEntity();
        $this->assertSame('', $entity->getId());

        $entity->setId($id);
        $this->assertSame($id, $entity->getId());
    }

    public function testToArray()
    {
        $id = random_bytes(8);
        $entity = (new TestEntity())
            ->setId($id);

        var_dump($entity);

        $this->assertSame([
            'id' => $id
        ], $entity->toArray());
    }

    public function testToArrayReturningAllPublicProperties()
    {
        $entity = new TestEntity();
        $this->assertSame(['id' => ''], $entity->toArray());

        $name = random_bytes(8);
        $sequence = random_int(0, 100);
        $roles = [random_bytes(8), random_bytes(8)];
        $entity = (new TestEntityWithProperties())
            ->setName($name)
            ->setSequence($sequence)
            ->setRoles($roles);
        $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys(
            [
                'id' => '',
                'name' => $name,
                'sequence' => $sequence,
                'roles' => $roles
            ],
            $entity->toArray(),
            ['id', 'name', 'sequence', 'roles']
        );
    }
}

/**
 * @extends Entity<TestEntity>
 */
class TestEntity extends Entity
{
}

/**
 * @extends Entity<TestEntityWithProperties>
 */
class TestEntityWithProperties extends Entity
{
    private string $name;
    private int $sequence;
    private array $roles;

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setSequence(int $value): self
    {
        $this->sequence = $value;
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
