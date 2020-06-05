<?php
// src\Entity\User.php
namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Mapping\EntityBase;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class User
 *
 * PHP version 7.2
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user")
 * @Vich\Uploadable
 */
class User extends EntityBase implements UserInterface
{
    const SEXE = [
        0 => 'Inconnu',
        1 => 'Homme',
        2 => 'Femme'
    ];

    /**
     * @var int Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var bool Banni ?
     * @ORM\Column(name="is_banned", type="boolean", options={"default" : false})
     * @Assert\NotBlank
     */
    private $banned;
    
    /**
     * @var string|null Biographie
     * @ORM\Column(name="biographie", type="text", nullable=true)
     */
    private $biographie;
    
    /**
     * @var DateTime|null Date of Birth
     * @ORM\Column(name="birthdate",type="datetime", nullable=true)
     */
    private $dateNaissance;

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
     * @var bool Actif ?
     * @ORM\Column(name="is_enable", type="boolean", options={"default" : true})
     */
    private $enabled;
    
    /**
     * @var DateTime|null Date of Last connexion
     * @ORM\Column(name="Last_connexion",type="datetime", nullable=true)
     */
    private $lastConnexion;

    /**
     * @var string|null Last name
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $nom;

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
     * @Vich\UploadableField(mapping="users_pictures", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var string|null First name
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $prenom;

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
     * @var string|null
     * @ORM\Column(name="token", type="string", length=32, nullable=true)
     */
    private $token;

    /**
     * @var string|null username
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    private $username;

    /**
     * @var bool Valide ?
     * @ORM\Column(name="is_valid", type="boolean", options={"default" : false})
     * @Assert\NotBlank
     */
    private $valided;

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
     * Get banned
     *
     * @return boolean|null
     */
    public function getBanned(): ?bool
    {
        return $this->banned;
    }

    /**
     * Set banned
     *
     * @param boolean $banned
     * @return self
     */
    public function setBanned(bool $banned = false): self
    {
        $this->banned = $banned;

        if ($banned) { // anonymisation du compte
            $this->setBiographie(null)
                ->setDateNaissance(null)
                ->setEnabled(false)
                ->setNom(null)
                ->setPicture(null)
                ->setPrenom(null)
                ->setPassword(md5(uniqid()))
                ->setRoles([])
                ->setUsername(null)
            ;
        }

        return $this;
    }
    
    /**
     * Get biographie
     *
     * @return string|null
     */
    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    /**
     * Set biographie
     *
     * @param string|null $biographie
     * @return self
     */
    public function setBiographie(?string $biographie = null): self
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get Date of Birth
     *
     * @return DateTimeInterface|null
     */
    public function getDateNaissance(): ?DateTimeInterface
    {
        return $this->dateNaissance;
    }

    /**
     * Set Date of Birth
     *
     * @param DateTimeInterface|null $dateNaissance
     * @return self
     */
    public function setDateNaissance(?DateTimeInterface $date = null): self
    {
        $this->dateNaissance = $date;

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
     * Get enabled
     *
     * @return boolean|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return self
     */
    public function setEnabled(bool $enabled = true): self
    {
        $this->enabled = $enabled;

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
     * Get nom
     *
     * @return  null|string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string|null $nom
     * @return self
     */
    public function setNom(?string $nom = null): self
    {
        $this->nom = $nom;

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
     * Get picture name
     *
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set picture name
     *
     * @param string|null $pictureName
     * @return self
     */
    public function setPicture(?string $pictureName = null): self
    {
        $this->picture = $pictureName;
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
            $this->setUpdatedAt(new DateTime('now'));
        }

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * Set prenom
     *
     * @param string|null $prenom
     * @return self
     */
    public function setPrenom(?string $prenom = null): self
    {
        $this->prenom = $prenom;

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
     * Get valided
     *
     * @return boolean|null
     */
    public function getValided(): ?bool
    {
        return $this->valided;
    }

    /**
     * Set valided
     *
     * @param boolean $valided
     * @return self
     */
    public function setValided(bool $valided = false): self
    {
        $this->valided = $valided;

        if (!$this->valided) {
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
