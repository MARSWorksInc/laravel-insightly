<?php


namespace Marsworksinc\LaravelInsightly;

class Contact
{
    public function __construct(
        private int $id,
        private string $firstName,
        private string $lastName,
        private ?string $email,
        private ?string $salutation = null,
        private ?int $organization = null,
        private ?array $tags = [],
    ) {
    }

    /**
     * @return int|null
     */
    public function getOrganization(): ?int
    {
        return $this->organization;
    }

    /**
     * @param int $organization
     */
    public function setOrganization(int $organization): void
    {
        $this->organization = $organization;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation(string $salutation): void
    {
        $this->salutation = $salutation;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
