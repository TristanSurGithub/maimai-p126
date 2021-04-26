<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

final class Newsletter
{
    /**
     * @Assert\Length(min=1)
     * @Assert\NotBlank()
     */
    public string $name;
    /**
     * @Assert\Email()
     */
    public string $email;
}