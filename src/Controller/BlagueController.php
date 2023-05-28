<?php

namespace App\Controller;

use App\Entity\Blague;
use App\Form\Blague1Type;
use App\Repository\BlagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
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

        return $this->json($blagues, 200);
    }

    #[Route('/new', name: 'app_blague_new', methods: ['POST'])]
    public function new(Request $request, BlagueRepository $blagueRepository ,SerializerInterface $serializer): Response
    {
        $json = $request->getContent();

        $blague = $serializer->deserialize($json,Blague::class,'json');

        $blagueRepository->save($blague, true);

        return $this->json('bien envoyé',200);

    }

    #[Route('/{id}', name: 'app_blague_show', methods: ['GET'])]
    public function show(Blague $blague): Response
    {
        if (!$blague){
            return $this->json('error joke no find',200);
        }
        return $this->json($blague,200);
    }

    #[Route('/edit/{id}', name: 'app_blague_edit', methods: ['PUT'])]
    public function edit(Request $request,SerializerInterface $serializer ,Blague $blague, BlagueRepository $blagueRepository): Response
    {
        if (!$blague){
            return $this->json('error joke no find',200);
        }
        $editeblague = $serializer->deserialize($request->getContent(), Blague::class, 'json');
        $blague->setBlague($editeblague->getBlague());
        $blagueRepository->save($blague, true);

        return $this->json('bien modifier',200);
    }

    #[Route('/remove/{id}', name: 'app_blague_delete', methods: ['DELETE'])]
    public function delete(Request $request, Blague $blague, BlagueRepository $blagueRepository): Response
    {
        if ($blague){
            $blagueRepository->remove($blague, true);
            return $this->json('data delete',200);
        }


        return $this->json('joke no exit',200);
    }
}
