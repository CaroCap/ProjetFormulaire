<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExemplesFormulaireController extends AbstractController
{
    #[Route('affichage/formulaire/independant/POST', name: 'affichage_formulaire_independant_Post')]
    public function AffichageFormulaireIndependantPost(): Response
    {
        return $this->render('exemples_formulaire/affichage_formulaire_independant_post.html.twig');
    }

    #[Route('traitement/formulaire/independant/POST', name: 'traitement_formulaire_independant_Post')]
    public function TraitementFormulaireIndependantPost(Request $req): Response
    {
        // Avec le GET, on devait juste faire $req->nomDeL'URL
        // Avec le POST
        $nom = $req->request->get('nom');
        $age = $req->request->get('age');
        $var = ['nom'=>$nom, 'age'=>$age];
        // dd($nom . " " . $age);
        return $this->render('exemples_formulaire/traitement_formulaire_independant_post.html.twig', $var);
    }

}
