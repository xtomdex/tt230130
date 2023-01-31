<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\Character\Edit;

final class CharactersController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {}

    #[Route(path: "/", name: "characters_index")]
    public function index(Request $request, CharacterRepository $charactersRepo): JsonResponse
    {
        if (($name = $request->query->get('name')) && strlen($name) > 2) {
            $characters = $charactersRepo->findByName($name);
        } else {
            $characters = $charactersRepo->findAll();
        }

        return $this->json($characters);
    }

    #[Route(path: "/character/{id}", name: "characters_edit")]
    public function edit(Character $character, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromCharacter($character);
        $form = $this->createForm(Edit\Form::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('characters_index');
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', 'Something went wrong during editing. Please try again later.');
            }
        }

        return $this->render('character_edit_View');
    }
}
