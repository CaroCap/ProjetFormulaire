<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Entity\Livre;
use App\Entity\Evenement;
use App\Entity\Pays;
use App\Form\AeroportType;
use App\Form\LivreType;
use App\Form\EvenementType;
use App\Form\PaysType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/afficher/form/aeroport')]
    public function afficherAeroportForm()
    {
        // Créer un objet Formulaire
        $formAeroport = $this->createForm(AeroportType::class);
        // Envoyer le Form à la vue
        $vars = ['formAeroport'=>$formAeroport->createView()];
        return $this->render('exemples_formulaire/afficher_form_aeroport.html.twig', $vars);
        //renderForm?
        // $vars = ['unFormulaire'=>'exemples_formulaires/ex_aeroport.html.twig', $vars];
    }

    #[Route('/ajouter/aeroport', name:'ajouter_aeroport')]
    public function ajouterAeroport(Request $req, ManagerRegistry $doctrine)
    {
        $aeroport = new Aeroport();

        // Créer un objet Formulaire
        $formAeroport = $this->createForm(AeroportType::class, $aeroport, ['method'=>'POST', 'action'=>$this->generateUrl('ajouter_aeroport')]);

        $formAeroport->handleRequest($req);

        if ($formAeroport->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($aeroport);
            $em->flush();
            return $this->renderForm('exemples_formulaire/resultat_ajouter_aeroport.html.twig', ['formAeroport'=>$formAeroport]);
        }
        // Envoyer le Form à la vue
        return $this->renderForm('exemples_formulaire/afficher_form_aeroport.html.twig', ['formAeroport'=>$formAeroport]);
    }

    #[Route('/afficher/form/evenement')]
    public function afficherEvenementForm()
    {
        //Pour préremplir
        $e1 = new Evenement();
        $e1->setNom('TommorrowLand');
        $e1->setDescription('C\'est la fête');
        $e1->setDateEvenement(new \DateTime());

        // NON prérempli
        // $formEvenement = $this->createForm(EvenementType::class);

        // Pré-rempli => on ajoute juste l'événement
        $formEvenement = $this->createForm(EvenementType::class, $e1);

        // $vars = ['formEvenement'=>$formEvenement->createView()];
        // return $this->render('exemples_formulaire/afficher_form_evenement.html.twig', $vars);
        return $this->renderForm('exemples_formulaire/afficher_form_evenement.html.twig', ['formEvenement' => $formEvenement]);
    }

    #[Route('/afficher/form/livre')]
    public function afficherLivreForm()
    {
        $formLivre = $this->createForm(LivreType::class, null, ['method' => 'POST', 'action' => $this->generateUrl('traiter_form_livre')]);

        // $vars = ['formEvenement'=>$formEvenement->createView()];
        // return $this->render('exemples_formulaire/afficher_form_evenement.html.twig', $vars);
        return $this->renderForm('exemples_formulaire/afficher_form_livre.html.twig', ['formLivre' => $formLivre]);
    }

    #[Route('/traiter/form/livre', name:'traiter_form_livre')]
    // La Request récupère la requête du navigateur
    public function traiterLivreForm(Request $req)
    {
        dump($req);
        dd('je fonctionne');
    }

    #[Route('/ajouter/livre', name:'ajouter_livre')]
    // La Request récupère la requête du navigateur
    public function ajouterLivre(Request $req, ManagerRegistry $doctrine)
    {
        $livre = new Livre();

        $formLivre = $this->createForm(LivreType::class, $livre, ['method'=>'POST', 'action'=>$this->generateUrl('ajouter_livre')]);

        
        $formLivre->handleRequest($req);

        if($formLivre->isSubmitted()){
            // on reçoit les données, on les stocke dans la BD
            $em = $doctrine->getManager();
            $em->persist($livre);
            $em->flush();
            return $this->renderForm('exemples_formulaire/resultat_ajouter_livre.html.twig', ['formLivre' => $formLivre]);
        }
        return $this->renderForm('exemples_formulaire/afficher_ajouter_livre.html.twig', ['formLivre' => $formLivre]);

        // dump($req);
        // dd('je fonctionne');
    }

    #[Route('affiche/upload', name:'affiche_upload')]
    public function afficheUpload(Request $req, ManagerRegistry $doctrine)
    {
        $pays = new Pays();

        $formUpload = $this->createForm(PaysType::class, $pays, ['method'=>'POST', 'action'=>$this->generateUrl('affiche_upload')]);

        $formUpload->handleRequest($req);

        if($formUpload->isSubmitted() && $formUpload->isValid()){
            //stocker le fichier sur le disque et stocker l'objet dans la BD
            // On va stocker dans une variable temporaire fichier sur le disque dur
            $fichier = $pays->getLienImage();
            // md5 => méthode de Hashage
            // uniqid => méthode de PHP pour générer un id aléatoire
            // guessExtension va essayer de devine l'extension du fichier
            $nomFichier = md5(uniqid()) . "." . $fichier->guessExtension();
            // move => permet de bouger le fichier dans le 1e paramètre = dossier (qui se crée automatiquement si n'existe pas encore) et de lui donner le nom du 2e parametre
            $fichier->move("dossierFichiers", $nomFichier);
            
            // Stocker dans la BD
            $em = $doctrine->getManager();
            $pays->setLienImage($nomFichier);
            $em->persist($pays);
            $em->flush();

        }

        return $this->renderForm('exemples_formulaire/affiche_upload.html.twig', ['formUpload'=>$formUpload]);
    }
}
