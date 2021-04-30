<?php

namespace App\Entity;

use App\Repository\MgUsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MgUsersRepository::class)
 */
class MgUsers implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * Il doit contenir entre 8 et 15 caractères
     * et au moins : une minuscule, une majuscule et un chiffre
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[A-Z])(?=.*[@#$%])(?!.*(.)\1{2}).*[a-z]/m",
     *      match=true,
     *      message="Format invalide."
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\ManyToOne(targetEntity=MgGenders::class, inversedBy="users")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creat;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=MgCustomersGroups::class, inversedBy="customers")
     */
    private $customer_group;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $customer_compagny;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $customer_birthday;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $customer_notes;

    public function __construct()
    {
        $this->date_creat = new \Datetime();
        $this->active = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCompleteName(): ?string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getGender(): ?MgGenders
    {
        return $this->gender;
    }

    public function setGender(?MgGenders $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCreat(): ?\DateTimeInterface
    {
        return $this->date_creat;
    }

    public function setDateCreat(\DateTimeInterface $date_creat): self
    {
        $this->date_creat = $date_creat;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCustomerGroup(): ?MgCustomersGroups
    {
        return $this->customer_group;
    }

    public function setCustomerGroup(?MgCustomersGroups $customer_group): self
    {
        $this->customer_group = $customer_group;

        return $this;
    }

    public function getCustomerCompagny(): ?string
    {
        return $this->customer_compagny;
    }

    public function setCustomerCompagny(?string $customer_compagny): self
    {
        $this->customer_compagny = $customer_compagny;

        return $this;
    }

    public function getCustomerBirthday(): ?\DateTimeInterface
    {
        return $this->customer_birthday;
    }

    public function setCustomerBirthday(?\DateTimeInterface $customer_birthday): self
    {
        $this->customer_birthday = $customer_birthday;

        return $this;
    }

    public function getCustomerNotes(): ?string
    {
        return $this->customer_notes;
    }

    public function setCustomerNotes(?string $customer_notes): self
    {
        $this->customer_notes = $customer_notes;

        return $this;
    }
}
