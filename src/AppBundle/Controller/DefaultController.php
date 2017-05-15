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
            'limit' => 10
        ]);
    }

    /**
     * @Route("/users/{page}/{limit}", name="users_route")
     * @param Request $request
     * @return Response
     */
    public function usersAction(Request $request, $page = 1, $limit = 10)
    {
        $nextPage = $page +1;
        $helper = new CollectionHelper();

        $collection = $helper
            ->withCollection($this->buildUsers($page, $limit), 'ns:users')
            ->withPagination($page, 100, $limit)
            ->withRouteDefinition('users_route')
            ->addRelations('self', "/users/$page/$limit")
            ->addRelations('first', "/users/1/$limit")
            ->addRelations('last', "/users/100/$limit")
            ->addRelations('next', "/users/$nextPage/$limit")
            ->buildCollection();

        return new JsonResponse(json_decode($this->get('serializer')->serialize($collection, 'json'), true));
    }

}
