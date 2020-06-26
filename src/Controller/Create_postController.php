<?php
namespace App\Controller;
use App\Entity\Post;
use App\Entity\Reponse;
use App\Form\CreatePostType;
use App\Form\ReponseType;
use App\Repository\PostRepository;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class Create_postController extends AbstractController
{

    /**
 * @Route("/forum/create_post", name="createpost")
 * @param UtilisateurRepository $rep
 * @param Request $request
 * @return Response
 * @throws Exception
 */

    public function index(UtilisateurRepository $rep,Request $request)
    {
        $post=new Post();
        $form=$this->createForm(CreatePostType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $post->setDatePost(new DateTime('now'));
            $user=$this->getUser();
            $x=$rep->find($user->getId());
            $post->setUser($x);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('forum');

        }
        return $this->render('create_post.html.twig',['form'=>$form->createView()]);
    }


    /**
     * @Route("/forum/post/{id}/reponses", name="reponsespost")
     * @param $id
     * @param PostRepository $rep
     * @return Response
     */

    public function respones($id,PostRepository $rep)
    {
        $post=$rep->find($id);
        $reponses= $post->getReponses();
        $reponse = new Reponse();
        $formreponse= $this->createForm(ReponseType::class,$reponse);

        return $this->render('post.html.twig',['reponses'=>$reponses,'post'=>$post,'form'=>$formreponse->createView()]);
    }

    /**
     * @Route("/forum/post/{id}/addreponse", name="addreponse")
     * @param $id
     * @param PostRepository $rep
     * @param Request $request
     * @param UtilisateurRepository $repository
     * @return Response
     * @throws Exception
     */

    public function addreponse($id,PostRepository $rep,Request $request,UtilisateurRepository $repository)
    {
        $post=$rep->find($id);
        $reponses=$post->getReponses();
        $reponse = new Reponse();
        $form= $this->createForm(ReponseType::class,$reponse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$this->getUser();
            $x=$repository->find($user->getId());
            $em=$this->getDoctrine()->getManager();
            $reponse->setUser($x);
            $reponse->setDateReponse(new  DateTime('now'));
            $reponse->setPost($post);
            $em->persist($reponse);
            $em->flush();
            return $this->redirectToRoute('reponsespost',['id'=>$id,'post'=>$post,'reponses'=>$reponses]);

        }
        return $this->render('post.html.twig',['form'=>$form->createView(),'id'=>$id,'post'=>$post,'reponses'=>$reponses]);
    }

    /**
     * @Route("/forum/post/{id}/deletepost", name="delpost")
     * @param $id
     * @param PostRepository $rep
     * @return RedirectResponse
     */

    public function delposte($id,PostRepository $rep)
    {
        $post = $rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('forum');

    }

    /**
     * @Route("/forum/post/{id}/deletereponse", name="delreponse")
     * @param $id
     * @param ReponseRepository $rep
     * @return RedirectResponse
     */

    public function delreponse($id,ReponseRepository $rep)
    {
        $reponse = $rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reponse);
        $em->flush();
        $postid=$reponse->getPost()->getId();
        return $this->redirectToRoute('reponsespost',['id'=>$postid]);

    }


}