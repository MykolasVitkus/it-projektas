<?php


namespace App\Controller;


use App\Entity\FilmShow;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route(path="/tickets", methods={"POST"}, name="ticket_purchase")
     */
    public function purchaseTicket(Request $request)
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('login');
        }
        $showId = $request->get('show');
        $ticketAmount = $request->get('ticketAmount');
        $em = $this->getDoctrine()->getManager();
        /** @var FilmShow $show */
        $show = $em->getRepository(FilmShow::class)->findOneBy(['id' => $showId]);
        if ($show && $ticketAmount) {
            if ($show->getRoom()->getAvailableSeats() - sizeof($show->getTickets()) >= $ticketAmount) {
                for ($i = 0; $i < $ticketAmount; $i++) {
                    $ticket = new Ticket();
                    $ticket->setFilmShow($show);
                    $ticket->setRefunded(false);
                    $ticket->setOwner($this->getUser());
                    $ticket->setPrice('6.00');
                    $em->persist($ticket);
                }
                $em->flush();
                $this->addFlash('success', 'Bilietai sėkmingai užsakyti');
            }
        }
        return $this->redirectToRoute('ticket_index');
    }

    /**
     * @Route(path="/tickets", methods={"GET"}, name="ticket_index")
     */
    public function index(TicketRepository $ticketRepository)
    {
        $user = $this->getUser();
        $tickets = $ticketRepository->findBy(['owner' => $user, 'refunded' => false]);
        $refundedTickets = $ticketRepository->findBy(['owner' => $user, 'refunded' => true]);
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
            'refundedTickets' => $refundedTickets
        ]);
    }

    /**
     * @Route(path="/tickets/{id}/refund", name="ticket_refund")
     */
    public function refundTicket(TicketRepository $ticketRepository, $id)
    {
        $ticket = $ticketRepository->findOneBy(['id' => $id]);
        $ticket->setRefunded(true);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', 'Bilietas sėkmingai atšauktas');
        return $this->redirectToRoute('ticket_index');
    }

}