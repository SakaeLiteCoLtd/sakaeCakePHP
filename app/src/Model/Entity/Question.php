<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
/**
 * Question Entity
 */
class Question extends Entity
{
    /**
     * @var array �e�v���p�e�B���ꊇ����ł��邩�ǂ����̏��
     */
    protected $_accessible = [
        'user_id' => true,
        'body' => true,
        'created' => true,
        'modified' => true
    ];
}