<?php
// src\Entity\User.php
namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Helper\ORM\IsEnablableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="u_user")
 * @Vich\Uploadable
 */
class User extends EntityBase implements UserInterface
{
    use IsEnablableTrait;
    
    const SEXE = [
        0 => 'Unknown',
        1 => 'Male',
        2 => 'Female'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var bool|null Banni ?
     * @ORM\Column(name="is_ban", type="boolean", options={"default" : false})
     */
    private $ban;
    
    /**
     * @var string|null Biography
     * @ORM\Column(name="biography", type="text", nullable=true)
     */
    private $biography;
    
    /**
     * @var DateTimeImmutable|null Date of Birth
     * @ORM\Column(name="birth_date",type="datetime_immutable", nullable=true)
     */
    private $birthDate;

    /**
     * @var string Email
     * @ORM\Column(name="email", type="string", length=180, nullable=false, unique=true)
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'Email '{{ value }}' n'est pas un email valide."
     * )
     */
    private $email;

    /**
     * @var string|null Firstname
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstname;
    
    /**
     * @var DateTimeImmutable|null Date of Last connexion
     * @ORM\Column(name="last_connexion",type="datetime_immutable", nullable=true)
     */
    private $lastConnexion;

    /**
     * @var string|null Lastname
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastname;

    /**
     * @var string The hashed password
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="user_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var string[] Array of roles
     * @ORM\Column(name="roles", type="json")
     */
    private $roles = [];

    /**
     * @var int Sexe
     * @ORM\Column(name="sexe", type="smallint", nullable=true, options={"default" : 0})
     */
    private $sexe;

    /**
     * @var string|null Token
     * @ORM\Column(name="token", type="string", length=32, nullable=true)
     */
    private $token;

    /**
     * @var string|null username
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    private $username;

    /**
     * @var bool|null Valid ?
     * @ORM\Column(name="is_valid", type="boolean", options={"default" : false})
     */
    private $valid;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setSexe();
    }

    /* ---------------------- Setters & Getters ---------------------- */
    
    /**
     * Get Id
     *
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get ban
     *
     * @return bool|null
     */
    public function getBan(): ?bool
    {
        return $this->ban;
    }

    /**
     * Set ban
     *
     * @param bool|null $ban
     * @return self
     */
    public function setBan(?bool $ban = false): self
    {
        $this->ban = $ban;

        if ($ban) { // anonymisation du compte
            $this->setBiography(null)
                ->setBirthDate(null)
                ->setEnable(false)
                ->setLastname(null)
                ->setPicture(null)
                ->setFirstname(null)
                ->setPassword(md5(uniqid()))
                ->setRoles([])
                ->setUsername(null)
            ;
        }

        return $this;
    }
    
    /**
     * Get biography
     *
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * Set biography
     *
     * @param string|null $biography
     * @return self
     */
    public function setBiography(?string $biography = null): self
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get Date of Birth
     *
     * @return DateTimeInterface|null
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * Set Date of Birth
     *
     * @param DateTimeInterface|null $birthDate
     * @return self
     */
    public function setBirthDate(?DateTimeInterface $date = null): self
    {
        $this->birthDate = $date;

        return $this;
    }

    /**
     * Get email
     *
     * @return  null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param   string  $email
     * @return  User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Date of last connexion
     *
     * @return DateTimeInterface|null
     */
    public function getLastConnexion(): ?DateTimeInterface
    {
        return $this->lastConnexion;
    }

    /**
     * Set Date of last connexion
     *
     * @param DateTimeInterface|null $date
     * @return self
     */
    public function setLastConnexion(?DateTimeInterface $date = null): self
    {
        $this->lastConnexion = $date;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return  null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string|null $lastname
     * @return self
     */
    public function setLastname(?string $lastname = null): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @see UserInterface
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set picture
     *
     * @param string|null $picture
     * @return self
     */
    public function setPicture(?string $picture = null): self
    {
        $this->picture = $picture;
        return $this;
    }
    
    /**
     * Get picture file
     *
     * @return File|null
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * Set picture file
     *
     * @param  File|UploadedFile|null $file
     * @return self
     */
    public function setPictureFile(?File $file = null): self
    {
        $this->pictureFile = $file;
        if (null !== $file) {
            $this->setUpdatedAt(new DateTimeImmutable('now'));
        }

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set firstname
     *
     * @param string|null $firstname
     * @return self
     */
    public function setFirstname(?string $firstname = null): self
    {
        $this->firstname = $firstname;

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

    /**
     * @see UserInterface
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
    }

    /**
     * Get sexe
     *
     * @return int|null
     */
    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    /**
     * Set sexe
     * 0: inconnu, 1: Homme, 2: Femme
     *
     * @param int|null $sexe
     * @return self
     */
    public function setSexe(?int $sexe = 0): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get token
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set token
     *
     * @param string|null $token
     * @return self
     */
    public function setToken(?string $token = null): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return (string) $this->username;
    }

    /**
     * Set username
     *
     * @param string|null $username
     * @return self
     */
    public function setUsername(?string $username = null): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get valid
     *
     * @return bool|null
     */
    public function getValid(): ?bool
    {
        return $this->valid;
    }

    /**
     * Set valid
     *
     * @param bool|null $valid
     * @return self
     */
    public function setValid(?bool $valid = false): self
    {
        $this->valid = $valid;

        if (!$this->valid) {
            $this->setToken($this->generateToken());
        } else {
            $this->setToken(null);
        }

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
    
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
    }

    /**
     * Genere un token
     *
     * @return string
     */
    public function generateToken(): string
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
