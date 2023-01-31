<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\Character\Edit;
use App\UseCase\Character\Index;

final class CharactersController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {}

    #[Route(path: "/", name: "characters_index")]
    public function index(Request $request, CharacterRepository $charactersRepo): Response
    {
        $filter = new Index\Filter();
        $form = $this->createForm(Index\Form::class, $filter);

        $form->handleRequest($request);

        $characters = $charactersRepo->findWithFilter($filter);

        return $this->render('characters/index.html.twig', [
            'form' => $form->createView(),
            'characters' => $characters
        ]);
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

        return $this->render('characters/edit.html.twig', [
            'form' => $form->createView(),
            'character' => $character
        ]);
    }
}
