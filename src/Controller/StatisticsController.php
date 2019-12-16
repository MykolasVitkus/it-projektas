<?php


namespace App\Controller;


use App\Entity\Film;
use App\Entity\FilmShow;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route(path="/statistics", name="statistics_index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $shows = $em->getRepository(FilmShow::class)->getShowsCount();
        $tickets = $em->getRepository(Ticket::class)->getTicketsCount();

        $films = $em->getRepository(Film::class)->getFilmsCount();
        $users = $em->getRepository(User::class)->findAll();

        $mostTickets = 0;
        $allFilms = $em->getRepository(Film::class)->findAll();
        $mostProfitableFilm = $allFilms[0];
        foreach ($allFilms as $film) {
            $filmShows = $film->getShows();
            $sum = 0;
            foreach ($filmShows as $show) {
                $sum += sizeof($show->getTickets());
            }
            if ($sum > $mostTickets) {
                $mostTickets = $sum;
                $mostProfitableFilm = $film;
            }
        }

        return $this->render('statistics/index.html.twig', [
            'shows' => $shows[0][1],
            'tickets' => $tickets[0][1],
            'films' => $films[0][1],
            'mostProfitableFilm' => $mostProfitableFilm,
            'users' => $users
        ]);

    }

}