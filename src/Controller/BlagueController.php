<?php

namespace App\Controller;

use App\Entity\Blague;
use App\Form\Blague1Type;
use App\Repository\BlagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/blague')]
class BlagueController extends AbstractController
{
    #[Route('/', name: 'app_blague_index', methods: ['GET'])]
    public function index( HttpClientInterface $httpClient): Response
    {
        $blagues=array();
        for ($i=0;$i<10;$i++){
            $reponse=$httpClient->request('GET','https://api.chucknorris.io/jokes/random');

            array_push($blagues,$reponse->toArray()['value']);
        }

        return $this->render('blague/index.html.twig', [
            'blagues' =>$blagues
        ]);
    }

    #[Route('/new', name: 'app_blague_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BlagueRepository $blagueRepository): Response
    {
        $blague = new Blague();
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $blague->setBlague($request->request->get("blague"));
        $blague->setProfile($this->getUser()->getProfile());
        $blagueRepository->save($blague, true);

        $data=[
            "response"=>"blague ajouté",
        ];
        return $this->json($data,200);
    }

    #[Route('/{id}', name: 'app_blague_show', methods: ['GET'])]
    public function show(Blague $blague): Response
    {
        return $this->render('blague/show.html.twig', [
            'blague' => $blague,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blague_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blague $blague, BlagueRepository $blagueRepository): Response
    {
        $form = $this->createForm(Blague1Type::class, $blague);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blagueRepository->save($blague, true);

            return $this->redirectToRoute('app_blague_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blague/edit.html.twig', [
            'blague' => $blague,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blague_delete', methods: ['POST'])]
    public function delete(Request $request, Blague $blague, BlagueRepository $blagueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blague->getId(), $request->request->get('_token'))) {
            $blagueRepository->remove($blague, true);
        }

        return $this->redirectToRoute('app_blague_index', [], Response::HTTP_SEE_OTHER);
    }
}
