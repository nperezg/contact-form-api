<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Exception\ValidationException;
use App\Repository\ContactRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * ContactController constructor.
     * @param ContactRepository $contactRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(ContactRepository $contactRepository, ValidatorInterface $validator)
    {
        $this->contactRepository = $contactRepository;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @Route("/api/contacts/", methods={"POST"}, name="api_contact_create")
     */
    public function create(Request $request)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $contact = (new Contact())
            ->setEmail($data['email'])
            ->setMessage($data['message']);

        $errors = $this->validator->validate($contact);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $this->contactRepository->save($contact);

        return new JsonResponse(
            [
                'message' => 'Contact created successfully.',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
}
