<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class T_feed extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}