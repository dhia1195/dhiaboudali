<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keyblog
 *
 * @ORM\Table(name="keyblog", indexes={@ORM\Index(name="keyword", columns={"keyword"}), @ORM\Index(name="blog", columns={"blog"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\KeyblogCandidatureRepository")
 */
class Keyblog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="blog", type="integer", nullable=false)
     */
    private $blog;

    /**
     * @var int
     *
     * @ORM\Column(name="keyword", type="integer", nullable=false)
     */
    private $keyword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlog(): ?int
    {
        return $this->blog;
    }

    public function setBlog(int $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getKeyword(): ?int
    {
        return $this->keyword;
    }

    public function setKeyword(int $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }


}
