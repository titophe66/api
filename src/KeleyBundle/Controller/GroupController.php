<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 19/09/17
 * Time: 12:59
 */

namespace KeleyBundle\Controller;

use KeleyBundle\Entity\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GroupController extends Controller
{

    public function GroupListAction(){
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('KeleyBundle:Groups')
            ->findAll();


        $json = [];
        foreach ($users as $value) {
            $json[] = [
                'id' => $value->getId(),
                'name' => $value->getName(),
                 ];
        }

        return new JsonResponse($json);
    }

    public function GroupIdAction($id){
        $groups = $this->get('doctrine.orm.entity_manager')
            ->getRepository('KeleyBundle:Groups')
            ->find($id);


        $json = [];

        $json[] = [
            'id' => $groups->getId(),
            'first name' => $groups->getName(),
            ];


        return new JsonResponse($json);
    }

    public function CreateGroupAction(Request $request){
        $em = $this->container->get('doctrine')->getEntityManager();
        $em->getRepository('KeleyBundle:Groups');
        $group = new Groups();

        $name=$request->request->get('name');

        $group->setName($name);

        $em->persist($group);
        $em->flush();

        $json = ['name' => $name];
        return new JsonResponse($json);
    }

    public function UpdateGroupAction($id,Request $request){
        $em = $this->container->get('doctrine')->getEntityManager();
        $group = $em->getRepository('KeleyBundle:Groups')->find($id);

        $name=$request->request->get('name');

        if(!empty($name) && $name!=$group->getName())$group->setName($name);

        $em->persist($group);
        $em->flush();

        return $this->redirect($id);

    }


}