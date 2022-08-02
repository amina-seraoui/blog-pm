<?php

namespace App\Controller\Model;

interface CreatedAtInterface
{
    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt): self;
}