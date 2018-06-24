<?php

namespace AppBundle\Service;

use AppBundle\Entity\Reminder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ReminderService
 * @package AppBundle\Service
 */
class ReminderService
{
    /**
     * @param $entityManager
     * @return mixed
     */
    public function getAllReminders($entityManager)
    {
        $reminders = $entityManager->getRepository(Reminder::class)->findBy([], ['deadline' => 'ASC']);
        return $reminders;
    }

    /**
     * @param $reminderId
     * @param $entityManager
     * @return mixed
     */
    public function getReminderById($reminderId, $entityManager)
    {
        $reminder = $entityManager->getRepository(Reminder::class)->findOneBy(['id' => $reminderId]);
        return $reminder;
    }

    /**
     * @param $reminderId
     * @param $entityManager
     * @return bool
     */
    public function deleteReminder($reminderId, $entityManager)
    {
        $reminder = $this->getReminderById($reminderId, $entityManager);
        if (!empty($reminder)) {
            $entityManager->remove($reminder);
            $entityManager->flush();
            return true;
        }
        return false;
    }

    /**
     * @param $reminderId
     * @param $reminderData
     * @param $entityManager
     * @return bool
     */
    public function updateReminder($reminderId, $reminderData, $entityManager)
    {
        if (!empty($reminderId) && !empty($reminderData)) {
            $reminder = $this->getReminderById($reminderId, $entityManager);
            if (!empty($reminder)) {
                $reminder->setDeadline($reminderData->getDeadline());
                $reminder->setComment($reminderData->getComment());
                $entityManager->flush();
                return true;
            }
        }

        return false;
    }

    /**
     * @param $reminderData
     * @param $entityManager
     * @return bool|mixed
     */
    public function insertReminder($reminderData, $entityManager)
    {
        // We shall assume the symfony form already checked if the data is empty or not
        if ($reminderData instanceof Reminder) {
            $reminderData->setDatePosted(new \DateTime());
            $entityManager->persist($reminderData);
            $entityManager->flush();
            return $reminderData->getId();
        }
        return false;
    }
}