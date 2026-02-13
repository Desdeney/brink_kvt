<?php

namespace App\Repository;

use App\Entity\ChecklistTemplateQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChecklistTemplateQuestion>
 */
class ChecklistTemplateQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChecklistTemplateQuestion::class);
    }
}