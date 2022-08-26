<?php

namespace App\Controller\Model;

class WelcomeModel
{
    const TITLE_LABEL = 'Titre du site';
    const TITLE_NAME = 'blog_title';

    const INSTALLED_LABEL = 'Site installé';
    const INSTALLED_NAME = 'blog_installed';

    private ?string $title;
    private ?string $username;
    private ?string $password;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return WelcomeModel
     */
    public function setTitle(?string $title): WelcomeModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return WelcomeModel
     */
    public function setUsername(?string $username): WelcomeModel
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return WelcomeModel
     */
    public function setPassword(?string $password): WelcomeModel
    {
        $this->password = $password;
        return $this;
    }
}
