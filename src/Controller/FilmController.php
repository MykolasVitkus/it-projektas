<?php


namespace App\Controller;


use App\Entity\Film;
use App\Repository\FilmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route(path="/", name="film_index")
     */
    public function index(Request $request, PaginatorInterface $paginator, FilmRepository $filmRepository)
    {
        $query = $filmRepository->getShowingFilms();
        $films = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('film/index.html.twig', [
            'films' => $films
        ]);
    }

    /**
     * @Route(path="/films/{id}", name="film_view")
     */
    public function view(FilmRepository $filmRepository, $id)
    {
        $film = $filmRepository->findOneBy(['id' => $id]);
        return $this->render('film/view.html.twig', [
            'film' => $film
        ]);
    }

}