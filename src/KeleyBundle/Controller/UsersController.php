<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 18/09/17
 * Time: 23:55
 */

namespace KeleyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use KeleyBundle\Entity\User;

class UsersController extends Controller
{


    public function UsersListAction(){
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('KeleyBundle:User')
            ->findAll();
        $json = [];
        foreach ($users as $value) {
            $json[] = [
                'id' => $value->getId(),
                'first name' => $value->getFirstName(),
                'last name' => $value->getLastName(),
                'email' => $value->getEmail(),
                'active' => $value->getIsActive(),
                'login' => $value->getLogin(),
                'date de creation' => $value->getCreatedAt(),
            ];
        }

        return new JsonResponse($json);
    }

    public function UsersIdAction($id){
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('KeleyBundle:User')
            ->find($id);


        $json = [];

            $json[] = [
                'id' => $users->getId(),
                'first name' => $users->getFirstName(),
                'last name' => $users->getLastName(),
                'email' => $users->getEmail(),
                'active' => $users->getIsActive(),
                'login' => $users->getLogin(),
                'date de creation' => $users->getCreatedAt(),
            ];


        return new JsonResponse($json);
    }

    public function CreateUserAction(Request $request){
        $em = $this->container->get('doctrine')->getEntityManager();
        $em->getRepository('KeleyBundle:User');
        $user = new User();

        $lastname=$request->request->get('lastname');
        $firstname=$request->request->get('firstname');
        $email = $request->request->get('email');
        $login = $request->request->get('login');
        $group = $request->request->get('group');


         $user->setLastName($lastname);
         $user->setFirstName($firstname);
         $user->setEmail($email);
         $user->setLogin($login);
        $user->setIsActive(1);
        $user->setCreatedAt(new \DateTime());


        if(empty($error)) {
            $em->persist($user);
            $em->flush();

            $json = ['lastname' => $lastname, 'firstname' => $firstname, 'email' => $email, 'login' => $login];
            return new JsonResponse($json);
        }else{
            $jsonerror=['error'=>'erreur a preciser'];
            return new JsonResponse($jsonerror);
        }
    }

    public function UpdateUserAction($id,Request $request){
        $em = $this->container->get('doctrine')->getEntityManager();
        $user = $em->getRepository('KeleyBundle:User')->find($id);

        $lastname=$request->request->get('lastname');
        $firstname=$request->request->get('firstname');
        $email = $request->request->get('email');
        $login = $request->request->get('login');
        $active = $request->request->get('active');
        $group = $request->request->get('group');

        $error = [];

        if(!empty($lastname) && $lastname!=$user->getLastName())  $user->setLastName($lastname);
        if(!empty($firstname) && $firstname!=$user->getFirstName()) $user->setFirstName($firstname);
        if(!empty($email) && $email!=$user->getEmail()) $user->setEmail($email);
        if(!empty($login) && $login!=$user->getLogin()) $user->setLogin($login);
        if(!empty($active) && $active!=$user->getIsActive())$user->setIsActive($active);


        $em->persist($user);
        $em->flush();

        /*$json = ['lastname' => $lastname];
        return new JsonResponse($json);*/
        return $this->redirect($id);

    }


}