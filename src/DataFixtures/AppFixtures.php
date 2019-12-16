<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\FilmShow;
use App\Entity\Room;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $director = new User();

        $password = $this->encoder->encodePassword($director, '123456789');
        $director
            ->setEmail('director@kinas.lt')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN', 'ROLE_DIRECTOR']);

        $manager->persist($director);


        $admin = new User();

        $password = $this->encoder->encodePassword($admin, '123456789');
        $admin
            ->setEmail('admin@kinas.lt')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $user = new User();

        $password = $this->encoder->encodePassword($user, '123456789');
        $user
            ->setEmail('user@kinas.lt')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN', 'ROLE_DIRECTOR']);

        $manager->persist($user);


        $room = new Room();
        $room->setAvailableSeats('120');
        $manager->persist($room);


        // Wonder Woman
        $film = new Film();
        $film
            ->setTitle('Wonder Woman')
            ->setDuration(60 * 60 * 2)
            ->setShowing(true)
            ->setGenres('Action, Adventure, Fantasy')
            ->setDirector('Patty Jenkins')
            ->setRating('7.4')
            ->setWriters('Allan Heinberg (screenplay), Zack Snyder (story)')
            ->setActors('Gal Gadot, Chris Pine, Robin Wright')
            ->setDescription('When a pilot crashes and tells of conflict in the outside world, Diana, an Amazonian warrior in training, leaves home to fight a war, discovering her full powers and true destiny.')
            ->setReleaseDate(new \DateTime('2017-06-02T00:00:00.00000Z'))
            ->setUpdatedAt(new \DateTime());

        copy('src/DataFixtures/images/wonder_woman.jpg', 'src/DataFixtures/images/wonder_woman_copy.jpg');
        $file = new UploadedFile('src/DataFixtures/images/wonder_woman_copy.jpg', 'wonder_woman.jpg', null, null, true);
        $film->setImageFile($file);
        $film->setImage('wonder_woman_copy.jpg');
        $manager->persist($film);

        for ($i = 0; $i < 30; $i++) {
            $show = new FilmShow();
            $datetime = new \DateTime("now + $i day");
            $datetime->setTime('8', '0');
            $show->setTime($datetime);
            $show->setFilm($film);
            $show->setRoom($room);
            $manager->persist($show);

            $show = new FilmShow();
            $datetime = new \DateTime("now + $i day");
            $datetime->setTime('22', '0');
            $show->setTime($datetime);
            $show->setFilm($film);
            $show->setRoom($room);
            $manager->persist($show);

        }

        // Limitless
        $film = new Film();
        $film
            ->setTitle('Limitless')
            ->setShowing(true)
            ->setDuration(60 * 60 * 2)
            ->setGenres('Sci-Fi, Thriller')
            ->setDirector('Neil Burger')
            ->setRating('7.4')
            ->setWriters('Leslie Dixon (screenplay), Alan Glynn (novel)')
            ->setActors('Bradley Cooper, Anna Friel, Abbie Cornish')
            ->setDescription('With the help of a mysterious pill that enables the user to access one hundred percent of his brain abilities, a struggling writer becomes a financial wizard, but it also puts him in a new world with lots of dangers.')
            ->setReleaseDate(new \DateTime('2011-03-18T00:00:00.00000Z'))
            ->setUpdatedAt(new \DateTime());

        copy('src/DataFixtures/images/limitless.jpg', 'src/DataFixtures/images/limitless_copy.jpg');
        $file = new UploadedFile('src/DataFixtures/images/limitless_copy.jpg', 'limitless.jpg', null, null, true);
        $film->setImageFile($file);
        $film->setImage('limitless_copy.jpg');
        $manager->persist($film);

        for ($i = 0; $i < 30; $i++) {
            $show = new FilmShow();
            $datetime = new \DateTime("now + $i day");
            $datetime->setTime('13', '0');
            $show->setTime($datetime);
            $show->setFilm($film);
            $show->setRoom($room);
            $manager->persist($show);

            $show = new FilmShow();
            $datetime = new \DateTime("now + $i day");
            $datetime->setTime('19', '0');
            $show->setTime($datetime);
            $show->setFilm($film);
            $show->setRoom($room);
            $manager->persist($show);

        }


        //The Revenant

        $film = new Film();
        $film
            ->setTitle('The Revenant')
            ->setDuration(60 * 60 * 2)
            ->setShowing(true)
            ->setGenres('Action, Adventure, Biography')
            ->setDirector('Alejandro G. Iñárritu')
            ->setRating('7.4')
            ->setWriters('Mark L. Smith (screenplay), Alejandro G. Iñárritu (screenplay)')
            ->setActors('Leonardo DiCaprio, Tom Hardy, Will Poulter')
            ->setDescription('A frontiersman on a fur trading expedition in the 1820s fights for survival after being mauled by a bear and left for dead by members of his own hunting team.')
            ->setReleaseDate(new \DateTime('2016-01-08T00:00:00.00000Z'))
            ->setUpdatedAt(new \DateTime());

        copy('src/DataFixtures/images/the_revenant.jpg', 'src/DataFixtures/images/the_revenant_copy.jpg');
        $file = new UploadedFile('src/DataFixtures/images/the_revenant_copy.jpg', 'the_revenant.jpg', null, null, true);
        $film->setImageFile($file);
        $film->setImage('the_revenant_copy.jpg');
        $manager->persist($film);



        for ($i = 0; $i < 30; $i++) {
            $show = new FilmShow();
            $datetime = new \DateTime("now + $i day");
            $datetime->setTime('10', '0');
            $show->setTime($datetime);
            $show->setFilm($film);
            $show->setRoom($room);
            $manager->persist($show);

            $show = new FilmShow();
            $datetime = new \DateTime("now + $i day");
            $datetime->setTime('16', '0');
            $show->setTime($datetime);
            $show->setFilm($film);
            $show->setRoom($room);
            $manager->persist($show);
        }
        $manager->flush();
    }
}
