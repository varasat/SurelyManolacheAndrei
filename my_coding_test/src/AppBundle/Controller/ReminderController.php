<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reminder;
use AppBundle\Service\ReminderService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReminderController
 * @package AppBundle\Controller
 */
class ReminderController extends Controller
{
    /**
     * @todo add pagination
     * @Route("/reminder/list")
     */
    public function listAction()
    {
        $reminderService = new ReminderService();
        $entityManager = $this->getDoctrine()->getManager();

        $reminders = $reminderService->getAllReminders($entityManager);
        return $this->render('listReminder.html.twig', ["reminders" => $reminders]);
    }

    /**
     * @Route("/reminder/create")
     */
    public function createAction(Request $request)
    {
        $reminder = new Reminder();
        $reminderService = new ReminderService();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($reminder)
            ->add('comment', TextType::class, ['required' => true])
            ->add('deadline', DateTimeType::class, ['required' => true,
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second'
                )])
            ->add('save', SubmitType::class, array('label' => 'Create Reminder', 'attr' => array(
                'class' => 'next-button')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reminderData = $form->getData();
            $newReminder = $reminderService->insertReminder($reminderData, $entityManager);
            if (!empty($newReminder)) {
                return $this->render('confirmedReminder.html.twig', ['reminderId' => $newReminder, 'action' => 'created']);
            }
        }

        return $this->render('formReminder.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Creates and manages the edit page
     * @todo put the form generation in a separate function to get rid of duplicate code
     * @Route("/reminder/edit/{reminderId}")
     */
    public function editAction($reminderId, Request $request)
    {
        $reminderService = new ReminderService();
        $entityManager = $this->getDoctrine()->getManager();
        $reminder = $reminderService->getReminderById($reminderId, $entityManager);

        $form = $this->createFormBuilder($reminder)
            ->add('comment', TextType::class, ['required' => true])
            ->add('deadline', DateTimeType::class, ['required' => true,
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second'
                )])
            ->add('save', SubmitType::class, array('label' => 'Edit Reminder', 'attr' => array(
                'class' => 'next-button')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reminderData = $form->getData();
            $newReminder = $reminderService->updateReminder($reminderId, $reminderData, $entityManager);
            if (!empty($newReminder)) {
                return $this->render('confirmedReminder.html.twig', ['reminderId' => $reminderId, 'action' => 'updated']);
            }
        }
        return $this->render('formReminder.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/reminder/delete/{reminderId}")
     */
    public function deleteAction($reminderId, Request $request)
    {
        if (!empty($reminderId)) {
            $entityManager = $this->getDoctrine()->getManager();
            $reminderService = new ReminderService();
            $reminderService->deleteReminder($reminderId, $entityManager);

        }
        return $this->redirect('/reminder/list');
    }

}