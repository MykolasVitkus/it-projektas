<?php

namespace App\Controller;

use App\Repository\FilmShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilmShowController extends AbstractController
{
    /**
     * @Route(path="/shows", name="show_index")
     */
    public function index(Request $request, FilmShowRepository $filmShowRepository)
    {
        $date = $request->get('date');
        if ($date) {
            $shows = $filmShowRepository->findShowsByDate(new \DateTime($date));
        } else {
            $shows = $filmShowRepository->findShowsByDate(new \DateTime());
        }
        return $this->render('show/index.html.twig', [
            'shows' => $shows
        ]);
    }

    /**
     * @Route(path="/shows/{id}", name="show_view")
     */
    public function view(FilmShowRepository $filmShowRepository, $id)
    {
//        if (!$this->isGranted('ROLE_USER')) {
//            return $this->redirectToRoute('login');
//        }
        return $this->render('show/view.html.twig', [
            'show' => $filmShowRepository->findOneBy(['id' => $id])
        ]);
    }

}