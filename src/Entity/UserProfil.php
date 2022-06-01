<?php

namespace App\Entity;

use App\Repository\UserProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

#[ORM\Entity(repositoryClass: UserProfilRepository::class)]
class UserProfil implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Veuillez remplir ce champs', groups:['form'])]
    #[Assert\Email(message: "L'adresse mail {{ value }} n'est pas valide, veuillez essayer à nouveau.", groups:['form'])]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'Veuillez remplir ce champs', groups:['form'])]
    #[SecurityAssert\UserPassword(message: 'Le mot de passe est incorrect.', groups:['form'])]
    #[Assert\Length(min: '5', minMessage: 'Votre mot de passe est trop court.', groups:['form'])]
    private $password;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(message: 'Veuillez remplir ce champs', groups:['form'])]
    private $name;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(message: 'Veuillez remplir ce champs', groups:['form'])]
    private $firstname;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: 'Veuillez mettre votre date de naissance.', groups:['form'])]
    private $birthday;

    #[ORM\Column(type: 'string', length: 25)]
    #[Assert\NotBlank(message: 'Veuillez remplir choisir votre sexe.', groups:['form'])]
    private $gender;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(message: 'Veuillez selectionner votre pays.', groups:['form'])]
    private $country;

    #[ORM\Column(type: 'string', length: 75)]
    #[Assert\NotBlank(message: 'Veuillez remplir ce champs.', groups:['form'])]
    private $city;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\NotBlank(message: 'Veuillez remplir ce champs.', groups:['form'])]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez inserer une photo.', groups:['form'])]
    private $picture;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: TodoArticle::class)]
    private $todoArticles;

    public function __construct()
    {
        $this->todoArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function __toString(){
        return $this->name; // Remplacer champ par une propriété "string" de l'entité
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, TodoArticle>
     */
    public function getTodoArticles(): Collection
    {
        return $this->todoArticles;
    }

    public function addTodoArticle(TodoArticle $todoArticle): self
    {
        if (!$this->todoArticles->contains($todoArticle)) {
            $this->todoArticles[] = $todoArticle;
            $todoArticle->setAuthor($this);
        }

        return $this;
    }

    public function removeTodoArticle(TodoArticle $todoArticle): self
    {
        if ($this->todoArticles->removeElement($todoArticle)) {
            // set the owning side to null (unless already changed)
            if ($todoArticle->getAuthor() === $this) {
                $todoArticle->setAuthor(null);
            }
        }

        return $this;
    }
}
