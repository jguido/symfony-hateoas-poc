<?php

namespace AppBundle\Controller;

use AppBundle\Domain\Enterprise;
use AppBundle\Domain\User;
use AppBundle\Helper\CollectionHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private function buildUsers($start, $end)
    {
        $users = [];
        foreach (range($start, $end) as $i) {
            $enterprise = new Enterprise($i.$i.$i, "cyber Corp $i.");
            $users[] =  new User($i, "firstname$i", "lastname$i", $enterprise);
        }

        return $users;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->redirectToRoute('users_route', [
            'page' => 1,
            'limit' => 1000
        ]);
    }

    /**
     * @Route("/users/{page}/{limit}", name="users_route")
     * @param Request $request
     * @return Response
     */
    public function usersAction(Request $request, $page = 1, $limit = 1000)
    {
        $nextPage = $page +1;
        $helper = new CollectionHelper();
        $nb = $this->get('doctrine.dbal.default_connection')->executeQuery("SELECT COUNT(ID) AS NB FROM USERS;")->fetch()['NB'];
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findBy([], array('firstName' => 'ASC'), $limit, $page);
        $nbOfPages = intval( $nb / $limit);

        $collection = $helper
            ->withCollection($users, 'ns:users')
            ->withPagination($page, $nbOfPages, $limit)
            ->withRouteDefinition('users_route')
            ->buildCollection();

        return new JsonResponse(json_decode($this->get('serializer')->serialize($collection, 'json'), true));
    }

}
