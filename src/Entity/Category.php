<?php

namespace App\Entity;

class Category {


    public function __construct(
        private ?string $label = null,
        private ?int $id = null
    ) {}

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getLabel(): ?string {
        return $this->label;
    }

    public function setLabel(?string $label): self{
        $this->label = $label;
        return $this;
    }
}