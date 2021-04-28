<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

final class Newsletter
{

    /**
     * @Assert\Length(min=1)
     */
    public string $lastname;

    /**
     * @Assert\Length(min=1)
     */
    public string $firstname;

    /**
     * @Assert\Email()
     */
    public string $email;

}
