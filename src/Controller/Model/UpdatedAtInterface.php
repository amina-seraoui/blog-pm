<?php

namespace App\Controller\Model;

interface UpdatedAtInterface extends CreatedAtInterface
{
    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self;
}